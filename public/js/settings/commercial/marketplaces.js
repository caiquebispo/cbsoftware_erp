let Marketplaces = (function (){
    return{
        init: function (){
            new DataTable('#example');
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

                    $("#custoSac").mask("#.##0.00", {reverse: true})
                    $("#comissao").mask("#.##0.00", {reverse: true})

                    $('.form-create-new-rule').on('submit', function (e){

                        e.preventDefault()
                        e.stopImmediatePropagation();

                        Marketplaces.store_new_rule(this)
                    });
                },
                error: function (error){
                    console.error('Error:', error);
                }
            })
        },
        store_new_rule(form)
        {
            let formData = new FormData(form);

            $.ajax({
                url: `${window.location.origin}/panel/settings/commercial/marketplaces/storeModalCreateNewRule`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Swal.fire({
                        title: "Sucesso!",
                        text: 'Regra cadastrada com sucesso',
                        icon: "success",
                    })

                    setTimeout(function (){
                        $('#modal-main').fadeOut();
                        Swal.close()

                    },2500)
                },
                error: function (error) {

                    if (error.status == 422) {
                        Utils.validate(error.responseJSON.errors);
                        return;
                    }
                    Swal.fire({
                        title: "Erro!",
                        text: error.responseJSON.message,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK!"
                    })
                }
            });
        },
    }
})()
