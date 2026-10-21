<footer class="site-footer">
    <div class="footer-inner">
        <section class="footer-identitas" aria-label="Identitas website">
            <div class="footer-logo-nama">
                <img src="{{ asset('assets/BPS.png') }}" alt="Logo Badan Pusat Statistik">
                <strong>BPS PROVINSI PAPUA</strong>
            </div>
            <p>Portal internal untuk mengelola publikasi dan mengakses data statistik BPS.</p>
        </section>
        <section class="footer-tautan" aria-labelledby="footerNavigasi">
            <h2 id="footerNavigasi">Navigasi</h2>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('publikasi.index') }}">Daftar Publikasi</a>
            <a href="{{ route('galeri') }}">Galeri Kegiatan</a>
        </section>
        <section class="footer-tautan" aria-labelledby="footerBps">
            <h2 id="footerBps">Sumber Resmi</h2>
            <a href="https://papua.bps.go.id/" target="_blank" rel="noopener noreferrer">Website BPS Papua</a>
        </section>
    </div>
    <div class="footer-bawah">
        <address><i>Dibuat oleh Theresia Neva (222413793@stis.ac.id)</i></address>
        <small>&copy; {{ now()->year }} BPS Provinsi Papua</small>
    </div>
</footer>
<dialog id="dialogLogout" class="dialog-logout" aria-labelledby="judulDialogLogout">
    <form method="dialog" class="dialog-logout-konten">
        <h2 id="judulDialogLogout">Konfirmasi Logout</h2>
        <p>Apakah Anda yakin ingin keluar dari akun?</p>
        <div class="dialog-aksi">
            <button type="submit" value="batal" class="tombol-sekunder">Batal</button>
            <button type="button" id="konfirmasiLogout">Logout</button>
        </div>
    </form>
</dialog>
<form id="formLogout" action="{{ route('logout') }}" method="post" hidden>
    @csrf
</form>
