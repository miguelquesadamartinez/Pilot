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
        Schema::create('order_disputes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orderId')->nullable();
            $table->string('orderNum')->nullable();
            $table->bigInteger('orderItemId')->nullable();
            $table->bigInteger('orderItemProductId')->nullable();
            $table->string('orderItemProductName')->nullable();
            $table->integer('orderItemQtn')->nullable();
            $table->double('orderItemPrice')->nullable();
            $table->double('orderItemTotal')->nullable();
            $table->boolean('ticked')->default(false);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_disputes');
    }
};
