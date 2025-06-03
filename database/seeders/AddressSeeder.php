<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('address')->insert([
            [
                'adress' => '123 Đường ABC, Quận 1, TP.HCM',
                'user_id' => 4, // Đảm bảo user_id này tồn tại
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'adress' => '456 Đường XYZ, Quận 3, TP.HCM',
                'user_id' => 3, // Đảm bảo user_id này tồn tại
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
