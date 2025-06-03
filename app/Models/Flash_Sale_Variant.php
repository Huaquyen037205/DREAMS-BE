<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flash_Sale_Variant extends Model
{
    use HasFactory;

    protected $table = 'flash_sale_variants';

    protected $fillable = ['flash_sale_id', 'variant_id', 'sale_price', 'flash_quantity', 'flash_sold'];

    public function flashSale()
    {
        return $this->belongsTo(Flash_Sale::class, 'flash_sale_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
