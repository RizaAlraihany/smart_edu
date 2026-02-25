<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['waliKelas', 'siswas'])->latest()->paginate(10);
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = Guru::where('status', 'aktif')->get();
        return view('kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'in:X,XI,XII'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'wali_kelas_id' => ['nullable', 'exists:gurus,id'],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kela)
    {
        $kela->load(['waliKelas', 'siswas', 'jadwals.mataPelajaran', 'jadwals.guru']);
        return view('kelas.show', compact('kela'));
    }

    public function edit(Kelas $kela)
    {
        $gurus = Guru::where('status', 'aktif')->get();
        return view('kelas.edit', compact('kela', 'gurus'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'in:X,XI,XII'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'wali_kelas_id' => ['nullable', 'exists:gurus,id'],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:50'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $kela->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
