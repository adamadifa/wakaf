<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfaqTransaction extends Model
{
    protected $guarded = [];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_transfer' => 'decimal:2',
    ];

    public function infaqCategory()
    {
        return $this->belongsTo(InfaqCategory::class);
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
