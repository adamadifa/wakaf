<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::latest()->paginate(10);
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.albums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $inputs = $request->except(['cover_image']);
        $album = Album::create($inputs);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('albums/covers', 'public');
            $album->update(['cover_image' => $path]);
        }

        return redirect()->route('admin.albums.index')->with('success', 'Album created successfully.');
    }

    public function show($id)
    {
        $album = Album::with(['photos' => function($q) {
            $q->orderBy('order', 'asc');
        }])->findOrFail($id);
        
        return view('admin.albums.show', compact('album'));
    }

    public function edit($id)
    {
        $album = Album::findOrFail($id);
        return view('admin.albums.edit', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $album = Album::findOrFail($id);
        $inputs = $request->except(['cover_image']);
        $album->update($inputs);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image && \Storage::disk('public')->exists($album->cover_image)) {
                \Storage::disk('public')->delete($album->cover_image);
            }
            $path = $request->file('cover_image')->store('albums/covers', 'public');
            $album->update(['cover_image' => $path]);
        }

        return redirect()->route('admin.albums.index')->with('success', 'Album updated successfully.');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        // Delete cover image
        if ($album->cover_image && \Storage::disk('public')->exists($album->cover_image)) {
            \Storage::disk('public')->delete($album->cover_image);
        }
        // Photos are deleted by cascade in DB, but files need manual deletion.
        // Or we can loop and delete them.
        foreach($album->photos as $photo) {
            if (\Storage::disk('public')->exists($photo->image_path)) {
                \Storage::disk('public')->delete($photo->image_path);
            }
        }
        $album->delete(); // This triggers cascade delete for records if configured in DB migration

        return redirect()->route('admin.albums.index')->with('success', 'Album deleted successfully.');
    }

    public function storePhoto(Request $request, $id)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $album = Album::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('albums/photos', 'public');
                $album->photos()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.albums.show', $album->id)->with('success', 'Photos uploaded successfully.');
    }

    public function destroyPhoto($id)
    {
        $photo = AlbumPhoto::findOrFail($id);
        $albumId = $photo->album_id;

        if (\Storage::disk('public')->exists($photo->image_path)) {
            \Storage::disk('public')->delete($photo->image_path);
        }
        $photo->delete();

        return redirect()->route('admin.albums.show', $albumId)->with('success', 'Photo deleted successfully.');
    }
}
