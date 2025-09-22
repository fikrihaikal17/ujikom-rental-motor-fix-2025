@props([
'striped' => false,
'hoverable' => true,
'clickable' => false,
'align' => 'left'
])

@php
$parentTable = $attributes->whereStartsWith('data-table-');
$isStriped = $parentTable['data-table-striped'] ?? $striped;
$isHoverable = $parentTable['data-table-hoverable'] ?? $hoverable;
$isCompact = $parentTable['data-table-compact'] ?? false;

$classes = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
$classes .= match($align) {
'center' => ' text-center',
'right' => ' text-right',
default => ' text-left'
};

if ($isCompact) {
$classes .= ' table-compact';
}
@endphp

<td {{ $attributes->except(array_keys($parentTable))->merge(['class' => $classes]) }}>
  {{ $slot }}
</td>