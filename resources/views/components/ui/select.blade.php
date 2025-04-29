@props([
    'name' => '',
    'label' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Selecione uma opção',
    'required' => false,
    'disabled' => false,
    'error' => '',
    'helpText' => '',
    'wrapperClass' => '',
    'selectClass' => '',
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

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        @class([
            'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
            'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' => $error,
            'bg-gray-100 text-gray-500' => $disabled,
            $selectClass
        ])
        {{ $attributes }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($helpText)
        <p class="mt-1 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>
