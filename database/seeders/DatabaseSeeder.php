<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Ticket;
use App\Models\PromoCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        Admin::create([
            'name' => 'Администратор',
            'email' => 'admin@eventgo.ru',
            
            'password' => 'admin123',
        ]);

     
        Ticket::create([
            'name' => 'Обычный билет',
            'type' => 'regular',
            'price' => 5000.00,
            'description' => 'Стандартный билет на мероприятие с доступом ко всем основным активностям',
            'available_quantity' => 250,
            'is_active' => true,
        ]);

        Ticket::create([
            'name' => 'VIP билет',
            'type' => 'vip',
            'price' => 15000.00,
            'description' => 'VIP билет с расширенными возможностями, приоритетным доступом и дополнительными привилегиями',
            'available_quantity' => 50,
            'is_active' => true,
        ]);

        PromoCode::create([
            'code' => 'SALE10',
            'discount_type' => 'percentage',
            'discount_value' => 10.00,
            'max_uses' => 250,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6),
            'is_active' => true,
        ]);

        PromoCode::create([
            'code' => 'SALE20',
            'discount_type' => 'percentage',
            'discount_value' => 20.00,
            'max_uses' => 250,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6),
            'is_active' => true,
        ]);

        PromoCode::create([
            'code' => 'SALE30',
            'discount_type' => 'percentage',
            'discount_value' => 30.00,
            'max_uses' => 250,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6),
            'is_active' => true,
        ]);
    }
}
