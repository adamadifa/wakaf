<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Donation;
use App\Models\ZakatTransaction;
use Illuminate\Http\Request;
use PDF;

class DonorDashboardController extends Controller
{
    public function index()
    {
        $donor = Donor::find(session('donor_id'));
        
        if (!$donor) {
            return redirect()->route('donor.login');
        }

        // Get donation statistics
        $totalDonations = $donor->donations()->where('status', 'confirmed')->sum('amount');
        $donationCount = $donor->donations()->where('status', 'confirmed')->count();
        
        // Get zakat statistics
        $totalZakat = ZakatTransaction::where('email', $donor->email)
            ->where('status', 'confirmed')
            ->sum('amount');
        $zakatCount = ZakatTransaction::where('email', $donor->email)
            ->where('status', 'confirmed')
            ->count();

        // Recent donations
        $recentDonations = $donor->donations()
            ->with('campaign')
            ->latest()
            ->take(5)
            ->get();

        // Recent zakat
        $recentZakat = ZakatTransaction::where('email', $donor->email)
            ->with('zakatType')
            ->latest()
            ->take(5)
            ->get();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.donor.dashboard', compact(
                'donor',
                'totalDonations',
                'donationCount',
                'totalZakat',
                'zakatCount',
                'recentDonations',
                'recentZakat'
            ));
        }

        return view('donor.dashboard', compact(
            'donor',
            'totalDonations',
            'donationCount',
            'totalZakat',
            'zakatCount',
            'recentDonations',
            'recentZakat'
        ));
    }

    public function donations()
    {
        $donor = Donor::find(session('donor_id'));
        
        if (!$donor) {
            return redirect()->route('donor.login');
        }

        $donations = $donor->donations()
            ->with('campaign')
            ->latest()
            ->paginate(20);

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.donor.donations', compact('donor', 'donations'));
        }

        return view('donor.donations', compact('donor', 'donations'));
    }

    public function zakat()
    {
        $donor = Donor::find(session('donor_id'));
        
        if (!$donor) {
            return redirect()->route('donor.login');
        }

        $zakatTransactions = ZakatTransaction::where('email', $donor->email)
            ->with('zakatType')
            ->latest()
            ->paginate(20);

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.donor.zakat', compact('donor', 'zakatTransactions'));
        }

        return view('donor.zakat', compact('donor', 'zakatTransactions'));
    }

    public function downloadReceipt($id)
    {
        $donor = Donor::find(session('donor_id'));
        
        if (!$donor) {
            return redirect()->route('donor.login');
        }

        // Try to find in donations first
        $donation = $donor->donations()->find($id);
        
        if ($donation) {
            // Generate PDF for donation
            $pdf = PDF::loadView('pdf.donation-receipt', compact('donation', 'donor'));
            return $pdf->download('kwitansi-donasi-' . $donation->invoice . '.pdf');
        }

        // Try zakat transaction
        $zakat = ZakatTransaction::where('email', $donor->email)->find($id);
        
        if ($zakat) {
            // Generate PDF for zakat
            $pdf = PDF::loadView('pdf.zakat-receipt', compact('zakat', 'donor'));
            return $pdf->download('kwitansi-zakat-' . $zakat->invoice . '.pdf');
        }

        abort(404);
    }
}
