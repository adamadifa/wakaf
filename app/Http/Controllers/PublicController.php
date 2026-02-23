<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentInstructionMail;

class PublicController extends Controller
{
    public function home()
    {
        // Get latest news
        $latestNews = \App\Models\News::whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Get active campaigns for slider (optional, or use static images)
        // Get active campaigns for slider (optional, or use static images)
        $sliderCampaigns = Campaign::where('status', 'active')
            ->where('is_featured', true)
            ->take(5)
            ->get();
            
        if ($sliderCampaigns->isEmpty()) {
             $sliderCampaigns = Campaign::where('status', 'active')->latest()->take(5)->get();
        }

        // Get featured infaq categories for slider
        $featuredInfaq = \App\Models\InfaqCategory::where('is_featured', true)->get();

        // Build unified slider items collection
        $sliderItems = collect();

        foreach ($sliderCampaigns as $campaign) {
            $sliderItems->push((object) [
                'type' => 'campaign',
                'title' => $campaign->title,
                'image_url' => $campaign->image_url,
                'url' => route('campaign.show', $campaign->slug),
                'badge' => $campaign->category->name ?? 'Program Unggulan',
            ]);
        }

        foreach ($featuredInfaq as $infaq) {
            $sliderItems->push((object) [
                'type' => 'infaq',
                'title' => $infaq->name,
                'image_url' => $infaq->image,
                'url' => route('infaq.show', $infaq->id),
                'badge' => 'Program Infaq',
            ]);
        }

        // Feature: Ensure enough slides for infinite loop smoothness (Safe Duplication)
        // If we have valid slides but fewer than 6, duplicate them to support Swiper loop
        $count = $sliderItems->count();
        if ($count > 0 && $count < 6) {
            $cloned = $sliderItems->values();
            $sliderItems = $sliderItems->merge($cloned);
            
            // If still less than 6 (e.g., started with 2, now 4), merge one more time
            if ($sliderItems->count() < 6) {
                $sliderItems = $sliderItems->merge($cloned);
            }
        }
        $latestDonations = \App\Models\Donation::where('status', 'confirmed')
            ->whereNotNull('message')
            ->where('message', '!=', '')
            ->with(['donor', 'campaign'])
            ->latest()
            ->take(10)
            ->take(10)
            ->get();

        $managers = \App\Models\Manager::orderBy('order')->get();

        // Build latest programs (combined wakaf + infaq), sorted by newest first, take 8
        $latestPrograms = collect();

        $latestCampaigns = Campaign::where('status', 'active')->latest()->take(8)->get();
        foreach ($latestCampaigns as $campaign) {
            $imgUrl = $campaign->image_url;
            if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                $imgUrl = str_starts_with($imgUrl, '/storage') ? $imgUrl : '/storage/' . $imgUrl;
            }
            $latestPrograms->push((object) [
                'type' => 'campaign',
                'title' => $campaign->title,
                'image_url' => $imgUrl,
                'url' => route('campaign.show', $campaign->slug),
                'badge' => $campaign->category->name ?? 'Wakaf',
                'badge_color' => 'emerald',
                'description' => $campaign->short_description,
                'created_at' => $campaign->created_at,
            ]);
        }

        $latestInfaq = \App\Models\InfaqCategory::latest()->take(8)->get();
        foreach ($latestInfaq as $infaq) {
            $imgUrl = $infaq->image;
            if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                $imgUrl = str_starts_with($imgUrl, '/storage') ? $imgUrl : '/storage/' . $imgUrl;
            }
            $latestPrograms->push((object) [
                'type' => 'infaq',
                'title' => $infaq->name,
                'image_url' => $imgUrl,
                'url' => route('infaq.show', $infaq->id),
                'badge' => 'Infaq',
                'badge_color' => 'blue',
                'description' => $infaq->description ? \Illuminate\Support\Str::limit($infaq->description, 200) : null,
                'created_at' => $infaq->created_at,
            ]);
        }

        // Sort by created_at descending to interleave, then take 8
        $latestPrograms = $latestPrograms->sortByDesc('created_at')->take(8)->values();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.home', compact('latestNews', 'sliderItems', 'latestDonations', 'managers', 'latestPrograms'));
        }

        return view('home', compact('latestNews', 'sliderItems', 'latestDonations', 'managers', 'latestPrograms'));
    }

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

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.wakaf.index', compact('campaigns', 'latestDonations', 'latestNews'));
        }

        return view('welcome', compact('campaigns', 'latestDonations', 'latestNews'));
    }

    public function programs(Request $request)
    {
        $query = Campaign::where('status', 'active');

        if ($request->has('q')) {
            $search = $request->q;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $campaigns = $query->latest()->paginate(9);
        $categories = \App\Models\Category::all();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.programs.index', compact('campaigns', 'categories'));
        }

        return view('campaigns.index', compact('campaigns', 'categories'));
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

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.campaigns.show', compact('campaign'));
        }

        return view('campaigns.show', compact('campaign'));
    }

    public function donate(Campaign $campaign)
    {
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        $setting = \App\Models\Setting::first();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.campaigns.donate', compact('campaign', 'paymentMethods', 'setting'));
        }

        return view('campaigns.donate', compact('campaign', 'paymentMethods', 'setting'));
    }

    public function storeDonation(Request $request, Campaign $campaign)
    {
        $setting = \App\Models\Setting::first();
        $isOnlinePayment = $request->payment_type === 'online' && $setting && $setting->is_payment_gateway_active;

        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_method_id' => $isOnlinePayment ? 'nullable' : 'required|exists:payment_methods,id',
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

        // Calculate totals
        $adminFee = 0;

        if ($isOnlinePayment) {
            $adminFee = $setting->midtrans_admin_fee ?? 0;
            $uniqueCode = 0;
            $totalTransfer = $request->amount + $adminFee;
            $paymentMethodId = null;
        } else {
            $uniqueCode = rand(100, 999);
            $totalTransfer = $request->amount + $uniqueCode;
            $paymentMethodId = $request->payment_method_id;
        }

        $donation = \App\Models\Donation::create([
            'invoice_number' => 'INV/' . date('Ymd') . '/' . rand(1000, 9999),
            'campaign_id' => $campaign->id,
            'donor_id' => $donor->id,
            'payment_method_id' => $paymentMethodId,
            'amount' => $request->amount,
            'admin_fee' => $adminFee,
            'unique_code' => $uniqueCode,
            'total_transfer' => $totalTransfer,
            'message' => $request->message,
            'status' => 'pending',
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        // Handle Online Payment (Midtrans)
        if ($isOnlinePayment) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

            $itemDetails = [
                [
                    'id' => $campaign->id,
                    'price' => $donation->amount,
                    'quantity' => 1,
                    'name' => substr($campaign->title, 0, 50),
                ]
            ];

            if ($adminFee > 0) {
                $itemDetails[] = [
                    'id' => 'ADMIN-FEE',
                    'price' => $adminFee,
                    'quantity' => 1,
                    'name' => 'Biaya Admin',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $donation->invoice_number,
                    'gross_amount' => $donation->total_transfer,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ],
                'item_details' => $itemDetails
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $donation->update([
                    'snap_token' => $snapToken,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Midtrans Error: ' . $e->getMessage());
            }
        }

        // Send Payment Instruction Email via Queue
        try {
            dispatch(new \App\Jobs\SendEmailJob($request->email, new PaymentInstructionMail($donation)));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Job Dispatch Error: ' . $e->getMessage());
        }

        return redirect()->route('campaign.success', $donation->invoice_number);
    }

    public function success($invoice)
    {
        $donation = \App\Models\Donation::where('invoice_number', $invoice)
            ->with(['campaign', 'paymentMethod'])
            ->firstOrFail();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.campaigns.success', compact('donation'));
        }

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

    public function about()
    {
        $about = \App\Models\About::first();
        
        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.about', compact('about'));
        }

        return view('about', compact('about'));
    }

    public function visionMission()
    {
        $visionMission = \App\Models\VisionMission::first();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.vision_mission', compact('visionMission'));
        }

        return view('vision_mission', compact('visionMission'));
    }

    public function visionMissionWakaf()
    {
        $visionMission = \App\Models\VisionMissionWakaf::first();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.vision_mission_wakaf', compact('visionMission'));
        }

        return view('vision_mission_wakaf', compact('visionMission'));
    }

    public function managers()
    {
        $managers = \App\Models\Manager::orderBy('order')->get();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.managers', compact('managers'));
        }

        return view('managers', compact('managers'));
    }

    public function contact()
    {
        $setting = \App\Models\Setting::first();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.contact', compact('setting'));
        }

        return view('contact', compact('setting'));
    }

    public function rekening()
    {
        $accounts = \App\Models\PaymentMethod::where('is_active', true)->get();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.rekening', compact('accounts'));
        }

        return view('rekening', compact('accounts'));
    }
    public function aboutWakaf()
    {
        $about = \App\Models\AboutWakaf::first();
        
        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('mobile.about-wakaf', compact('about'));
        }

        return view('about-wakaf', compact('about'));
    }
}
