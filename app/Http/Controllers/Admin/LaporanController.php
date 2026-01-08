<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|digits:4',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'required|mimes:pdf|max:10240', // 10MB max for PDF
            'title' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['month', 'year', 'title']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('laporan-images', 'public');
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('laporan-files', 'public');
        }

        Laporan::create($data);

        return redirect()->route('admin.laporans.index')->with('success', 'Laporan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|digits:4',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'nullable|mimes:pdf|max:10240',
            'title' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['month', 'year', 'title']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($laporan->image) {
                Storage::disk('public')->delete($laporan->image);
            }
            $data['image'] = $request->file('image')->store('laporan-images', 'public');
        }

        if ($request->hasFile('file')) {
            // Delete old file
            if ($laporan->file) {
                Storage::disk('public')->delete($laporan->file);
            }
            $data['file'] = $request->file('file')->store('laporan-files', 'public');
        }

        $laporan->update($data);

        return redirect()->route('admin.laporans.index')->with('success', 'Laporan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->image) {
            Storage::disk('public')->delete($laporan->image);
        }
        if ($laporan->file) {
            Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return redirect()->route('admin.laporans.index')->with('success', 'Laporan deleted successfully.');
    }
}
