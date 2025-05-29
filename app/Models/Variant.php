<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $table = 'variants';
    protected $fillable = [
        'product_id',
        'img_id',
        'size',
        'stock_quantity',
        'price',
        'sale_price',
        'active',
        'status',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function img()
    {
        return $this->belongsTo(Img::class, 'img_id', 'id');
    }
}
