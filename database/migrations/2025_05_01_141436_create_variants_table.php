<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) { // Đổi 'variant' thành 'variants'
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('img_id')->references('id')->on('img');
            $table->string('size');
            $table->integer('stock_quantity');
            $table->integer('price');
            $table->string('status');
            $table->date('created_day');
            $table->timestamps();
        });
    }
};
