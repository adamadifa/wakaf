@extends('layouts.admin')

@section('title', 'Tambah Mitra')

@section('content')
<div class="mb-8">
    <div class="mb-6">
        <a href="{{ route('admin.mitras.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary font-medium transition-colors">
            <i class="ti ti-arrow-left"></i>
            Kembali ke Manajemen Mitra
        </a>
    </div>

    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Tambah Mitra Baru</h2>

            <form action="{{ route('admin.mitras.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="Masukkan nama mitra" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Logo Mitra <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer" onclick="document.getElementById('logo-input').click()">
                            <input type="file" id="logo-input" name="logo" accept="image/*" required class="hidden" onchange="previewLogo(this)">
                            
                            <div id="logo-placeholder">
                                <i class="ti ti-cloud-upload text-3xl text-gray-300 mb-2"></i>
                                <p class="text-sm font-semibold text-gray-600">Upload Logo</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG, WebP (maks. 2MB)</p>
                            </div>

                            <div id="logo-preview" class="hidden">
                                <img id="preview-img" src="" class="max-h-24 mx-auto">
                                <p class="text-xs text-primary mt-2 font-medium">Klik untuk mengganti</p>
                            </div>
                        </div>
                        @error('logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="0">
                        <p class="text-xs text-gray-400 mt-1">Semakin kecil angka, semakin atas posisinya.</p>
                    </div>

                    <!-- Active -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" id="is_active" checked class="rounded border-gray-300 text-primary focus:ring-primary">
                        <label for="is_active" class="text-sm text-gray-700 font-medium">Aktif (tampilkan di website)</label>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="submit" class="flex items-center gap-2 bg-primary text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
                        <i class="ti ti-check"></i>
                        Simpan
                    </button>
                    <a href="{{ route('admin.mitras.index') }}" class="px-6 py-2.5 rounded-xl font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('logo-placeholder').classList.add('hidden');
                document.getElementById('logo-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
