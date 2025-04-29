@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<x-ui.section>
    <x-ui.section-header
        title="Dashboard"
        icon="fa-solid fa-chart-line"
    />
    {{-- Indicator    --}}
    <div class="w-full flex gap-6 justify-end">

    </div>
</x-ui.section>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        Dashboard.init();
    </script>
@endsection
