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
            'pwa_icon' => 'nullable|image|mimes:png|max:5120',
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

        if ($request->hasFile('pwa_icon')) {
            $file = $request->file('pwa_icon');
            $tempPath = $file->path();
            
            // Paths for PWA icons in public directory
            $publicPath = public_path();
            $iconPaths = [
                'pwa-icon-512.png' => 512,
                'pwa-icon-192.png' => 192,
                'pwa-icon.png' => 512,
                'apple-touch-icon.png' => 180,
            ];

            foreach ($iconPaths as $filename => $size) {
                $targetPath = $publicPath . '/' . $filename;
                // Use sips for high-quality resizing on Mac
                $command = "sips -z $size $size " . escapeshellarg($tempPath) . " --out " . escapeshellarg($targetPath);
                exec($command);
            }

            // Update manifest.json with cache busting timestamp
            $manifestPath = public_path('manifest.json');
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                if (isset($manifest['icons'])) {
                    $timestamp = time();
                    foreach ($manifest['icons'] as &$icon) {
                        $baseSrc = explode('?', $icon['src'])[0];
                        $icon['src'] = $baseSrc . '?v=' . $timestamp;
                    }
                    file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                }
            }
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
