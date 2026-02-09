@extends('layouts.admin')

@section('title', 'Manajemen Jenis Zakat')

@section('content')
<!-- Header & Actions -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Jenis Zakat</h1>
        <p class="text-gray-500 mt-1">Kelola jenis-jenis zakat (Fitrah & Mal) yang tersedia.</p>
    </div>
    <a href="{{ route('admin.zakat-types.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Tambah Jenis Zakat
    </a>
</div>

<!-- List -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nama Zakat</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Icon</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Thumbnail</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($zakatTypes as $type)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800">{{ $type->name }}</div>
                        <div class="text-xs text-gray-400 mt-1 max-w-xs truncate">{{ $type->description }}</div>
                    </td>
                     <td class="py-4 px-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $type->category == 'fitrah' ? 'bg-orange-50 text-orange-600 border border-orange-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                            {{ ucfirst($type->category) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
                            <i class="ti {{ $type->icon ?? 'ti-coins' }} text-xl"></i>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        @if($type->image)
                            <img src="{{ Str::startsWith($type->image, 'http') ? $type->image : asset($type->image) }}" class="h-10 w-16 object-cover rounded-lg border border-gray-100" alt="{{ $type->name }}">
                        @else
                            <span class="text-xs text-gray-400 italic">No image</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2 text-right">
                            <a href="{{ route('admin.zakat-types.edit', $type) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-emerald-50 rounded-lg transition-all" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.zakat-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis zakat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <p>Belum ada jenis zakat yang ditambahkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
