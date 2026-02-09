<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZakatTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'zakat_type_id',
        'donor_id',
        'name',
        'email',
        'phone',
        'amount',
        'unique_code',
        'total_transfer',
        'payment_method_id',
        'payment_proof',
        'status',
        'confirmed_at',
        'snap_token',
        'admin_fee',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_transfer' => 'decimal:2',
    ];

    public function zakatType()
    {
        return $this->belongsTo(ZakatType::class);
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
