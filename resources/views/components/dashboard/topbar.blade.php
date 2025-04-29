<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Mobile menu button -->
        <button id="sidebarToggle" class="md:hidden text-gray-500 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Search Bar -->
        <div class="relative mx-4 flex-1 max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Pesquisar...">
        </div>

        <!-- User Menu -->
        <div class="flex items-center space-x-4">
            <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-bell text-xl"></i>
            </button>
            <div class="relative">
                <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                    <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold">
                        Name
                    </div>
                    <span class="hidden md:block">Name</span>
                    <i class="fas fa-chevron-down hidden md:block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Meu Perfil</a>
                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configurações</a>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
