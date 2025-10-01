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
        Schema::table('interventions', function (Blueprint $table) {
            $table->string('client_feedback_quality_service')->nullable();
            $table->string('client_feedback_arrive_time')->nullable();
            $table->string('client_feedback_professionalism')->nullable();
            $table->string('client_feedback_specific_needs')->nullable();
            $table->string('client_feedback_recommend_our_services')->nullable();
            $table->text('client_feedback')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn([
                'client_feedback_quality_service',
                'client_feedback_arrive_time',
                'client_feedback_professionalism',
                'client_feedback_specific_needs',
                'client_feedback_recommend_our_services',
                'client_feedback'
            ]);
        });
    }
};
