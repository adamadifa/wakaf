@extends('layouts.admin')

@section('title', 'Edit Program Wakaf')

@section('content')
<!-- Header Back -->
<div class="mb-6">
    <a href="{{ route('admin.campaigns.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Data Campaign
    </a>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Edit Program Wakaf</h2>
        </div>
        
        <form id="campaign-form" action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 p-8" novalidate>
            @csrf
            @method('PUT')
            
            <!-- Judul -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Program</label>
                <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required 
                       data-message="Mohon isi judul program wakaf."
                       placeholder="Contoh: Wakaf Pembangunan Masjid..." 
                       class="form-input @error('title') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid Kategori & Target -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="form-group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" required 
                            data-message="Silakan pilih kategori program."
                            class="form-input appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-no-repeat bg-[right_1rem_center] @error('category_id') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $campaign->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Target Donasi (Rp)</label>
                    <div class="flex items-center border rounded-xl transition-all overflow-hidden bg-white @error('target_amount') border-red-500 focus-within:border-red-500 focus-within:ring-red-500/20 @else border-gray-200 focus-within:border-primary focus-within:ring-primary/20 @enderror input-group-validate">
                        <div class="px-4 py-3 bg-gray-50 border-r border-gray-100 text-gray-500 font-medium">Rp</div>
                        <input type="text" id="target_amount_display" required placeholder="0" 
                               data-message="Target donasi belum diisi."
                               value="{{ old('target_amount', $campaign->target_amount) ? number_format(old('target_amount', $campaign->target_amount), 0, ',', '.') : '' }}"
                               class="w-full px-4 py-3 outline-none border-none bg-transparent placeholder-gray-400 text-gray-900 text-right font-medium"
                               oninput="formatCurrency(this)">
                        <input type="hidden" name="target_amount" id="target_amount" value="{{ old('target_amount', $campaign->target_amount) }}">
                    </div>
                    <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                    @error('target_amount')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status (Edit Only) -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status Program</label>
                <select name="status" required class="form-input appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%20stroke%3D%22%236b7280%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem_1.25rem] bg-no-repeat bg-[right_1rem_center] @error('status') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    <option value="active" {{ old('status', $campaign->status) == 'active' ? 'selected' : '' }}>Active (Sedang Berjalan)</option>
                    <option value="completed" {{ old('status', $campaign->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    <option value="inactive" {{ old('status', $campaign->status) == 'inactive' ? 'selected' : '' }}>Inactive (Arsip/Draft)</option>
                </select>
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Lengkap</label>
                <textarea name="description" required rows="6" placeholder="Jelaskan detail tujuan, penerima manfaat, dan urgensi program wakaf..." 
                          data-message="Mohon lengkapi deskripsi program."
                          class="form-input @error('description') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">{{ old('description', $campaign->full_description) }}</textarea>
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Upload -->
            <div class="mb-6 form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Banner</label>
                <div class="relative group">
                    <input type="file" name="image" id="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                    
                    <!-- Placeholder (Hidden if image exists) -->
                    <div id="upload-placeholder" class="@if($campaign->image_url) hidden @endif border-2 border-dashed rounded-xl p-8 text-center transition-all group-hover:border-primary group-hover:bg-emerald-50/30 @error('image') border-red-500 bg-red-50/30 @else border-gray-200 @enderror">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform text-gray-400 group-hover:text-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700 mb-1">Klik untuk ganti gambar</p>
                        <p class="text-xs text-gray-400">Format GIF, JPG, PNG (Max. 2MB)</p>
                    </div>

                    <!-- Preview (Shown if image exists) -->
                    <div id="image-preview-container" class="@if(!$campaign->image_url) hidden @endif relative mt-4 border-2 border-gray-100 rounded-xl overflow-hidden group-hover:opacity-75 transition-opacity">
                         <img id="image-preview" src="{{ Str::startsWith($campaign->image_url, 'http') ? $campaign->image_url : asset('storage/' . $campaign->image_url) }}" class="w-full h-64 object-cover">
                         <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                             <p class="text-white font-medium text-sm flex items-center gap-2">
                                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                 Ganti Gambar
                             </p>
                         </div>
                    </div>
                </div>
                <p class="mt-1 text-sm text-red-500 hidden validation-message"></p>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai (Opsional)</label>
                    <input type="text" name="start_date" value="{{ old('start_date', $campaign->start_date?->format('Y-m-d')) }}" class="form-input datepicker bg-white @error('start_date') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="Pilih tanggal mulai...">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai (Opsional)</label>
                    <input type="text" name="end_date" value="{{ old('end_date', $campaign->end_date?->format('Y-m-d')) }}" class="form-input datepicker bg-white @error('end_date') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror" placeholder="Pilih tanggal selesai...">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                 <a href="{{ route('admin.campaigns.index') }}" class="px-6 py-2.5 rounded-xl font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Update Program
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
        // ... (validation logic remains same)
        const form = document.getElementById('campaign-form');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        inputs.forEach(input => {
            // Validate on blur (when leaving the field)
            input.addEventListener('blur', () => validateField(input));
            
            // Validate on input (as user types)
            input.addEventListener('input', () => {
                // Delay validation slightly to avoid flashing error on first type
                if (input.classList.contains('border-red-500') || input.value.trim() !== '') {
                    validateField(input);
                }
            });
             
            // Also validate select on change
             if (input.tagName === 'SELECT') {
                 input.addEventListener('change', () => validateField(input));
             }
        });

        // Validate on Submit
        form.addEventListener('submit', function(e) {
            let hasError = false;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
            }
        });

        function validateField(field) {
            const container = field.closest('.form-group');
            const errorText = container.querySelector('.validation-message');
            // Handle special logic for target amount which is nested differently
            const isAmount = field.id === 'target_amount_display';
            // For amount, the direct parent of input is the border div that needs styling
            // For others, it's usually the field itself
            const validationTarget = isAmount ? field.parentElement : field;
            
             // Special case for Image (input is inside relative group, we want to style the placeholder div)
             const isImage = field.type === 'file';
             let imagePlaceholder = null;
             if (isImage) {
                 imagePlaceholder = container.querySelector('#upload-placeholder') || container.querySelector('#image-preview-container');
                 // Prioritize visible one
                 if (imagePlaceholder && imagePlaceholder.classList.contains('hidden')) {
                      // If first one found was hidden (e.g. placeholder), try finding the other one (preview)
                      // Or just check which one is NOT hidden
                      const placeholder = container.querySelector('#upload-placeholder');
                      const preview = container.querySelector('#image-preview-container');
                      if (placeholder && !placeholder.classList.contains('hidden')) imagePlaceholder = placeholder;
                      else if (preview && !preview.classList.contains('hidden')) imagePlaceholder = preview;
                 }
             }
            
            let isValid = true;
            let message = '';

            // Check if empty
            if (!field.value.trim()) {
                isValid = false;
                // Use custom message from data-message attribute or fallback
                message = field.getAttribute('data-message') || 'Field ini wajib diisi.';
            }

            if (isValid) {
                // Success State
                if (isAmount) {
                     validationTarget.classList.remove('border-red-500', 'focus-within:border-red-500', 'focus-within:ring-red-500/20');
                     validationTarget.classList.add('border-gray-200', 'focus-within:border-primary', 'focus-within:ring-primary/20');
                } else if (isImage && imagePlaceholder) {
                     imagePlaceholder.classList.remove('border-red-500', 'bg-red-50/30');
                     imagePlaceholder.classList.add('border-gray-200');
                } else {
                    field.classList.remove('!border-red-500', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
                    field.classList.add('border-gray-200'); // Reset to default if using dynamic classes, simplified here
                }
                
                if (errorText) {
                    errorText.classList.add('hidden');
                    errorText.textContent = '';
                }
            } else {
                // Error State
                if (isAmount) {
                    validationTarget.classList.remove('border-gray-200', 'focus-within:border-primary', 'focus-within:ring-primary/20');
                    validationTarget.classList.add('border-red-500', 'focus-within:border-red-500', 'focus-within:ring-red-500/20');
                } else if (isImage && imagePlaceholder) {
                     imagePlaceholder.classList.remove('border-gray-200');
                     imagePlaceholder.classList.add('border-red-500', 'bg-red-50/30');
                } else {
                    field.classList.add('!border-red-500', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
                }
                
                if (errorText) {
                    errorText.classList.remove('hidden');
                    errorText.textContent = message;
                }
            }
            
            return isValid;
        }
    });

    // Initialize Flatpickr
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            locale: {
                firstDayOfWeek: 1
            }
        });
    });

    function formatCurrency(input) {
        // Hapus karakter selain angka
        let value = input.value.replace(/\D/g, '');
        
        // Simpan nilai asli ke hidden input
        document.getElementById('target_amount').value = value;
        
        // Format tampilan dengan ribuan (id-ID)
        if (value !== '') {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            input.value = '';
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').classList.remove('hidden');
                document.getElementById('upload-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
