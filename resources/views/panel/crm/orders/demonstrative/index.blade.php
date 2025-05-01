@extends('layouts.app')

@section('title', 'Demonstrativo Margem de IPV')

@section('content')
    <x-ui.section collapsed="true">
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

    <x-ui.section collapsed="true" class="my-6">
        <x-slot:header>
            <x-ui.section-header title="Indicadores de Performance" icon="fa-solid fa-chart-line" />
        </x-slot:header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 my-4">
            <x-ui.performance-indicators
                title="Receita Total"
                value="R$ 0.00"
                icon="fa-dollar-sign"
                icon-color="blue"
                border-color="blue"
                change="0.00%"
                comparison="R$ 0.00 (mês anterior)"
                :positive="true"
            />
            <x-ui.performance-indicators
                title="Custo Total"
                value="R$ 0.00"
                icon="fa-dollar-sign"
                icon-color="red"
                border-color="red"
                change="0.00%"
                comparison="R$ 0.00 (mês anterior)"
                :positive="true"
            />
            <x-ui.performance-indicators
                title="Margem"
                value="0.00%"
                icon="fa-percent"
                icon-color="blue"
                border-color="blue"
                change="0.00%"
                comparison="0.00% (mês anterior)"
                :positive="false"
            />
            <x-ui.performance-indicators
                title="IPV"
                value="0.00%"
                icon="fa-percent"
                icon-color="green"
                border-color="green"
                change="0.00%"
                comparison="0.00% (mês anterior)"
                :positive="true"
            />

        </div>
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
