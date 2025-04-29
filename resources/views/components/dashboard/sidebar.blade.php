@props([
    'logo' => true,
    'menuItems' => [],
    'version' => '1.0.0', // Nova prop para versão
    'showVersion' => true // Controle para exibir/ocultar
])

<div
    class="sidebar bg-indigo-800 text-white w-64 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out flex flex-col h-full"
    id="sidebar"
    x-data="{
        openMenus: [],
        toggleMenu(menuKey) {
            if (this.openMenus.includes(menuKey)) {
                this.openMenus = this.openMenus.filter(key => key !== menuKey);
            } else {
                this.openMenus.push(menuKey);
            }
        },
        isMenuOpen(menuKey) {
            return this.openMenus.includes(menuKey);
        }
    }"
    x-init="
        document.querySelectorAll('[data-menu-active]').forEach(el => {
            const menuKeys = el.dataset.menuActive.split(',');
            menuKeys.forEach(key => {
                if (key && !this.openMenus.includes(key)) {
                    this.openMenus.push(key);
                }
            });
        })
    "
>
    <!-- Conteúdo principal com rolagem -->
    <div class="flex-1 overflow-y-auto space-y-6">
        @if($logo)
            <div class="flex items-center space-x-2 px-4">
                <i class="fas fa-rocket text-2xl text-indigo-300"></i>
                <span class="text-xl font-bold">Guimepa App</span>
            </div>
        @endif

        <nav>
            <ul class="space-y-2">
                @foreach($menuItems as $menuItem)
                    <x-dashboard.sidebar-item
                        :item="$menuItem"
                        :level="0"
                    />
                @endforeach
            </ul>
        </nav>
    </div>

    <!-- Rodapé fixo ao fundo -->
    @if($showVersion)
        <div class="px-4 py-3 border-t border-indigo-700 bg-indigo-900 text-xs text-indigo-300">
            <div class="flex justify-between items-center">
                <span>Versão: {{ $version }}</span>
                <span class="text-indigo-400">{{ date('Y') }}</span>
            </div>
        </div>
    @endif
</div>
