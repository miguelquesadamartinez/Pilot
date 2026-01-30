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
            $table->boolean('supervisor_task')->default(false);
            $table->string('department_supervisor_task')->nullable();
            $table->bigInteger('supervisor_id')->nullable();
            $table->boolean('urgent_task')->default(false);
            $table->string('department_urgent_task')->nullable();
            $table->boolean('reminder')->default(false);
            $table->string('department_reminder')->nullable();
            $table->date('reminder_date')->nullable();
            $table->time('reminder_time')->nullable();
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
