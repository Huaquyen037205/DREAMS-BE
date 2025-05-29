<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flash_sale_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flash_sale_id');
            $table->unsignedBigInteger('variant_id');
            $table->integer('sale_price');
            $table->integer('flash_quantity');
            $table->integer('flash_sold')->default(0);
            $table->timestamps();

            $table->foreign('flash_sale_id')->references('id')->on('flash_sales')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sale_variants');
    }
};
