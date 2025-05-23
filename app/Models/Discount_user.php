<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount_user extends Model
{
    protected $table = 'discount_user';
    protected $fillable = [
        'user_id',
        'discount_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
