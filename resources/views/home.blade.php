@extends('layouts.app')
@section('title', 'Home')
@section('content')
<main class="home" id="kontenUtama">
    <section class="home-hero" aria-labelledby="selamatDatang">
        <div class="home-hero-isi">
            <span class="home-label">PORTAL INTERNAL BPS</span>
            <h1 id="selamatDatang">Selamat Datang</h1>
            <p>Kelola publikasi dan akses data statistik BPS Provinsi Papua dalam satu tempat.</p>
            <p class="session-info">Login sebagai: {{ session('bps_username') }}</p>
            <a class="tombol-utama" href="{{ route('publikasi.index') }}">Lihat Publikasi</a>
        </div>
    </section>

    <section class="home-fitur" aria-labelledby="fiturUtama">
        <div class="home-section-heading">
            <span>AKSES CEPAT</span>
            <h2 id="fiturUtama">Layanan Utama</h2>
        </div>
        <div class="home-kartu-grid">
            <a class="home-kartu" href="{{ route('publikasi.index') }}">
                <strong>Daftar Publikasi</strong>
                <span>Kelola dan temukan publikasi yang tersedia.</span>
            </a>
            <a class="home-kartu" href="{{ route('publikasi.create') }}">
                <strong>Tambah Publikasi</strong>
                <span>Tambahkan publikasi baru ke dalam daftar.</span>
            </a>
            <a class="home-kartu" href="{{ route('galeri') }}">
                <strong>Galeri Kegiatan</strong>
                <span>Lihat dokumentasi kegiatan BPS Papua.</span>
            </a>
        </div>
    </section>

    <section class="home-sumber" aria-label="Sumber resmi">
        <p>Gunakan sumber resmi untuk informasi statistik yang lebih lengkap.</p>
        <div>
            <a href="https://papua.bps.go.id/" target="_blank" rel="noopener noreferrer">Website BPS Papua</a>
        </div>
    </section>
</main>
@endsection
