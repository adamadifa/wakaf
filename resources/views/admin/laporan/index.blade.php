@extends('layouts.admin')

@section('title', 'Manajemen Laporan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Laporan</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola laporan bulanan dan tahunan.</p>
    </div>
    <a href="{{ route('admin.laporans.create') }}" class="btn btn-primary bg-primary text-white hover:bg-primary-dark px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-lg shadow-blue-500/30">
        <div class="flex items-center gap-2">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Buat Laporan Baru
        </div>
    </a>
</div>

<!-- Laporans Table -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Laporan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">File</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($laporans as $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 line-clamp-1">{{ $item->title ?? 'Laporan Bulanan' }}</h3>
                                <p class="text-sm text-gray-500 line-clamp-1">Updated: {{ $item->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $item->month }} {{ $item->year }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        @if($item->file)
                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                Download PDF
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                             <a href="{{ route('admin.laporans.edit', $item->id) }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-primary hover:border-primary transition-all">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.laporans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
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
                        Belum ada laporan yang tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($laporans->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $laporans->links() }}
    </div>
    @endif
</div>
@endsection
