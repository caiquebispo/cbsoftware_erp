@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, outline, ghost
    'size' => 'normal', // sm, normal, lg
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
    'loading' => false,
    'fullWidth' => false,
])

<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    @class([
        'inline-flex items-center justify-center rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200',
        'px-4 py-2 text-sm' => $size === 'sm',
        'px-6 py-3 text-base' => $size === 'lg',
        'px-5 py-2.5 text-sm' => $size === 'normal',
        'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500' => $variant === 'primary',
        'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500' => $variant === 'secondary',
        'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500' => $variant === 'danger',
        'bg-transparent text-indigo-600 border border-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500' => $variant === 'outline',
        'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-500' => $variant === 'ghost',
        'opacity-50 cursor-not-allowed' => $disabled || $loading,
        'w-full' => $fullWidth,
    ])
    {{ $attributes }}
>
    @if($icon && $iconPosition === 'left' && !$loading)
        <i class="{{ $icon }} mr-2"></i>
    @endif

    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right' && !$loading)
        <i class="{{ $icon }} ml-2"></i>
    @endif
</button>
