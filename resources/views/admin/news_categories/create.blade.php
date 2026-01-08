@extends('layouts.admin')

@section('title', 'Tambah Kategori Berita')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.news-categories.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Kategori
    </a>
</div>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Tambah Kategori Baru</h2>
        </div>
        
        <form action="{{ route('admin.news-categories.store') }}" method="POST" class="mt-6 p-8">
            @csrf
            
            <!-- Nama Kategori -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       placeholder="Contoh: Kegiatan Wakaf" 
                       class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                 <a href="{{ route('admin.news-categories.index') }}" class="px-6 py-2.5 rounded-xl font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
