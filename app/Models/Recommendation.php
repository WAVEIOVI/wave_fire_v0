<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];


    public function mission_folders()
    {
        return $this->belongsToMany(MissionFolder::class, 'mission_folder_recommendation')
            ->withPivot('recommendation_status');
    }
}
