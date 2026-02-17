<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = Manager::orderBy('order')->get();
        return view('admin.managers.index', compact('managers'));
    }

    public function create()
    {
        return view('admin.managers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'bio' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ]);

        $input = $request->all();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('managers', $filename, 'public');
            $input['image'] = 'storage/' . $path;
        }

        Manager::create($input);

        return redirect()->route('admin.managers.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Manager $manager)
    {
        return view('admin.managers.edit', compact('manager'));
    }

    public function update(Request $request, Manager $manager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'bio' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ]);

        $input = $request->all();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('managers', $filename, 'public');
            $input['image'] = 'storage/' . $path;
            
            // Delete old image
            if ($manager->image && file_exists(public_path($manager->image))) {
                unlink(public_path($manager->image));
            }
        } else {
            unset($input['image']);
        }

        $manager->update($input);

        return redirect()->route('admin.managers.index')->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(Manager $manager)
    {
        if ($manager->image && file_exists(public_path($manager->image))) {
            unlink(public_path($manager->image));
        }

        $manager->delete();

        return redirect()->route('admin.managers.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}
