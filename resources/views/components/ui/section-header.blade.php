@props([
    'title',
    'description' => null,
    'icon' => null,
    'iconColor' => 'text-indigo-600',
    'iconBg' => 'bg-indigo-100'
])

<div class="border-b border-gray-200 pb-5 mb-6">
    <div class="flex items-center">
        @if($icon)
            <span class="{{ $iconBg }} {{ $iconColor }} mr-4 p-3 rounded-lg">
                <i class="{{ $icon }} text-xl"></i>
            </span>
        @endif
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ $title }}
            </h3>
            @if($description)
                <p class="mt-1 text-sm text-gray-500">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>
</div>
