{{-- resources/views/components/input-icon-group.blade.php --}}

@props([
    'id' => 'custoSac',
    'name' => 'custoSac',
    'type' => 'text',
    'label' => 'Custo Sac',
    'icon' => '',
    'iconPosition' => 'left', // 'left', 'right', 'left-inside', 'right-inside', or 'none'
    'placeholder' => '0,00',
    'min' => '0.00',
    'suffix' => '',
    'prefix' => null,
    'containerClass' => 'space-y-2',
    'labelContainerClass' => 'flex items-center',
    'labelTextClass' => 'block text-sm font-medium text-gray-700',
    'iconClass' => 'text-gray-500',
    'inputGroupClass' => 'relative rounded-md shadow-sm',
    'inputClass' => 'block w-full py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
    'suffixClass' => 'absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 sm:text-sm',
    'prefixClass' => 'absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500 sm:text-sm',
    'iconLeftClass' => 'mr-2',
    'iconRightClass' => 'ml-2',
    'iconInsideClass' => 'absolute inset-y-0 flex items-center pointer-events-none text-gray-500',
    'iconInsideLeftClass' => 'left-0 pl-3',
    'iconInsideRightClass' => 'right-0 pr-3',
])

<div class="{{ $containerClass }}">
    @if($label)
        <label for="{{ $id }}" class="{{ $labelContainerClass }}">
            @if($icon && in_array($iconPosition, ['left', 'right']))
                @if($iconPosition === 'left')
                    <i class="{{ $icon }} {{ $iconClass }} {{ $iconLeftClass }}"></i>
                @endif

                <span class="{{ $labelTextClass }}">{{ $label }}</span>

                @if($iconPosition === 'right')
                    <i class="{{ $icon }} {{ $iconClass }} {{ $iconRightClass }}"></i>
                @endif
            @else
                <span class="{{ $labelTextClass }}">{{ $label }}</span>
            @endif
        </label>
    @endif

    <div class="{{ $inputGroupClass }}">
        @if($prefix)
            <div class="{{ $prefixClass }}">
                <span>{{ $prefix }}</span>
            </div>
        @endif

        @if($icon && $iconPosition === 'left-inside')
            <div class="{{ $iconInsideClass }} {{ $iconInsideLeftClass }}">
                <i class="{{ $icon }} {{ $iconClass }}"></i>
            </div>
        @endif

        @php
            $inputPadding = 'px-2';
            if ($prefix) $inputPadding .= ' pl-7';
            if ($prefix) $inputPadding .= ' pr-3';
            if ($suffix) $inputPadding .= ' pr-7';
            if ($suffix) $inputPadding .= ' pl-3';
            if ($icon && $iconPosition === 'left-inside') $inputPadding .= ' pl-10';
            if ($icon && $iconPosition === 'right-inside') $inputPadding .= ' pr-10';
        @endphp

        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @if($min && $type === 'number') min="{{ $min }}" @endif
            class="{{ $inputClass }} {{ $inputPadding }}"
            {{ $attributes }}
        >

        @if($icon && $iconPosition === 'right-inside')
            <div class="{{ $iconInsideClass }} {{ $iconInsideRightClass }}">
                <i class="{{ $icon }} {{ $iconClass }}"></i>
            </div>
        @endif

        @if($suffix)
            <div class="{{ $suffixClass }}">
                <span>{{ $suffix }}</span>
            </div>
        @endif
    </div>
</div>
