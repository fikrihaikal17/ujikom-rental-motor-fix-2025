@props([
'variant' => 'info',
'dismissible' => false,
'icon' => null,
'title' => null
])

@php
$alertClasses = match($variant) {
'success' => 'bg-green-50 border-green-200 text-green-800',
'error', 'danger' => 'bg-red-50 border-red-200 text-red-800',
'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
'info' => 'bg-blue-50 border-blue-200 text-blue-800',
default => 'bg-blue-50 border-blue-200 text-blue-800'
};

$iconClasses = match($variant) {
'success' => 'text-green-400',
'error', 'danger' => 'text-red-400',
'warning' => 'text-yellow-400',
'info' => 'text-blue-400',
default => 'text-blue-400'
};

$defaultIcons = [
'success' => 'check-circle',
'error' => 'x-circle',
'danger' => 'x-circle',
'warning' => 'exclamation-triangle',
'info' => 'information-circle'
];

$displayIcon = $icon ?? $defaultIcons[$variant] ?? 'information-circle';
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 {$alertClasses}"]) }}>
  <div class="flex">
    @if($displayIcon)
    <div class="flex-shrink-0">
      <x-dynamic-component :component="'icons.' . $displayIcon" class="h-5 w-5 {{ $iconClasses }}" />
    </div>
    @endif

    <div class="{{ $displayIcon ? 'ml-3' : '' }} flex-1">
      @if($title)
      <h3 class="text-sm font-medium mb-1">{{ $title }}</h3>
      @endif

      <div class="text-sm">
        {{ $slot }}
      </div>
    </div>

    @if($dismissible)
    <div class="ml-auto pl-3">
      <div class="-mx-1.5 -my-1.5">
        <button type="button"
          class="inline-flex rounded-md p-1.5 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent focus:ring-blue-600"
          onclick="this.closest('[role=alert]').remove()">
          <span class="sr-only">Dismiss</span>
          <x-icons.x-mark class="h-5 w-5" />
        </button>
      </div>
    </div>
    @endif
  </div>
</div>