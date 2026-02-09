<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'is_anonymous' => 'boolean',
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }



    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
