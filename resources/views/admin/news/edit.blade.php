@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Berita
    </a>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Edit Berita</h2>
        </div>
        
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 p-8">
            @csrf
            @method('PUT')
            
            <!-- Judul -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel</label>
                    <input type="text" name="title" value="{{ old('title', $news->title) }}" required 
                           class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="news_category_id" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
                        <option value="">-- Pilih Kategori (Opsional) --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('news_category_id', $news->news_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Gambar -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Utama</label>
                @if($news->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $news->image) }}" class="h-32 rounded-lg object-cover">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                <p class="text-xs text-gray-500 mt-1">Upload gambar baru untuk mengganti.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Berita -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten Berita</label>
                <textarea name="content" required rows="10" 
                          class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('content') border-red-500 @enderror">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Publikasi -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi</label>
                <input type="date" name="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : '') }}" 
                       class="form-input w-full md:w-1/2 px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                 <a href="{{ route('admin.news.index') }}" class="px-6 py-2.5 rounded-xl font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
