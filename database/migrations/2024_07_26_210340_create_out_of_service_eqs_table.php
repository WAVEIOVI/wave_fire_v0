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
        Schema::create('out_of_service_eqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_folder_id')->constrained()->cascadeOnDelete();
            $table->string('equipment');
            $table->text('the_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_of_service_eqs');
    }
};
