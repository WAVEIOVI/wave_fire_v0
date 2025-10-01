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
        Schema::create('mission_folder_suggestion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_folder_id')->constrained()->onDelete('cascade');
            $table->foreignId('suggestion_id')->constrained()->onDelete('cascade');
            $table->string('suggestion_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_folder_suggestion');
    }
};
