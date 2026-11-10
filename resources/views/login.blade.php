@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<section class="login grid gap-5 lg:grid-cols-[55fr_45fr]">
    <div class="login__panel" data-aos="fade-right">
        <div>
            <p class="login__eyebrow">Tunas · Kebun kecil, catatan rapi.</p>
            <h2 class="login__headline">Satu layar untuk delapan tanaman hidroponikmu.</h2>
        </div>

        <ol class="login__index">
            <li><span>01</span> 8 tanaman dalam satu daftar</li>
            <li><span>02</span> Jadwal perawatan harian</li>
            <li><span>03</span> Estimasi panen terdekat</li>
        </ol>

        <p class="login__meta">Demo UTS Pemrograman Web 2026</p>
    </div>

    <div class="login__form" data-aos="fade-left" data-aos-delay="100">
        <p class="eyebrow">Masuk ke kebunmu</p>
        <h1 class="login__title">Selamat datang kembali</h1>
        <p class="login__helper">Cukup isi nama panggilan. Tidak perlu kata sandi.</p>

        <form method="POST" action="{{ route('login.store') }}" class="login-form">
            @csrf

            <div class="field">
                <label for="username">Nama pengguna</label>
                <input
                    class="field__input"
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="nara_08"
                    autocomplete="username"
                    autofocus
                >
                @error('username')
                    <p class="field__error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn--primary btn--block" type="submit">Masuk</button>
        </form>

        <p class="login__note">Data hanya untuk demo UTS, tidak disimpan permanen.</p>
    </div>
</section>
@endsection
