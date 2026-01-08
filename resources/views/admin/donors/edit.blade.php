@extends('layouts.admin')

@section('title', 'Edit Donatur')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8 pl-1">
        <a href="{{ route('admin.donors.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-3">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Donatur</h1>
        <p class="text-gray-500 mt-1">Perbarui informasi donatur.</p>
    </div>

    <form action="{{ route('admin.donors.update', $donor->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm space-y-5">
            
            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $donor->name) }}" class="form-input @error('name') border-red-500 @enderror" placeholder="Nama Lengkap Donatur">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $donor->email) }}" class="form-input @error('email') border-red-500 @enderror" placeholder="email@example.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $donor->phone) }}" class="form-input @error('phone') border-red-500 @enderror" placeholder="0812...">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.donors.index') }}" class="px-5 py-2.5 rounded-xl text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">Perbarui Data</button>
            </div>
        </div>
    </form>
</div>
@endsection
