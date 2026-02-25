<x-app-layout>
    {{-- Slot untuk Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Ganti Judul Ini Sesuai Halaman --}}
            {{ __('Judul Halaman Anda') }}
        </h2>
    </x-slot>

    {{-- Konten Utama --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Letakkan semua konten spesifik halaman di sini --}}
                    {{-- Contoh: Tombol Tambah, Tabel Data, Form, dll. --}}

                    <p>Konten untuk halaman ini akan ditampilkan di sini.</p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
