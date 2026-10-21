@extends('layouts.app')
@section('title', 'Edit Publikasi')
@section('content')
<main>
    <h1>Ubah Data Publikasi</h1>

    <form action="{{ route('publikasi.update', $publikasi) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table>
            <tbody>
                <tr>
                    <td>Nomor:</td>
                    <td>{{ $publikasi->no }}</td>
                </tr>
                <tr>
                    <td><label for="judul">Judul:</label></td>
                    <td>
                        <input id="judul" type="text" name="judul" value="{{ old('judul', $publikasi->judul) }}" maxlength="100" required>
                        @error('judul')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="tanggal_rilis">Tanggal:</label></td>
                    <td>
                        <input id="tanggal_rilis" type="date" name="tanggal_rilis" value="{{ old('tanggal_rilis', $publikasi->tanggal_rilis->format('Y-m-d')) }}" required>
                        @error('tanggal_rilis')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>Sampul Lama:</td>
                    <td><img src="{{ asset('assets/'.$publikasi->sampul) }}" alt="Sampul lama" width="70"></td>
                </tr>
                <tr>
                    <td><label for="sampul_baru">Sampul Baru:</label></td>
                    <td>
                        <input id="sampul_baru" type="file" name="sampul_baru" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small>Kosongkan bila tidak diganti.</small>
                        @error('sampul_baru')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit">Simpan Perubahan</button></td>
                </tr>
            </tbody>
        </table>
    </form>
</main>
@endsection
