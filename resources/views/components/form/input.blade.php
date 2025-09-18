@props([
  'label' => null,
  'name',
  'type' => 'text',
  'required' => false,
  'help' => null,
])
@php
  $base = 'w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary';
@endphp
<div {{ $attributes->class(['space-y-1']) }}>
  @if($label)
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-black dark:text-white">{{ $label }} @if($required)<span class="text-red-500">*</span>@endif</label>
  @endif
  <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" {{ $required ? 'required' : '' }} value="{{ old($name, $slot) }}" class="{{ $base }}" />
  @error($name)
    <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
  @if($help)
    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $help }}</p>
  @endif
</div>
