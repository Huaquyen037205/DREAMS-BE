<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    protected $fillable = [
        'adress',
        'user_id',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
