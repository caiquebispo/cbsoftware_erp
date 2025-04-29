@props([
'title' => null,
'actions' => null,
'padding' => 'p-6',
'border' => false,
'shadow' => true,
'rounded' => 'rounded-lg',
'background' => 'bg-white',
'titleClass' => '',
'containerClass' => ''
])

<div {{ $attributes->merge(['class' => implode(' ', [
    $background,
    $padding,
    $rounded,
    $border ? 'border border-gray-200' : '',
    $shadow ? 'shadow' : '',
    $containerClass
    ])]) }}>
    @if($title || $actions)
    <div class="flex justify-between items-center mb-6">
        @if($title)
        <h2 class="{{ $titleClass }} text-lg font-bold text-gray-800">
            {{ $title }}
        </h2>
        @endif

        @if($actions)
        <div class="flex items-center space-x-2">
            {{ $actions }}
        </div>
        @endif
    </div>
    @endif

    <div class="{{ $slot->isEmpty() ? 'text-gray-500' : '' }}">
        {{ $slot }}
    </div>
</div>
