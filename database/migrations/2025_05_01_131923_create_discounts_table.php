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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedTinyInteger('percentage');
            $table->date('start_day');
            $table->date('end_day');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
