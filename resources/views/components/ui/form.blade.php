@props([
'action' => null,
'method' => 'POST',
'enctype' => null,
'novalidate' => false
])

<form
  @if($action) action="{{ $action }}" @endif
  method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
  @if($enctype) enctype="{{ $enctype }}" @endif
  @if($novalidate) novalidate @endif
  {{ $attributes->merge(['class' => 'space-y-6']) }}>
  @if(strtoupper($method) !== 'GET' && strtoupper($method) !== 'POST')
  @method($method)
  @endif

  @if(strtoupper($method) !== 'GET')
  @csrf
  @endif

  {{ $slot }}
</form>