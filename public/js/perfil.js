var perfil = (function (window, undefined) {
    var init = function() {
        $('.menuEdicion li button').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                document.location.href=$(this).attr('data-accion');
            });
        });

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

    var formulario = function(urlCancelar) {
        $('button[data-accion="guardar"]').on('click', function(e) {
            e.preventDefault();
            principal.pantallaOn();
            var continuar = true;
            
            $('.inputerror').removeClass('inputerror');
            $('#upd [required="true"], #upd [required="required"]').each(function() {
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

            if(continuar) {
                $('#upd').submit();
            } else {
                principal.pantallaOff();
                principal.alerta('Atención', 'Completa el formulario.', 'warning');
            }
        });

        $('button[data-accion="cancelar"]').on('click', function(e) {
            e.preventDefault();
            document.location.href = urlCancelar;
        });
    };

    var imagen = function(elemento) {
        if (elemento.files && elemento.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#ejemplo').attr('src', e.target.result);
            };

            reader.readAsDataURL(elemento.files[0]);
        }
    };

    return {
        init : function() {
            init();
        },
        formulario : function(urlCancelar) {
            formulario(urlCancelar);
        },
        imagen : function(elemento) {
            imagen(elemento);
        }
    };

})(window, undefined);