<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donor::query();

        if ($request->has('q')) {
            $search = $request->q;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $donors = $query->latest()->paginate(10);
        
        return view('admin.donors.index', compact('donors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.donors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:donors',
            'phone' => 'nullable|string|max:20',
        ]);

        Donor::create($validated);

        return redirect()->route('admin.donors.index')
            ->with('success', 'Donatur berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donor $donor)
    {
        return view('admin.donors.edit', compact('donor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donor $donor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:donors,email,' . $donor->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $donor->update($validated);

        return redirect()->route('admin.donors.index')
            ->with('success', 'Data Donatur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donor $donor)
    {
        $donor->delete();

        return redirect()->route('admin.donors.index')
            ->with('success', 'Data Donatur berhasil dihapus.');
    }
}
