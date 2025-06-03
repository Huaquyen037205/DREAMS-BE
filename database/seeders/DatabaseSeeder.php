<?php

namespace Database\Seeders;

use App\Models\Shipping;
use App\Models\Address;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
        ShippingSeeder::class,
        AddressSeeder::class,
        PaymentSeeder::class,
    ]);
    }
}
