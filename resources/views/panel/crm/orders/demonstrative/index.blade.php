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
            <x-ui.select :options="[
                ['value' => 'year', 'label' => 'Ano anterior'],
                ['value' => 'months', 'label' => 'Mês anterior'],
                ]"
             name="select-comparision" label="Tipo de Comparitvo" icon="fa-solid fa-calendar-days" class="w-full" id="select_comparision" optionValue="value" optionLabel="label" selected="year"/>
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

    <x-ui.section>
        <x-slot:header>
            <x-ui.section-header title="Gráfico" icon="fa-solid fa-chart-bar" />
        </x-slot:header>
        <div class="flex items-center flex-col md:flex-row gap-5" hidden="">
            <x-ui.select :options="[
                ['value' => 'total_sales', 'label' => 'Venda'],
                ['value' => 'cost_total', 'label' => 'Custo'],
                ['value' => 'profit', 'label' => 'Lucro'],
                ['value' => 'margin', 'label' => 'Margem'],
                ['value' => 'ipv', 'label' => 'IPV'],
            ]" name="indicator_1" label="Indicador 1" icon="fa-solid fa" class="w-full" id="indicator_1" optionValue="value" optionLabel="label" selected="total_sales"/>

            <x-ui.select :options="[
                ['value' => 'total_sales_last', 'label' => 'Venda'],
                ['value' => 'cost_total_last', 'label' => 'Custo'],
                ['value' => 'profit_last', 'label' => 'Lucro'],
                ['value' => 'margin_last', 'label' => 'Margem'],
                ['value' => 'ipv_last', 'label' => 'IPV'],
            ]" name="indicator_2" label="Indicador 2" icon="fa-solid fa" class="w-full" id="indicator_2" optionValue="value" optionLabel="label" selected="total_sales_last"/>

            <x-ui.checkbox name="actualPeriod" id="actualPeriod" label="Periodo Atual?" :checked="true" containerClass="flex items-center bg-white"/>
        </div>
        <div id="charts-container" style="display: flex; flex-wrap: wrap; justify-content: space-around;" class="my-6">
            <div id="profitChart"></div>
            <div id="marginChart"></div>
            <div id="ipvChart"></div>
        </div>
        <div class="content-chart" style="height: 450px"></div>
    </x-ui.section>

    <x-ui.section class="my-6">
        <x-slot:header>
            <x-ui.section-header title="Tabela" icon="fa-solid fa-table" />
        </x-slot:header>
        <div class="flex items-center flex-col md:flex-row gap-5">
            <x-ui.select :options="[
                ['value' => 'true', 'label' => 'Sim'],
                ['value' => 'false', 'label' => 'Não'],
            ]" name="is_grouped_data" label="Ver dados Agrupado?" icon="fa-solid fa" class="w-full" id="is_grouped_data" optionValue="value" optionLabel="label" selected="false"/>

        </div>
        <div id="content-table" class="my-6"></div>

    </x-ui.section>
@endsection

@section('scripts')
    <script src="{{ asset('js/crm/orders/demonstrative.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        Demonstrative.init();
    </script>
@endsection
