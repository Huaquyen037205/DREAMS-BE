<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shippings')->insert([
            [
                'shipping_status' => 'Giao hàng tiêu chuẩn',
                'tracking_number' => 'STD123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipping_status' => 'Giao hàng nhanh',
                'tracking_number' => 'FAST654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
