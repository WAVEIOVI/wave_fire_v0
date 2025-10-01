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
        Schema::create('equipment_intervention', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('intervention_id')->constrained()->onDelete('cascade');
            $table->string('inspection')->nullable();
            $table->string('raw_recharge')->nullable();
            $table->string('nitrogen_recharge')->nullable();
            $table->string('equipment_protection_id')->nullable();
            $table->string('equipment_protection_name')->nullable();
            $table->string('maintenance')->nullable();
            $table->string('additional_maintenance')->nullable();
            $table->string('supply')->nullable();
            $table->string('accessory')->nullable();
            $table->string('equipment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_intervention');
    }
};
