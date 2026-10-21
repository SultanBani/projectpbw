@extends('layouts.app')
@section('title', 'Galeri Kegiatan')
@section('content')
<main class="gallery-page">
    <h1>Galeri Kegiatan</h1>
    <p class="gallery-intro">Dokumentasi kegiatan BPS Provinsi Papua.</p>

    <section class="container-galeri">
        <div class="galeri-hero">
            <button type="button" class="galeri-nav galeri-sebelum" aria-label="Foto sebelumnya">‹</button>
            <img id="gambarUtama" src="{{ asset('assets/galeri1.jpeg') }}" alt="Kegiatan BPS Papua">
            <button type="button" class="galeri-nav galeri-sesudah" aria-label="Foto berikutnya">›</button>
        </div>
        <div class="galeri-dots"></div>
        <div class="thumbnail">
            @foreach (['galeri1.jpeg', 'galeri2.jpeg', 'galeri3.jpeg', 'galeri4.jpg', 'galeri5.jpg', 'galeri6.jpg'] as $image)
                <img src="{{ asset('assets/'.$image) }}" alt="Kegiatan BPS Papua">
            @endforeach
        </div>
    </section>
</main>
@endsection
@push('scripts')
    <script src="{{ asset('assets/galeri.js') }}"></script>
@endpush
