<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'discount_value', 'expiry_date', 'is_public'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupons_user', 'coupon_id', 'user_id')->withTimestamps();
    }
}
