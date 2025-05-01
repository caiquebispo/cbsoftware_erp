@props([
    'id' => 'multiplicarQt',
    'name' => 'multiplicarQt',
    'label' => 'Multiplicar Pela Quantidade de Itens',
    'icon' => '',
    'checked' => false,
    'containerClass' => 'flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/70',
    'inputClass' => 'h-5 w-5 text-blue-600 dark:text-blue-500 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded cursor-pointer transition-colors duration-200',
    'labelClass' => 'ml-3 flex items-center cursor-pointer',
    'iconClass' => 'mr-2 text-gray-600 dark:text-gray-400',
    'textClass' => 'block text-sm font-medium text-gray-700 dark:text-gray-300'
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
