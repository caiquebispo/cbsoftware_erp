@props([
    'type' => 'button',
    'text' => 'Button',
    'icon' => null,
    'iconPosition' => 'left', // 'left', 'right', or 'none'
    'color' => 'blue', // Tailwind colors: slate, gray, zinc, neutral, stone, red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose
    'variant' => 'solid', // 'solid', 'outline', 'gradient'
    'gradientDirection' => 'r', // 'r', 'l', 't', 'b', 'tr', 'br', 'tl', 'bl'
    'size' => 'md', // 'xs', 'sm', 'md', 'lg', 'xl'
    'rounded' => 'lg', // 'none', 'sm', 'md', 'lg', 'xl', '2xl', '3xl', 'full'
    'shadow' => 'sm', // 'none', 'sm', 'md', 'lg', 'xl', '2xl'
    'disabled' => false,
    'loading' => false,
])

@php
    // Size classes
    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];

    // Color classes for each variant
    $colorClasses = [
        'solid' => [
            'bg' => "bg-{$color}-600",
            'text' => 'text-white',
            'hover' => "hover:bg-{$color}-700",
            'focus' => "focus:ring-{$color}-500",
            'disabled' => "bg-{$color}-300",
        ],
        'outline' => [
            'bg' => 'bg-transparent',
            'text' => "text-{$color}-600",
            'border' => "border border-{$color}-600",
            'hover' => "hover:bg-{$color}-50",
            'focus' => "focus:ring-{$color}-500",
            'disabled' => "text-{$color}-300 border-{$color}-300",
        ],
        'gradient' => [
            'bg' => "bg-gradient-to-{$gradientDirection} from-{$color}-500 to-{$color}-600",
            'text' => 'text-white',
            'hover' => "hover:from-{$color}-600 hover:to-{$color}-700",
            'focus' => "focus:ring-{$color}-500",
            'disabled' => "bg-{$color}-300",
        ],
    ];

    // Get classes based on variant
    $variantClasses = $colorClasses[$variant];

    // Base classes
    $baseClasses = 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200';

    // Build all classes
    $buttonClasses = implode(' ', [
        $baseClasses,
        $sizes[$size],
        "rounded-{$rounded}",
        $shadow !== 'none' ? "shadow-{$shadow}" : '',
        $variantClasses['bg'],
        $variantClasses['text'],
        $variant === 'outline' ? $variantClasses['border'] : 'border border-transparent',
        $disabled ? $variantClasses['disabled'] : $variantClasses['hover'],
        $variantClasses['focus'],
    ]);

    // Icon classes
    $iconClasses = [
        'left' => 'mr-2',
        'right' => 'ml-2',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $buttonClasses]) }}
    @if($disabled) disabled @endif
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" x-show="loading">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif

    @if($icon && $iconPosition === 'left' && !$loading)
        <i class="{{ $icon }} {{ $iconClasses[$iconPosition] }}"></i>
    @endif

    {{ $text }}

    @if($icon && $iconPosition === 'right')
        <i class="{{ $icon }} {{ $iconClasses[$iconPosition] }}"></i>
    @endif
</button>
