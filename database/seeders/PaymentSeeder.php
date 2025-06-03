<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('payments')->insert([
            ['payment_method' => 'Tiền mặt', 'payment_status' => 'active'],
            ['payment_method' => 'VNPAY', 'payment_status' => 'active'],
            ['payment_method' => 'Momo', 'payment_status' => 'active'],
        ]);
    }
}
