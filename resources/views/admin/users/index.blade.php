@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $pageTitle ?? 'Manajemen User' }}</h1>
        <p class="text-gray-500 mt-1">{{ $pageDescription ?? 'Kelola data pengguna, staff, dan admin.' }}</p>
    </div>
    <a href="{{ route('admin.users.create', request()->only(['role', 'type'])) }}" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <line x1="20" y1="8" x2="20" y2="14"></line>
            <line x1="23" y1="11" x2="17" y2="11"></line>
        </svg>
        Tambah User
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-8">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." 
                       class="w-full px-4 py-2.5 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all">
            </div>
            @if(!request('role') && !request('type'))
            <div class="md:col-span-3">
                <select name="role" class="w-full px-4 py-2.5 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="donor" {{ request('role') == 'donor' ? 'selected' : '' }}>Donor</option>
                </select>
            </div>
            @elseif(request('type') == 'internal')
            <div class="md:col-span-3">
                <select name="role" class="w-full px-4 py-2.5 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primary focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                    <option value="">Semua Internal</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                <input type="hidden" name="type" value="internal">
            </div>
            @else
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
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
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Nama</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Email</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Role</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Terdaftar</th>
                    <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-lg overflow-hidden">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($user->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">{{ $user->email }}</td>
                    <td class="py-4 px-6">
                        @if($user->role == 'admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Admin
                            </span>
                        @elseif($user->role == 'staff')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Staff
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Donor
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-gray-500 text-sm">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary hover:bg-emerald-50 transition-all" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <p>Data user tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
