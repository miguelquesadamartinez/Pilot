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
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn('galenicum');
            $table->dropColumn('biogyne');
            $table->dropColumn('theramex');
            $table->dropColumn('havea_fr');
            $table->dropColumn('havea_be');
            $table->dropColumn('lifestyles');
            $table->dropColumn('upsa_fr');
            $table->dropColumn('upsa_es');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            //
        });
    }
};
