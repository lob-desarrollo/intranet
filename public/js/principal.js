$(window).scroll(function() {
    if($(this).scrollTop() > 300){ 
        $('.botonSubir').slideDown(300);
    }else{
        $('.botonSubir').slideUp(300);
    }
});

var principal = (function (window, undefined) {
    var init = function() {
        $('#openMenu').on('click', function(e) {
            e.preventDefault();
            $('#inicio').addClass('slideout-open');
            $('.bloqueMenu').addClass('visible');
        });

        $('#closeMenu').on('click', function(e) {
            e.preventDefault();
            $('.bloqueMenu').removeClass('visible');
            $('#inicio').removeClass('slideout-open');
        });

        $('.dropDown').each(function() {
            $(this).find('a.opcmenu').on('click', function(e) {
                e.preventDefault();
            });

            $(this).on('mouseover', function() {
                $(this).find('ul.submenu').addClass('submenuVisible');
            }).on('mouseout', function() {
                $(this).find('ul.submenu').removeClass('submenuVisible');
            });
        });

        $('[href="dropDown"]').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                $('.enlaceActivo').removeClass('enlaceActivo');
                $('.subMenuLateralVisible').removeClass('subMenuLateralVisible');
                $(this).addClass('enlaceActivo');
                $(this).parent().find('.subMenuLateral').addClass('subMenuLateralVisible');
            });
        });
    };

    var avisos = function() {
        $('[data-aviso]').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-aviso');
                var titulo = $(this).attr('data-titulo');
                document.location.href='/aviso/'+id+'/'+titulo;
            });
        });

        $('[data-listaavisos]').on('click', function(e) {
            e.preventDefault();
            document.location.href=$(this).attr('data-listaavisos');
        });
    };

    var contenidos = function() {
        $('[data-contenido]').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-contenido');
                var titulo = $(this).attr('data-titulo');
                document.location.href='/contenido/'+id+'/'+titulo;
            });
        });

        $('[data-listacontenidos]').on('click', function(e) {
            e.preventDefault();
            document.location.href=$(this).attr('data-listacontenidos');
        });
    };

    var validar = function(valor, tipo) {
        var res = true;

        switch(tipo) {
            case 'crc':
                var re = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
                
                if(!re.exec(valor)){
                    res = false;
                } 
            break;

            case 'txt':
                if(valor.length == 0) {
                    res = false;
                }
            break;

            case 'mcero':
                if(valor.length == 0 || parseInt(valor) <= 0) {
                    res = false;
                }
            break;
        }

        return res;
    };

    var pantallaOn = function() {
        $('.pantalla').addClass('aparece');
    };

    var pantallaOff = function() {
        $('.pantalla').removeClass('aparece');
    };

    var alerta = function(titulo, mensaje, tipo) {
        Swal.fire({ icon              : tipo,
                    title             : titulo,
                    text              : mensaje,
                    showConfirmButton : false,
                    timer             : 2000,
                    timerProgressBar  : true, });
    };

    return {
        init : function() {
            init();
        },
        avisos : function() {
            avisos();
        },
        contenidos : function() {
            contenidos();
        },
        pantallaOn : function() {
            pantallaOn();
        },
        pantallaOff : function() {
            pantallaOff();
        },
        alerta : function(data, mensaje, tipo) {
            switch(typeof data) {
                case 'object':
                    alerta(data.titulo, data.mensaje, data.tipo);
                break;

                default:
                    alerta(data, mensaje, tipo);
                break;
            }
        },
        validar : function(valor, tipo) {
            return validar(valor, tipo);
        }
    };

})(window, undefined);