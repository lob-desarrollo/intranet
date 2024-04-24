var perfil = (function (window, undefined) {
    var init = function() {
        $('.maskMovil').mask('00.0000.0000');

        $('[data-clave="cambiar"]').on('click', function(e) {
            e.preventDefault();
            principal.pantallaOn();
            var continuar = true;
            var mensaje = 'Ingresa nueva contraseña.';
            
            $('.inputerror').removeClass('inputerror');
            $('#password [required="true"]').each(function() {
                if($(this).attr('required') != undefined && $(this).prop('disabled') == false) {
                    if(!principal.validar($(this).val(), $(this).attr('data-tipo'))) {
                        continuar = false;
                        $(this).addClass('inputerror');    
                        if($(this).hasClass('select2')) {
                            $(this).parent().find('.select2').find('.select2-selection--multiple').addClass('inputerror');
                        }
                    }
                }
            });
            
            if($('#clave').val().length < 8) {
                continuar = false;
                mensaje = 'La contraseña debe ser más larga';
                $('#clave').addClass('inputerror');
            }

            if(continuar) {
                $.ajax({ type     : 'POST',
                         url      : '/perfil/request/setclave',
                         data     : { clave     : $('#clave').val(),
                                      _token : $('[name="_token"]').val() },
                         dataType : 'json',
                         success  : function(data) {
                                        principal.pantallaOff();
                                        principal.alerta(data);
                                        $('.inputerror').removeClass('inputerror');
                                        $('#password')[0].reset();
                                    },
                         error    : function(data) {
                                        principal.pantallaOff();
                                        principal.alerta('Error', 'Experimentamos problemas en el servicio.', 'error');
                                    }
                    });
            } else {
                principal.pantallaOff();
                principal.alerta('Atención', mensaje, 'warning');
            }
        });
    };

    return {
        init : function() {
            init();
        }
    };

})(window, undefined);