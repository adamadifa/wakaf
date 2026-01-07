@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Kategori
    </a>
</div>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Tambah Kategori Baru</h2>
        </div>
        
        <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST" class="mt-6 p-8 pt-0" novalidate>
            @csrf
            
            <!-- Nama Kategori -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       data-message="Mohon isi nama kategori."
                       placeholder="Contoh: Pendidikan, Kesehatan..." 
                       class="form-input @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="4" placeholder="Keterangan singkat kategori..." 
                          class="form-input @error('description') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                 <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 rounded-xl font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
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

@push('scripts')
<script>
    // Real-time Validation Script
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('category-form');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => {
                if (input.classList.contains('border-red-500') || input.value.trim() !== '') {
                    validateField(input);
                }
            });
        });

        form.addEventListener('submit', function(e) {
            let hasError = false;
            inputs.forEach(input => {
                if (!validateField(input)) hasError = true;
            });

            if (hasError) e.preventDefault();
        });

        function validateField(field) {
            const container = field.closest('.form-group');
            const errorText = container.querySelector('.validation-message');
            
            let isValid = true;
            let message = '';

            if (!field.value.trim()) {
                isValid = false;
                message = field.getAttribute('data-message') || 'Field ini wajib diisi.';
            }

            if (isValid) {
                field.classList.remove('!border-red-500', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
                field.classList.add('border-gray-200');
                if (errorText) {
                    errorText.classList.add('hidden');
                    errorText.textContent = '';
                }
            } else {
                field.classList.add('!border-red-500', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
                if (errorText) {
                    errorText.classList.remove('hidden');
                    errorText.textContent = message;
                }
            }
            return isValid;
        }
    });
</script>
@endpush
