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

            $table->string('OrderNum');
            $table->string('CIP');

            $table->string('pharmacyName')->nullable();

            $table->enum('country', ['es', 'en', 'fr']); 

            $table->date('desiredDeliveryDate')->nullable();
            $table->date('dateExpedition')->nullable();
            $table->date('dateLivrasion')->nullable();
            
            $table->decimal('discount', 10,2)->default(0)->nullable();
            $table->decimal('total', 10,2)->nullable();

            $table->enum('sageStatus', ['New', 'Preparing', 'Shipped', 'Invoiced', 'Cancelled'])->default('New');

            $table->string('colisNum')->nullable();
            
            $table->enum('deliveryStatus', ['Preparing', 'Send', 'Delivered', 'On delivery', 'Non deliveried', 'Cancelled'])->default('Preparing');

            $table->bigInteger('agent_id')->nullable();
            $table->string('agent_name')->nullable();

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
