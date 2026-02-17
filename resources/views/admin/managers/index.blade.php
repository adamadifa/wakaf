@extends('layouts.admin')

@section('title', 'Data Pengurus')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Pengurus</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola data pengurus/staff organisasi.</p>
    </div>
    <a href="{{ route('admin.managers.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all flex items-center gap-2">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Tambah Pengurus
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">No</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Foto</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama & Jabatan</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Urutan</th>
                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-right py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($managers as $manager)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6">
                        <img src="{{ asset($manager->image) }}" alt="{{ $manager->name }}" class="w-12 h-12 rounded-full object-cover border border-gray-100">
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800">{{ $manager->name }}</div>
                        <div class="text-xs text-gray-500">{{ $manager->position }}</div>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $manager->order }}</td>
                    <td class="py-4 px-6">
                        @if($manager->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Non-Aktif
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.managers.edit', $manager->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.managers.destroy', $manager->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data pengurus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
