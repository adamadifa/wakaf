@extends('layouts.admin')

@section('title', 'Kategori Berita')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kategori Berita</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola kategori untuk pengelompokan berita.</p>
    </div>
    <a href="{{ route('admin.news-categories.create') }}" class="btn btn-primary bg-primary text-white hover:bg-primary-dark px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-lg shadow-blue-500/30">
        <div class="flex items-center gap-2">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Kategori
        </div>
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Berita</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-900 font-medium">
                        {{ $category->name }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 font-mono text-sm">
                        {{ $category->slug }}
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $category->news_count ?? 0 }} Berita
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                             <a href="{{ route('admin.news-categories.edit', $category->id) }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary hover:border-primary transition-all">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.news-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-red-500 hover:border-red-500 transition-all">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        Belum ada kategori yang tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
