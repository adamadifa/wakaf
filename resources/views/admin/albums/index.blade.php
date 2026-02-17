@extends('layouts.admin')

@section('title', 'Manajemen Album Foto')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Manajemen Album Foto</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola galeri foto kegiatan dan dokumentasi.</p>
        </div>
        <a href="{{ route('admin.albums.create') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
            <i class="ti ti-plus text-lg"></i>
            Tambah Album
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="ti ti-check-circle text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($albums as $album)
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
                <!-- Cover Image -->
                <div class="relative h-48 w-full shrink-0 bg-gray-100">
                    @if($album->cover_image)
                        <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="ti ti-photo text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="absolute top-4 right-4">
                        @if($album->is_published)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100/90 text-emerald-700 backdrop-blur-sm shadow-sm">Published</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100/90 text-gray-700 backdrop-blur-sm shadow-sm">Draft</span>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">
                        <a href="{{ route('admin.albums.show', $album->id) }}" class="hover:text-primary transition-colors">
                            {{ Str::limit($album->title, 50) }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-500 mb-4 flex-1">
                        {{ Str::limit($album->description, 80) ?? 'Tidak ada deskripsi.' }}
                    </p>
                    
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1">
                        <i class="ti ti-photo"></i>
                        {{ $album->photos->count() }} Foto
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-5 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end items-center gap-2">
                    <a href="{{ route('admin.albums.show', $album->id) }}" class="p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Kelola Foto">
                        <i class="ti ti-photo-edit text-lg"></i>
                    </a>
                    <a href="{{ route('admin.albums.edit', $album->id) }}" class="p-2 text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit Album">
                        <i class="ti ti-edit text-lg"></i>
                    </a>
                    <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album ini beserta semua fotonya?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Album">
                            <i class="ti ti-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-photo-off text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada album</h3>
                <p class="text-gray-500 mb-4">Mulai dengan membuat album foto pertama Anda.</p>
                <a href="{{ route('admin.albums.create') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                    <i class="ti ti-plus"></i> Tambah Album Baru
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $albums->links() }}
    </div>
</div>
@endsection
