var listas = (function (window, undefined) {
    var init = function(idtabla, urlLista, urlNuevo, urlEditar) {
        $('#btnNuevo').on('click', function(e) {
            e.preventDefault();
            location.href=urlNuevo;
        });

        var tabla = '#'+idtabla;
        $(tabla).DataTable({ processing   : true,
                             serverSide   : true,
                             stateSave    : true,
                             ajax         : { url    : urlLista,
                                              type   : 'POST',
                                              data   : { _token : $('[name="_token"]').val() }
                                            },
                             language     : { paginate     : { previous : '<i class="mdi mdi-arrow-left"></i>',
                                                               next     : '<i class="mdi mdi-arrow-right"></i>' },
                                                              search       : 'Buscar',
                                                              info         : 'Mostrando _START_-_END_/_TOTAL_',
                                                              infoEmpty    : 'Mostrando 0-0/0',
                                                              infoFiltered : '(_MAX_ Totales)',
                                                              lengthMenu   : 'Ver _MENU_ por página',
                                                              emptyTable   : 'No hay elementos en esta tabla',
                                                              zeroRecords  : 'No se encontraron registros',
                                                              processing   : 'Procesando ...',
                                                            },
                             lengthMenu   : [[20, 50, 100, 300], [20, 50, 100, 300]],
                             iDisplayLength: 20,
                             responsive : true,
                             order      : [[0, 'desc']],
                             ordering   : false,
                             columnDefs : [{ responsivePriority: 1, targets: 0 },
                                           { responsivePriority: 2, targets: 1 },
                                           { responsivePriority: 3, targets: -1 },
                                           /*{ orderable : false, targets: [-1] }*/
                                          ],
                             drawCallback : function() {
                                                 $('[href="editar"]').on('click', function(e) {
                                                     e.preventDefault();
                                                     var id = $(this).attr('data-id');
                                                     document.location.href = urlEditar+id+'/edit';
                                                 });

                                                 $('[href="eliminar"]').on('click', function(e) {
                                                     e.preventDefault();
                                                     var id = $(this).attr('data-id');
                                                     Swal.fire({
                                                       title: "Se eliminará el registro<br /> ¿Esta seguro?",
                                                       showDenyButton: true,
                                                       confirmButtonText: 'Eliminar',
                                                       denyButtonText: 'Cancelar',
                                                       confirmButtonColor: "#7bed9f",
                                                       denyButtonButtonColor: "#ff6b81",
                                                     }).then((result) => {
                                                       if (result.isConfirmed) {
                                                            $('#registro_id').val(id);
                                                            $('#formdelete').attr('action', urlEditar+id).submit();
                                                       }
                                                     });
                                                  });
                                            }
                           });
    };

    var formulario = function(urlCancelar) {
        $('button[data-accion="guardar"]').on('click', function(e) {
            e.preventDefault();
            pantallaOn();
            var continuar = true;
            
            $('.inputerror').removeClass('inputerror');
            $('#nuevo [required="true"]').each(function() {
                if($(this).attr('required') != undefined && $(this).prop('disabled') == false) {
                    if(!validar($(this).val(), $(this).attr('data-tipo'))) {
                        continuar = false;
                        $(this).addClass('inputerror');    
                        if($(this).hasClass('select2')) {
                            $(this).parent().find('.select2').find('.select2-selection--multiple').addClass('inputerror');
                        }
                    }
                }
            });

            if(editor.getData().length == 0) {
                continuar = false;
                $('.cke').addClass('inputerror');
            }

            if(continuar) {
                $('#nuevo').submit();
            } else {
                pantallaOff();
                alerta('Atención', 'Completa el formulario.', 'warning');
            }
        });

        $('button[data-accion="cancelar"]').on('click', function(e) {
            e.preventDefault();
            document.location.href = urlCancelar;
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
        init : function(idtabla, urlLista, urlNuevo, urlEditar) {
            init(idtabla, urlLista, urlNuevo, urlEditar);
        },
        formulario : function(urlCancelar) {
            formulario(urlCancelar);
        },
        alerta : function(data) {
            alerta(data.titulo, data.mensaje, data.tipo);
        },
        imagen : function(elemento) {
            imagen(elemento);
        }
    };

})(window, undefined);