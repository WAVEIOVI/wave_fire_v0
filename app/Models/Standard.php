<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;
    protected $fillable = [
        'standard_id',
        'name',
        'description',
        'version',
    ];

    public function mission_folders()
    {
        return $this->belongsToMany(MissionFolder::class, 'mission_folder_standard');
    }
}
