<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> Guimepa - @yield('title')</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Select2   -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Alpine JS -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Configurações vite   -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Injetado Estilos de paginas de maneira global -->
    @yield('styles')
</head>
<body class="bg-gray-100 font-sans">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <x-dashboard.sidebar version="v0.0.1" :menuItems="[
        [
            'label' => 'Dashboard',
            'icon' => 'fas fa-home',
            'route' => route('dashboard'),
            'active' => 'dashboard'
        ],
        [
            'label' => 'Configurações',
            'icon' => 'fas fa-cog',
            'key' => 'sales',
            'active' => 'sales',
            'submenu' => [
                [
                    'label' => 'Comercial',
                    'key' => 'orders',
                    'submenu' => [
                        [
                            'label' => 'Marketplaces',
                            'route' => route('marketplaces.index'),
                            'active' => 'orders'
                        ]
                    ]
                ],

            ]
        ]
    ]
    "  />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <x-dashboard.topbar />

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/sidebar.js') }}" type="text/javascript"></script>
{{--Modal--}}
<x-ui.modal />

@yield('scripts')
<script>
    $(document).ready(function() {
        // Toggle sidebar on mobile
        $('#sidebarToggle').click(function() {
            $('#sidebar').toggleClass('-translate-x-full');
        });

        // Toggle user dropdown menu
        $('#userMenuButton').click(function() {
            $('#userMenu').toggleClass('hidden');
        });

        // Close dropdown when clicking outside
        $(document).click(function(event) {
            if (!$(event.target).closest('#userMenuButton, #userMenu').length) {
                $('#userMenu').addClass('hidden');
            }
        });
        $('.modal-close').on('click', function (e){
            e.preventDefault();
            e.stopImmediatePropagation();

            $('.modal-main').fadeOut()
        })
    });
</script>
</body>
</html>
