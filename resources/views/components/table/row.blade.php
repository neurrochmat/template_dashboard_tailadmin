@props([
  'as' => 'tr',
  'class' => ''
])
@php
  $tag = $as;
  $base = 'bg-white '.
          'dark:bg-boxdark '.
          'even:bg-gray-50 dark:even:bg-boxdark/60 '.
          'transition-colors '.
          'hover:bg-gray-100 dark:hover:bg-boxdark/80';
@endphp
<{{ $tag }} {{ $attributes->merge(['class' => $base.' '.$class]) }}>
  {!! $slot !!}
</{{ $tag }}>
