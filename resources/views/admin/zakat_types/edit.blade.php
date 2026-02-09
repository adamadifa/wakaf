@extends('layouts.admin')

@section('title', 'Edit Jenis Zakat')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8 pl-1">
        <a href="{{ route('admin.zakat-types.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-3">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Jenis Zakat
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Jenis Zakat</h1>
        <p class="text-gray-500 mt-1">Perbarui informasi jenis zakat.</p>
    </div>

    <form action="{{ route('admin.zakat-types.update', $zakatType) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Zakat <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $zakatType->name) }}" required 
                           class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-sm outline-none @error('name') !border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="category" required 
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-sm outline-none appearance-none cursor-pointer @error('category') !border-red-500 @enderror">
                            <option value="mal" {{ old('category', $zakatType->category) == 'mal' ? 'selected' : '' }}>Zakat Mal (Harta)</option>
                            <option value="fitrah" {{ old('category', $zakatType->category) == 'fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </div>
                    </div>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="4" 
                          class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-sm outline-none resize-none">{{ old('description', $zakatType->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Icon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon Class (Tabler Icons)</label>
                    <div class="relative">
                        <input type="text" name="icon" value="{{ old('icon', $zakatType->icon) }}" 
                               class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all text-sm outline-none">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                             <i class="ti ti-star text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-right">
                        <a href="https://tabler-icons.io/" target="_blank" class="text-xs text-primary hover:underline font-medium">Lihat Daftar Icon</a>
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Thumbnail Image</label>
                    <div class="space-y-3">
                        @if($zakatType->image)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <img src="{{ Str::startsWith($zakatType->image, 'http') ? $zakatType->image : asset($zakatType->image) }}" class="h-12 w-16 object-cover rounded-lg" alt="Current Image">
                                <div class="text-xs text-gray-500">Gambar saat ini</div>
                            </div>
                        @endif
                        <input type="file" name="image" 
                               class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all text-sm text-gray-500" accept="image/*">
                        <p class="text-[11px] text-gray-400 ml-1">Format: JPG, PNG. Max: 2MB.</p>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3">
                <a href="{{ route('admin.zakat-types.index') }}" class="px-5 py-2.5 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">
                    Update Data
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
