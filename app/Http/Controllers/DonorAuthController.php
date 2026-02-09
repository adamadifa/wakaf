<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonorOtpMail;

class DonorAuthController extends Controller
{
    public function showLoginForm()
    {
        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.donor.login');
        }
        return view('donor.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find donor by email
        $donor = Donor::where('email', $request->email)->first();

        if (!$donor) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar. Pastikan Anda menggunakan email yang sama saat donasi.',
            ])->withInput();
        }

        // Generate OTP
        $otpRecord = $donor->generateOtp();

        // Send OTP via email
        try {
            Mail::to($donor->email)->send(new DonorOtpMail($donor, $otpRecord->otp));
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Gagal mengirim OTP. Silakan coba lagi.',
            ])->withInput();
        }

        // Store email in session for verification step
        session(['donor_email' => $donor->email]);

        return redirect()->route('donor.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showVerifyForm()
    {
        if (!session('donor_email')) {
            return redirect()->route('donor.login');
        }

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.donor.verify');
        }
        return view('donor.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $email = session('donor_email');
        if (!$email) {
            return redirect()->route('donor.login');
        }

        $donor = Donor::where('email', $email)->first();
        if (!$donor) {
            return redirect()->route('donor.login');
        }

        // Find valid OTP
        $otpRecord = $donor->otps()
            ->where('otp', strtoupper($request->otp))
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.',
            ]);
        }

        // Mark OTP as used
        $otpRecord->markAsUsed();

        // Create session
        session([
            'donor_id' => $donor->id,
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
        ]);

        // Clear temporary email session
        session()->forget('donor_email');

        return redirect()->route('donor.dashboard')->with('success', 'Selamat datang, ' . $donor->name . '!');
    }

    public function logout()
    {
        session()->forget(['donor_id', 'donor_name', 'donor_email']);
        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}
