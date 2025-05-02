let Demonstrative = (function () {
    return {
        init: function () {
            Demonstrative.event_listeners()
        },
        event_listeners: function () {

            let start = moment().startOf('month');
            let end = moment().endOf('month');

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

            $('.btn-search').on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                Demonstrative.getDataIndicators(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
                Demonstrative.getDataChart(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));

            })

            Demonstrative.getDataIndicators(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
        },
        getDataIndicators: function (start, end){

            Utils.loading(true);

            $.ajax({
                url: `${window.location.origin}/panel/crm/orders/demonstrative/getDataIndicators`,
                method: 'GET',
                data:{'start':start,'end':end},
                success: function (data){

                    Utils.loading(false)
                    $('.content-indicators').html(data['view']);
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
        getDataChart: function (start, end){

            // Utils.loading(true);

            $.ajax({
                url: `${window.location.origin}/panel/crm/orders/demonstrative/getDataChart`,
                method: 'GET',
                data:{'start':start,'end':end},
                success: function (data){

                    // Utils.loading(false)
                    // $('.content-indicators').html(data['view']);
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
    }
})()
