@props([
    'title',
    'description' => null,
    'icon' => null,
    'iconColor' => 'text-indigo-600 dark:text-indigo-400',
    'iconBg' => 'bg-indigo-100 dark:bg-indigo-900/50'
])

<div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-6 transition-colors duration-300">
    <div class="flex items-center">
        @if($icon)
            <span class="{{ $iconBg }} {{ $iconColor }} mr-4 p-3 rounded-lg transition-colors duration-300">
                <i class="{{ $icon }} text-xl"></i>
            </span>
        @endif
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                {{ $title }}
            </h3>
            @if($description)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>
</div>
