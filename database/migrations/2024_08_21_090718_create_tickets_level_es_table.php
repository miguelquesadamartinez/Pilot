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

        Schema::dropIfExists('tickets_level_es');
        
        Schema::create('tickets_level_es', function (Blueprint $table) {
            $table->id();
                        
            $table->bigInteger('level_d_id')->nullable();

            $table->string('level_e_en')->nullable();
            $table->string('level_e_es')->nullable();
            $table->string('level_e_fr')->nullable();

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_level_ds');
    }
};
