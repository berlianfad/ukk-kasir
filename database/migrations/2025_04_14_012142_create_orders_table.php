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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->json('products');
            $table->string('customer_name')->nullable();
            $table->string('total');
            $table->string('phone_number')->nullable();
            $table->string('status');
            $table->string('invoice');
            $table->string('kembalian')->nullable();
            $table->integer('poin_digunakan');
            $table->timestamps();
        });
    }

    /**
      * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
