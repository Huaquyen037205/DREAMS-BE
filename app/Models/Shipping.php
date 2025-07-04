<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $table = 'shippings';
    protected $fillable = [
        'name',
        'shipping_status',
        'tracking_number',
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'shipping_id', 'id');
    }

}
