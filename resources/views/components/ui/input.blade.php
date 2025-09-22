@props([
'label' => null,
'name' => null,
'type' => 'text',
'required' => false,
'error' => null,
'help' => null,
'placeholder' => null
])

<div {{ $attributes->except(['class'])->merge(['class' => 'form-spacing']) }}>
  @if($label)
  <label for="{{ $name }}" class="form-label">
    {{ $label }}
    @if($required)
    <span class="text-red-500">*</span>
    @endif
  </label>
  @endif

  <input
    type="{{ $type }}"
    @if($name) name="{{ $name }}" id="{{ $name }}" @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    @if($required) required @endif
    {{ $attributes->only(['value', 'class'])->merge(['class' => 'form-input' . ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '')]) }} />

  @if($error)
  <p class="form-error">{{ $error }}</p>
  @endif

  @if($help && !$error)
  <p class="form-help">{{ $help }}</p>
  @endif
</div>