@extends('layouts.admin')

@section('title', 'Tentang Kami')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tentang Kami & Wakaf</h1>
    <p class="text-gray-500 text-sm mt-1">Kelola halaman profil organisasi dan edukasi wakaf.</p>
</div>

<!-- Tabs Navigation -->
<div class="flex items-center gap-2 mb-6 bg-gray-100/50 p-1.5 rounded-2xl w-fit border border-gray-100">
    <a href="{{ route('admin.about.index', ['tab' => 'umum']) }}" 
       class="px-6 py-2.5 rounded-xl text-sm font-semibold transition-all {{ $tab === 'umum' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
        Profil Umum
    </a>
    <a href="{{ route('admin.about.index', ['tab' => 'wakaf']) }}" 
       class="px-6 py-2.5 rounded-xl text-sm font-semibold transition-all {{ $tab === 'wakaf' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
        Tentang Wakaf
    </a>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        
        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="tab" value="{{ $tab }}">

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Halaman ({{ ucfirst($tab) }})</label>
                <input type="text" name="judul" value="{{ old('judul', $about->judul) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('judul') border-red-500 @enderror" placeholder="Contoh: Sejarah Yayasan">
                @error('judul') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Cover</label>
                @if($about->gambar)
                    <div class="mb-3">
                        <img src="{{ asset($about->gambar) }}" alt="Current Image" class="w-full h-48 object-cover rounded-xl border border-gray-200">
                    </div>
                @endif
                <input type="file" name="gambar" accept="image/*" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all @error('gambar') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Max: 2MB.</p>
                @error('gambar') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Lengkap</label>
                <textarea name="deskripsi" rows="10" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Tuliskan isi konten di sini...">{{ old('deskripsi', $about->deskripsi) }}</textarea>
                @error('deskripsi') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
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
    // CKEditor Initialization for Deskripsi
    ClassicEditor
        .create(document.querySelector('textarea[name="deskripsi"]'), {
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
