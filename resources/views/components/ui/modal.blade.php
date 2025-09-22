@props([
'id' => 'modal',
'show' => false,
'maxWidth' => '2xl',
'closeable' => true,
'title' => null,
'footer' => null
])

@php
$maxWidthClass = match($maxWidth) {
'sm' => 'sm:max-w-sm',
'md' => 'sm:max-w-md',
'lg' => 'sm:max-w-lg',
'xl' => 'sm:max-w-xl',
'2xl' => 'sm:max-w-2xl',
'3xl' => 'sm:max-w-3xl',
'4xl' => 'sm:max-w-4xl',
'5xl' => 'sm:max-w-5xl',
'6xl' => 'sm:max-w-6xl',
'7xl' => 'sm:max-w-7xl',
default => 'sm:max-w-2xl'
};
@endphp

<div x-data="{ 
        show: @js($show),
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
  x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-hidden');
            setTimeout(() => firstFocusable()?.focus(), 100)
        } else {
            document.body.classList.remove('overflow-hidden');
        }
    })"
  x-on:open-modal.window="$event.detail == '{{ $id }}' ? show = true : null"
  x-on:close-modal.window="$event.detail == '{{ $id }}' ? show = false : null"
  x-on:close.stop="show = false"
  x-on:keydown.escape.window="show = false"
  x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
  x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
  x-show="show"
  id="{{ $id }}"
  class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
  style="display: none;">
  <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
  </div>

  <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidthClass }} sm:mx-auto"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

    @if($title)
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">
          {{ $title }}
        </h3>

        @if($closeable)
        <button type="button"
          class="bg-white rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
          x-on:click="show = false">
          <span class="sr-only">Close</span>
          <x-icons.x-mark class="h-6 w-6" />
        </button>
        @endif
      </div>
    </div>
    @endif

    <div class="{{ $title ? 'px-4 pb-4 sm:p-6 sm:pt-0' : 'p-6' }}">
      {{ $slot }}
    </div>

    @if($footer)
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      {{ $footer }}
    </div>
    @endif
  </div>
</div>