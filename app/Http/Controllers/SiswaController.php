<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with(['kelas', 'user'])->paginate(20);
        $kelas = Kelas::where('status', 'aktif')->get();

        $total_siswa = Siswa::count();
        $siswa_aktif = Siswa::where('status', 'aktif')->count();
        $siswa_laki = Siswa::where('jenis_kelamin', 'L')->count();
        $siswa_perempuan = Siswa::where('jenis_kelamin', 'P')->count();

        return view('siswa.index', compact(
            'siswas',
            'kelas',
            'total_siswa',
            'siswa_aktif',
            'siswa_laki',
            'siswa_perempuan'
        ));
    }

    public function create()
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nisn' => 'required|string|unique:siswas',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string',
            'telepon_orang_tua' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
                'email_verified_at' => now(),
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'telepon_orang_tua' => $request->telepon_orang_tua,
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'user', 'nilais.mataPelajaran']);
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string',
            'telepon_orang_tua' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif,lulus,pindah',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            $siswa->user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            $siswa->update([
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'telepon_orang_tua' => $request->telepon_orang_tua,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $siswa->user->delete(); // Akan cascade delete siswa juga
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
