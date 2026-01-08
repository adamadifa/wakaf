@extends('layouts.admin')

@section('title', 'Data Donatur')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Donatur</h1>
        <p class="text-gray-500 mt-1">Kelola data para donatur dan wakif.</p>
    </div>
    <a href="{{ route('admin.donors.create') }}" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Tambah Donatur
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm mb-6">
    <form action="{{ route('admin.donors.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-11">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." 
                       class="w-full px-4 py-2.5 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all">
            </div>
            <div class="md:col-span-1">
                <button type="submit" class="w-full px-4 py-2.5 bg-gray-800 text-white rounded-xl font-semibold hover:bg-gray-900 transition-colors">
                    Cari
                </button>
            </div>
        </div>
    </form>
</div>

<!-- List -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">ID</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nama</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Email</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">No. Telepon</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Terdaftar</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($donors as $donor)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6 text-gray-500">
                        #{{ $donor->id }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-primary font-bold text-lg overflow-hidden">
                                {{ substr($donor->name, 0, 1) }}
                            </div>
                            <div class="font-medium text-gray-900">{{ $donor->name }}</div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">{{ $donor->email }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ $donor->phone ?? '-' }}</td>
                    <td class="py-4 px-6 text-gray-500 text-sm">
                        {{ $donor->created_at->format('d M Y') }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.donors.edit', $donor->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary hover:bg-emerald-50 transition-all" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                            <form action="{{ route('admin.donors.destroy', $donor->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus donatur ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <p>Data donatur tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($donors->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $donors->links() }}
    </div>
    @endif
</div>
@endsection
