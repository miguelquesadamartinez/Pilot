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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
     
            $table->text('title');
            $table->longText('description')->nullable();

            $table->bigInteger('orders_id');

            $table->string('order_number')->nullable();
            $table->string('CIP')->nullable();

            $table->bigInteger('status_id');
            $table->bigInteger('categories_id');

            $table->string('country');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
