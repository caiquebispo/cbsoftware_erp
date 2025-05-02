let Demonstrative = (function () {
    return {
        init: function () {

            Demonstrative.event_listeners()

        },
        event_listeners: function () {
            let start = moment();
            let end = moment().add(1, 'months');

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
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });

            $('.btn-search').on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();


                Utils.loading(true);

            })
        }
    }
})()
