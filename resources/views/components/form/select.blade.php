@props([
  'label' => null,
  'name',
  'required' => false,
  'options' => [], // [['value'=>'','label'=>'']]
  'placeholder' => null,
])
@php
  $base = 'w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 pr-10 text-black outline-none transition focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary';
  $value = old($name, $attributes->get('value'));
@endphp
<div {{ $attributes->class(['space-y-1']) }}>
  @if($label)
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-black dark:text-white">{{ $label }} @if($required)<span class="text-red-500">*</span>@endif</label>
  @endif
  <select id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }} class="{{ $base }}">
    @if($placeholder)
      <option value="">{{ $placeholder }}</option>
    @endif
    @foreach($options as $opt)
      <option value="{{ $opt['value'] }}" {{ (string)$value === (string)$opt['value'] ? 'selected' : '' }}>{{ $opt['label'] }}</option>
    @endforeach
    {{ $slot }}
  </select>
  @error($name)
    <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>
