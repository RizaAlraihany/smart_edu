<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumanList = Pengumuman::with('pembuat')->latest()->paginate(10);
        return view('pengumuman.index', compact('pengumumanList'));
    }

    public function create()
    {
        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_publish' => 'nullable|date',
        ]);

        $validatedData['dibuat_oleh_nip'] = Auth::user()->nip;
        Pengumuman::create($validatedData);
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        // **OTORISASI:** Hanya admin atau guru yang membuat pengumuman yang boleh mengedit.
        if (Auth::user()->cannot('is-admin') && $pengumuman->dibuat_oleh_nip !== Auth::user()->nip) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }
        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        // **OTORISASI:** Pengecekan yang sama seperti di method edit.
        if (Auth::user()->cannot('is-admin') && $pengumuman->dibuat_oleh_nip !== Auth::user()->nip) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_publish' => 'nullable|date',
        ]);

        $pengumuman->update($validatedData);
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        // **OTORISASI:** Pengecekan yang sama.
        if (Auth::user()->cannot('is-admin') && $pengumuman->dibuat_oleh_nip !== Auth::user()->nip) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }
        $pengumuman->delete();
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
