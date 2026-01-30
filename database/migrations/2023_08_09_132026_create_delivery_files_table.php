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
        Schema::create('delivery_files', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('orders_id');
            $table->string('fileName');

            $table->timestamps();

            $table->foreign('orders_id')
                    ->references('id')
                    ->on('orders')
                    ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_files');
    }
};
