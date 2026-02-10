@extends('layouts.admin')

@section('title', 'Buat Kabar Terbaru')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8 pl-1">
        <a href="{{ route('admin.campaign-updates.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-3">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Buat Kabar Terbaru</h1>
        <p class="text-gray-500 mt-1">Bagikan perkembangan program wakaf.</p>
    </div>

    <form action="{{ route('admin.campaign-updates.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm space-y-6">
            
            <!-- Campaign Select -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Program Campaign <span class="text-red-500">*</span></label>
                <select name="campaign_id" class="select2 w-full">
                    <option value="">Pilih Campaign...</option>
                    @foreach($campaigns as $campaign)
                        <option value="{{ $campaign->id }}" {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>{{ $campaign->title }}</option>
                    @endforeach
                </select>
                @error('campaign_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Update <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input @error('title') border-red-500 @enderror" placeholder="Contoh: Penyaluran Tahap 1 Selesai">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Published Date -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi <span class="text-red-500">*</span></label>
                <input type="text" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" class="datepicker form-input @error('published_at') border-red-500 @enderror">
                @error('published_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita <span class="text-red-500">*</span></label>
                <textarea name="content" rows="8" class="form-input @error('content') border-red-500 @enderror" placeholder="Tuliskan detail update...">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.campaign-updates.index') }}" class="px-5 py-2.5 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">Publikasikan</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('textarea[name="content"]'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h2', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h3', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
<style>
    .ck-editor__editable {
        min-height: 300px;
    }
</style>
<script>
    $(document).ready(function() {
        // Init Select2
        $('.select2').select2({
            placeholder: "Pilih Campaign...",
            allowClear: true,
            width: '100%'
        });

        // Init Flatpickr
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            allowInput: true,
            defaultDate: "{{ old('published_at', date('Y-m-d')) }}",
            locale: {
                firstDayOfWeek: 1
            }
        });
    });
</script>
<style>
    /* Custom Select2 Styling */
    .select2-container .select2-selection--single {
        height: 48px !important;
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important; /* border-gray-200 */
        border-radius: 0.75rem !important; /* rounded-xl */
        padding-top: 10px !important;
        padding-left: 10px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 11px !important;
        right: 10px !important;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }
</style>
@endpush
@endsection
