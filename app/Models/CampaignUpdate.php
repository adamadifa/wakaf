<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignUpdate extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
