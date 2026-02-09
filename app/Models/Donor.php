<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'remember_token',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function zakatTransactions()
    {
        return $this->hasMany(ZakatTransaction::class, 'email', 'email');
    }

    public function otps()
    {
        return $this->hasMany(DonorOtp::class);
    }

    public function generateOtp()
    {
        // Generate 6-digit alphanumeric OTP (excluding confusing characters)
        $otp = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6));
        
        // Delete old unused OTPs for this donor
        $this->otps()->where('used', false)->delete();
        
        // Create new OTP with 5 minute expiry
        return $this->otps()->create([
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
            'used' => false,
        ]);
    }
}
