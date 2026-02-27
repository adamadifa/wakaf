<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\News;
use App\Models\Album;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $campaigns = Campaign::latest()->get();
        $news = News::whereNotNull('published_at')->latest()->get();
        $albums = Album::where('is_published', true)->latest()->get();

        return response()->view('sitemap', [
            'campaigns' => $campaigns,
            'news' => $news,
            'albums' => $albums,
        ])->header('Content-Type', 'text/xml');
    }
}
