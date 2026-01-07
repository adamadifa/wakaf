@extends('layouts.frontend')

@section('title', 'Donasi - ' . $campaign->title)

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
    <div class="text-center mb-2">
        <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem;">Masukan Nominal Donasi</h1>
        <p style="color: var(--text-muted);">Program: <strong>{{ $campaign->title }}</strong></p>
    </div>

    <div class="card" style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow);">
        <form action="{{ route('campaign.store', $campaign->slug) }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nominal Donasi (Rp)</label>
                <input type="number" name="amount" class="form-control" placeholder="Min. 10.000" min="10000" required
                    style="width: 100%; padding: 1rem; font-size: 1.25rem; border: 2px solid #eee; border-radius: 0.5rem; font-weight: 700;">
                
                <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <button type="button" onclick="setAmount(50000)" class="btn btn-outline" style="font-size: 0.9rem;">Rp 50.000</button>
                    <button type="button" onclick="setAmount(100000)" class="btn btn-outline" style="font-size: 0.9rem;">Rp 100.000</button>
                    <button type="button" onclick="setAmount(500000)" class="btn btn-outline" style="font-size: 0.9rem;">Rp 500.000</button>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Metode Pembayaran</h3>
                <div style="display: grid; gap: 1rem;">
                    @foreach($paymentMethods as $method)
                    <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid #ddd; border-radius: 0.5rem; cursor: pointer;">
                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" required>
                        @if($method->logo_url)
                            <img src="{{ Storage::url($method->logo_url) }}" style="height: 30px; object-fit: contain;">
                        @else
                            <span style="font-weight: 600;">{{ $method->bank_name }}</span>
                        @endif
                        <span style="color: var(--text-muted); font-size: 0.9rem;">{{ $method->account_number }} (a.n {{ $method->account_name }})</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Data Diri</h3>
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.25rem;">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required value="{{ Auth::check() ? Auth::user()->name : '' }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.25rem;">Email</label>
                        <input type="email" name="email" class="form-control" required value="{{ Auth::check() ? Auth::user()->email : '' }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.25rem;">Nomor WhatsApp (Opsional)</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_anonymous">
                        <span>Sembunyikan nama saya (Hamba Allah)</span>
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.25rem;">Doa & Dukungan (Opsional)</label>
                <textarea name="message" rows="3" 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem;">Lanjut Pembayaran</button>
        </form>
    </div>
</div>

<script>
    function setAmount(value) {
        document.querySelector('input[name="amount"]').value = value;
    }
</script>
@endsection
