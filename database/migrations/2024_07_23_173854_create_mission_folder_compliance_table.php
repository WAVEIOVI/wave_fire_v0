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
        Schema::create('mission_folder_compliance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_folder_id')->constrained()->onDelete('cascade');
            $table->foreignId('compliance_id')->constrained()->onDelete('cascade');
            $table->string('action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_folder_compliance');
    }
};
