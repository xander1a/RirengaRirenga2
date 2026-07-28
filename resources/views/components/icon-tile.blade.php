@props(['icon' => 'leaf', 'bg' => '#3F7C8A20', 'color' => '#1E3A4A'])

<div {{ $attributes->merge(['class' => 'w-full h-full flex items-center justify-center icon-tile']) }}
     style="background:{{ $bg }}; color:{{ $color }};">
    <svg class="relative z-10 w-1/3 h-1/3" viewBox="0 0 24 24" fill="none" stroke="{{ $color }}" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        @switch($icon)
            @case('leaf')
                <path d="M5 21c8-1 13-6 14-14-8 1-13 6-14 14Z"/>
                <path d="M5 21c0-5 2-9 6-11"/>
                @break
            @case('bird')
                <path d="M3 14c4 1 6-1 7-4 2 3 6 4 9 1-1 3-4 5-7 5-3 4-7 5-12 4 2-1 3-3 3-6Z"/>
                <circle cx="15" cy="7" r="1" fill="{{ $color }}" stroke="none"/>
                @break
            @case('mountain')
                <path d="M3 18 9 7l4 6 2-3 6 8H3Z"/>
                <circle cx="17" cy="6" r="2"/>
                @break
            @case('sprout')
                <path d="M12 21v-9"/>
                <path d="M12 12c0-4-3-6-7-6 0 4 3 6 7 6Z"/>
                <path d="M12 9c0-3 2-5 6-5 0 3-2 5-6 5Z"/>
                @break
            @case('dish')
                <circle cx="12" cy="12" r="8"/>
                <circle cx="12" cy="12" r="3"/>
                @break
            @case('wine')
                <path d="M8 3h8l-1 7a3 3 0 0 1-6 0L8 3Z"/>
                <path d="M12 13v6"/>
                <path d="M9 21h6"/>
                @break
            @case('cocktail')
                <path d="M5 4h14l-7 8-7-8Z"/>
                <path d="M12 12v9"/>
                <path d="M8 21h8"/>
                @break
            @case('music')
                <circle cx="6" cy="18" r="2.5"/>
                <circle cx="17" cy="16" r="2.5"/>
                <path d="M8.5 18V6l11-2v12"/>
                @break
            @case('newspaper')
                <rect x="3" y="5" width="14" height="14" rx="1"/>
                <path d="M17 9h4v8a2 2 0 0 1-2 2h-2"/>
                <path d="M7 9h6M7 12h6M7 15h4"/>
                @break
            @case('bed')
                <path d="M3 18v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/>
                <path d="M3 18v2M21 18v2"/>
                <path d="M3 13h18"/>
                <circle cx="7" cy="10" r="1.5"/>
                @break
            @case('sun')
                <circle cx="12" cy="13" r="3.5"/>
                <path d="M12 4v2M12 20h.01M4 13h1.5M18.5 13H20M6.3 7.3l1 1M16.7 7.3l-1 1"/>
                <path d="M3 20h18"/>
                @break
            @default
                <path d="M5 21c8-1 13-6 14-14-8 1-13 6-14 14Z"/>
        @endswitch
    </svg>
</div>
