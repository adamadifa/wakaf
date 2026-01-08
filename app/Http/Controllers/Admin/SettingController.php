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
            'maps_embed' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->only(['address', 'maps_embed']);

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
