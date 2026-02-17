<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([]);
        }
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([]);
        }

        $request->validate([
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'maps_embed' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'is_payment_gateway_active' => 'nullable|boolean',
            'midtrans_merchant_id' => 'nullable|string',
            'midtrans_client_key' => 'nullable|string',
            'midtrans_server_key' => 'nullable|string',
            'midtrans_is_production' => 'nullable|boolean',
            'midtrans_admin_fee' => 'nullable|numeric|min:0',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'short_description' => 'nullable|string',
        ]);

        $data = $request->only([
            'address', 'phone_number', 'maps_embed', 
            'midtrans_merchant_id', 'midtrans_client_key', 'midtrans_server_key', 'midtrans_admin_fee',
            'facebook', 'instagram', 'twitter', 'linkedin', 'youtube',
            'short_description'
        ]);
        $data['is_payment_gateway_active'] = $request->has('is_payment_gateway_active');
        $data['midtrans_is_production'] = $request->has('midtrans_is_production');

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('header_image')) {
            if ($setting->header_image) {
                Storage::disk('public')->delete($setting->header_image);
            }
            $data['header_image'] = $request->file('header_image')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
