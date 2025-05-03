let Demonstrative = (function () {
    return {
        init: function () {
            Demonstrative.event_listeners()
        },
        event_listeners: function () {

            let start = moment().startOf('month');
            let end = moment().endOf('month');
            let comparasion = $("#select_comparision option:selected").val();

            $('input[name="periods"]').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Dia Atual': [moment(), moment()],
                    'Dia Anterior': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                    'Mês Atual': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo Mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function(start_, end_, label) {
                start = start_
                end = end_
            });

            $('#select_comparision').on('change', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                comparasion = $(this).find("option:selected").val();
            })
            $('.btn-search').on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Demonstrative.getDataIndicators(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'), comparasion);
                Demonstrative.getDataChart(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'), comparasion);

            })

            Demonstrative.getDataIndicators(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),comparasion);
            Demonstrative.getDataChart(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),comparasion);
        },
        getDataIndicators: function (start, end,comparasion){

            Utils.loading(true);

            $.ajax({
                url: `${window.location.origin}/panel/crm/orders/demonstrative/getDataIndicators`,
                method: 'GET',
                data:{'start':start,'end':end, 'comparasion': comparasion},
                success: function (data){

                    Utils.loading(false)
                    $('.content-indicators').html(data['view']);
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
        getDataChart: function (start, end,comparasion){

            Utils.loading(true);

            $.ajax({
                url: `${window.location.origin}/panel/crm/orders/demonstrative/getDataChart`,
                method: 'GET',
                data:{'start':start,'end':end, 'comparasion': comparasion},
                success: function (data){

                    Utils.loading(false);

                    let indicator_1 = $("#indicator_1 option:selected").val();
                    let indicator_2 = $("#indicator_2 option:selected").val();

                    $("#indicator_1").on('change', function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();

                        indicator_1 = $(this).find("option:selected").val();
                        Demonstrative.makeChart(data['data'], comparasion, indicator_1, indicator_2);
                    })
                    $("#indicator_2").on('change', function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();

                        indicator_2 = $(this).find("option:selected").val();
                        Demonstrative.makeChart(data['data'], comparasion, indicator_1, indicator_2);
                    })

                    Demonstrative.makeChart(data['data'], comparasion, indicator_1, indicator_2);
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
        makeChart: function (data, comparasion, indicator_1 = "total_sales", indicator_2 = "total_sales_last"){

            $('.content-chart').html('');

            const key = data[0].day ? "day" : "month";

            const categories = data.map(item => item[key]);
            const currentSales = data.map(item => item[indicator_1]);
            const lastSales = data.map(item => item[indicator_2]);
            let tile_1 = "Vendas"
            switch (indicator_1) {
                case "total_sales":
                    tile_1 = "Vendas"
                    break;
                case "cost_total":
                    tile_1 = "Custo"
                    break;
                case "profit":
                    tile_1 = "Lucro"
                    break;
                case "margin":
                    tile_1 = "Margem"
                    break;
                case "ipv":
                    tile_1 = "IPV"
                    break;
            }
            let tile_2 = "Vendas"
            switch (indicator_2) {

                case "total_sales_last":
                    tile_2 = "Vendas"
                    break;
                case "cost_total_last":
                    tile_2 = "Custo"
                    break;
                case "profit_last":
                    tile_2 = "Lucro"
                    break;
                case "margin_last":
                    tile_2 = "Margem"
                    break;
                case "ipv_last":
                    tile_2 = "IPV"
                    break;
            }
            const options = {
                chart: {
                    height: 420,
                    type: 'line',
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: false
                    },
                    foreColor: '#333'
                },
                series: [
                    {
                        name: tile_1,
                        type: "column",
                        data: currentSales
                    },
                    {
                        name: tile_2,
                        type: "line",
                        data: lastSales
                    }
                ],
                stroke: {
                    width: [0, 3],
                    curve: 'smooth'
                },
                colors: ['#3b82f6', '#10b981'],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '40%'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        rotate: -45
                    },
                    title: {
                        text: key === "day" ? "Dias" : "Meses"
                    }
                },
                yaxis: {
                    title: {
                        text: "Total de Vendas"
                    },
                    labels: {
                        formatter: val => `R$ ${val.toLocaleString()}`
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: val => `R$ ${val.toLocaleString()}`
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                title: {
                    text: `Comparativo de Vendas (${key === "day" ? "Diário" : "Mensal"}) - (${comparasion === "year" ? "Ano Atual X Anterior" : "Mês Atual X Anterior"})`,
                    align: 'center',
                    style: {
                        fontSize: '18px',
                        fontWeight: 'bold',
                        color: '#111827'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector(".content-chart"), options);

            chart.render();


        }
    }
})()
