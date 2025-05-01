<header class="bg-white dark:bg-gray-800 shadow-sm" x-data="{ userMenuOpen: false }">
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">

        <!-- Mobile menu button -->
        <button id="sidebarToggle" class="md:hidden text-gray-500 dark:text-gray-400 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Search bar (centralizado no desktop) -->
        <div class="flex-1 mx-4 max-w-md hidden sm:block">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                </div>
                <input
                    type="text"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                    placeholder="Pesquisar..."
                >
            </div>
        </div>

        <!-- Right-side user controls -->
        <div class="flex items-center space-x-4">
            <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                <i class="fas fa-bell text-xl"></i>
            </button>
            <x-ui.toggle-dark-mode  />
            <!-- User Menu -->
            <div class="relative" @click.away="userMenuOpen = false">
                <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-2 focus:outline-none">
                    <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold">
                        N
                    </div>
                    <span class="hidden md:block text-gray-700 dark:text-gray-200">Nome</span>
                    <i class="fas fa-chevron-down hidden md:block text-gray-700 dark:text-gray-200"></i>
                </button>

                <!-- Dropdown -->
                <div
                    x-show="userMenuOpen"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-50"
                    style="display: none;"
                >
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Meu Perfil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Configurações</a>
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile search bar -->
    <div class="px-4 pb-3 sm:hidden">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
            </div>
            <input
                type="text"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                placeholder="Pesquisar..."
            >
        </div>
    </div>
</header>
