<?php

namespace App\Http\Controllers;

use App\Models\InfaqCategory;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class InfaqController extends Controller
{
    public function index()
    {
        $categories = InfaqCategory::all();

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.infaq.index', compact('categories'));
        }

        return view('infaq.index', compact('categories'));
    }

    public function show($id)
    {
        $category = InfaqCategory::findOrFail($id);
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        $setting = \App\Models\Setting::first();

        $totalCollected = \App\Models\InfaqTransaction::where('infaq_category_id', $id)
            ->where('status', 'confirmed')
            ->sum('amount');

        $donorCount = \App\Models\InfaqTransaction::where('infaq_category_id', $id)
            ->where('status', 'confirmed')
            ->count();

        $recentDonors = \App\Models\InfaqTransaction::where('infaq_category_id', $id)
            ->where('status', 'confirmed')
            ->orderBy('confirmed_at', 'desc')
            ->take(10)
            ->get();

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.infaq.show', compact('category', 'paymentMethods', 'setting', 'totalCollected', 'donorCount', 'recentDonors'));
        }

        return view('infaq.show', compact('category', 'paymentMethods', 'setting', 'totalCollected', 'donorCount', 'recentDonors'));
    }

    public function store(Request $request, $id)
    {
        $setting = \App\Models\Setting::first();
        $isOnlinePayment = $request->payment_type === 'online' && $setting && $setting->is_payment_gateway_active;

        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_method_id' => $isOnlinePayment ? 'nullable' : 'required|exists:payment_methods,id',
        ]);

        $category = InfaqCategory::findOrFail($id);

        // Find or create donor
        $donor = \App\Models\Donor::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
            ]
        );

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

        $transaction = \App\Models\InfaqTransaction::create([
            'invoice_number' => 'INF/' . date('Ymd') . '/' . rand(1000, 9999),
            'infaq_category_id' => $category->id,
            'donor_id' => $donor->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_anonymous' => $request->has('is_anonymous'),
            'message' => $request->message,
            'amount' => $request->amount,
            'admin_fee' => $adminFee,
            'unique_code' => $uniqueCode,
            'total_transfer' => $totalTransfer,
            'payment_method_id' => $paymentMethodId,
            'status' => 'pending',
        ]);

        // Handle Online Payment (Midtrans)
        if ($isOnlinePayment) {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

            $itemDetails = [
                [
                    'id' => $category->id,
                    'price' => $transaction->amount,
                    'quantity' => 1,
                    'name' => 'Infaq: ' . substr($category->name, 0, 40),
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
                    'order_id' => $transaction->invoice_number,
                    'gross_amount' => $transaction->total_transfer,
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
                $transaction->update([
                    'snap_token' => $snapToken,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Midtrans Infaq Error: ' . $e->getMessage());
            }
        }

        // Send Payment Instruction Email
        try {
            dispatch(new \App\Jobs\SendEmailJob($request->email, new \App\Mail\InfaqPaymentInstructionMail($transaction)));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Infaq Email Error: ' . $e->getMessage());
        }

        return redirect()->route('infaq.success', $transaction->invoice_number);
    }

    public function success($invoice)
    {
        $transaction = \App\Models\InfaqTransaction::where('invoice_number', $invoice)
            ->with(['paymentMethod'])
            ->firstOrFail();

        $setting = \App\Models\Setting::first();

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.infaq.success', compact('transaction', 'setting'));
        }

        return view('infaq.success', compact('transaction', 'setting'));
    }

    public function confirm(Request $request, $invoice)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $transaction = \App\Models\InfaqTransaction::where('invoice_number', $invoice)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('infaq_proofs', 'public');
            $transaction->update([
                'payment_proof' => $path,
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Admin akan segera memverifikasi infaq Anda.');
    }
}
