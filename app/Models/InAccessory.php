<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InAccessory extends Model
{
    use HasFactory;
    protected $fillable = [
        'accessory_id',
        'name',
        'description',
    ];
}
