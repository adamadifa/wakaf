<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::ordered()->paginate(12);
        return view('admin.mitras.index', compact('mitras'));
    }

    public function create()
    {
        return view('admin.mitras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $logoPath = $request->file('logo')->store('mitras', 'public');

        Mitra::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function edit(Mitra $mitra)
    {
        return view('admin.mitras.edit', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($mitra->logo) {
                Storage::disk('public')->delete($mitra->logo);
            }
            $data['logo'] = $request->file('logo')->store('mitras', 'public');
        }

        $mitra->update($data);

        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy(Mitra $mitra)
    {
        if ($mitra->logo) {
            Storage::disk('public')->delete($mitra->logo);
        }

        $mitra->delete();

        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil dihapus.');
    }
}
