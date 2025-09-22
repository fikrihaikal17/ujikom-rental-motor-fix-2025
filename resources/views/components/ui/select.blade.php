@props([
'label' => null,
'name' => null,
'required' => false,
'error' => null,
'help' => null,
'placeholder' => 'Pilih...',
'options' => []
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

  <select
    @if($name) name="{{ $name }}" id="{{ $name }}" @endif
    @if($required) required @endif
    {{ $attributes->only(['class'])->merge(['class' => 'form-select' . ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '')]) }}>
    @if($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif

    @if(is_array($options) && count($options))
    @foreach($options as $value => $text)
    <option value="{{ $value }}">{{ $text }}</option>
    @endforeach
    @else
    {{ $slot }}
    @endif
  </select>

  @if($error)
  <p class="form-error">{{ $error }}</p>
  @endif

  @if($help && !$error)
  <p class="form-help">{{ $help }}</p>
  @endif
</div>