@props([
    'item' => null,
    'level' => 0
])

@php
    if (!$item) return;

    $hasChildren = isset($item['submenu']) && count($item['submenu']) > 0;
    $isActive = isset($item['active']) && request()->segment($level + 1) === $item['active'];
    $menuKey = $item['key'] ?? strtolower(str_replace(' ', '-', $item['label']));
@endphp

<li>
    @if($hasChildren)
        <!-- Item com submenu -->
        <button
            @click="$store.sidebar.toggleMenu('{{ $menuKey }}')"
            class="flex items-center justify-between w-full px-4 py-3 text-indigo-200 dark:text-indigo-300 hover:bg-indigo-700 hover:text-white dark:hover:bg-indigo-800 dark:hover:text-white rounded-lg transition duration-200"
            :class="{ 'bg-indigo-900 text-white dark:bg-indigo-800 dark:text-gray-100': $store.sidebar.isMenuOpen('{{ $menuKey }}') || {{ $isActive ? 'true' : 'false' }} }"
            data-menu-active="{{ $isActive ? $menuKey : '' }}"
        >
            <div class="flex items-center space-x-2">
                @if($item['icon'] ?? false)
                    <i class="{{ $item['icon'] }}"></i>
                @endif
                <span>{{ $item['label'] }}</span>
            </div>
            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
               :class="{ 'transform rotate-180': $store.sidebar.isMenuOpen('{{ $menuKey }}') }"></i>
        </button>

        <!-- Submenu -->
        <ul
            x-show="$store.sidebar.isMenuOpen('{{ $menuKey }}')"
            x-collapse
            class="ml-{{ $level * 2 + 4 }} mt-1 space-y-1"
        >
            @foreach($item['submenu'] as $childItem)
                <x-dashboard.sidebar-item
                    :item="$childItem"
                    :level="$level + 1"
                />
            @endforeach
        </ul>
    @else
        <!-- Item simples -->
        <a
            href="{{ $item['route'] ?? '#' }}"
            class="flex items-center space-x-2 px-4 py-3 text-indigo-200 dark:text-indigo-300 hover:bg-indigo-700 hover:text-white dark:hover:bg-indigo-800 dark:hover:text-white rounded-lg transition duration-200"
            :class="{ 'bg-indigo-900 text-white dark:bg-indigo-800 dark:text-gray-100': {{ $isActive ? 'true' : 'false' }} }"
        >
            @if($item['icon'] ?? false)
                <i class="{{ $item['icon'] }}"></i>
            @endif
            <span>{{ $item['label'] }}</span>
        </a>
    @endif
</li>
