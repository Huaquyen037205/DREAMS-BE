<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flash_Sale extends Model
{
    use HasFactory;

    protected $table = 'flash_sales';

    protected $fillable = ['name', 'start_time', 'end_time', 'status'];

    public function variants()
    {
        return $this->hasMany(Flash_Sale_Variant::class);
    }
}

