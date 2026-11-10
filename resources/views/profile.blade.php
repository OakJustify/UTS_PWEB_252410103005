@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<section class="page-head" data-aos="fade-up">
    <div class="page-head__text">
        <p class="eyebrow">Akun pengelola</p>
        <h1 class="page-head__title">Profil pengelola</h1>
        <p class="page-head__sub">Akun simulasi untuk UTS. Tidak terhubung ke basis data.</p>
    </div>

    <p class="page-head__date">{{ $profil['bergabung'] }}</p>
</section>

<section class="panel profile-card" data-aos="fade-up" data-aos-delay="50">
    <div class="grid gap-5 lg:grid-cols-[1fr_420px] items-center">
        <div class="profile-card__identity">
            <span class="avatar" aria-hidden="true">{{ $profil['inisial'] }}</span>
            <div class="flex-1 min-w-0">
                <p class="profile-card__name">{{ $username }}</p>
                <p class="profile-card__role">{{ $profil['peran'] }}</p>
                <p class="profile-card__meta">Bergabung {{ $profil['bergabung'] }} · {{ $profil['lokasi'] }}</p>
            </div>
        </div>

        <div class="cell-grid grid grid-cols-3">
            @foreach ($profil['statistik'] as $item)
                <div class="cell profile-stat">
                    <p class="profile-stat__value" data-count>{{ $item['value'] }}</p>
                    <p class="profile-stat__label">{{ $item['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <blockquote class="profile-card__bio">{{ $profil['bio'] }}</blockquote>

    <div class="profile-prefs">
        <div class="section-head">
            <h2 class="section-label">Preferensi</h2>
            <span class="section-index">04</span>
        </div>

        <dl class="prefs-list">
            @foreach ($profil['preferensi'] as $item)
                <div class="prefs-list__item">
                    <dt>{{ $item['judul'] }}</dt>
                    <dd>{{ $item['nilai'] }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>
@endsection
