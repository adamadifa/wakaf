@extends('layouts.admin')

@section('title', 'Visi & Misi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Visi & Misi</h1>
    <p class="text-gray-500 text-sm mt-1">Kelola Visi dan Misi organisasi.</p>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        
        <form action="{{ route('admin.vision-mission.update') }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Visi Organisasi</label>
                <textarea name="visi" rows="3" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Masukkan visi organisasi...">{{ old('visi', $visionMission->visi ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Visi jangka panjang organisasi.</p>
                @error('visi') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Misi Organisasi</label>
                <textarea name="misi" rows="10" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Masukkan misi organisasi...">{{ old('misi', $visionMission->misi ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Misi / langkah-langkah organisasi.</p>
                @error('misi') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-gray-50">
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // CKEditor Initialization for Misi
    ClassicEditor
        .create(document.querySelector('textarea[name="misi"]'), {
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
        min-height: 200px;
    }
    .ck-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
    }
    .ck-content ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
    }
</style>
@endpush
