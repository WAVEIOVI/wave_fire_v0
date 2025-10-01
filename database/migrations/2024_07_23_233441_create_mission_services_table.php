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
        Schema::create('mission_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_id')->unique(); // Unique service_id
            $table->string('name'); // service name
            $table->text('description')->nullable(); // service description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_services');
    }
};
