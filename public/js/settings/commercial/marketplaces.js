let Marketplaces = (function (){
    return{
        init: function (){

            Marketplaces.event_listeners()
        },
        event_listeners: function (){

            $('#btn-create-new-rule').on('click', function (e){
                e.preventDefault();
                e.stopImmediatePropagation();

                Marketplaces.open_modal_create_new_rule();
            })
        },
        open_modal_create_new_rule()
        {
            $.ajax({
                url: `${window.location.origin}/panel/settings/commercial/marketplaces/openModalCreateNewRule`,
                method: 'GET',
                success: function (data){
                    $('#modal-main').fadeIn();
                    $('.modal-title').text('Cadastrar nova regra');
                    $('.modal-body').html(data.view);
                },
                error: function (error){
                    console.log('error: '.data)
                }
            })

        }
    }
})()
