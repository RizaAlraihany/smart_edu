@props([
    'href' => '#',
    'active' => false,
])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'block px-3 py-2 rounded-md ' . ($active ? 'text-blue-600 font-semibold' : 'hover:text-gray-900'),
    ]) }}>
    {{ $slot }}
</a>
