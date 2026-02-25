<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Absensi;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $data = [
            'user' => $user,
            'pengumuman_terbaru' => Pengumuman::where('status', 'aktif')
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->latest()
                ->take(5)
                ->get(),
        ];

        if ($user->isAdmin()) {
            $data = array_merge($data, [
                'total_siswa' => Siswa::where('status', 'aktif')->count(),
                'total_guru' => Guru::where('status', 'aktif')->count(),
                'total_kelas' => Kelas::where('status', 'aktif')->count(),
                'total_mapel' => MataPelajaran::where('status', 'aktif')->count(),
                'pembayaran_pending' => Pembayaran::where('status_pembayaran', 'belum_bayar')->count(),
                'absensi_hari_ini' => Absensi::whereDate('tanggal', today())->count(),
            ]);
        } elseif ($user->isGuru()) {
            $guru = $user->guru;
            if ($guru) {
                $data = array_merge($data, [
                    'jadwal_hari_ini' => $guru->jadwals()
                        ->where('hari', Carbon::now()->locale('id')->dayName)
                        ->with(['kelas', 'mataPelajaran'])
                        ->get(),
                    'kelas_diampu' => $guru->jadwals()
                        ->with('kelas')
                        ->distinct('kelas_id')
                        ->count(),
                ]);
            }
        } elseif ($user->isSiswa()) {
            $siswa = $user->siswa;
            if ($siswa && $siswa->kelas) {
                $data = array_merge($data, [
                    'jadwal_hari_ini' => $siswa->kelas->jadwals()
                        ->where('hari', Carbon::now()->locale('id')->dayName)
                        ->with(['mataPelajaran', 'guru'])
                        ->get(),
                    'nilai_terbaru' => $siswa->nilais()
                        ->with(['mataPelajaran', 'guru'])
                        ->latest()
                        ->take(5)
                        ->get(),
                    'pembayaran_pending' => $siswa->pembayarans()
                        ->where('status_pembayaran', 'belum_bayar')
                        ->count(),
                ]);
            }
        }

        return view('dashboard', $data);
    }
}
