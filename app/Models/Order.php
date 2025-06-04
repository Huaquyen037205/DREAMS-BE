<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'shipping_id',
        'discount_id',
        'payment_id',
        'coupon_id',
        'address_id',
        'status',
        'total_price',
        'vnp_TxnRef',
    ];

    public function order_items() {
        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
}
