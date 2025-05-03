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
                    $('.content-chart').html('');
                    Demonstrative.makeChart(data['data']);
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
        makeChart: function (data){

            const key = data[0].day ? "day" : "month";

            const categories = data.map(item => item[key]);
            const currentSales = data.map(item => item.total_sales);
            const lastSales = data.map(item => item.total_sales_last);

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
                        name: "Vendas Atuais",
                        type: "column",
                        data: currentSales
                    },
                    {
                        name: "Vendas Anteriores",
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
                    text: `Comparativo de Vendas (${key === "day" ? "Diário" : "Mensal"})`,
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
