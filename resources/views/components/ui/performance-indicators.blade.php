@props([
    'title',
    'value',
    'icon' => 'fa-dollar-sign',
    'iconColor' => 'blue',
    'borderColor' => 'blue',
    'change' => null,
    'comparison' => null,
    'positive' => true,
])

@php
    $iconBgColor = $iconColor . '-100';
    $iconTextColor = $iconColor . '-500';
    $borderClass = 'border-l-4 border-' . $borderColor . '-500';
    $arrowIcon = $positive ? 'fa-arrow-up' : 'fa-arrow-down';
    $changeColor = $positive ? 'text-green-500' : 'text-red-500';
@endphp

<div class="bg-white rounded-lg shadow-md p-6 {{ $borderClass }}">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-gray-500 font-medium">{{ $title }}</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $value }}</h2>
        </div>
        <div class="bg-{{ $iconBgColor }} p-2 rounded-full">
            <i class="fas {{ $icon }} text-{{ $iconTextColor }}"></i>
        </div>
    </div>

    @if($change)
        <div class="mt-4 flex items-center">
            <span class="{{ $changeColor }} flex items-center">
                <i class="fas {{ $arrowIcon }} mr-1"></i> {{ $change }}
            </span>
            @if($comparison)
                <span class="text-gray-500 text-sm ml-2">vs {{ $comparison }}</span>
            @endif
        </div>
    @endif
</div>
