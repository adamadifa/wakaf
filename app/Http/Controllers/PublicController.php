<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')
            ->latest()
            ->take(6) // Limit for homepage
            ->get();

        $latestDonations = \App\Models\Donation::where('status', 'confirmed')
            ->whereNotNull('message')
            ->where('message', '!=', '')
            ->with(['donor', 'campaign'])
            ->latest()
            ->take(10)
            ->get();

        $latestNews = \App\Models\News::whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('welcome', compact('campaigns', 'latestDonations', 'latestNews'));
    }

    public function programs(Request $request)
    {
        $query = Campaign::where('status', 'active');

        if ($request->has('q')) {
            $search = $request->q;
            $query->where('title', 'like', "%{$search}%");
        }

        $campaigns = $query->latest()->paginate(9);

        return view('campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        if ($campaign->status !== 'active' && $campaign->status !== 'completed') {
            abort(404);
        }

        $campaign->load(['category', 'user', 'updates' => function ($query) {
            $query->latest();
        }, 'distributions' => function ($query) {
            $query->latest();
        }, 'donations' => function ($query) {
            $query->where('status', 'confirmed')->with('donor')->latest();
        }]);

        return view('campaigns.show', compact('campaign'));
    }

    public function donate(Campaign $campaign)
    {
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        return view('campaigns.donate', compact('campaign', 'paymentMethods'));
    }

    public function storeDonation(Request $request, Campaign $campaign)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'message' => 'nullable|string',
        ]);

        // Find or create donor
        $donor = \App\Models\Donor::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
            ]
        );
        
        // Optional: Link to user if email exists, for legacy support
        $user = \App\Models\User::where('email', $request->email)->first();

        $uniqueCode = rand(100, 999);
        $totalTransfer = $request->amount + $uniqueCode;

        $donation = \App\Models\Donation::create([
            'invoice_number' => 'INV/' . date('Ymd') . '/' . rand(1000, 9999),
            'campaign_id' => $campaign->id,

            'donor_id' => $donor->id,

            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'unique_code' => $uniqueCode,
            'total_transfer' => $totalTransfer, // Total with unique code
            'message' => $request->message,
            'status' => 'pending',
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        return redirect()->route('campaign.success', $donation->invoice_number);
    }

    public function success($invoice)
    {
        $donation = \App\Models\Donation::where('invoice_number', $invoice)
            ->with(['campaign', 'paymentMethod'])
            ->firstOrFail();

        return view('campaigns.success', compact('donation'));
    }

    public function confirmDonation(Request $request, $invoice)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048', // Max 2MB
        ]);

        $donation = \App\Models\Donation::where('invoice_number', $invoice)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('donations', 'public');
            $donation->update([
                'payment_proof' => $path,
                // Optional: You might want to update status here or keep it pending for admin review
                // 'status' => 'pending' 
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Admin akan segera memverifikasi donasi Anda.');
    }
}
