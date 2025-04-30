@props([
    'id' => 'multiplicarQt',
    'name' => 'multiplicarQt',
    'label' => 'Multiplicar Pela Quantidade de Itens',
    'icon' => '',
    'checked' => false,
    'containerClass' => 'flex items-center p-4 bg-gray-50 rounded-lg',
    'inputClass' => 'h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer',
    'labelClass' => 'ml-3 flex items-center',
    'iconClass' => 'mr-2 text-gray-600',
    'textClass' => 'block text-sm font-medium text-gray-700'
])

<div class="{{ $containerClass }}">
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="checkbox"
        class="{{ $inputClass }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes }}
    >
    <label for="{{ $id }}" class="{{ $labelClass }}">
        @if($icon)
            <i class="{{ $icon }} {{ $iconClass }}"></i>
        @endif
        <span class="{{ $textClass }}">{{ $label }}</span>
    </label>
</div>
