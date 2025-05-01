@props([
    'padding' => 'p-6',
    'border' => false,
    'shadow' => true,
    'rounded' => 'rounded-lg',
    'background' => 'bg-white dark:bg-gray-800',
    'containerClass' => '',
    'collapsed' => false
])

<div
    x-data="{ open: {{ $collapsed ? 'false' : 'true' }} }"
    {{ $attributes->merge(['class' => implode(' ', [
        $background,
        $padding,
        $rounded,
        $border ? 'border border-gray-200 dark:border-gray-700' : '',
        $shadow ? 'shadow dark:shadow-lg dark:shadow-gray-900/20' : '',
        $containerClass,
        'transition-colors duration-300'
    ])]) }}
>
    {{-- Slot para o header --}}
    <div class="flex justify-between items-start mb-4">
        <div class="flex-1 text-gray-800 dark:text-gray-200">
            {{ $header ?? '' }}
        </div>

        {{-- Toggle button --}}
        <button
            @click="open = !open"
            class="ml-4 text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition-colors"
            title="Exibir/ocultar conteúdo"
            aria-label="Toggle content"
        >
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 15l7-7 7 7" />
            </svg>
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    {{-- Slot do conteúdo (body) --}}
    <div x-show="open" x-transition x-collapse class="text-gray-700 dark:text-gray-300">
        {{ $slot }}
    </div>
</div>
