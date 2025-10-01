<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutOfServiceEq extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment',
        'the_reason',
    ];

    public function mission_folder()
    {
        return $this->belongsTo('App\Models\MissionFolder');
    }
}
