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
        'created_day',
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
}
