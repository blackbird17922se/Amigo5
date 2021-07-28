$(document).ready(function(){

 

    $(document).bind("contextmenu",function(e){
        $('#menu').css({'display':'block', 'left': e.pageX, 'top': e.pageY});
        return false;
    })

    // $(document).click(function(e){
    //     if(e.button == 0){
    //         console.log("fuera");
    //         $('#contextMenu').hide('fast');


    //     }
    // })

    $('#tabla_products tbody').mousedown(function (e) { 
        if(e.button == 2){
            console.log("click der");
            $("#contextMenu").css("top", e.pageY -20);
            $("#contextMenu").css("left", e.pageX -20);
            $("#contextMenu").show("fast");



        }
        
    });


var TimeFn=null;
    /* ------------------------ */
    
    $('#tabla_products tbody').on( 'dblclick', 'tr', function () {
        clearTimeout(TimeFn);

        console.log("doble");
 
    })

    $('#tabla_products tbody').on( 'click', 'tr', function () {
        clearTimeout(TimeFn);
        
        let datos ="";
        /* Obtener los datos de la fila seleccionada */
        datos = datatable.row(this).data();

        TimeFn = setTimeout(function(){

    
            let id= datos.placa;
            console.log("hooo " + id);
            // datatable.row('.selected').remove().draw( false );
            // if ( $(this).hasClass('selected') ) {
            //     $(this).removeClass('selected');
            // }
            // else {
            //     datatable.$('tr.selected').removeClass('selected');
            //     $(this).addClass('selected');
            // }


        },300)

    })


    /* --------------------- */






















    $('#contextMenu').click(function(e){
        switch(e.target.id){
            case "eliminar":


                let datos = datatable.row($(this).parents()).data();
                let id= datos.placa;
                let nom= datos.nombre;
                var funcion = "borrar";
                /* Alerta */
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success m-1',
                      cancelButton: 'btn btn-danger m-1'
                    },
                    buttonsStyling: false
                })
                 
                swalWithBootstrapButtons.fire({
                    title: '¿Está seguro que desea eliminar el producto '+nom+'?',
                    text: "Esta acción ya no se podrá deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        console.log(id);
                        $.post('../controllers/productoController.php',{id,funcion},(response)=>{
                            datatable;
                            if(response=='borrado'){
        
                                swalWithBootstrapButtons.fire(
                                    'Eliminado '+nom+'!',
                                    'El producto ha sido eliminado.',
                                    'success'
                                )
                                datatable.ajax.reload();
                              
                            }else{
                                swalWithBootstrapButtons.fire(
                                    'Error al eliminar '+nom,
                                    'El producto está siendo usado en un lote o venta.',
                                    'error'
                                )
                                datatable.ajax.reload();
                            }
                        })
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                    }
                });




            break
        }
    })



    $('#contextMenu').mouseleave(function(){
        $('#contextMenu').hide('fast');


    })

    function eliminarMenu(){
        $('#contextMenu').hide('fast');
    }

    var funcion;
    var funcionVeh;

    $('.select2').select2();
    $('.select2-mult').select2();
    // obt();

    funcion = "cargarOrdenes";
    let datatable = $('#tabla_products').DataTable( {

        "scrollX": true,


        ajax: "data.json",
        
        "ajax": {
            
            "url":"../controllers/ordenController.php",
            "method":"POST",
            "data":{funcion:funcion},
            "dataSrc":""
        },
        "columns": [

            { "defaultContent": `

                <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crearproduct">
                    <i class="fa fa-pencil"></i>
                </button>

                <button class="lote btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#crearlote">
                    <i class="fa fa-plus-square"></i>
                </button>

                <button class="borrar btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i>
                </button>

            `},


            { "data": "placa" },
            { "data": "conduct" },
            { "data": "encargado" },
            { "data": "tipo_serv" },
            { "data": "obscliente" },
            { "data": "dgmec" },
            { "data": "proced" },
            { "data": "repuest" },
            { "data": "obsad" }
        ],
        language: espanol,
    });

    funcionVeh = "cargarVehiculos"
    let dtVehiculos = $('#tabla_veh').DataTable({

        "scrollX": true,

        ajax: "data.json",

        "ajax": {
            
            "url":"../controllers/vehiController.php",
            "method":"POST",
            "data":{funcion:funcionVeh},
            "dataSrc":""
        },

        "columns": [

            { "defaultContent": `

                <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crearproduct">
                    <i class="fa fa-pencil"></i>
                </button>

                <button class="lote btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#crearlote">
                    <i class="fa fa-plus-square"></i>
                </button>

                <button class="borrar btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i>
                </button>

            `},

            { "data": "placa" },
            { "data": "marca" },
            { "data": "refer" },
            { "data": "modelo" },
            { "data": "color" },
            { "data": "tipo_veh" },
            { "data": "cliente" },
            { "data": "num_contac" },
            { "data": "email" }
                 
        ],
        language: espanol,
    });


    listarMecanicos();
    function listarMecanicos(){
        funcion = "listarMecanicos";
        
        $.post('../controllers/mecanicoController.php',{funcion},(response)=>{
            // console.log(response);
            const MECANICS = JSON.parse(response);
            let template = '';
            MECANICS.forEach(mecanic=>{
                template+=`
                    <option value="${mecanic.id_mec}">${mecanic.nom_mec}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('#encargado').html(template);
            // $('#encargado2').html(template);
        })
    }

    listarServicios();
    function listarServicios(){
        funcion = "listarServicios";
        
        $.post('../controllers/servicioController.php',{funcion},(response)=>{
            // console.log("serv: " + response);
            const SERVICIOS = JSON.parse(response);
            let template = '';
            SERVICIOS.forEach(servicio=>{
                template+=`
                    <option value="${servicio.id_serv}">${servicio.nom_serv}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('#qwe').html(template);
            // $('#encargado2').html(template);
        })
    }




    $(document).on('click','#op_n_orden', e =>{
        console.log("hj");

        Swal.fire({
            title: '¿Qué tipo de orden desea crear?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Para un vehículo nuevo`,
            denyButtonText: `Para un vehículo existente.`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // $('#mod_n_orden').modal();    // Desplegar Modal Nuevo vehiculo
                $('#mod_n_veh').modal();    // Desplegar Modal Nuevo vehiculo

                $('#form_crear_veh').submit(e =>{

                    let cliente = $('#cliente').val();
                    let telef = $('#telef').val();
                    let email = $('#email').val();
                    let placa = $('#placa').val();
                    let marca = $('#marca').val();
                    let refer = $('#refer').val();
                    let modelo = $('#modelo').val();
                    let tipo = $('#tipo').val();
                    let color = $('#color').val();

                    let placaReg ="";
                    
                    funcion = "crearvehiculo";
            
                    $.post("../controllers/vehiController.php",
                    {funcion, cliente, email, placa, marca, telef, refer, modelo, tipo, color},
                    (response) => {
                        console.log(response);
                        if(response=="add"){

                            placaReg =  $('#placa').val();
                            dtVehiculos.ajax.reload();

                            $('#form_crear_veh').trigger('reset');
                            
                            /* Adicional a esto, cuenta con una regla css en longhorn.css
                            para evitar que cuando se abruiera el nuevo modal, la bara
                            lateral desapareciera
                             */
                            $('#mod_n_veh').modal('toggle')       // Ocultar modadl vehiculo
                            $('#mod_n_veh').hide()        // Ocultar modadl vehiculo

                            $('#mod_n_orden').modal();    // Desplegar Modal Nuevo orden

                            asignarOrden(placaReg);

                        }
                        if(response=="noadd"){
            
                            $('#alert_add_mec').hide();
                            $('#alert_noadd_mec').hide('slow');
                            $('#alert_noadd_mec').show(1000);
                        }
                    });
            
                    e.preventDefault();
                });

            } else if (result.isDenied) {
              Swal.fire('Changes are not saved', '', 'info')
            }
          })
    })


    function asignarOrden(placaReg){

        const PLACAREG = placaReg;

        $('#placaReg').val(PLACAREG);

        $('#form_crear_orden').submit(e=>{

            // Obtener los valores de los checkbox de servicios
            // var checkbxServ= $('input[type="checkbox"]:checked');
            // var valChecks = "";
            // if(checkbxServ.length > 0){
            //     checkbxServ.each(function(){
            //         valChecks += $(this).val() + "-"
            //     })
            // }

            $('select.select2-mult').val()
            let placa = $('#placaReg').val();
            let conduct   = $('#conduct').val();
            let encargado   = $('#encargado').val();
            // let tipo_serv = valChecks;
            let tipo_serv = $('select.select2-mult').val();
            let obscliente   = $('#obscliente').val();
            let dgmec   = $('#dgmec').val();
            let proced   = $('#proced').val();
            let repuest   = $('#repuest').val();
            let obsad   = $('#obsad').val();

            console.log("tipos" + tipo_serv);

            funcion = "asignarOrden"

            $.post('../controllers/ordenController.php',
            {funcion,placa,conduct,encargado,tipo_serv,obscliente,dgmec,proced,repuest,obsad},
            (response2)=>{
                console.log(response2);
                if(response2=='add orden'){

                    datatable.ajax.reload();

                    $('#alert_add_ord').hide('slow');
                    $('#alert_noadd_ord').hide();
                    $('#alert_add_ord').show(1000);
                    $('#form_crear_orden').trigger('reset');
                }else{
                    datatable.ajax.reload();
                    $('#alert_noadd_ord').hide();
                    $('#alert_add_ord').hide();
                    $('#alert_noadd_ord').show(1000);
                    $('#form_crear_orden').trigger('reset');
                }
                
            })
            e.preventDefault();
        });
    }



    $('#tabla_products tbody').on('click','.borrar',function(){
        let datos = datatable.row($(this).parents()).data();
        let id= datos.id_prod;
        let nom= datos.nombre;
        var funcion = "borrar";
        /* Alerta */
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success m-1',
              cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
        })
         
        swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar el producto '+nom+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                console.log(id);
                $.post('../controllers/productoController.php',{id,funcion},(response)=>{
                    datatable;
                    if(response=='borrado'){

                        swalWithBootstrapButtons.fire(
                            'Eliminado '+nom+'!',
                            'El producto ha sido eliminado.',
                            'success'
                        )
                        datatable.ajax.reload();
                      
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+nom,
                            'El producto está siendo usado en un lote o venta.',
                            'error'
                        )
                        datatable.ajax.reload();
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            }
        });
    });

})


/* DATATABLE A ESPAÑOL */
let espanol = {
    "aria": {
        "sortAscending": "Activar para ordenar la columna de manera ascendente",
        "sortDescending": "Activar para ordenar la columna de manera descendente"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Rellene todas las celdas con <i>%d&lt;\\\/i&gt;<\/i>",
        "fillHorizontal": "Rellenar celdas horizontalmente",
        "fillVertical": "Rellenar celdas verticalmentemente"
    },
    "buttons": {
        "collection": "Colección",
        "colvis": "Visibilidad",
        "colvisRestore": "Restaurar visibilidad",
        "copy": "Copiar",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %d fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "1": "Mostrar 1 fila",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir"
    },
    "decimal": ",",
    "emptyTable": "No se encontraron resultados",
    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "infoThousands": ",",
    "lengthMenu": "Mostrar _MENU_ registros",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "processing": "Procesando...",
    "search": "Buscar:",
    "searchBuilder": {
        "add": "Añadir condición",
        "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condición",
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total}",
        "emptyPanes": "Sin paneles de búsqueda",
        "loadMessage": "Cargando paneles de búsqueda",
        "title": "Filtros Activos - %d"
    },
    "select": {
        "1": "%d fila seleccionada",
        "_": "%d filas seleccionadas",
        "cells": {
            "1": "1 celda seleccionada",
            "_": "$d celdas seleccionadas"
        },
        "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
        }
    },
    "thousands": ",",
    "zeroRecords": "No se encontraron resultados",
    "datetime": {
        "previous": "Anterior",
        "next": "Proximo",
        "hours": "Horas",
        "minutes": "Minutos",
        "seconds": "Segundos",
        "unknown": "-",
        "amPm": [
            "am",
            "pm"
        ]
    },
    "editor": {
        "close": "Cerrar",
        "create": {
            "button": "Nuevo",
            "title": "Crear Nuevo Registro",
            "submit": "Crear"
        },
        "edit": {
            "button": "Editar",
            "title": "Editar Registro",
            "submit": "Actualizar"
        },
        "remove": {
            "button": "Eliminar",
            "title": "Eliminar Registro",
            "submit": "Eliminar",
            "confirm": {
                "_": "¿Está seguro que desea eliminar %d filas?",
                "1": "¿Está seguro que desea eliminar 1 fila?"
            }
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\\\\\/a&gt;).&lt;\\\/a&gt;<\/a>"
        },
        "multi": {
            "title": "Múltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
        }
    }
} 