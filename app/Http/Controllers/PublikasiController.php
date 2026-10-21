<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PublikasiController extends Controller
{
    public function index()
    {
        $publikasi = Publikasi::orderBy('no')->get();

        return view('publikasi.index', compact('publikasi'));
    }

    public function create()
    {
        return view('publikasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'no' => ['required', 'integer', 'min:1', 'unique:publikasi,no'],
            'judul' => ['required', 'string', 'max:100'],
            'tanggal_rilis' => ['required', 'date'],
            'sampul' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        $data['sampul'] = $this->saveCover($request->file('sampul'));

        Publikasi::create($data);

        return redirect()->route('publikasi.index')
            ->with('success', 'Publikasi baru berhasil ditambahkan.');
    }

    public function data(Request $request)
    {
        $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $query = trim((string) $request->query('q'));
        $publikasi = Publikasi::when($query !== '', fn ($builder) => $builder->where('judul', 'like', "%{$query}%"))
            ->orderBy('no')
            ->get(['no', 'judul', 'tanggal_rilis', 'sampul']);

        return response()->json(['data' => $publikasi]);
    }

    public function edit(Publikasi $publikasi)
    {
        return view('publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, Publikasi $publikasi)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:100'],
            'tanggal_rilis' => ['required', 'date'],
            'sampul_baru' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('sampul_baru')) {
            $oldCover = $publikasi->sampul;
            $data['sampul'] = $this->saveCover($request->file('sampul_baru'));
            unset($data['sampul_baru']);
            $this->deleteUploadedCover($oldCover);
        } else {
            unset($data['sampul_baru']);
        }

        $publikasi->update($data);

        return redirect()->route('publikasi.index')->with('success', 'Data publikasi berhasil diubah.');
    }

    public function destroy(Publikasi $publikasi)
    {
        $cover = $publikasi->sampul;
        $publikasi->delete();
        $this->deleteUploadedCover($cover);

        return redirect()->route('publikasi.index')->with('success', 'Data publikasi berhasil dihapus.');
    }

    private function saveCover(UploadedFile $file): string
    {
        $name = 'cover_'.bin2hex(random_bytes(8)).'.'.$file->extension();
        $file->move(public_path('assets'), $name);

        return $name;
    }

    private function deleteUploadedCover(string $cover): void
    {
        if (preg_match('/^cover_[a-f0-9]{16}\.(jpg|jpeg|png|gif|webp)$/', $cover)) {
            @unlink(public_path("assets/{$cover}"));
        }
    }
}
