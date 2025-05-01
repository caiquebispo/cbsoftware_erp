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
    // Cores para modo claro
    $iconBgColor = $iconColor . '-100';
    $iconTextColor = $iconColor . '-500';
    $borderClass = 'border-l-4 border-' . $borderColor . '-500';
    $arrowIcon = $positive ? 'fa-arrow-up' : 'fa-arrow-down';
    $changeColor = $positive ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400';

    // Cores para modo escuro
    $darkIconBgColor = $iconColor . '-900';
    $darkIconTextColor = $iconColor . '-300';
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-900/30 p-6 {{ $borderClass }} dark:border-{{ $borderColor }}-400 transition-colors duration-300">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">{{ $title }}</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $value }}</h2>
        </div>
        <div class="bg-{{ $iconBgColor }} dark:bg-{{ $darkIconBgColor }} p-2 rounded-full transition-colors duration-300">
            <i class="fas {{ $icon }} text-{{ $iconTextColor }} dark:text-{{ $darkIconTextColor }}"></i>
        </div>
    </div>

    @if($change)
        <div class="mt-4 flex items-center">
            <span class="{{ $changeColor }} flex items-center">
                <i class="fas {{ $arrowIcon }} mr-1"></i> {{ $change }}
            </span>
            @if($comparison)
                <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">vs {{ $comparison }}</span>
            @endif
        </div>
    @endif
</div>
