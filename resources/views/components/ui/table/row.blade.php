@props([
'striped' => false,
'hoverable' => true,
'clickable' => false
])

@php
$parentTable = $attributes->whereStartsWith('data-table-');
$isStriped = $parentTable['data-table-striped'] ?? $striped;
$isHoverable = $parentTable['data-table-hoverable'] ?? $hoverable;

$classes = '';

if ($isStriped) {
$classes .= ' table-row-striped';
}

if ($isHoverable) {
$classes .= ' table-row-hover';
}

if ($clickable) {
$classes .= ' cursor-pointer';
}
@endphp

<tr {{ $attributes->except(array_keys($parentTable))->merge(['class' => $classes]) }}>
  {{ $slot }}
</tr>