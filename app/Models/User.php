<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'day_of_birth',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // Quan hệ với bảng discount_user (nhiều-nhiều)
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_user', 'user_id', 'discount_id')
            ->withTimestamps();
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlist')->withTimestamps();
    }
public function coupons()
{
    return $this->belongsToMany(\App\Models\Coupon::class, 'coupons_user', 'user_id', 'coupon_id')->withTimestamps();
}
}
