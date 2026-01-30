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
        Schema::create('recording_searches', function (Blueprint $table) {
            $table->id();

            $table->string('operation')->nullable();
            $table->string('operator')->nullable();
            $table->string('filename')->nullable();
            $table->string('path')->nullable();
            $table->string('cip')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recording_searches');
    }
};
