<x-app-layout>
    <x-slot name="header">Data Guru</x-slot>

    <div class="space-y-6">
        <!-- Header dengan tombol tambah -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Guru</h1>
                <p class="text-gray-600">Kelola data guru</p>
            </div>
            <a href="{{ route('guru.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Guru
            </a>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option>Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
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
                <div>
                    <label class="form-label">Pendidikan</label>
                    <select class="form-select">
                        <option>Semua</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Telepon</th>
                            <th>Pendidikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $guru)
                            <tr>
                                <td class="font-medium">{{ $guru->nip }}</td>
                                <td>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-500 text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">{{ $guru->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $guru->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $guru->telepon ?? '-' }}</td>
                                <td>{{ $guru->pendidikan_terakhir ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $guru->status == 'aktif' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($guru->status) }}
                                    </span>
                                </td>
                                <td class="space-x-2">
                                    <a href="{{ route('guru.show', $guru) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('guru.edit', $guru) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="inline-block" action="{{ route('guru.destroy', $guru) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                    <i class="fas fa-chalkboard-teacher text-4xl mb-2"></i>
                                    <p>Tidak ada data guru</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($gurus->hasPages())
                <div class="px-6 py-3 bg-gray-50 border-t">
                    {{ $gurus->links() }}
                </div>
            @endif
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="stat-card green">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher text-3xl opacity-20"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-white/80 text-sm">Total Guru</div>
                        <div class="text-white text-2xl font-bold">{{ $total_guru }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card blue">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-3xl opacity-20"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-white/80 text-sm">Guru Aktif</div>
                        <div class="text-white text-2xl font-bold">{{ $guru_aktif }}</div>
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
                        <div class="text-white text-2xl font-bold">{{ $guru_laki }}</div>
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
                        <div class="text-white text-2xl font-bold">{{ $guru_perempuan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
