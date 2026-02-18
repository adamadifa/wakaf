<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionMissionWakaf extends Model
{
    use HasFactory;

    protected $fillable = [
        'visi',
        'misi',
    ];
}
