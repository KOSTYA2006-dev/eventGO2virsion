<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\YooKassaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $yooKassaService;

    public function __construct(YooKassaService $yooKassaService)
    {
        $this->yooKassaService = $yooKassaService;
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'ticket', 'promoCode'])->findOrFail($id);

        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', $order->id);
        }

        return view('payment.show', compact('order'));
    }

    public function start($id)
    {
        $order = Order::with(['customer', 'ticket', 'promoCode'])->findOrFail($id);

        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', $order->id);
        }

        if ((float) $order->total_amount <= 0) {
            $order->update(['payment_status' => 'paid']);
            $this->generateAndSendReceipt($order);
            return redirect()->route('order.success', $order->id);
        }

        try {
            $returnUrl = route('order.success', $order->id);
            $payment = $this->yooKassaService->createPayment($order, $returnUrl);

            return redirect($payment->getConfirmation()->getConfirmationUrl());
        } catch (\Exception $e) {
            Log::error('Ошибка создания платежа YooKassa: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => (string) $order->total_amount,
                'exception' => $e,
            ]);

            $userMessage = config('app.debug')
                ? ('Ошибка при создании платежа: ' . $e->getMessage())
                : 'Ошибка при создании платежа. Попробуйте позже.';

            return redirect()
                ->route('payment.show', $order->id)
                ->withErrors(['error' => $userMessage]);
        }
    }

    public function confirm($id)
    {
        return redirect()->route('payment.show', $id);
    }

    public function success($id)
    {
        $order = Order::with(['customer', 'ticket', 'promoCode'])->findOrFail($id);

        if ($order->payment_status !== 'paid' && $order->payment_id) {
            try {
                $paymentInfo = $this->yooKassaService->getPaymentInfo($order->payment_id);
                $status = $paymentInfo->getStatus();

                if ($status === 'succeeded') {
                    $order->update(['payment_status' => 'paid']);
                    $this->generateAndSendReceipt($order);
                } elseif ($status === 'canceled' && $order->payment_status === 'pending') {
                    $order->update(['payment_status' => 'cancelled']);
                    $order->ticket?->increment('available_quantity', $order->quantity);
                }
            } catch (\Exception $e) {
                Log::warning('Не удалось проверить статус платежа на return_url: ' . $e->getMessage(), [
                    'order_id' => $order->id,
                    'payment_id' => $order->payment_id,
                ]);
            }
        }

        return view('order.success', compact('order'));
    }

    public function testCheck($id)
    {
        try {
            $order = Order::with(['customer', 'ticket'])->findOrFail($id);

            if ($order->payment_status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Заказ уже оплачен',
                    'order_number' => $order->order_number
                ]);
            }

            if (abs($order->total_amount - 10.00) > 0.01) {
                return response()->json([
                    'success' => false,
                    'message' => 'Тестовая проверка работает только для заказов на сумму 10 рублей',
                    'order_amount' => $order->total_amount,
                    'required_amount' => 10.00
                ]);
            }

            $order->update(['payment_status' => 'paid']);
            $this->generateAndSendReceipt($order);

            Log::info("Test payment verified for order {$order->order_number}");

            return response()->json([
                'success' => true,
                'message' => 'Оплата подтверждена. Чек и билет отправлены на email.',
                'order_number' => $order->order_number,
                'customer_email' => $order->customer->email
            ]);

        } catch (\Exception $e) {
            Log::error('Test check error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Ошибка при проверке оплаты: ' . $e->getMessage()
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            Log::info('YooKassa webhook received', [
                'data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $requestBody = $request->getContent();
            $result = $this->yooKassaService->handleWebhook($requestBody);

            if (!$result) {
                Log::warning('YooKassa webhook: no action required');
                return response()->json(['status' => 'ok'], 200);
            }

            $order = $result['order'];
            $status = $result['status'];

            if ($status === 'paid' && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_id' => $result['payment_id'],
                ]);

                $this->generateAndSendReceipt($order);

                Log::info("Payment verified via YooKassa webhook for order {$order->order_number}");

                return response()->json([
                    'status' => 'ok',
                    'message' => 'Payment processed and emails sent'
                ], 200);
            } elseif ($status === 'cancelled' && $order->payment_status === 'pending') {
                $order->update([
                    'payment_status' => 'cancelled',
                    'payment_id' => $result['payment_id'],
                ]);

                $order->loadMissing('ticket');
                if ($order->ticket) {
                    $order->ticket->increment('available_quantity', $order->quantity);
                }

                Log::info("Payment cancelled via YooKassa webhook for order {$order->order_number}");
                return response()->json(['status' => 'ok'], 200);
            } elseif ($order->payment_status === 'paid') {
                Log::info("Order {$order->order_number} already paid");
                return response()->json(['status' => 'ok'], 200);
            }

            return response()->json(['status' => 'ok'], 200);

        } catch (\Exception $e) {
            Log::error('YooKassa webhook error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function generateAndSendReceipt(Order $order)
    {
        try {
            $receiptPath = $this->generateReceiptPDF($order);

            if ($receiptPath) {
                $order->update([
                    'payment_receipt_path' => $receiptPath,
                ]);
            }

            $ticketPath = $this->generateTicketPDF($order);

            if ($ticketPath) {
                $order->update([
                    'ticket_path' => $ticketPath,
                ]);
            }

            $receiptSent = false;
            $ticketSent = false;

            try {
                Mail::send('emails.receipt', ['order' => $order], function ($message) use ($order, $receiptPath) {
                    $message->to($order->customer->email)
                        ->subject('Чек об оплате заказа №' . $order->order_number);

                    if ($receiptPath && Storage::exists($receiptPath)) {
                        $message->attach(Storage::path($receiptPath), [
                            'as' => 'receipt_' . $order->order_number . '.html',
                            'mime' => 'text/html',
                        ]);
                    }
                });
                Log::info("Receipt email sent to {$order->customer->email} for order {$order->order_number}");
                $receiptSent = true;
            } catch (\Exception $e) {
                Log::error('Ошибка отправки чека на email: ' . $e->getMessage());
            }

            try {
                Mail::send('emails.ticket', ['order' => $order], function ($message) use ($order, $ticketPath) {
                    $message->to($order->customer->email)
                        ->subject('Ваш билет - Заказ №' . $order->order_number);

                    if ($ticketPath && Storage::exists($ticketPath)) {
                        $message->attach(Storage::path($ticketPath), [
                            'as' => 'ticket_' . $order->order_number . '.html',
                            'mime' => 'text/html',
                        ]);
                    }
                });
                Log::info("Ticket email sent to {$order->customer->email} for order {$order->order_number}");
                $ticketSent = true;
            } catch (\Exception $e) {
                Log::error('Ошибка отправки билета на email: ' . $e->getMessage());
            }

            $order->update([
                'receipt_sent' => $receiptSent,
                'ticket_sent' => $ticketSent,
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при генерации и отправке чека/билета: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function generateReceiptPDF(Order $order): ?string
    {
        $receiptContent = view('receipt.template', compact('order'))->render();
        $filename = 'receipts/receipt_' . $order->order_number . '_' . time() . '.html';
        Storage::put($filename, $receiptContent);

        return $filename;
    }

    private function generateTicketPDF(Order $order): ?string
    {
        $ticketContent = view('emails.ticket', compact('order'))->render();
        $filename = 'tickets/ticket_' . $order->order_number . '_' . time() . '.html';
        Storage::put($filename, $ticketContent);

        return $filename;
    }
}
