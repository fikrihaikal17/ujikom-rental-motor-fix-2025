@props([
'striped' => false,
'hoverable' => true,
'bordered' => true,
'compact' => false
])

@php
$tableClasses = 'min-w-full divide-y divide-gray-200';
if ($bordered) {
$tableClasses .= ' border border-gray-200';
}
@endphp

<div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
  <div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => $tableClasses]) }}>
      {{ $slot }}
    </table>
  </div>
</div>

@pushOnce('styles')
<style>
  .table-row-striped:nth-child(even) {
    background-color: rgb(249 250 251);
  }

  .table-row-hover:hover {
    background-color: rgb(243 244 246);
  }

  .table-compact th,
  .table-compact td {
    padding: 0.5rem 0.75rem;
  }
</style>
@endPushOnce