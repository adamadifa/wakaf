<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutWakaf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'umum');
        
        if ($tab === 'wakaf') {
            $about = AboutWakaf::first();
            if (!$about) {
                $about = AboutWakaf::create([
                    'judul' => 'Tentang Wakaf',
                    'deskripsi' => 'Deskripsi tentang program wakaf Anda.',
                    'gambar' => null,
                ]);
            }
        } else {
            $about = About::first();
            if (!$about) {
                $about = About::create([
                    'judul' => 'Tentang Kami',
                    'deskripsi' => 'Deskripsi tentang organisasi Anda.',
                    'gambar' => null,
                ]);
            }
        }

        return view('admin.about.index', compact('about', 'tab'));
    }

    public function update(Request $request)
    {
        $tab = $request->input('tab', 'umum');
        
        $model = ($tab === 'wakaf') ? AboutWakaf::class : About::class;
        $about = $model::first();
        if (!$about) {
            $about = $model::create([]);
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
            $folder = ($tab === 'wakaf') ? 'about_wakaf' : 'about';
            $path = $file->storeAs($folder, $filename, 'public');
            $input['gambar'] = 'storage/' . $path;

            // Delete old image
            if ($about->gambar && file_exists(public_path($about->gambar))) {
                unlink(public_path($about->gambar));
            }
        }

        $about->update($input);

        return redirect()->route('admin.about.index', ['tab' => $tab])
            ->with('success', 'Data ' . ($tab === 'wakaf' ? 'Tentang Wakaf' : 'Tentang Kami') . ' berhasil diperbarui.');
    }
}
