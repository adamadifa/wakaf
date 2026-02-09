<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZakatType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ZakatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zakatTypes = ZakatType::latest()->get();
        return view('admin.zakat_types.index', compact('zakatTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.zakat_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:fitrah,mal',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'nisab' => 'nullable|string',
            'rate' => 'nullable|string',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('zakat-types', 'public');
            $data['image'] = Storage::url($path);
        }

        ZakatType::create($data);

        return redirect()->route('admin.zakat-types.index')->with('success', 'Zakat Type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZakatType $zakatType)
    {
        return view('admin.zakat_types.edit', compact('zakatType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ZakatType $zakatType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:fitrah,mal',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists and is not a remote URL (starts with http)
            if ($zakatType->image && !str_starts_with($zakatType->image, 'http')) {
                 $oldPath = str_replace('/storage/', '', $zakatType->image);
                 Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('zakat-types', 'public');
            $data['image'] = Storage::url($path);
        }

        $zakatType->update($data);

        return redirect()->route('admin.zakat-types.index')->with('success', 'Zakat Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZakatType $zakatType)
    {
        if ($zakatType->image && !str_starts_with($zakatType->image, 'http')) {
             $oldPath = str_replace('/storage/', '', $zakatType->image);
             Storage::disk('public')->delete($oldPath);
        }
        
        $zakatType->delete();

        return redirect()->route('admin.zakat-types.index')->with('success', 'Zakat Type deleted successfully.');
    }
}
