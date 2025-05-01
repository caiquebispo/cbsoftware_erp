@props([
    'logo' => true,
    'menuItems' => [],
    'version' => '1.0.0',
    'showVersion' => true
])

<div
    x-data="{
        sidebarOpen: false,
        openMenus: [],
        toggleSidebar() { this.sidebarOpen = !this.sidebarOpen },
        toggleMenu(menuKey) {
            this.openMenus.includes(menuKey)
                ? this.openMenus = this.openMenus.filter(k => k !== menuKey)
                : this.openMenus.push(menuKey);
        },
        isMenuOpen(menuKey) {
            return this.openMenus.includes(menuKey);
        }
    }"
    @sidebar-toggle.window="sidebarOpen = !sidebarOpen"
    class="relative"
>
    <!-- Overlay para mobile -->
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
        @click="sidebarOpen = false"
        style="display: none;"
    ></div>

    <!-- Sidebar -->
    <div
        id="sidebar"
        class="z-40 w-64 bg-indigo-800 text-white transform transition-transform duration-300 ease-in-out flex flex-col h-full
           fixed inset-y-0 left-0 md:relative md:translate-x-0"
        :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    >
        <!-- Botão de fechar no mobile -->
        <div class="flex justify-end md:hidden px-4 pt-4">
            <button
                @click="sidebarOpen = false"
                class="text-white text-xl transition-transform"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Topo com logo -->
        <div class="py-4 px-4">
            @if($logo)
                <div class="flex items-center space-x-2">
                    <i class="fas fa-rocket text-2xl text-indigo-300"></i>
                    <span class="text-xl font-bold">Guimepa App</span>
                </div>
            @endif
        </div>

        <!-- Menu -->
        <div class="flex-1 overflow-y-auto px-2 space-y-4">
            <nav>
                <ul class="space-y-2">
                    @foreach($menuItems as $menuItem)
                        <x-dashboard.sidebar-item
                            :item="$menuItem"
                            :level="0"
                            x-bind="{}"
                        />
                    @endforeach
                </ul>
            </nav>
        </div>

        <!-- Rodapé com versão -->
        @if($showVersion)
            <div class="px-4 py-3 border-t border-indigo-700 bg-indigo-900 text-xs text-indigo-300">
                <div class="flex justify-between items-center">
                    <span>Versão: {{ $version }}</span>
                    <span class="text-indigo-400">{{ date('Y') }}</span>
                </div>
            </div>
        @endif
    </div>
</div>
