<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flash_Sale;
use App\Models\Flash_Sale_Variant;
use App\Models\Variant;

class FlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo flash sale
        $flashSale = Flash_Sale::create([
            'name' => 'Flash Sale 1',
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
            'status' => true,
        ]);

        // Giả sử đã có variant id = 1
        Flash_Sale_Variant::create([
            'flash_sale_id' => $flashSale->id,
            'variant_id' => 1,
            'sale_price' => 99000,
            'flash_quantity' => 10,
            'flash_sold' => 0,
        ]);
    }
}
