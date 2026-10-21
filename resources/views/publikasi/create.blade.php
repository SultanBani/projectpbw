@extends('layouts.app')
@section('title', 'Tambah Publikasi')
@section('content')
<main>
    <h1>Form Tambah Publikasi Baru</h1>

    <form action="{{ route('publikasi.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <table>
            <tbody>
                <tr>
                    <td><label for="no">Nomor:</label></td>
                    <td>
                        <input id="no" name="no" type="number" min="1" value="{{ old('no') }}" required>
                        @error('no')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="judul">Judul:</label></td>
                    <td>
                        <input id="judul" name="judul" type="text" maxlength="100" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="tanggal_rilis">Tanggal Rilis:</label></td>
                    <td>
                        <input id="tanggal_rilis" name="tanggal_rilis" type="date" value="{{ old('tanggal_rilis') }}" required>
                        @error('tanggal_rilis')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="sampul">Sampul:</label></td>
                    <td>
                        <input id="sampul" name="sampul" type="file" accept="image/jpeg,image/png,image/gif,image/webp" required>
                        <small>JPG, PNG, GIF, atau WEBP; maksimal 2 MB.</small>
                        @error('sampul')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit">Tambah</button>
                        <a href="{{ route('publikasi.index') }}">Batal</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</main>
@endsection
