<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category')->whereNotNull('published_at');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $categorySlug = $request->category;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $news = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = \App\Models\NewsCategory::all(); // Get all categories for filter
        
        return view('news.index', compact('news', 'categories'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->whereNotNull('published_at')->firstOrFail();
        
        // Get related news (excluding current one)
        $relatedNews = News::where('id', '!=', $news->id)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();
            
        return view('news.show', compact('news', 'relatedNews'));
    }
}
