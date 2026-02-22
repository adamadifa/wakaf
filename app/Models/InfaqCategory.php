<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfaqCategory extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function transactions()
    {
        return $this->hasMany(InfaqTransaction::class);
    }
}
