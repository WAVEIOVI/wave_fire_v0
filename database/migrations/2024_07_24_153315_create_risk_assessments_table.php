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
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_folder_id')->constrained()->cascadeOnDelete();
            $table->string('hazard');
            $table->text('description')->nullable();
            $table->string('likelihood')->nullable();
            $table->string('severity')->nullable();
            $table->string('risk_level')->nullable(); // Calculated field
            $table->text('mitigation_strategy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
