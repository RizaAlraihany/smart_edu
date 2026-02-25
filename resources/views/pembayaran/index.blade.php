<x-app-layout>
    <x-slot name="header">Data Siswa</x-slot>

    <div class="space-y-6">
        <!-- Header dengan tombol tambah -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Siswa</h1>
                <p class="text-gray-600">Kelola data siswa</p>
            </div>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Siswa
            </a>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Kelas</label>
                    <select class="form-select">
                        <option>Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option>Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                        <option value="lulus">Lulus</option>
                        <option value="pindah">Pindah</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select">
                        <option>Semua</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="btn btn-primary w-full">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $siswa)
                            <tr>
                                <td class="font-medium">{{ $siswa->nisn }}</td>
                                <td>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-500 text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">{{ $siswa->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $siswa->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $siswa->telepon ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $siswa->status == 'aktif' ? 'badge-success' : ($siswa->status == 'lulus' ? 'badge-info' : 'badge-warning') }}">
                                        {{ ucfirst($siswa->status) }}
                                    </span>
                                </td>
                                <td class="space-x-2">
                                    <a href="{{ route('siswa.show', $siswa) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="inline-block" action="{{ route('siswa.destroy', $siswa) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-users text-4xl mb-2"></i>
                                    <p>Tidak ada data siswa</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($siswas->hasPages())
                <div class="px-6 py-3 bg-gray-50 border-t">
                    {{ $siswas->links() }}
                </div>
            @endif
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="stat-card blue">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-graduate text-3xl opacity-20"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-white/80 text-sm">Total Siswa</div>
                        <div class="text-white text-2xl font-bold">{{ $total_siswa }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card green">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-3xl opacity-20"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-white/80 text-sm">Siswa Aktif</div>
                        <div class="text-white text-2xl font-bold">{{ $siswa_aktif }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card purple">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-male text-3xl opacity-20"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-white/80 text-sm">Laki-laki</div>
                        <div class="text-white text-2xl font-bold">{{ $siswa_laki }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card orange">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-female text-3xl opacity-20"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-white/80 text-sm">Perempuan</div>
                        <div class="text-white text-2xl font-bold">{{ $siswa_perempuan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>