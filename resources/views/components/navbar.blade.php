@props(['username' => null])

<header class="site-header">
    <div class="container nav">
        <a class="brand" href="{{ $username !== null ? route('dashboard', ['username' => $username]) : route('login') }}">
            <svg class="brand__mark" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M12 21c0-6 3-10 8-12-1 7-4 10-8 12Z"></path>
                <path d="M12 21C12 14 8 10 4 8c1 7 4 11 8 13Z"></path>
                <path d="M12 21v-6"></path>
            </svg>
            <span class="brand__name">tunas</span>
        </a>

        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="menu-utama">
            <span class="nav-toggle__bar"></span>
            <span class="nav-toggle__bar"></span>
            <span class="nav-toggle__bar"></span>
            <span class="sr-only">Buka menu navigasi</span>
        </button>

        <nav id="menu-utama" class="nav-menu" data-nav-menu aria-label="Menu utama">
            @if ($username !== null)
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
                   href="{{ route('dashboard', ['username' => $username]) }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('pengelolaan') ? 'is-active' : '' }}"
                   href="{{ route('pengelolaan', ['username' => $username]) }}">Pengelolaan</a>
                <a class="nav-link {{ request()->routeIs('profile') ? 'is-active' : '' }}"
                   href="{{ route('profile', ['username' => $username]) }}">Profil</a>

                <span class="user-chip">
                    <span class="user-chip__initial" aria-hidden="true">{{ strtoupper(substr($username, 0, 1)) }}</span>
                    <span class="user-chip__name">{{ $username }}</span>
                </span>

                <a class="nav-link nav-link--muted" href="{{ route('logout') }}">Keluar</a>
            @else
                <a class="nav-link {{ request()->routeIs('login') ? 'is-active' : '' }}" href="{{ route('login') }}">Masuk</a>
            @endif
        </nav>
    </div>
</header>
