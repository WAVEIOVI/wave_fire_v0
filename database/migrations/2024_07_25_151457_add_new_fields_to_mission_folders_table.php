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
        Schema::table('mission_folders', function (Blueprint $table) {
            $table->string('operational_readiness')->nullable();
            $table->string('operational_readiness_desc')->nullable();
            $table->string('maintenance_quality')->nullable();
            $table->string('maintenance_quality_desc')->nullable();
            $table->string('safety_compliance')->nullable();
            $table->string('safety_compliance_desc')->nullable();
            $table->string('compliance_rate')->nullable();
            $table->string('park_status')->nullable();
            $table->string('park_status_desc')->nullable();
            $table->string('intervention_status')->nullable();
            $table->string('intervention_status_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_folders', function (Blueprint $table) {
            $table->dropColumn([
                'operational_readiness',
                'operational_readiness_desc',
                'maintenance_quality',
                'maintenance_quality_desc',
                'safety_compliance',
                'safety_compliance_desc',
                'compliance_rate',
                'park_status',
                'park_status_desc',
                'intervention_status',
                'intervention_status_desc'
            ]);
        });
    }
};
