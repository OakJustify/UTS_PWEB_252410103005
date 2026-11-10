@extends('layouts.app')

@section('title', 'Pengelolaan')

@section('content')
<section class="page-head" data-aos="fade-up">
    <div class="page-head__text">
        <p class="eyebrow">Daftar tanaman</p>
        <h1 class="page-head__title">Pengelolaan tanaman</h1>
        <p class="page-head__sub">{{ $ringkasan['total'] }} tanaman di 3 rak. Cari berdasarkan nama, kode, atau status.</p>
    </div>

    <p class="page-head__date">Rak A · B · C</p>
</section>

<div class="cell-grid grid grid-cols-3" data-aos="fade-up" data-aos-delay="50">
    <div class="cell">
        <p class="stat-card__value" data-count>{{ $ringkasan['total'] }}</p>
        <p class="stat-card__label">Total tanaman</p>
    </div>
    <div class="cell">
        <p class="stat-card__value" data-count>{{ $ringkasan['siap_panen'] }}</p>
        <p class="stat-card__label">Siap panen</p>
    </div>
    <div class="cell">
        <p class="stat-card__value" data-count>{{ $ringkasan['perlu_perhatian'] }}</p>
        <p class="stat-card__label">Perlu perhatian</p>
    </div>
</div>

<section class="panel" data-aos="fade-up" data-aos-delay="100">
    <div class="section-head">
        <h2 class="section-label">Buku catatan tanaman</h2>
        <span class="section-index">{{ $ringkasan['total'] }} entri</span>
    </div>

    <div class="toolbar">
        <div class="field field--search">
            <label class="sr-only" for="cari-tanaman">Cari tanaman</label>
            <input class="field__input" type="search" id="cari-tanaman" data-plant-search
                   placeholder="Cari nama, kode, atau rak..." autocomplete="off">
        </div>

        <div class="filter-chips" role="group" aria-label="Filter status tanaman">
            <button class="chip is-active" type="button" data-plant-filter="semua" aria-pressed="true">Semua</button>
            <button class="chip" type="button" data-plant-filter="Siap panen" aria-pressed="false">Siap panen</button>
            <button class="chip" type="button" data-plant-filter="Tumbuh" aria-pressed="false">Tumbuh</button>
            <button class="chip" type="button" data-plant-filter="Perlu perhatian" aria-pressed="false">Perlu perhatian</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="plant-table">
            <caption class="sr-only">Daftar {{ $ringkasan['total'] }} tanaman hidroponik beserta status dan estimasi panen</caption>
            <thead>
                <tr>
                    <th scope="col">Kode</th>
                    <th scope="col">Tanaman</th>
                    <th scope="col">Media</th>
                    <th scope="col">Rak</th>
                    <th scope="col">Umur</th>
                    <th scope="col">Status</th>
                    <th scope="col">Estimasi</th>
                </tr>
            </thead>
            <tbody data-plant-body>
                @foreach ($tanaman as $item)
                    <tr data-plant-row data-status="{{ $item['status'] }}">
                        <td data-label="Kode"><span class="plant-code">{{ $item['kode'] }}</span></td>
                        <td data-label="Tanaman">
                            <span class="plant-name">{{ $item['nama'] }}</span>
                            <span class="plant-category">{{ $item['kategori'] }}</span>
                        </td>
                        <td data-label="Media">{{ $item['media'] }}</td>
                        <td data-label="Rak">{{ $item['rak'] }}</td>
                        <td data-label="Umur">{{ $item['umur'] }} HST</td>
                        <td data-label="Status">
                            @if ($item['status'] === 'Siap panen')
                                <span class="badge badge--ready">Siap panen</span>
                            @elseif ($item['status'] === 'Perlu perhatian')
                                <span class="badge badge--warning">Perlu perhatian</span>
                            @else
                                <span class="badge badge--growing">Tumbuh</span>
                            @endif
                        </td>
                        <td data-label="Estimasi">{{ $item['estimasi'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="empty-state" data-plant-empty hidden>Tidak ada tanaman yang cocok. Coba kata kunci atau filter lain.</p>

    <p class="table-note">
        Data statis dari Controller, tidak diubah dari halaman ini.
    </p>
</section>
@endsection
