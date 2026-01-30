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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();

            $table->integer('pharmacy_id');

            // Nota del usuario, nullable para saber si se ha puesto nota
            $table->integer('manual')->nullable();

            // Notas para cada diferente laboratorio
            $table->integer('galenicum');
            $table->integer('biogyne');
            $table->integer('theramex');
            $table->integer('havea_fr');
            $table->integer('havea_be');
            $table->integer('lifestyles');
            $table->integer('upsa_fr');
            $table->integer('upsa_es');

            $table->float('score')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
