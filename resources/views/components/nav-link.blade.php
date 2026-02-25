{{-- @props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

 --}}

@props(['active' => false, 'icon' => null])

@php
    // Kelas dasar yang selalu ada
    $baseClasses = 'flex items-center gap-3 px-3 py-2 rounded-md transition-colors';

    // Kelas tambahan jika link sedang aktif
    $activeClasses = 'bg-blue-100 text-blue-600 font-semibold';

    // Kelas tambahan jika link tidak aktif (hanya untuk hover)
    $inactiveClasses = 'hover:bg-gray-100';

    // Gabungkan kelas berdasarkan kondisi 'active'
    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Ikon - HANYA TAMPIL JIKA ICON DIBERIKAN --}}
    @if ($icon)
        <i class="{{ $icon }} text-base w-5 text-center"></i>
    @endif

    {{-- Teks (Slot) --}}
    <span>{{ $slot }}</span>
</a>
