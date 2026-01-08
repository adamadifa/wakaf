<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::latest()->paginate(10);
        return view('admin.news_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.news_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name',
        ]);

        NewsCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.news-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        //
    }

    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news_categories.edit', compact('newsCategory'));
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name,' . $newsCategory->id,
        ]);

        $newsCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.news-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        // Check if has related news? If nullOnDelete is set in migration, it's safe.
        $newsCategory->delete();
        return redirect()->route('admin.news-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
