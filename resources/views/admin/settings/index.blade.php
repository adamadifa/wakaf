@extends('layouts.admin')

@section('title', 'Pengaturan Situs')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Situs</h1>
    <p class="text-gray-500 text-sm mt-1">Kelola informasi dasar situs web.</p>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')
            
            <!-- Logo & Hero Image (Disabled temporarily) -->
            {{--
            <div class="mb-8 pb-8 border-b border-gray-50">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Identitas Visual</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Website</label>
                        @if($setting->logo)
                            <div class="mb-3 p-4 bg-gray-50 rounded-xl inline-block">
                                <img src="{{ asset('storage/' . $setting->logo) }}" class="h-12 object-contain">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        <p class="text-xs text-gray-500 mt-1">Format: PNG, SVG, JPG. Max: 2MB.</p>
                        @error('logo') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Header Utama (Hero)</label>
                        @if($setting->header_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $setting->header_image) }}" class="h-32 w-full object-cover rounded-xl">
                            </div>
                        @endif
                        <input type="file" name="header_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        <p class="text-xs text-gray-500 mt-1">Gambar background untuk halaman depan. Max: 5MB.</p>
                        @error('header_image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            --}}

            <!-- Informasi Kontak -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi & Lokasi</h3>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="3" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">{{ old('address', $setting->address) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Akan ditampilkan di footer website.</p>
                    @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $setting->phone_number) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Contoh: 081234567890">
                    <p class="text-xs text-gray-500 mt-1">Nomor kontak resmi yayasan.</p>
                    @error('phone_number') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat Footer</label>
                    <textarea name="short_description" rows="3" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">{{ old('short_description', $setting->short_description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Teks pendek yang muncul di footer sebelum lencana akreditasi.</p>
                    @error('short_description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Google Maps Embed (Iframe URL)</label>
                    <textarea name="maps_embed" rows="3" placeholder='https://www.google.com/maps/embed?pb=...' class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">{{ old('maps_embed', $setting->maps_embed) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Masukkan URL dari src iframe Google Maps. Contoh: https://www.google.com/maps/embed?pb=...</p>
                    @error('maps_embed') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                
                @if($setting->maps_embed)
                    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 mb-2">Preview Maps:</p>
                        <iframe src="{{ $setting->maps_embed }}" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-lg"></iframe>
                    </div>
                @endif
            </div>


            
            <!-- Social Media -->
            <div class="mb-8 border-t border-gray-50 pt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Media Sosial</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $setting->facebook) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm" placeholder="https://facebook.com/username">
                        @error('facebook') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Instagram</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $setting->instagram) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm" placeholder="https://instagram.com/username">
                        @error('instagram') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter (X)</label>
                        <input type="url" name="twitter" value="{{ old('twitter', $setting->twitter) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm" placeholder="https://twitter.com/username">
                        @error('twitter') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">LinkedIn</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin', $setting->linkedin) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm" placeholder="https://linkedin.com/in/username">
                        @error('linkedin') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">YouTube</label>
                        <input type="url" name="youtube" value="{{ old('youtube', $setting->youtube) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm" placeholder="https://youtube.com/c/username">
                        @error('youtube') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Gateway -->
            <div class="mb-8 border-t border-gray-50 pt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Pembayaran</h3>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">
                    <div>
                        <h4 class="font-semibold text-gray-800">Midtrans Payment Gateway</h4>
                        <p class="text-sm text-gray-500 mt-1">Aktifkan fitur pembayaran otomatis menggunakan Midtrans.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_payment_gateway_active" value="1" class="sr-only peer" {{ $setting->is_payment_gateway_active ? 'checked' : '' }} onchange="document.getElementById('midtrans-settings').classList.toggle('hidden')">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>

                <div id="midtrans-settings" class="{{ $setting->is_payment_gateway_active ? '' : 'hidden' }} space-y-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Merchant ID</label>
                        <input type="text" name="midtrans_merchant_id" value="{{ old('midtrans_merchant_id', $setting->midtrans_merchant_id) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm">
                        @error('midtrans_merchant_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Client Key</label>
                        <input type="text" name="midtrans_client_key" value="{{ old('midtrans_client_key', $setting->midtrans_client_key) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm">
                        @error('midtrans_client_key') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Server Key</label>
                        <input type="text" name="midtrans_server_key" value="{{ old('midtrans_server_key', $setting->midtrans_server_key) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm">
                        @error('midtrans_server_key') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                        <div>
                            <h4 class="font-semibold text-gray-800">Mode Production</h4>
                            <p class="text-xs text-gray-500 mt-1">Aktifkan jika menggunakan Key Production. Matikan untuk Sandbox (Test).</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="midtrans_is_production" value="1" class="sr-only peer" {{ $setting->midtrans_is_production ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Biaya Admin (Rp)</label>
                        <input type="number" name="midtrans_admin_fee" value="{{ old('midtrans_admin_fee', $setting->midtrans_admin_fee) }}" class="form-input w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-mono text-sm" placeholder="Contoh: 4000">
                        <p class="text-xs text-gray-500 mt-1">Biaya tambahan yang akan dibebankan ke donatur saat menggunakan Midtrans.</p>
                        @error('midtrans_admin_fee') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end pt-6 border-t border-gray-50">
                <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
