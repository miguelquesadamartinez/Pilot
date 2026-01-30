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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orders_id');
            $table->string('orderNum');
            $table->string('colisNum')->nullable();
            
            $table->date('dateExpedition')->nullable();
            $table->date('dateLivrasion')->nullable();

            $table->enum('status', ['Preparing', 
                                    'Send', 
                                    'Delivered', 
                                    'On delivery', 
                                    'Non deliveried', 
                                    'Cancelled'
                                    ])->default('Preparing');

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
        Schema::dropIfExists('deliveries');
    }
};
