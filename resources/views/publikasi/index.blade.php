@extends('layouts.app')
@section('title', 'Daftar Publikasi')
@section('content')
<main
    data-api-url="{{ route('publikasi.data') }}"
    data-assets-url="{{ asset('assets') }}"
    data-edit-url="{{ url('/publikasi/__NO__/edit') }}"
    data-delete-url="{{ url('/publikasi/__NO__') }}"
>
    <h1>Daftar Publikasi</h1>

    @if (session('success'))
        <p class="notifikasi sukses">{{ session('success') }}</p>
    @endif

    <section class="pencarian" aria-label="Pencarian publikasi">
        <label for="kataKunci">Cari Judul Publikasi:</label>
        <input id="kataKunci" type="search" placeholder="Ketik judul publikasi" autocomplete="off">
    </section>

    <div id="saranPublikasi" class="saran-publikasi" aria-live="polite" hidden></div>
    <p id="statusPencarian" aria-live="polite" hidden></p>

    <div class="tabel-responsif">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Tanggal Rilis</th>
                    <th>Sampul</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="isiPublikasi">
                @forelse ($publikasi as $item)
                    <tr>
                        <td>{{ $item->no }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->tanggal_rilis->format('d F Y') }}</td>
                        <td>
                            <img
                                src="{{ asset('assets/'.$item->sampul) }}"
                                alt="Sampul {{ $item->judul }}"
                                width="70"
                                onerror="this.alt='Sampul tidak tersedia'; this.removeAttribute('src');"
                            >
                        </td>
                        <td>
                            <a href="{{ route('publikasi.edit', $item) }}">Edit</a> |
                            <form
                                class="form-hapus"
                                action="{{ route('publikasi.destroy', $item) }}"
                                method="post"
                                onsubmit="return confirm('Yakin ingin menghapus publikasi ini?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada publikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
@push('scripts')
    <script src="{{ asset('assets/live-publikasi.js') }}"></script>
@endpush
