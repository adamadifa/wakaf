<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'address',
        'maps_embed',
        'header_image',
    ];

    public static function get()
    {
        return self::first();
    }
}
