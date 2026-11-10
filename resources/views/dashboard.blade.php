@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="page-head" data-aos="fade-up">
    <div class="page-head__text">
        <p class="eyebrow">Ringkasan kebun</p>
        <h1 class="page-head__title">Halo, {{ $username }}.</h1>
        <p class="page-head__sub">Kebunmu terlihat sehat. Tiga tanaman siap dipanen minggu ini.</p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <p class="page-head__date">{{ $tanggal }}</p>
        <a class="btn btn--primary" href="{{ route('pengelolaan', ['username' => $username]) }}">Kelola tanaman</a>
    </div>
</section>

<div class="ticker" data-aos="fade-up" data-aos-delay="50" aria-hidden="true">
    <div class="ticker__track">
        @foreach ([1, 2] as $ulang)
            <div class="ticker__group">
                @foreach ($statistik as $item)
                    <span class="ticker__item"><span class="ticker__dot"></span><b>{{ $item['value'] }}</b> {{ $item['label'] }}</span>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<section class="grid gap-3">
    <div class="section-head" data-aos="fade-up">
        <h2 class="section-label">Statistik kebun</h2>
        <span class="section-index">01 / 03</span>
    </div>

    <div class="cell-grid grid grid-cols-2 lg:grid-cols-4">
        @foreach ($statistik as $item)
            @include('partials.stat-card', [
                'label' => $item['label'],
                'value' => $item['value'],
                'hint' => $item['hint'],
            ])
        @endforeach
    </div>
</section>

<div class="grid gap-5 md:grid-cols-2">
    <section class="panel" data-aos="fade-up">
        <div class="section-head">
            <h2 class="section-label">Jadwal hari ini</h2>
            <span class="section-index">02 / 03</span>
        </div>
        <ul class="timeline">
            @foreach ($jadwal as $item)
                <li class="timeline__item">
                    <span class="timeline__time">{{ $item['waktu'] }}</span>
                    <span class="timeline__body">
                        <span class="timeline__text">{{ $item['kegiatan'] }}</span>
                        <span class="timeline__place">{{ $item['lokasi'] }}</span>
                    </span>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="panel" data-aos="fade-up" data-aos-delay="100">
        <div class="section-head">
            <h2 class="section-label">Aktivitas terbaru</h2>
            <span class="section-index">03 / 03</span>
        </div>
        <ul class="activity">
            @foreach ($aktivitas as $item)
                <li class="activity__item">
                    <p class="activity__text">{{ $item['teks'] }}</p>
                    <p class="activity__time">{{ $item['waktu'] }}</p>
                </li>
            @endforeach
        </ul>
    </section>
</div>

<section class="panel" data-aos="fade-up">
    <div class="section-head">
        <h2 class="section-label">Siap dipanen</h2>
        <a class="text-link" href="{{ route('pengelolaan', ['username' => $username]) }}">Lihat semua</a>
    </div>
    <ul class="harvest-list">
        @foreach ($panen as $item)
            <li class="harvest-item">
                <span class="harvest-item__code">{{ $item['kode'] }}</span>
                <span class="harvest-item__name">{{ $item['nama'] }}</span>
                <span class="harvest-item__rack">Rak {{ $item['rak'] }}</span>
                <span class="harvest-item__date">{{ $item['estimasi'] }}</span>
            </li>
        @endforeach
    </ul>
</section>
@endsection
