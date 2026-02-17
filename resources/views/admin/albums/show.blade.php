@extends('layouts.admin')

@section('title', 'Detail Album')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.albums.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-500">
                <i class="ti ti-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $album->title }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    @if($album->is_published)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Published</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700">Draft</span>
                    @endif
                    <span class="text-sm text-gray-500">• {{ $album->photos->count() }} Foto</span>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.albums.edit', $album->id) }}" class="flex items-center gap-2 bg-yellow-50 text-yellow-600 px-4 py-2 rounded-xl font-medium hover:bg-yellow-100 transition-colors">
                <i class="ti ti-edit"></i> Edit Info
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="ti ti-check-circle text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Album Details & Upload -->
        <div class="md:col-span-1 space-y-6">
            <!-- Info Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="aspect-video w-full bg-gray-100 relative">
                    @if($album->cover_image)
                        <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="ti ti-photo text-4xl"></i>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $album->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>

            <!-- Upload Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-900 mb-4">Upload Foto Baru</h3>
                <form action="{{ route('admin.albums.photos.store', $album->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="flex items-center justify-center w-full mb-4">
                        <label for="images" class="flex flex-col items-center justify-center w-full h-40 border-2 border-primary/30 border-dashed rounded-xl cursor-pointer bg-primary/5 hover:bg-primary/10 transition-colors group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="ti ti-cloud-upload text-3xl text-primary mb-2 group-hover:scale-110 transition-transform"></i>
                                <p class="text-sm text-primary font-medium" id="file-label">Pilih Foto (Bisa Banyak)</p>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max 2MB)</p>
                            </div>
                            <input id="images" name="images[]" type="file" multiple class="hidden" accept="image/*" onchange="document.getElementById('file-label').innerText = this.files.length + ' file dipilih'" />
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all flex items-center justify-center gap-2">
                        <i class="ti ti-upload"></i> Upload Semua
                    </button>
                </form>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="md:col-span-2">
            <h3 class="font-bold text-gray-900 mb-4 text-lg">Galeri Foto</h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4">
                @forelse($album->photos as $photo)
                    <div class="group relative aspect-square bg-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Photo" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- Actions Overlay -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="p-2 bg-white/20 backdrop-blur-sm text-white rounded-full hover:bg-white hover:text-primary transition-colors">
                                <i class="ti ti-eye"></i>
                            </a>
                            <form action="{{ route('admin.albums.photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white/20 backdrop-blur-sm text-white rounded-full hover:bg-red-500 hover:text-white transition-colors">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                        <i class="ti ti-photo-off text-3xl text-gray-300 mb-2 block"></i>
                        <p class="text-gray-500">Belum ada foto yang diupload.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
