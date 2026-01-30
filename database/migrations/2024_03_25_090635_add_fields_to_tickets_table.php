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
        Schema::table('tickets', function (Blueprint $table) {

            $table->string('department')->nullable();
            
            $table->bigInteger('level_a_id')->nullable();
            $table->bigInteger('level_b_id')->nullable();
            $table->bigInteger('level_c_id')->nullable();
            $table->bigInteger('level_d_id')->nullable();

            $table->bigInteger('old_level_a_id')->nullable();
            $table->bigInteger('old_level_b_id')->nullable();
            $table->bigInteger('old_level_c_id')->nullable();
            $table->bigInteger('old_level_d_id')->nullable();

            $table->bigInteger('old_category_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
