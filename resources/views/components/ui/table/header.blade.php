@props([
'sortable' => false,
'sortDirection' => null,
'align' => 'left'
])

@php
$classes = 'px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider';
$classes .= match($align) {
'center' => ' text-center',
'right' => ' text-right',
default => ' text-left'
};

if ($sortable) {
$classes .= ' cursor-pointer select-none hover:bg-gray-100';
}
@endphp

<th {{ $attributes->merge(['class' => $classes]) }}>
  <div class="flex items-center {{ $align === 'center' ? 'justify-center' : ($align === 'right' ? 'justify-end' : '') }}">
    <span>{{ $slot }}</span>

    @if($sortable)
    <span class="ml-2 flex-none rounded text-gray-400">
      @if($sortDirection === 'asc')
      <x-icons.chevron-up class="h-4 w-4" />
      @elseif($sortDirection === 'desc')
      <x-icons.chevron-down class="h-4 w-4" />
      @else
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
      </svg>
      @endif
    </span>
    @endif
  </div>
</th>