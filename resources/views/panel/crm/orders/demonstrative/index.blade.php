@extends('layouts.app')

@section('title', 'Demonstrativo Margem de IPV')

@section('content')
    <x-ui.section>
        <x-slot:header>
            <x-ui.section-header title="Filtros" icon="fa-solid fa-filter" />
        </x-slot:header>

        <div class="flex flex-col md:flex-row gap-5">
            <x-ui.input type="text" name="orders_id" placeholder="315879" icon="fa-solid fa-magnifying-glass" label="Pedido" class="w-full px-2" />
            <x-ui.input type="text" name="periods" icon="fa-solid fa-calendar-days" label="Data de Emissão" class="w-full" />
        </div>
        <div class="flex justify-end">
            <x-ui.button class="mt-4 btn-search" text="Pesquisar" icon="fa-solid fa-filter" color="green" />
        </div>
    </x-ui.section>

    <x-ui.section class="my-6">
        <x-slot:header>
            <x-ui.section-header title="Indicadores de Performance" icon="fa-solid fa-chart-line" />
        </x-slot:header>

       <div class="content-indicators"></div>

    </x-ui.section>

    <x-ui.section collapsed="true">
        <x-slot:header>
            <x-ui.section-header title="Gráfico" icon="fa-solid fa-chart-bar" />
        </x-slot:header>
    </x-ui.section>

    <x-ui.section class="my-6" collapsed="true">
        <x-slot:header>
            <x-ui.section-header title="Tabela" icon="fa-solid fa-table" />
        </x-slot:header>
    </x-ui.section>
@endsection

@section('scripts')
    <script src="{{ asset('js/crm/orders/demonstrative.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        Demonstrative.init();
    </script>
@endsection
