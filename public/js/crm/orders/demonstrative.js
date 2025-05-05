let Demonstrative = (function () {
    return {
        init: function () {
            Demonstrative.event_listeners()
        },
        event_listeners: function () {

            let start = moment().startOf('month');
            let end = moment().endOf('month');
            let comparasion = $("#select_comparision option:selected").val();
            let isGrouped = false;

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

            $("#select_comparision").on('change', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                comparasion = $(this).find("option:selected").val();
            })
            $('#is_grouped_data').on('change', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Demonstrative.getDataTable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'), $(this).find("option:selected").val());
            })
            $('.btn-search').on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Demonstrative.getDataIndicators(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'), comparasion);
                Demonstrative.getDataChart(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'), comparasion);
                Demonstrative.getDataTable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),isGrouped);

            })

            Demonstrative.getDataIndicators(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),comparasion);
            Demonstrative.getDataChart(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),comparasion);
            Demonstrative.getDataTable(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),isGrouped);
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
                success: function (response){
                    var data = response.data
                    Utils.loading(false);

                    let indicator_1 = $("#indicator_1 option:selected").val();
                    let indicator_2 = $("#indicator_2 option:selected").val();

                    $("#indicator_1").on('change', function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();

                        indicator_1 = $(this).find("option:selected").val();
                        Demonstrative.makeChart(data, comparasion, indicator_1, indicator_2);
                    })
                    $("#indicator_2").on('change', function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();

                        indicator_2 = $(this).find("option:selected").val();
                        Demonstrative.makeChart(data, comparasion, indicator_1, indicator_2);
                    })
                    const groupedData = Demonstrative.groupDataByMonth(data);
                    Demonstrative.createPieCharts(groupedData);
                    Demonstrative.makeChart(data, comparasion, indicator_1, indicator_2);
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
        getDataTable: function(start, end, isGrouped = false) {

            Utils.loading(true);

            $.ajax({
                url: `${window.location.origin}/panel/crm/orders/demonstrative/getDataTable`,
                method: 'GET',
                data: { start, end, isGrouped },
                success: function(response) {
                    Utils.loading(false);

                    if(isGrouped == 'true'){
                        Demonstrative.makeTableGrouped(response);
                    }else{
                        Demonstrative.makeTableBasic(response);
                    }

                },
                error: function(error) {
                    Utils.loading(false);
                    console.error('Error:', error);
                    // Tratamento de erro para o usuário
                    alert('Ocorreu um erro ao carregar os dados. Por favor, tente novamente.');
                }
            });
        },
        groupDataByMonth: function(data) {
            return {
                current: {
                    profit: data.reduce((sum, item) => sum + item.profit, 0),
                    margin: (data.reduce((sum, item) => sum + item.profit, 0) / data.reduce((sum, item) => sum + item.total_sales, 0)) * 100,
                    ipv: data.reduce((sum, item) => sum + item.ipv, 0) / data.length // Média do IPV
                },
                last: {
                    profit: data.reduce((sum, item) => sum + item.profit_last, 0),
                    margin: (data.reduce((sum, item) => sum + item.profit_last, 0) / data.reduce((sum, item) => sum + item.total_sales_last, 0)) * 100,
                    ipv: data.reduce((sum, item) => sum + item.ipv_last, 0) / data.length // Média do IPV anterior
                }
            };
        },
        createPieCharts: function(grouped) {

            const commonOptions = {
                chart: { type: 'pie', height: 300 },
                colors: ['#FF4560', '#008FFB'],
                legend: { position: 'bottom' },
                responsive: [{
                    breakpoint: 768,
                    options: { chart: { height: 250 } }
                }]
            };

            new ApexCharts(document.querySelector("#profitChart"), {
                ...commonOptions,
                series: [grouped.current.profit, grouped.last.profit],
                labels: ['Mês Atual', 'Mês Anterior'],
                title: { text: 'Comparativo de Lucro', align: 'center' },
                tooltip: { y: { formatter: (val) => `R$ ${val.toLocaleString()}` } }
            }).render();

            new ApexCharts(document.querySelector("#marginChart"), {
                ...commonOptions,
                series: [grouped.current.margin, grouped.last.margin],
                labels: ['Mês Atual', 'Mês Anterior'],
                title: { text: 'Comparativo de Margem (%)', align: 'center' },
                dataLabels: { formatter: (val) => `${val.toFixed(2)}%` }
            }).render();

            new ApexCharts(document.querySelector("#ipvChart"), {
                ...commonOptions,
                series: [grouped.current.ipv, grouped.last.ipv],
                labels: ['Mês Atual', 'Mês Anterior'],
                title: { text: 'Comparativo de IPV', align: 'center' },
                tooltip: { y: { formatter: (val) => val.toFixed(3) } }
            }).render();
    },
        makeChart: function (data, comparasion, indicator_1 = "total_sales", indicator_2 = "total_sales_last"){

            // console.log('Data:', data);

            $('.content-chart').html('<div class="chart"></div>');

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

            var chart = new ApexCharts(document.querySelector(".chart"), options);

            chart.render();


        },
        makeTableGrouped:function (response) {

            $('#content-table').html('<table id="mainTable" class="display" style="width:100%"></table>')
            const formatValue = (value, type) => {
                if (value === null || value === undefined) return '-';
                if (type === 'currency') return `R$ ${value.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, '$1.')}`;
                if (type === 'percentage') return `${value.toFixed(2)}%`;
                return value.toFixed(3);
            };

            const mainTable = $("#mainTable").DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
                },
                data: response.data,
                columns: [
                    {
                        className: 'details-control cursor-pointer',
                        orderable: false,
                        data: null,
                        defaultContent: '<span>+</span>',
                        width: '60px'
                    },
                    { title: 'Data Emissão', data: 'data_emissao' },
                    {
                        title: 'Total Vendas',
                        data: 'total_sales',
                        render: data => formatValue(data, 'currency')
                    },
                    {
                        title: 'Custo Total',
                        data: 'cost_total',
                        render: data => formatValue(data, 'currency')
                    },
                    {
                        title: 'Lucro',
                        data: 'profit',
                        render: data => formatValue(data, 'currency')
                    },
                    {
                        title: 'Margem (%)',
                        data: 'margin',
                        render: data => formatValue(data, 'percentage')
                    },
                    {
                        title: 'IPV',
                        data: 'ipv',
                        render: data => formatValue(data)
                    }
                ]
            });
            $('#mainTable tbody').on('click', 'td.details-control', function() {
                const tr = $(this).closest('tr');
                const row = mainTable.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).html('<span>+</span>');

                } else {
                    console.log('Row data:', row.data());
                    const rowData = row.data();

                    if (!rowData.resume || typeof rowData.resume !== 'object') {

                        row.child('<div class="subtable-container p-6">Nenhum dado disponível</div>').show();
                        tr.addClass('shown');
                        $(this).html('<span>-</span>');
                        return;
                    }

                    // Prepara os dados com fallbacks seguros
                    const subtableData = Object.values(rowData.resume).map(item => ({
                        total_sales: item.total_sales || 0,
                        cost_total: item.cost_total || 0,
                        profit: item.profit || 0,
                        margin: item.margin || 0,
                        ipv: item.hasOwnProperty('ipv') ? item.ipv : 0 // Fallback explícito para ipv
                    })).filter(fn => fn.total_sales !== 0 || fn.cost_total !== 0 || fn.profit !== 0 || fn.margin !== 0 || fn.ipv !== 0);

                    const subtableContainer = $('<div class="subtable-container p-6"/>');

                    // Inicializa a subtabela
                    const initSubTable = () => {
                        subtableContainer.find('table').DataTable({
                            data: subtableData,
                            columns: [
                                {
                                    title: 'Total Vendas',
                                    data: 'total_sales',
                                    render: data => formatValue(data, 'currency')
                                },
                                {
                                    title: 'Custo Total',
                                    data: 'cost_total',
                                    render: data => formatValue(data, 'currency')
                                },
                                {
                                    title: 'Lucro',
                                    data: 'profit',
                                    render: data => formatValue(data, 'currency')
                                },
                                {
                                    title: 'Margem (%)',
                                    data: 'margin',
                                    render: data => formatValue(data, 'percentage')
                                },
                                {
                                    title: 'IPV',
                                    data: 'ipv',
                                    render: data => formatValue(data)
                                }
                            ],
                            searching: true,
                            paging: true,
                            info: false
                        });
                    };

                    subtableContainer.append('<table class="subtable"><tbody></tbody></table>');
                    row.child(subtableContainer).show();
                    initSubTable();

                    tr.addClass('shown');
                    $(this).html('<span>-</span>');
                }
            });
        },
        makeTableBasic: function (response) {

            $('#content-table').html('<table id="mainTable" class="display" style="width:100%"></table>')
            const formatValue = (value, type) => {
                if (value === null || value === undefined) return '-';
                if (type === 'currency') return `R$ ${value.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, '$1.')}`;
                if (type === 'percentage') return `${value.toFixed(2)}%`;
                return value.toFixed(3);
            };

            $("#mainTable").DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
                },
                data: response.data,
                columns: [
                    { title: 'Data Emissão', data: 'data_emissao' },
                    {
                        title: 'Total Vendas',
                        data: 'total_sales',
                        render: data => formatValue(data, 'currency')
                    },
                    {
                        title: 'Custo Total',
                        data: 'cost_total',
                        render: data => formatValue(data, 'currency')
                    },
                    {
                        title: 'Lucro',
                        data: 'profit',
                        render: data => formatValue(data, 'currency')
                    },
                    {
                        title: 'Margem (%)',
                        data: 'margin',
                        render: data => formatValue(data, 'percentage')
                    },
                    {
                        title: 'IPV',
                        data: 'ipv',
                        render: data => formatValue(data)
                    }
                ]
            });
        }
    }
})()
