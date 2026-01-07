@extends('layouts.admin')

@section('title', 'Edit Metode Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8 pl-1">
        <a href="{{ route('admin.payment-methods.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-3">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Metode Pembayaran</h1>
        <p class="text-gray-500 mt-1">Perbarui data rekening bank.</p>
    </div>

    <form action="{{ route('admin.payment-methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm space-y-5">
            
            <!-- Bank Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank <span class="text-red-500">*</span></label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $paymentMethod->bank_name) }}" class="form-input @error('bank_name') border-red-500 @enderror" placeholder="Contoh: Bank Syariah Indonesia">
                @error('bank_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Account Number -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening <span class="text-red-500">*</span></label>
                    <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" class="form-input @error('account_number') border-red-500 @enderror" placeholder="Contoh: 1234567890">
                    @error('account_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Account Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Atas Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="account_name" value="{{ old('account_name', $paymentMethod->account_name) }}" class="form-input @error('account_name') border-red-500 @enderror" placeholder="Contoh: Yayasan Wakaf">
                    @error('account_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Logo -->
            <div>
                 <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Bank</label>
                 <div class="relative group">
                    <input type="file" name="logo_url" id="logo_input" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <div class="w-full h-32 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center gap-2 text-gray-400 hover:border-primary hover:text-primary transition-all cursor-pointer bg-gray-50/50" onclick="document.getElementById('logo_input').click()">
                        <div id="preview_container" class="{{ $paymentMethod->logo_url ? '' : 'hidden' }} w-full h-full p-2 flex items-center justify-center">
                            <img id="preview_img" src="{{ $paymentMethod->logo_url ? asset($paymentMethod->logo_url) : '' }}" class="max-h-full max-w-full object-contain">
                        </div>
                        <div id="upload_placeholder" class="{{ $paymentMethod->logo_url ? 'hidden' : 'flex' }} flex flex-col items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                            <span class="text-sm font-medium mt-2">Upload Logo (Opsional)</span>
                        </div>
                        
                        <!-- Change Overlay -->
                        <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center rounded-xl transition-all">
                            <span class="text-white font-medium text-sm">Ganti Logo</span>
                        </div>
                    </div>
                 </div>
                 @error('logo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Instructions -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi Pembayaran</label>
                <textarea name="instructions" rows="3" class="form-input @error('instructions') border-red-500 @enderror" placeholder="Catatan tambahan untuk donatur...">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                @error('instructions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }} class="w-5 h-5 text-primary rounded border-gray-300 focus:ring-primary">
                <label for="is_active" class="font-medium text-gray-700 select-none cursor-pointer">Aktifkan Metode Pembayaran ini</label>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-5 py-2.5 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_img').src = e.target.result;
                document.getElementById('preview_container').classList.remove('hidden');
                document.getElementById('upload_placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
