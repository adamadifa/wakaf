@extends('layouts.admin')

@section('title', 'Manajemen Mitra')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Manajemen Mitra</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola logo mitra dan partner yang bekerjasama.</p>
        </div>
        <a href="{{ route('admin.mitras.create') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all">
            <i class="ti ti-plus text-lg"></i>
            Tambah Mitra
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="ti ti-check-circle text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @forelse ($mitras as $mitra)
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
                <!-- Logo -->
                <div class="relative h-32 w-full shrink-0 bg-gray-50 flex items-center justify-center p-4">
                    <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-500">
                    
                    <div class="absolute top-2 right-2">
                        @if($mitra->is_active)
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 block shadow-sm"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-300 block shadow-sm"></span>
                        @endif
                    </div>
                </div>

                <!-- Name -->
                <div class="px-3 py-3 border-t border-gray-50">
                    <h3 class="text-xs font-bold text-gray-900 text-center truncate">{{ $mitra->name }}</h3>
                </div>

                <!-- Actions -->
                <div class="px-3 pb-3 flex justify-center items-center gap-1">
                    <a href="{{ route('admin.mitras.edit', $mitra->id) }}" class="p-1.5 text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                        <i class="ti ti-edit text-sm"></i>
                    </a>
                    <form action="{{ route('admin.mitras.destroy', $mitra->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                            <i class="ti ti-trash text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-building text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada mitra</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan logo mitra pertama.</p>
                <a href="{{ route('admin.mitras.create') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                    <i class="ti ti-plus"></i> Tambah Mitra Baru
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $mitras->links() }}
    </div>
</div>
@endsection
