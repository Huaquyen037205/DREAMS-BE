<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'active',
        'status',
        'view',
        'hot',
    ];
    public function img()
    {
        return $this->hasMany(Img::class, 'product_id', 'id');
    }

    public function variant()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function getDiscountedPriceAttribute()
    {
        $variant = $this->variant->first();
        if (!$variant) {
            return 0;
        }
        if ($this->discount && $this->discount->percentage > 0) {
            return round($this->variant->first()->price * (1 - $this->discount->percentage / 100));
        }
        return $this->variant->first()->price;
    }
}
