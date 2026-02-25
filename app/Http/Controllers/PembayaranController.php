<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Pembayaran::with('siswa');

        // Jika user adalah SISWA, filter hanya untuk pembayarannya sendiri.
        if ($user->can('is-siswa')) {
            // Asumsi: tabel 'users' memiliki kolom 'nisn' untuk siswa
            $query->where('nisn_siswa', $user->nisn);
        }

        $pembayaranList = $query->latest()->paginate(15);
        return view('pembayaran.index', compact('pembayaranList'));
    }

    public function create()
    {
        $this->authorize('is-admin'); 
        $siswaList = Siswa::orderBy('nama')->get();
        return view('pembayaran.create', compact('siswaList'));
    }

    public function store(Request $request)
    {
        $this->authorize('is-admin');
        $validatedData = $request->validate([
            'nisn_siswa' => 'required|exists:siswas,nisn',
            'jenis_pembayaran' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:Lunas,Belum Lunas',
        ]);

        Pembayaran::create($validatedData);
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil ditambahkan.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $this->authorize('is-admin');
        $siswaList = Siswa::orderBy('nama')->get();
        return view('pembayaran.edit', compact('pembayaran', 'siswaList'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $this->authorize('is-admin');
        $validatedData = $request->validate([
            'nisn_siswa' => 'required|exists:siswas,nisn',
            'jenis_pembayaran' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:Lunas,Belum Lunas',
        ]);

        $pembayaran->update($validatedData);
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $this->authorize('is-admin');
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
