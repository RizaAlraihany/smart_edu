<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dashboard</h1>
            <p class="text-gray-600">Selamat datang, Administrator</p>
        </div>

        @if ($user->isAdmin())
            <!-- Admin Dashboard Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Siswa -->
                <div class="stat-card blue">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-graduate text-4xl opacity-20"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-white/80 text-sm">Total Siswa</div>
                            <div class="text-white text-3xl font-bold">{{ $total_siswa ?? 150 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Total Guru -->
                <div class="stat-card green">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chalkboard-teacher text-4xl opacity-20"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-white/80 text-sm">Total Guru</div>
                            <div class="text-white text-3xl font-bold">{{ $total_guru ?? 25 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Kelas Aktif -->
                <div class="stat-card purple">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-door-open text-4xl opacity-20"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-white/80 text-sm">Kelas Aktif</div>
                            <div class="text-white text-3xl font-bold">{{ $total_kelas ?? 12 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Pending -->
                <div class="stat-card red">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-4xl opacity-20"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-white/80 text-sm">Pembayaran Pending</div>
                            <div class="text-white text-3xl font-bold">{{ $pembayaran_pending ?? 8 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pengumuman Terbaru -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Pengumuman Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-800">
                                            Libur Semester
                                        </p>
                                        <p class="text-sm text-blue-700 mt-1">
                                            Libur semester akan dimulai tanggal 20 Januari 2024
                                        </p>
                                        <p class="text-xs text-blue-600 mt-2">2024-01-15</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-yellow-800">
                                            Ujian Tengah Semester
                                        </p>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            UTS akan dilaksanakan mulai tanggal 25 Januari 2024
                                        </p>
                                        <p class="text-xs text-yellow-600 mt-2">2024-01-12</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-900">Absensi hari ini telah diinput</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-900">Nilai UTS telah diupdate</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-900">Pembayaran SPP menunggu konfirmasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($user->isGuru())
            <!-- Teacher Dashboard -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Today\'s Schedule -->
                <div class="card">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Hari Ini</h4>
                    <div class="space-y-3">
                        @forelse($jadwal_hari_ini ?? [] as $jadwal)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h5 class="font-medium">{{ $jadwal->mataPelajaran->nama_mapel }}</h5>
                                    <p class="text-sm text-gray-600">Kelas {{ $jadwal->kelas->nama_kelas }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">{{ $jadwal->jam_mulai->format('H:i') }} -
                                        {{ $jadwal->jam_selesai->format('H:i') }}</p>
                                    <p class="text-sm text-gray-600">{{ $jadwal->ruangan }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">Tidak ada jadwal hari ini</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Kelas yang Diampu:</span>
                            <span class="font-semibold">{{ $kelas_diampu ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($user->isSiswa())
            <!-- Student Dashboard -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Today's Schedule -->
                <div class="card">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Hari Ini</h4>
                    <div class="space-y-3">
                        @forelse($jadwal_hari_ini ?? [] as $jadwal)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h5 class="font-medium">{{ $jadwal->mataPelajaran->nama_mapel }}</h5>
                                    <p class="text-sm text-gray-600">{{ $jadwal->guru->nama }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">{{ $jadwal->jam_mulai->format('H:i') }} -
                                        {{ $jadwal->jam_selesai->format('H:i') }}</p>
                                    <p class="text-sm text-gray-600">{{ $jadwal->ruangan }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">Tidak ada jadwal hari ini</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Grades -->
                <div class="card">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Nilai Terbaru</h4>
                    <div class="space-y-3">
                        @forelse($nilai_terbaru ?? [] as $nilai)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h5 class="font-medium">{{ $nilai->mataPelajaran->nama_mapel }}</h5>
                                    <p class="text-sm text-gray-600">{{ ucfirst($nilai->jenis_nilai) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold {{ $nilai->nilai >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $nilai->nilai }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">Belum ada nilai</p>
                        @endforelse
                    </div>
                </div>
            </div>

            @if (isset($pembayaran_pending) && $pembayaran_pending > 0)
                <!-- Payment Alert -->
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Anda memiliki {{ $pembayaran_pending }} pembayaran yang belum diselesaikan.
                                <a href="{{ route('pembayaran.index') }}" class="font-medium underline">Lihat detail</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>