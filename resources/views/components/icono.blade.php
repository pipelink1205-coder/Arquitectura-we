@props(['nombre'])
@php
    $wa = 'M16.04 3C9.06 3 3.4 8.63 3.4 15.57c0 2.22.59 4.39 1.7 6.3L3.3 28.7l7.02-1.83a12.7 12.7 0 0 0 5.72 1.38c6.97 0 12.65-5.63 12.65-12.57C28.69 8.63 23.01 3 16.04 3zm5.76 15.16c-.32-.16-1.87-.92-2.16-1.02-.29-.11-.5-.16-.71.16-.21.31-.82 1.02-1 1.23-.18.21-.37.24-.68.08-.32-.16-1.33-.49-2.54-1.56-.94-.83-1.57-1.86-1.76-2.18-.18-.31-.02-.48.14-.64.14-.14.32-.37.47-.55.16-.18.21-.31.32-.52.11-.21.05-.39-.03-.55-.08-.16-.71-1.7-.97-2.33-.26-.61-.52-.53-.71-.54h-.61c-.21 0-.55.08-.84.39-.29.31-1.1 1.07-1.1 2.62s1.13 3.04 1.29 3.25c.16.21 2.22 3.37 5.37 4.73 3.15 1.36 3.15.9 3.72.85.57-.05 1.87-.76 2.13-1.5.26-.73.26-1.36.18-1.5-.08-.13-.29-.21-.6-.37z';
@endphp
@switch($nombre)
    @case('telefono')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg>
        @break
    @case('whatsapp')
        <svg {{ $attributes }} viewBox="0 0 32 32" fill="currentColor" aria-hidden="true"><path d="{{ $wa }}"/></svg>
        @break
    @case('whatsapp-fab')
        <svg {{ $attributes }} viewBox="0 0 32 32" aria-hidden="true"><path d="M16.04 3C9.06 3 3.4 8.63 3.4 15.57c0 2.22.59 4.39 1.7 6.3L3.3 28.7l7.02-1.83a12.7 12.7 0 0 0 5.72 1.38h.01c6.97 0 12.64-5.63 12.64-12.57C28.69 8.63 23.01 3 16.04 3zm0 22.98h-.01c-1.89 0-3.74-.5-5.36-1.46l-.38-.23-4.17 1.08 1.11-4.04-.25-.41a10.36 10.36 0 0 1-1.6-5.55c0-5.76 4.71-10.45 10.5-10.45 2.8 0 5.44 1.09 7.42 3.07a10.36 10.36 0 0 1 3.07 7.39c0 5.76-4.71 10.6-10.33 10.6zm5.76-7.82c-.32-.16-1.87-.92-2.16-1.02-.29-.11-.5-.16-.71.16-.21.31-.82 1.02-1 1.23-.18.21-.37.24-.68.08-.32-.16-1.33-.49-2.54-1.56-.94-.83-1.57-1.86-1.76-2.18-.18-.31-.02-.48.14-.64.14-.14.32-.37.47-.55.16-.18.21-.31.32-.52.11-.21.05-.39-.03-.55-.08-.16-.71-1.7-.97-2.33-.26-.61-.52-.53-.71-.54h-.61c-.21 0-.55.08-.84.39-.29.31-1.1 1.07-1.1 2.62s1.13 3.04 1.29 3.25c.16.21 2.22 3.37 5.37 4.73.75.32 1.34.52 1.8.66.75.24 1.44.2 1.98.12.6-.09 1.87-.76 2.13-1.5.26-.73.26-1.36.18-1.5-.08-.13-.29-.21-.6-.37z"/></svg>
        @break
    @case('arriba')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
        @break
    @case('anterior')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
        @break
    @case('siguiente')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
        @break
    @case('cerrar')
        <svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
        @break
@endswitch
