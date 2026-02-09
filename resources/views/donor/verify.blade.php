@extends('layouts.home_layout')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary/5 to-secondary/5 py-16">
    <div class="max-w-md mx-auto px-5">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-mail-opened text-6xl text-primary"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Masukkan Kode OTP</h1>
            <p class="text-gray-600">
                Kami telah mengirim kode 6 digit ke<br>
                <strong class="text-gray-900">{{ session('donor_email') }}</strong>
            </p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-start">
                    <i class="ti ti-circle-check text-xl mr-2 mt-0.5"></i>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- OTP Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
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

            <form action="{{ route('donor.verify.otp') }}" method="POST" id="otpForm">
                @csrf
                
                <div class="mb-8">
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-4 text-center">
                        Masukkan 6 Digit Kode OTP
                    </label>
                    
                    <!-- OTP Input Boxes -->
                    <div class="flex justify-center gap-3 mb-4" id="otpInputs">
                        <input type="text" maxlength="1" class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="0">
                        <input type="text" maxlength="1" class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="1">
                        <input type="text" maxlength="1" class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="2">
                        <input type="text" maxlength="1" class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="3">
                        <input type="text" maxlength="1" class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="4">
                        <input type="text" maxlength="1" class="otp-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" data-index="5">
                    </div>
                    
                    <!-- Hidden input for form submission -->
                    <input type="hidden" name="otp" id="otpValue">
                    
                    <p class="text-xs text-gray-500 text-center">
                        <i class="ti ti-clock text-sm"></i>
                        Kode akan kadaluarsa dalam <strong class="text-secondary">5 menit</strong>
                    </p>
                </div>

                <button 
                    type="submit" 
                    id="submitBtn"
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                    disabled
                >
                    <i class="ti ti-check mr-2"></i>
                    Verifikasi & Masuk
                </button>
            </form>

            <!-- Resend OTP -->
            <div class="text-center mt-6 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-600 mb-2">Tidak menerima kode?</p>
                <a href="{{ route('donor.login') }}" class="text-sm font-semibold text-secondary hover:text-secondary/80 transition-colors">
                    <i class="ti ti-refresh mr-1"></i>
                    Kirim Ulang OTP
                </a>
            </div>
        </div>

        <!-- Change Email -->
        <div class="text-center">
            <a href="{{ route('donor.login') }}" class="text-sm text-gray-600 hover:text-primary transition-colors inline-flex items-center">
                <i class="ti ti-arrow-left mr-1"></i>
                Ganti Email
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const otpValue = document.getElementById('otpValue');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('otpForm');

    // Auto-focus first input
    inputs[0].focus();

    inputs.forEach((input, index) => {
        // Handle input
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            
            // Only allow alphanumeric
            e.target.value = value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            
            // Move to next input
            if (e.target.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            
            updateOtpValue();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').toUpperCase().replace(/[^A-Z0-9]/g, '');
            
            for (let i = 0; i < pastedData.length && index + i < inputs.length; i++) {
                inputs[index + i].value = pastedData[i];
            }
            
            // Focus last filled input or next empty
            const lastIndex = Math.min(index + pastedData.length, inputs.length - 1);
            inputs[lastIndex].focus();
            
            updateOtpValue();
        });
    });

    function updateOtpValue() {
        const otp = Array.from(inputs).map(input => input.value).join('');
        otpValue.value = otp;
        
        // Enable submit button if all inputs filled
        submitBtn.disabled = otp.length !== 6;
    }
});
</script>
@endsection
