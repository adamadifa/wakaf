<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'image',
        'bio',
        'facebook_link',
        'instagram_link',
        'order',
        'is_active',
    ];
}
