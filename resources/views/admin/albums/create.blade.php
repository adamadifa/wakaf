@extends('layouts.admin')

@section('title', 'Tambah Album Foto')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.albums.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-500">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900">Tambah Album Baru</h2>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Album</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 transition-all outline-none" value="{{ old('title') }}" placeholder="Contoh: Kegiatan Wakaf Akbar 2024" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring focus:ring-primary/20 transition-all outline-none" placeholder="Deskripsi singkat tentang album ini...">{{ old('description') }}</textarea>
            </div>

            <div class="mb-5">
                <label for="cover_image" class="block text-sm font-semibold text-gray-700 mb-2">Cover Album</label>
                <div class="flex items-center justify-center w-full">
                    <label for="cover_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="ti ti-cloud-upload text-2xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-primary">Klik untuk upload</span> atau drag and drop</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                        </div>
                        <input id="cover_image" name="cover_image" type="file" class="hidden" accept="image/*" />
                    </label>
                </div>
                @error('cover_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', 1) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    <span class="ms-3 text-sm font-medium text-gray-700">Publikasikan Album</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.albums.index') }}" class="px-5 py-2.5 rounded-xl text-gray-600 font-medium hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
                    Simpan Album
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
