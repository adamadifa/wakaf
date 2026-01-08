@extends('layouts.admin')

@section('title', 'Pengaturan Situs')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Situs</h1>
    <p class="text-gray-500 text-sm mt-1">Kelola informasi dasar situs web.</p>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')
            
            <!-- Logo -->
            <div class="mb-8 pb-8 border-b border-gray-50">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Identitas Visual</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Website</label>
                        @if($setting->logo)
                            <div class="mb-3 p-4 bg-gray-50 rounded-xl inline-block">
                                <img src="{{ asset('storage/' . $setting->logo) }}" class="h-12 object-contain">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        <p class="text-xs text-gray-500 mt-1">Format: PNG, SVG, JPG. Max: 2MB.</p>
                        @error('logo') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Header Utama (Hero)</label>
                        @if($setting->header_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $setting->header_image) }}" class="h-32 w-full object-cover rounded-xl">
                            </div>
                        @endif
                        <input type="file" name="header_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        <p class="text-xs text-gray-500 mt-1">Gambar background untuk halaman depan. Max: 5MB.</p>
                        @error('header_image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi & Lokasi</h3>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="3" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">{{ old('address', $setting->address) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Akan ditampilkan di footer website.</p>
                    @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Google Maps Embed (Iframe URL)</label>
                    <textarea name="maps_embed" rows="3" placeholder='https://www.google.com/maps/embed?pb=...' class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">{{ old('maps_embed', $setting->maps_embed) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Masukkan URL dari src iframe Google Maps. Contoh: https://www.google.com/maps/embed?pb=...</p>
                    @error('maps_embed') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                
                @if($setting->maps_embed)
                    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 mb-2">Preview Maps:</p>
                        <iframe src="{{ $setting->maps_embed }}" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-lg"></iframe>
                    </div>
                @endif
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end pt-6 border-t border-gray-50">
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
