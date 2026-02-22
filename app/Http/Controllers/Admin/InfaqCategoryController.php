<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfaqCategory;
use Illuminate\Http\Request;

class InfaqCategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\InfaqCategory::latest()->get();
        return view('admin.infaq_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.infaq_categories.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('image');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('infaq-categories', 'public');
            $data['image'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        \App\Models\InfaqCategory::create($data);

        return redirect()->route('admin.infaq-categories.index')->with('success', 'Kategori Infaq berhasil dibuat.');
    }

    public function edit(\App\Models\InfaqCategory $infaqCategory)
    {
        return view('admin.infaq_categories.edit', compact('infaqCategory'));
    }

    public function show(\App\Models\InfaqCategory $infaqCategory)
    {
        $totalCollected = \App\Models\InfaqTransaction::where('infaq_category_id', $infaqCategory->id)
            ->where('status', 'confirmed')
            ->selectRaw('COALESCE(SUM(amount + unique_code), 0) as total')
            ->value('total');

        $donorCount = \App\Models\InfaqTransaction::where('infaq_category_id', $infaqCategory->id)
            ->where('status', 'confirmed')
            ->count();

        $donors = \App\Models\InfaqTransaction::where('infaq_category_id', $infaqCategory->id)
            ->where('status', 'confirmed')
            ->orderBy('confirmed_at', 'desc')
            ->get();

        return view('admin.infaq_categories.show', compact('infaqCategory', 'totalCollected', 'donorCount', 'donors'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\InfaqCategory $infaqCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('image');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            if ($infaqCategory->image && !str_starts_with($infaqCategory->image, 'http')) {
                 $oldPath = str_replace('/storage/', '', $infaqCategory->image);
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('infaq-categories', 'public');
            $data['image'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        $infaqCategory->update($data);

        return redirect()->route('admin.infaq-categories.index')->with('success', 'Kategori Infaq berhasil diperbarui.');
    }

    public function destroy(\App\Models\InfaqCategory $infaqCategory)
    {
        if ($infaqCategory->image && !str_starts_with($infaqCategory->image, 'http')) {
             $oldPath = str_replace('/storage/', '', $infaqCategory->image);
             \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }
        
        $infaqCategory->delete();

        return redirect()->route('admin.infaq-categories.index')->with('success', 'Kategori Infaq berhasil dihapus.');
    }
}
