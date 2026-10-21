<header class="site-header">
    <div class="header-inner">
        <a class="identitas-web" href="{{ route('home') }}" aria-label="BPS Provinsi Papua, halaman Home">
            <img src="{{ asset('assets/BPS.png') }}" alt="Logo Badan Pusat Statistik">
            <span class="judulweb">BPS PROVINSI PAPUA</span>
        </a>

        <nav aria-label="Navigasi utama">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            <a class="{{ request()->routeIs('publikasi.index', 'publikasi.edit') ? 'active' : '' }}" href="{{ route('publikasi.index') }}">Daftar Publikasi</a>
            <a class="{{ request()->routeIs('publikasi.create') ? 'active' : '' }}" href="{{ route('publikasi.create') }}">Tambah Publikasi</a>
            <a class="{{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}">Galeri Kegiatan</a>
            <a class="logout-trigger" href="#" data-logout-trigger>Logout</a>
        </nav>
    </div>
</header>
