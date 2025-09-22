@props([
'variant' => 'default',
'size' => 'md',
'padding' => true,
'shadow' => true,
'border' => true,
'rounded' => true
])

@php
$classes = 'bg-white';

// Variant styling
$classes .= match($variant) {
'outlined' => ' border border-gray-200',
'elevated' => ' border border-gray-100 shadow-lg',
'gradient' => ' bg-gradient-to-br from-white to-gray-50 border border-gray-100',
default => ' border border-gray-200'
};

// Size-based padding
if($padding) {
$classes .= match($size) {
'sm' => ' p-3',
'lg' => ' p-8',
default => ' p-6'
};
}

// Shadow
if($shadow && $variant !== 'elevated') {
$classes .= ' shadow-sm';
}

// Rounded corners
if($rounded) {
$classes .= ' rounded-lg';
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</div>