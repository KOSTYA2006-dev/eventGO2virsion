<?php

namespace App\Services;

use App\Models\Order;
use YooKassa\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class YooKassaService
{
    private $client;

    private function normalizePhone(?string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') {
            return null;
        }

        if (strlen($digits) === 11 && $digits[0] === '8') {
            return '+7' . substr($digits, 1);
        }
        if (strlen($digits) === 11 && $digits[0] === '7') {
            return '+7' . substr($digits, 1);
        }

        return '+' . $digits;
    }

    public function __construct()
    {
        $shopId = config('payment.yookassa.shop_id');
        $secretKey = config('payment.yookassa.secret_key');

        if (!$shopId || !$secretKey) {
            throw new \Exception('ЮKassa не настроен. Укажите YOOKASSA_SHOP_ID и YOOKASSA_SECRET_KEY в .env');
        }

        $this->client = new Client();
        $this->client->setAuth($shopId, $secretKey);
    }

    public function createPayment(Order $order, $returnUrl = null)
    {
        try {
            $amount = (float) $order->total_amount;
            if ($amount <= 0) {
                throw new \InvalidArgumentException('Сумма платежа должна быть больше 0');
            }

            $order->loadMissing(['customer', 'ticket']);

            $customerEmail = $order->customer?->email ?: null;
            $customerPhone = $this->normalizePhone($order->customer?->phone);
            if (!$customerEmail && !$customerPhone) {
                throw new \InvalidArgumentException('Для чека нужен email или телефон покупателя');
            }

            $taxSystemCode = (int) config('payment.yookassa.tax_system_code', 2);
            $vatCode = (int) config('payment.yookassa.vat_code', 1);
            $paymentSubject = (string) config('payment.yookassa.payment_subject', 'service');
            $paymentMode = (string) config('payment.yookassa.payment_mode', 'full_payment');

            $description = $order->ticket?->name
                ? ("Билет: " . $order->ticket->name)
                : ("Заказ №{$order->order_number}");

            $payment = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => number_format($amount, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => $returnUrl ?: route('order.success', $order->id),
                    ],
                    'capture' => true,
                    'description' => "Оплата заказа №{$order->order_number}",
                    'receipt' => [
                        'customer' => array_filter([
                            'email' => $customerEmail,
                            'phone' => $customerPhone,
                        ], fn ($v) => !empty($v)),
                        'tax_system_code' => $taxSystemCode,
                        'items' => [
                            [
                                'description' => $description,
                                'quantity' => '1.00',
                                'amount' => [
                                    'value' => number_format($amount, 2, '.', ''),
                                    'currency' => 'RUB',
                                ],
                                'vat_code' => $vatCode,
                                'payment_subject' => $paymentSubject,
                                'payment_mode' => $paymentMode,
                            ],
                        ],
                    ],
                    'metadata' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ],
                ],
                (string) Str::uuid()
            );

            $order->update([
                'payment_id' => $payment->getId(),
            ]);

            return $payment;
        } catch (\Exception $e) {
            Log::error('Ошибка создания платежа ЮKassa: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => (string) $order->total_amount,
                'return_url' => $returnUrl,
                'exception' => $e,
            ]);
            throw $e;
        }
    }

    public function getPaymentInfo($paymentId)
    {
        try {
            return $this->client->getPaymentInfo($paymentId);
        } catch (\Exception $e) {
            Log::error('Ошибка получения информации о платеже: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handleWebhook($requestBody)
    {
        try {
            $notification = json_decode($requestBody, true);

            if (!isset($notification['event'])) {
                Log::warning('Webhook без event: ' . $requestBody);
                return null;
            }

            $event = $notification['event'];
            $payment = $notification['object'] ?? null;

            if (!$payment || !isset($payment['id'])) {
                Log::warning('Webhook без payment: ' . $requestBody);
                return null;
            }

            $paymentId = $payment['id'];
            $status = $payment['status'] ?? null;
            $metadata = $payment['metadata'] ?? [];

            $order = null;
            if (isset($metadata['order_id'])) {
                $order = Order::find($metadata['order_id']);
            } elseif (isset($metadata['order_number'])) {
                $order = Order::where('order_number', $metadata['order_number'])->first();
            } else {
                $order = Order::where('payment_id', $paymentId)->first();
            }

            if (!$order) {
                Log::warning("Заказ не найден для payment_id: {$paymentId}");
                return null;
            }

            if ($event === 'payment.succeeded') {
                if ($status === 'succeeded' && $order->payment_status !== 'paid') {
                    return [
                        'order' => $order,
                        'status' => 'paid',
                        'payment_id' => $paymentId,
                    ];
                }
            } elseif ($event === 'payment.canceled') {
                if ($status === 'canceled') {
                    return [
                        'order' => $order,
                        'status' => 'cancelled',
                        'payment_id' => $paymentId,
                    ];
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Ошибка обработки webhook ЮKassa: ' . $e->getMessage());
            return null;
        }
    }
}
