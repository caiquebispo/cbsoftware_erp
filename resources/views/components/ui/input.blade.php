@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => '',
    'helpText' => '',
    'icon' => null,
    'iconPosition' => 'left',
    'wrapperClass' => '',
    'inputClass' => '',
    'labelClass' => '',
])

<div class="{{ $wrapperClass }} space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 {{ $labelClass }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-md shadow-sm">
        @if($icon && $iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            @class([
                'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                'pl-10' => $icon && $iconPosition === 'left',
                'pr-10' => $icon && $iconPosition === 'right',
                'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' => $error,
                'bg-gray-100 text-gray-500' => $disabled,
                $inputClass
            ])
            {{ $attributes }}
        >

        @if($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($helpText)
        <p class="mt-1 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>
