<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'judul' => 'Tentang Kami',
                'deskripsi' => 'Deskripsi tentang organisasi Anda.',
                'gambar' => null,
            ]);
        }
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([]);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $input = $request->only(['judul', 'deskripsi']);

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('about', $filename, 'public');
            $input['gambar'] = 'storage/' . $path;

            // Delete old image
            if ($about->gambar && file_exists(public_path($about->gambar))) {
                unlink(public_path($about->gambar));
            }
        }

        $about->update($input);

        return redirect()->back()->with('success', 'Data Tentang Kami berhasil diperbarui.');
    }
}
