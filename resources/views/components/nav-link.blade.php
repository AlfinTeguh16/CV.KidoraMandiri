@props(['href', 'active'])

@php
$classes = $active
    ? 'flex items-center px-4 py-2 rounded bg-blue-100 text-blue-700 font-semibold'
    : 'flex items-center px-4 py-2 rounded text-gray-700 hover:bg-gray-100';
@endphp

<li>
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </a>
</li>
