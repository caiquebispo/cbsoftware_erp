@extends('layouts.app')

@section('title', 'Marketplaces')

@section('content')
    <x-ui.section>
        <x-ui.section-header
            title="Demonstrativo Margem de IPV"
            description="Cadastro de critérios"
            icon="fa-solid fa-list-check"
        />
        {{-- Indicator    --}}
        <div class="w-full flex gap-6 justify-end">

            <x-ui.button variant="primary" iconPosition="right" id="btn-create-new-rule">
                Nova Regra
            </x-ui.button>
            <x-ui.button variant="primary" iconPosition="right" id="btn-search">
                Canais
            </x-ui.button>
            <x-ui.button variant="primary" iconPosition="right" id="btn-search">
                Custo Operacional
            </x-ui.button>
            <x-ui.button variant="primary" iconPosition="right" id="btn-search">
                Impostos
            </x-ui.button>

        </div>
    </x-ui.section>
@endsection
@section('scripts')
    <script src="{{ asset('js/settings/commercial/marketplaces.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        Marketplaces.init();
    </script>
@endsection
