let Utils = (function (){

    function clearErrorOnInput() {
        $(document).on('input change', 'input, textarea, select', function () {
            $(this).removeClass('border-red-500');
            $(this).next('.error-message').remove();
        });
    }

    // Inicializar listeners uma única vez
    clearErrorOnInput();
    return{
        validate: function (errors){
            $('.error-message').remove();
            $('.border-red-500').removeClass('border-red-500');

            $.each(errors, function (field, messages) {
                const $input = $('[name="' + field + '"]');
                if ($input.length) {
                    $input.addClass('border-red-500');

                    const $errorDiv = $('<div class="text-sm text-red-600 mt-1 error-message"></div>')
                        .text(messages[0]);

                    $input.after($errorDiv);
                }
            });
        }
    }
})()
