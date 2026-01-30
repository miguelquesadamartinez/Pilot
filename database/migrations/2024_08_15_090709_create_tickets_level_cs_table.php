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

        Schema::dropIfExists('tickets_level_cs');
        
        Schema::create('tickets_level_cs', function (Blueprint $table) {
            $table->id();
                        
            $table->bigInteger('level_b_id')->nullable();

            $table->string('level_c_en')->nullable();
            $table->string('level_c_es')->nullable();
            $table->string('level_c_fr')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_level_cs');
    }
};
