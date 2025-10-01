<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'hazard',
        'description',
        'mitigation_strategy',
        'likelihood',
        'severity',
        'risk_level',
    ];

    public function mission_folder()
    {
        return $this->belongsTo('App\Models\MissionFolder');
    }
}
