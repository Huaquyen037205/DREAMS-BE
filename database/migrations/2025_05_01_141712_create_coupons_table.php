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

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('discount_value');
            $table->string('code')->unique();
            $table->datetime('expiry_date');
            $table->timestamps();
        });

    }
};
