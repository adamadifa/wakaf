<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationConfirmedMail;

class DonationController extends Controller
{
    public function index()
    {
        $query = Donation::with(['campaign', 'donor', 'paymentMethod'])->latest();

        // Keyword Search (Invoice or Donor Name)
        if (request('q')) {
            $search = request('q');
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('donor', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Campaign
        if (request('campaign_id')) {
            $query->where('campaign_id', request('campaign_id'));
        }

        // Filter by Status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by Date Range
        if (request('start_date')) {
            $query->whereDate('created_at', '>=', request('start_date'));
        }

        if (request('end_date')) {
            $query->whereDate('created_at', '<=', request('end_date'));
        }

        $donations = $query->paginate(10)->withQueryString();
        $campaigns = Campaign::select('id', 'title')->latest()->get(); // For filter dropdown
            
        return view('admin.donations.index', compact('donations', 'campaigns'));
    }

    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected,pending',
        ]);

        try {
            DB::transaction(function () use ($donation, $validated) {
                $oldStatus = $donation->status;
                $newStatus = $validated['status'];

                // Update Donation Status
                $donation->update([
                    'status' => $newStatus,
                    'confirmed_at' => $newStatus === 'confirmed' ? now() : null,
                ]);

                // Handle Campaign Amount Update
                if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed') {
                    // Increment campaign amount if confirmed
                    $donation->campaign->increment('current_amount', $donation->amount);
                    
                    // Send Confirmation Email
                    try {
                        if ($donation->donor && $donation->donor->email) {
                            dispatch(new \App\Jobs\SendEmailJob($donation->donor->email, new DonationConfirmedMail($donation)));
                        }
                    } catch (\Exception $e) {
                         \Illuminate\Support\Facades\Log::error('Email Error: ' . $e->getMessage());
                    }
                } elseif ($oldStatus === 'confirmed' && $newStatus !== 'confirmed') {
                    // Decrement if changing from confirmed to something else (rollback)
                    $donation->campaign->decrement('current_amount', $donation->amount);
                }
            });

            return back()->with('success', 'Status donasi berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    public function cancel(Donation $donation)
    {
        try {
            DB::transaction(function () use ($donation) {
                // Ensure only confirmed transactions can be cancelled/reverted
                if ($donation->status !== 'confirmed') {
                    throw new \Exception('Hanya donasi yang sudah dikonfirmasi yang bisa dibatalkan.');
                }

                // Revert Donation Status
                $donation->update([
                    'status' => 'pending',
                    'confirmed_at' => null,
                ]);

                // Decrement campaign amount (rollback)
                $donation->campaign->decrement('current_amount', $donation->amount);
            });

            return back()->with('success', 'Status donasi dikembalikan ke Pending dan saldo campaign disesuaikan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan: ' . $e->getMessage());
        }
    }

    public function destroy(Donation $donation)
    {
        // If deleting a confirmed donation, revert the amount
        if ($donation->status === 'confirmed') {
            $donation->campaign->decrement('current_amount', $donation->amount);
        }
        
        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('success', 'Data donasi berhasil dihapus!');
    }
}
