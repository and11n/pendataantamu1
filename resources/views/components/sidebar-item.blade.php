@props(['active', 'img', 'activeimg'])
@php
    $classes = $active ?? false ? 'd-flex gap-2 align-items-center' : 'd-flex gap-2 align-items-center';
    $styles = $active ?? false ? 'text-decoration: none;color:2F80ED' : 'text-decoration: none;color:#B1B1B1';
    $image = $active ?? false ? $activeimg : $img;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} {{ $attributes->merge(['style' => $styles]) }}>
    <div>
        <img src="{{ $image }}" alt="logo">
    </div>
    <div>
        {{ $slot }}
    </div>
</a>
