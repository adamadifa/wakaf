<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::where('is_published', true)
            ->withCount('photos')
            ->latest()
            ->paginate(12);

        return view('gallery.index', compact('albums'));
    }

    public function show($id)
    {
        $album = Album::where('is_published', true)
            ->with('photos')
            ->findOrFail($id);

        return view('gallery.show', compact('album'));
    }
}
