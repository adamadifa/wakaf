<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->paginate(10);
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo_url')) {
            $path = $request->file('logo_url')->store('payment_methods', 'public');
            $validated['logo_url'] = '/storage/' . $path;
        }

        // Checkbox handling
        $validated['is_active'] = $request->has('is_active');

        PaymentMethod::create($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo_url')) {
            // Delete old logo if exists
            if ($paymentMethod->logo_url) {
                $oldPath = str_replace('/storage/', '', $paymentMethod->logo_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('logo_url')->store('payment_methods', 'public');
            $validated['logo_url'] = '/storage/' . $path;
        }

        // Checkbox handling is tricky with validate, better to force it if not present but we are validating boolean.
        // If unchecked, it won't be in request, so we need to set it manually if using fill/update directly on validated data??
        // Actually, $request->validate won't include 'is_active' if it's missing from request (unchecked checkbox).
        // So we merge it.
        $validated['is_active'] = $request->has('is_active');

        $paymentMethod->update($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->logo_url) {
            $oldPath = str_replace('/storage/', '', $paymentMethod->logo_url);
            Storage::disk('public')->delete($oldPath);
        }
        
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
