@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<!-- Header & Actions -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kategori Program</h1>
        <p class="text-gray-500 mt-1">Kelola kategori untuk pengelompokan program wakaf.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Tambah Kategori
    </a>
</div>

<!-- Category List -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nama Kategori</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Slug</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Deskripsi</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Jumlah Program</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800">{{ $category->name }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $category->slug }}</code>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-sm text-gray-500 max-w-xs truncate">{{ $category->description ?? '-' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                            {{ $category->campaigns_count ?? 0 }} Program
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2 text-right">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-emerald-50 rounded-lg transition-all" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
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
                            <p>Belum ada kategori ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
