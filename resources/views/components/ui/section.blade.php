@props([
    'padding' => 'p-6',
    'border' => false,
    'shadow' => true,
    'rounded' => 'rounded-lg',
    'background' => 'bg-white',
    'containerClass' => '',
    'collapsed' => false
])

<div
    x-data="{ open: {{ $collapsed ? 'false' : 'true' }} }"
    {{ $attributes->merge(['class' => implode(' ', [
        $background,
        $padding,
        $rounded,
        $border ? 'border border-gray-200' : '',
        $shadow ? 'shadow' : '',
        $containerClass
    ])]) }}
>
    {{-- Slot para o header --}}
    <div class="flex justify-between items-start mb-4">
        <div class="flex-1">
            {{ $header ?? '' }}
        </div>

        {{-- Toggle button (caso tenha conteúdo no body) --}}
        <button
            @click="open = !open"
            class="ml-4 text-gray-500 hover:text-gray-800 transition"
            title="Exibir/ocultar conteúdo"
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
    <div x-show="open" x-transition x-collapse>
        {{ $slot }}
    </div>
</div>
