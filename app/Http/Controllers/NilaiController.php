<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // load relasi siswa dan mataPelajaran untuk efisiensi
        $nilaiList = Nilai::with(['siswa', 'mataPelajaran'])->latest()->paginate(15);
        return view('nilai.index', compact('nilaiList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data siswa dan mapel untuk dropdown di form
        $siswaList = Siswa::orderBy('nama')->get();
        $mapelList = MataPelajaran::orderBy('nama_mapel')->get();
        return view('nilai.create', compact('siswaList', 'mapelList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nisn_siswa' => 'required|exists:siswas,nisn',
            'id_mapel' => 'required|exists:mata_pelajarans,id_mapel',
            'jenis' => 'required|string|max:50', // Misal: Tugas, UTS, UAS
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        Nilai::create($validatedData);
        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
    }
    
    /**
     * Show the form for editing the specified resource.
    */
    public function edit(Nilai $nilai)
    {
        $siswaList = Siswa::orderBy('nama')->get();
        $mapelList = MataPelajaran::orderBy('nama_mapel')->get();
        return view('nilai.edit', compact('nilai', 'siswaList', 'mapelList'));
    }
    
    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, Nilai $nilai)
    {
        $validatedData = $request->validate([
            'nisn_siswa' => 'required|exists:siswas,nisn',
            'id_mapel' => 'required|exists:mata_pelajarans,id_mapel',
            'jenis' => 'required|string|max:50',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);
    
        $nilai->update($validatedData);
        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}
