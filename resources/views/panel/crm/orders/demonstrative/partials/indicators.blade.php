<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 my-5">

    <x-ui.performance-indicators
        title="Venda Total"
        :value="$indicators['total_sales']"
        icon="fa-dollar-sign"
        icon-color="blue"
        border-color="blue"
        :change="$indicators['variation_sales']"
        :comparison="$indicators['total_sales_last']"
        type="currency"
        :positive="$indicators['variation_sales_is_negative']"
    />

    <x-ui.performance-indicators
        title="Custo Total"
        :value="$indicators['cost_total']"
        icon="fa-dollar-sign"
        icon-color="red"
        border-color="red"
        :change="$indicators['variation_cost']"
        :comparison="$indicators['cost_total_last']"
        :positive="abs(!$indicators['variation_cost_is_negative'])"
    />
    <x-ui.performance-indicators
        title="Lucro Total"
        :value="$indicators['profit']"
        icon="fa-dollar-sign"
        icon-color="blue"
        border-color="blue"
        :change="$indicators['variation_profit']"
        :comparison="$indicators['profit_last']"
        type="currency"
        :positive="$indicators['variation_profit_is_negative']"
    />
    <x-ui.performance-indicators
        title="Margem"
        :value="$indicators['margin']"
        icon="fa-percent"
        icon-color="blue"
        border-color="blue"
        type="percent"
        :change="$indicators['variation_margin']"
        :comparison="$indicators['margin_last']"
        :positive="$indicators['variation_margin_is_negative']"
    />
    <x-ui.performance-indicators
        title="IPV"
        :value="$indicators['ipv']"
        icon="fa-percent"
        icon-color="green"
        border-color="green"
        :change="$indicators['variation_ipv']"
        type="percent"
        :comparison="$indicators['ipv_last']"
        :positive="$indicators['variation_ipv_is_negative']"
    />

</div>
