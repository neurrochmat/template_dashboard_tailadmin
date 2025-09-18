@props([
  'label' => null,
  'name',
  'value' => 1,
  'checked' => false,
])
@php
  $isChecked = old($name, $checked) ? true : false;
@endphp
<label class="flex items-center gap-2 text-sm font-medium text-black dark:text-white">
  <input type="checkbox" name="{{ $name }}" value="{{ $value }}" @checked($isChecked) class="h-4 w-4 rounded border-stroke text-primary focus:ring-primary/50 dark:border-form-strokedark dark:bg-form-input" />
  <span>{{ $label ?? $slot }}</span>
</label>
@error($name)
  <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
@enderror
