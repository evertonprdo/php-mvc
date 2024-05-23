$(document).ready(function () {
    $("#busca").keyup(function() {
        var busca = $(this).val();
        if (busca !== "") {
            $.ajax({
                url: $('form').attr('data-url-busca'),
                method: 'POST',
                data: {
                    busca: busca
                },
                success: function (data) {
                    $('#buscaResultado').html(data);
                }
            });
            $('#buscaResultado').css('display', 'initial');
        } else {
            $('#buscaResultado').css('display', 'none');
        }
    })
})