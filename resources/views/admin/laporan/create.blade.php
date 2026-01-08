@extends('layouts.admin')

@section('title', 'Tambah Laporan')

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
            <h2 class="text-xl font-bold text-gray-800">Tambah Laporan Baru</h2>
        </div>
        
        <form action="{{ route('admin.laporans.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 p-8">
            @csrf
            
            <!-- Judul (Opsional) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Laporan (Opsional)</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Laporan Keuangan Januari" 
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
                            <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
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
                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                <input type="file" name="image" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- File PDF -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">File Laporan (PDF)</label>
                <input type="file" name="file" accept="application/pdf" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                <p class="text-xs text-gray-500 mt-1">Format: PDF only. Max: 10MB.</p>
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
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
