@extends('layouts.admin')

@section('title', 'Edit Laporan')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.laporans.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Manajemen Laporan
    </a>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Edit Laporan</h2>
        </div>
        
        <form action="{{ route('admin.laporans.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 p-8">
            @csrf
            @method('PUT')
            
            <!-- Judul (Opsional) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Laporan (Opsional)</label>
                <input type="text" name="title" value="{{ old('title', $laporan->title) }}" placeholder="Contoh: Laporan Keuangan Januari" 
                       class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bulan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                    <select name="month" required class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('month') border-red-500 @enderror">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                            <option value="{{ $m }}" {{ old('month', $laporan->month) == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                    @error('month')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                    <select name="year" required class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('year') border-red-500 @enderror">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ old('year', $laporan->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    @error('year')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cover Image -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Gambar</label>
                @if($laporan->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $laporan->image) }}" class="h-32 rounded-lg object-cover">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                <p class="text-xs text-gray-500 mt-1">Upload gambar baru untuk mengganti. Format: JPG, PNG. Max: 2MB.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- File PDF -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">File Laporan (PDF)</label>
                @if($laporan->file)
                    <div class="mb-3 flex items-center gap-2 text-sm text-gray-600">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        <span>File saat ini: <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank" class="text-primary hover:underline">Download PDF</a></span>
                    </div>
                @endif
                <input type="file" name="file" accept="application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                <p class="text-xs text-gray-500 mt-1">Upload PDF baru untuk mengganti. Max: 10MB.</p>
                @error('file')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                 <a href="{{ route('admin.laporans.index') }}" class="px-6 py-2.5 rounded-xl font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
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
