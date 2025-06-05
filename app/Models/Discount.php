<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';
    protected $fillable = [
        'name',
        'percentage',
        'start_day',
        'end_day',
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'discount_id');
    }
}
