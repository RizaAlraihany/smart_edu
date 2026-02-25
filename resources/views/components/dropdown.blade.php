@props(['title', 'icon', 'open' => false])

<div x-data="{ open: {{ $open ? 'true' : 'false' }} }">
    {{-- Tombol untuk membuka/menutup dropdown --}}
    <button @click="open = !open"
        class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md transition-colors hover:bg-gray-100 text-left">
        <span class="flex items-center gap-3">
            <i class="{{ $icon }} text-base w-5 text-center"></i>
            <span>{{ $title }}</span>
        </span>
        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
    </button>

    {{-- Konten dropdown (submenu) --}}
    <div x-show="open" x-transition class="mt-1 ml-4 pl-4 border-l border-gray-200 space-y-1">
        {{ $slot }}
    </div>
</div>
