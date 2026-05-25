<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Для уже развёрнутых БД: снимаем ограничение ENUM и переводим способ оплаты на ЮKassa.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE orders MODIFY payment_method VARCHAR(32) NOT NULL DEFAULT 'yookassa'");
        }

        DB::table('orders')->whereIn('payment_method', ['qr', 'sbp'])->update(['payment_method' => 'yookassa']);
    }

    public function down(): void
    {
        //
    }
};
