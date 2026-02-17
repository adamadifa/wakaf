<?php

namespace App\Http\Controllers;

use App\Models\ZakatType;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ZakatController extends Controller
{
    public function index()
    {
        // Auto-seed if empty (Temporary solution for immediate display)
        if (ZakatType::count() == 0) {
            $this->seedZakatTypes();
        }

        $zakatTypes = ZakatType::all()->groupBy('category');

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.zakat.index', compact('zakatTypes'));
        }

        return view('zakat.index', compact('zakatTypes'));
    }

    private function seedZakatTypes()
    {
        $types = [
            [
                'category' => 'fitrah',
                'name' => 'Zakat Fitrah',
                'description' => 'Zakat yang wajib dikeluarkan setiap Muslim pada bulan Ramadan sebelum salat Idulfitri. Wajib bagi setiap Muslim yang mampu.',
                'icon' => 'ti-bowl',
                'image' => 'https://images.unsplash.com/photo-1627889708993-9c8e14620023?q=80&w=600&auto=format&fit=crop' // Rice/Grains
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Emas dan Perak',
                'description' => 'Zakat atas kepemilikan emas dan perak yang mencapai nisab dan haul.',
                'icon' => 'ti-gold',
                'image' => 'https://images.unsplash.com/photo-1610375461246-83df859d849d?q=80&w=600&auto=format&fit=crop' // Gold
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Uang / Tabungan',
                'description' => 'Disamakan dengan emas. Termasuk uang tunai, tabungan, dan deposito.',
                'icon' => 'ti-wallet',
                'image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?q=80&w=600&auto=format&fit=crop' // Money
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Perdagangan',
                'description' => 'Untuk barang dagangan (usaha, toko, online shop, dll).',
                'icon' => 'ti-shopping-cart',
                'image' => 'https://images.unsplash.com/photo-1556740758-90de2742dd78?q=80&w=600&auto=format&fit=crop' // Commerce
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Pertanian',
                'description' => 'Hasil pertanian seperti padi, gandum, kurma, dll.',
                'icon' => 'ti-plant',
                'image' => 'https://images.unsplash.com/photo-1625246333195-58403a79a8e8?q=80&w=600&auto=format&fit=crop' // Agriculture
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Peternakan',
                'description' => 'Zakat untuk hewan ternak seperti unta, sapi, dan kambing.',
                'icon' => 'ti-paw',
                'image' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?q=80&w=600&auto=format&fit=crop' // Livestock (Goats)
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Rikaz',
                'description' => 'Harta karun atau temuan (harta terpendam). Tidak menunggu haul.',
                'icon' => 'ti-treasure-chest',
                'image' => 'https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?q=80&w=600&auto=format&fit=crop' // Treasure/Jewelry
            ],
            [
                'category' => 'mal',
                'name' => 'Zakat Profesi',
                'description' => 'Zakat penghasilan dari gaji, honor, atau jasa profesi.',
                'icon' => 'ti-briefcase',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=600&auto=format&fit=crop' // Professional
            ],
        ];

        foreach ($types as $type) {
            ZakatType::create($type);
        }
    }
    public function show($id)
    {
        $zakatType = ZakatType::findOrFail($id);
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        $setting = \App\Models\Setting::first();

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.zakat.show', compact('zakatType', 'paymentMethods', 'setting'));
        }

        return view('zakat.show', compact('zakatType', 'paymentMethods', 'setting'));
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

        $zakatType = ZakatType::findOrFail($id);

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

        $transaction = \App\Models\ZakatTransaction::create([
            'invoice_number' => 'ZKT/' . date('Ymd') . '/' . rand(1000, 9999),
            'zakat_type_id' => $zakatType->id,
            'donor_id' => $donor->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => $request->amount,
            'admin_fee' => $adminFee,
            'unique_code' => $uniqueCode,
            'total_transfer' => $totalTransfer,
            'payment_method_id' => $paymentMethodId,
            'status' => 'pending',
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
                    'id' => $zakatType->id,
                    'price' => $transaction->amount,
                    'quantity' => 1,
                    'name' => 'Zakat: ' . substr($zakatType->name, 0, 40),
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
                \Illuminate\Support\Facades\Log::error('Midtrans Zakat Error: ' . $e->getMessage());
            }
        }

        // Send Payment Instruction Email
        try {
            dispatch(new \App\Jobs\SendEmailJob($request->email, new \App\Mail\ZakatPaymentInstructionMail($transaction)));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Zakat Email Error: ' . $e->getMessage());
        }

        return redirect()->route('zakat.success', $transaction->invoice_number);
    }

    public function success($invoice)
    {
        $transaction = \App\Models\ZakatTransaction::where('invoice_number', $invoice)
            ->with(['paymentMethod'])
            ->firstOrFail();

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.zakat.success', compact('transaction'));
        }

        return view('zakat.success', compact('transaction'));
    }

    public function confirm(Request $request, $invoice)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048', // Max 2MB
        ]);

        $transaction = \App\Models\ZakatTransaction::where('invoice_number', $invoice)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('zakat_proofs', 'public');
            $transaction->update([
                'payment_proof' => $path,
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Admin akan segera memverifikasi zakat Anda.');
    }
}
