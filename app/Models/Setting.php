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
        'phone_number',
        'maps_embed',
        'header_image',
        'is_payment_gateway_active',
        'midtrans_merchant_id',
        'midtrans_client_key',
        'midtrans_server_key',
        'midtrans_server_key',
        'midtrans_is_production',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'midtrans_admin_fee',
        'short_description',
    ];

    protected $casts = [
        'is_payment_gateway_active' => 'boolean',
        'midtrans_is_production' => 'boolean',
    ];

    public static function get()
    {
        return self::first();
    }
}
