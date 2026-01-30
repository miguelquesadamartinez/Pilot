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
        Schema::create('tickets_level_bs', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('level_a_id')->nullable();

            $table->string('level_b_en')->nullable();
            $table->string('level_b_es')->nullable();
            $table->string('level_b_fr')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_level_bs');
    }
};
