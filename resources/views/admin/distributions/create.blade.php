@extends('layouts.admin')

@section('title', 'Input Penyaluran')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.distributions.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Penyaluran
    </a>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Input Penyaluran Dana</h2>
            <p class="text-sm text-gray-500 mt-1">Catat penggunaan dana wakaf secara rinci.</p>
        </div>

        <form id="distribution-form" action="{{ route('admin.distributions.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 p-8" novalidate>
            @csrf
            
            <!-- Campaign Info -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Program Wakaf</label>
                <select name="campaign_id" required 
                        data-message="Silakan pilih program wakaf."
                        class="select2 w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-primary/20 transition-all text-sm @error('campaign_id') border-red-500 @enderror">
                    <option value="">Pilih Program Wakaf</option>
                    @foreach($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>
                            {{ $campaign->title }} (Terkumpul: Rp {{ number_format($campaign->current_amount, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('campaign_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Penyaluran</label>
                <input type="text" name="title" value="{{ old('title') }}" required 
                       data-message="Mohon isi judul penyaluran."
                       placeholder="Contoh: Pembelian Semen Tahap 1" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-primary/20 transition-all text-sm @error('title') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Dana (Rp)</label>
                <div class="flex items-center border rounded-xl transition-all overflow-hidden bg-white @error('amount') border-red-500 focus-within:border-red-500 focus-within:ring-red-500/20 @else border-gray-200 focus-within:border-primary focus-within:ring-primary/20 @enderror input-group-validate">
                    <div class="px-4 py-3 bg-gray-50 border-r border-gray-100 text-gray-500 font-medium">Rp</div>
                    <input type="text" id="amount_display" required placeholder="0" 
                           data-message="Jumlah dana belum diisi."
                           value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}"
                           class="w-full px-4 py-3 outline-none border-none bg-transparent placeholder-gray-400 text-gray-900 text-right font-medium"
                           oninput="formatCurrency(this)">
                    <input type="hidden" name="amount" id="amount" value="{{ old('amount') }}">
                </div>
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('amount')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Penyaluran</label>
                <input type="text" name="distributed_at" value="{{ old('distributed_at', date('Y-m-d')) }}" required
                       data-message="Pilih tanggal penyaluran."
                       class="datepicker w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-primary/20 transition-all text-sm bg-white @error('distributed_at') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('distributed_at')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Rincian</label>
                <textarea name="description" required rows="5" 
                          data-message="Mohon lengkapi keterangan penggunaan dana."
                          placeholder="Jelaskan penggunaan dana secara rinci..." 
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-primary/20 transition-all text-sm @error('description') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">{{ old('description') }}</textarea>
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Documentation Upload -->
            <div class="mb-8 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dokumentasi (Foto/Bukti)</label>
                <div class="relative group">
                    <input type="file" name="documentation" id="documentation" accept="image/*,application/pdf" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewFile(this)">
                    
                    <div id="upload-placeholder" class="border-2 border-dashed rounded-xl p-8 text-center transition-all group-hover:border-primary group-hover:bg-emerald-50/30 border-gray-200">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform text-gray-400 group-hover:text-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700 mb-1">Klik untuk upload dokumentasi</p>
                        <p class="text-xs text-gray-400">Format GIF, JPG, PNG, PDF (Max. 5MB)</p>
                    </div>

                    <div id="file-preview-container" class="hidden relative mt-4 border border-gray-100 rounded-xl p-4 bg-gray-50 flex items-center gap-3">
                         <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                         </div>
                         <div class="flex-1 overflow-hidden">
                             <p class="text-sm font-medium text-gray-900 truncate" id="filename-preview">filename.jpg</p>
                             <p class="text-xs text-gray-500">Siap diupload</p>
                         </div>
                         <button type="button" onclick="resetFile()" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors z-20 relative">
                             <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                         </button>
                    </div>
                </div>
                @error('documentation')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                 <a href="{{ route('admin.distributions.index') }}" class="px-6 py-2.5 rounded-xl font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Simpan Penyaluran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            locale: {
                firstDayOfWeek: 1
            }
        });

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Program Wakaf",
                allowClear: true,
                width: '100%'
            });

            $('.select2').on('change', function() {
                validateField(this);
            });
        });

        const form = document.getElementById('distribution-form');
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
                if (!validateField(input)) {
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
                const firstError = form.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });

    function validateField(field) {
        const container = field.closest('.form-group');
        const errorText = container.querySelector('.validation-message');
        const isAmount = field.id === 'amount_display';
        const isSelect2 = $(field).hasClass('select2-hidden-accessible');
        
        const validationTarget = isAmount ? field.parentElement : field;
        
        let isValid = true;
        let message = '';

        if (!field.value.trim()) {
            isValid = false;
            message = field.getAttribute('data-message') || 'Field ini wajib diisi.';
        }

        if (isValid) {
            if (isAmount) {
                 validationTarget.classList.remove('border-red-500', 'focus-within:border-red-500', 'focus-within:ring-red-500/20');
                 validationTarget.classList.add('border-gray-200', 'focus-within:border-primary', 'focus-within:ring-primary/20');
            } else if (isSelect2) {
                 $(container).find('.select2-selection').removeClass('!border-red-500');
            } else {
                field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
                field.classList.add('border-gray-200');
            }
            
            if (errorText) {
                errorText.classList.add('hidden');
                errorText.textContent = '';
            }
        } else {
            if (isAmount) {
                validationTarget.classList.remove('border-gray-200', 'focus-within:border-primary', 'focus-within:ring-primary/20');
                validationTarget.classList.add('border-red-500', 'focus-within:border-red-500', 'focus-within:ring-red-500/20');
            } else if (isSelect2) {
                 $(container).find('.select2-selection').addClass('!border-red-500');
            } else {
                field.classList.remove('border-gray-200');
                field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            }
            
            if (errorText) {
                errorText.classList.remove('hidden');
                errorText.textContent = message;
            }
        }
        
        return isValid;
    }

    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        document.getElementById('amount').value = value;
        if (value !== '') {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            input.value = '';
        }
    }

    function previewFile(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById('filename-preview').textContent = file.name;
            document.getElementById('file-preview-container').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
    }

    function resetFile() {
        const input = document.getElementById('documentation');
        input.value = ''; 
        document.getElementById('file-preview-container').classList.add('hidden');
        document.getElementById('upload-placeholder').classList.remove('hidden');
    }
</script>
<style>
    .select2-container .select2-selection--single {
        height: 46px !important;
        background-color: #fff !important;
        border: 1px solid #e5e7eb !important; 
        border-radius: 0.75rem !important; 
        padding-top: 8px !important;
        padding-left: 12px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 10px !important;
        right: 12px !important;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: #10b981 !important; 
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }
    .select2-selection.border-red-500 {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
    }
</style>
@endpush
