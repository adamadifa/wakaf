@extends('layouts.mobile_layout')

@section('title', 'Login Donatur')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary/5 to-secondary/5 py-8 px-5">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-user-circle text-5xl text-primary"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
            <p class="text-gray-600 text-sm">Masuk untuk melihat riwayat donasi Anda</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-start">
                        <i class="ti ti-alert-circle text-xl mr-2 mt-0.5"></i>
                        <div class="flex-1">
                            @foreach($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('donor.login.send-otp') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Donatur
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ti ti-mail text-gray-400 text-xl"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-sm"
                            placeholder="Gunakan email yang terdaftar"
                            required
                            autofocus
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="ti ti-info-circle text-sm"></i>
                        Gunakan email yang sama saat Anda melakukan donasi atau zakat
                    </p>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/30 active:scale-95"
                >
                    <i class="ti ti-send mr-2"></i>
                    Kirim Kode OTP
                </button>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-secondary">
            <div class="flex items-start">
                <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center shrink-0 mr-3">
                    <i class="ti ti-help text-xl text-secondary"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 text-sm mb-1">Lupa atau belum memiliki email login?</h3>
                    <p class="text-gray-600 text-xs mb-3">Hubungi kami untuk bantuan</p>
                    <a 
                        href="https://wa.me/6281234567890" 
                        target="_blank"
                        class="inline-flex items-center text-sm font-semibold text-secondary hover:text-secondary/80 transition-colors"
                    >
                        <i class="ti ti-brand-whatsapp mr-1.5"></i>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-primary transition-colors inline-flex items-center">
                <i class="ti ti-arrow-left mr-1"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
