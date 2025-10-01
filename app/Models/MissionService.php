<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionService extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'name',
        'description',
    ];

    public function mission_folders()
    {
        return $this->belongsToMany(MissionFolder::class, 'mission_folder_service');
    }
}
