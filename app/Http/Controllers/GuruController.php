<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user')->paginate(20);

        $total_guru = Guru::count();
        $guru_aktif = Guru::where('status', 'aktif')->count();
        $guru_laki = Guru::where('jenis_kelamin', 'L')->count();
        $guru_perempuan = Guru::where('jenis_kelamin', 'P')->count();

        return view('guru.index', compact(
            'gurus',
            'total_guru',
            'guru_aktif',
            'guru_laki',
            'guru_perempuan'
        ));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nip' => 'required|string|unique:gurus',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
                'email_verified_at' => now(),
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function show(Guru $guru)
    {
        $guru->load('user');
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        DB::transaction(function () use ($request, $guru) {
            $guru->user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            $guru->update([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru) {
            $guru->user->delete(); // Akan cascade delete guru juga
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
