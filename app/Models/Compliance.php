<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;
    protected $fillable = [
        'compliance_desc',
        'applicable_standard',
        'compliance_status'
    ];

    public function mission_folders()
    {
        return $this->belongsToMany(MissionFolder::class, 'mission_folder_compliance')
            ->withPivot('action');
    }
}
