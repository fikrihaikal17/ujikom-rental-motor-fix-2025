@props([
'variant' => 'primary',
'size' => 'md',
'icon' => null,
'iconPosition' => 'left',
'type' => 'button',
'disabled' => false
])

@php
$baseClasses = 'btn-base focus-ring disabled:opacity-50 disabled:cursor-not-allowed';

$variantClasses = match($variant) {
'primary' => 'btn-primary',
'secondary' => 'btn-secondary',
'danger' => 'btn-danger',
'success' => 'btn-success',
default => 'btn-primary',
};

$sizeClasses = match($size) {
'sm' => 'btn-sm',
'md' => 'btn-md',
'lg' => 'btn-lg',
default => 'btn-md',
};

$classes = $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses;
@endphp

<button
  type="{{ $type }}"
  {{ $attributes->merge(['class' => $classes]) }}
  @if($disabled) disabled @endif>
  @if($icon && $iconPosition === 'left')
  <x-dynamic-component :component="'icons.' . $icon" class="w-4 h-4 mr-2" />
  @endif

  {{ $slot }}

  @if($icon && $iconPosition === 'right')
  <x-dynamic-component :component="'icons.' . $icon" class="w-4 h-4 ml-2" />
  @endif
</button>