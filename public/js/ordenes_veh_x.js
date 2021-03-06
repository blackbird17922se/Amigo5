/* Controla la funcionalidad de la vista dnde se muestra las ordenes
de un determinado vehiculo */

$(document).ready(function(){

    /* Recibe el id que contiene la placa, enviado por url por METODO GET */
    var matr = getParameterByName('id');

    /* Funcion para adquirir la url y el get */
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    var funcion;
    var funcionVeh;
    var TimeFn=null;
    var edit = false;   // bandera

    $('.select2').select2();
    $('.select2-mult').select2();

    funcion = "cargarOrdenesVehiculoX";


    let datatable = $('#tabla_ord_veh_x').DataTable( {

        "scrollX": true,
        "order": [[ 1, "desc" ]],



        ajax: "data.json",
        
        "ajax": {
            
            "url":"../controllers/ordenController.php",
            "method":"POST",
            "data":{funcion:funcion,matr:matr},
            "dataSrc":""
        },
        "columns": [



            { "data": "idOrden" },
            { "data": "fechaOrd" },
            { "data": "conduct" },
            { "data": "encargado" },
            { "data": "tipo_serv" },
            { "data": "obscliente" },
 
        ],
        language: espanol,
    });


    listarTvehiculos();
    function listarTvehiculos(){
        funcion = "listarTvehiculos";
        
        $.post('../controllers/tVehiculoController.php',{funcion},(response)=>{
            const TVEHS = JSON.parse(response);
            let template = '';
            TVEHS.forEach(tveh=>{
                template+=`
                    <option value="${tveh.id_tveh}">${tveh.nom_tveh}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('.tveh').html(template);
            // $('#encargado2').html(template);
        })
    }

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
            $('.encargado').html(template);
            // $('#encargado2').html(template);
        })
    }

    listarServicios();
    function listarServicios(){
        funcion = "listarServicios";
        
        $.post('../controllers/tServicioController.php',{funcion},(response)=>{
            // console.log("serv: " + response);
            const SERVICIOS = JSON.parse(response);
            let template = '';
            SERVICIOS.forEach(servicio=>{
                template+=`
                    <option value="${servicio.id_serv}">${servicio.nom_serv}</option>
                `;
            });
            /* id del campo que contiene el listado */
            $('.servicios').html(template);
            // $('#encargado2').html(template);
        })
    }

    listarVehiculos();
    function listarVehiculos(){
        funcion = "listarVehiculos";
        
        $.post('../controllers/vehiController.php',{funcion},(response)=>{
            // console.log("serv: " + response);
            const VEHICULOS = JSON.parse(response);
            let template = '';
            VEHICULOS.forEach(vehiculo=>{
                template+=`
                    <option value="${vehiculo.placa}">${vehiculo.placa}</option>
                `;
            });
            $('.veh_asignado').html(template);
        })
    }


    cargarDatosVehX(matr);
    function cargarDatosVehX(matr){
        funcion = "cargarDatosVehX";
        $.post('../controllers/vehiController.php',{funcion, matr},(response)=>{
            console.log("serv: " + response);
            const VEHICULOX = JSON.parse(response);
            VEHICULOX.forEach(vehX=>{

                let concat = vehX.marca + ' ' + vehX.refer;

                $('#matr').html(vehX.placa);
                $('#tVeh').html(vehX.tVeh);
                $('#marc_refer').html(concat);
                $('#color').html(vehX.color);
                $('#model').html(vehX.model);
                $('#cliente').html(vehX.cliente);
                $('#telef').html(vehX.telef);
                $('#email').html(vehX.email);
            });
        })
    }

    /* NUEVA ORDEN */
    $(document).on('click','#op_n_orden', e =>{

        Swal.fire({
            title: '??Qu?? tipo de orden desea crear?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `Para??un veh??culo nuevo`,
            denyButtonText: `Para??un veh??culo existente.`,
          }).then((result) => {
            if (result.isConfirmed) {

                /* Limpiar y resetear formulario */
                $('#form_crear_veh').trigger('reset');
                $('#tveh').select2("val","");
                $('#alert_noadd_veh').hide();

                // $('#mod_n_orden').modal();    // Desplegar Modal Orden SOLO EXPERIMENTAL
                $('#mod_n_veh').modal();    // Desplegar Modal Nuevo vehiculo
                
                $('#form_crear_veh').submit(e =>{

                    let cliente   = $('#cliente').val();
                    let telef     = $('#telef').val();
                    let email     = $('#email').val();
                    let placa     = $('#placa').val();
                    let marca     = $('#marca').val();
                    let refer     = $('#refer').val();
                    let modelo    = $('#modelo').val();
                    let tipo      = $('#tveh').val();
                    let color     = $('#color').val();
                    let placaReg  ="";
                    
                    funcion = "crearvehiculo";
            
                    $.post("../controllers/vehiController.php",
                    {funcion, cliente, email, placa, marca, telef, refer, modelo, tipo, color},(response) => {

                        if(response == "add"){

                            placaReg =  $('#placa').val();
                            placaReg = placaReg.toUpperCase();
                            dtVehiculos.ajax.reload();
                            
                            /* Adicional a esto, cuenta con una regla css en longhorn.css
                            para evitar que cuando se abruiera el nuevo modal, la bara
                            lateral desapareciera
                             */
                            $('#mod_n_veh').modal('toggle')       // Ocultar modadl vehiculo
                            $('#mod_n_veh').hide()        // Ocultar modadl vehiculo

                            $('#mod_n_orden').modal();    // Desplegar Modal Nuevo orden

                            /* 
                             * adicionalmente se le pasa el nombre del cliente
                             * para que ese dato en asignarOrden() sea pasado
                             * como un valor por default el el campo nombre conductor.
                             * Util cuando el conductor es el mismo cliente del vehiculo
                             */
                            asignarOrden(placaReg,cliente);

                        }
                        if(response =="noadd"){
            
                            $('#alert_noadd_veh').hide();
                            $('#alert_noadd_veh').show(1000);
                        }
                    });
            
                    e.preventDefault();
                });

            } else if (result.isDenied) {
                resetAsigOrdForm();
                $('#mod_orden_veh_exist').modal();    // Desplegar Modal Orden
                asignarOrdenVehExist();
            }
        });
    })


    function asignarOrden(placaReg,cliente){

        const MATREG = placaReg;
        $('#pholderMatr').html(MATREG);

        /* Para cuando el conductor es el mismo cliente */
        $('#conduct').val(cliente);

        $('#form_crear_orden').submit(e=>{

            $('select.select2-mult').val()

            let placa = MATREG;

            let conduct   = $('#conduct').val();
            let encargado   = $('#encargado').val();
            let serv = $('select.select2-mult').val();
            let obscliente   = $('#obscliente').val();
            let dgmec   = $('#dgmec').val();
            let proced   = $('#proced').val();
            let repuest   = $('#repuest').val();
            let obsad   = $('#obsad').val();

            funcion = "asignarOrden"
            
            $.post('../controllers/ordenController.php',
            {funcion,placa,conduct,encargado,serv,obscliente,dgmec,proced,repuest,obsad},(response2)=>{
                console.log("respondio"+response2);
                if(response2=='add orden'){

                    datatable.ajax.reload();
                    resetCrearOrdForm();
                    $('#alert_add_ord').show(1000);

                }else{
                    datatable.ajax.reload();
                    $('#alert_noadd_ord').hide();
                    $('#alert_add_ord').hide();
                    $('#alert_noadd_ord').show(1000);
                }
                
            })
            e.preventDefault();
        });
    }


    function eliminarOrden(idOrden){

        var funcion = "borrarOrden";
        /* Alerta */
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-1',
                cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
        })
            
        swalWithBootstrapButtons.fire({
            title: '??Est?? seguro que desea eliminar la orden '+idOrden+'?',
            text: "Esta acci??n ya no se podr?? deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.post('../controllers/ordenController.php',{idOrden,funcion},(response)=>{
                    datatable;
                    if(response=='borrado'){

                        swalWithBootstrapButtons.fire(
                            'Eliminada '+idOrden+'!',
                            'la Orden ha sido eliminada.',
                            'success'
                        )
                        datatable.ajax.reload();
                        
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+idOrden,
                            'No se pudo eliminar la orden.',
                            'error'
                        )
                        datatable.ajax.reload();
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            }
        });
    }

    function generarPDF(idOrden){
        $.post('../controllers/PDFController.php',{idOrden},(response)=>{
            /* Blanc es para que abra una esta??a nueva */
            window.open('../pdf/pdf-'+idOrden+'.pdf','_blank');
        });
    }


    function editarOrden(idOrden){

        funcion = "cargarDatosOrden";
        let matr,
            conduct,
            encargado,
            serv,
            obscliente,
            dgmec,
            proced,
            repuest,
            obsad;
        $.post('../controllers/ordenController.php',{idOrden,funcion},(response)=>{
            // console.log(response);
            const DATOSORDEN = JSON.parse(response);
            
            DATOSORDEN.forEach(datoOrden => {
                matr        = datoOrden.placa,
                conduct     = datoOrden.conduct,
                encargado   = datoOrden.encargado,
                serv        = datoOrden.tipo_serv,
                obscliente  = datoOrden.obscliente,
                dgmec       = datoOrden.dgmec,
                proced      = datoOrden.proced,
                repuest     = datoOrden.repuest,
                obsad       = datoOrden.obsad  
                // console.log("servicios:"+serv);             
            });

            /* convertir en aun array la cadena de texto que contiene
            los servicios, para enviarle el array al select multiple */
            serv=serv.split(',');

            /* titulos de la parte superior del modal */
            $('#titMatrEd').html(matr)
            $('#titIdOrdenEd').html(idOrden)
            
            $('#idOrdenEdit').val(idOrden)
            $('#edconduct').val(conduct)
            $('#edencargado').val(encargado).trigger('change')
            $('select.select2-mult').val(serv).trigger('change')
            $('#edobscliente').val(obscliente)
            $('#eddgmec').val(dgmec)
            $('#edproced').val(proced)
            $('#edrepuest').val(repuest)
            $('#edobsad').val(obsad)
        });
      
        $('#mod_ed_orden').modal();
    }


    /* Evento al enviar los datos del formulario editar orden */
    $('#form_edit_orden').submit(e=>{

        $('select.select2-mult').val();
   
        let idOrden     = $('#idOrdenEdit').val();
        let conduct     = $('#edconduct').val();
        let encargado   = $('#edencargado').val();
        let serv        = $('#edservicios').val();
        let obscliente  = $('#edobscliente').val();
        let dgmec       = $('#eddgmec').val();
        let proced      = $('#edproced').val();
        let repuest     = $('#edrepuest').val();
        let obsad       = $('#edobsad').val();

        funcion = "editarOrden";
        
        $.post('../controllers/ordenController.php',
        {funcion,idOrden,conduct,encargado,serv,obscliente,dgmec,proced,repuest,obsad},
        (response)=>{

            if(response == "edit"){           
                $('#alert_edit_ord').hide('slow');
                $('#alert_noedit_ord').hide();
                $('#alert_edit_ord').show(1000);
                $('#edencargado').select2("val","");
                $('#edservicios').select2("val","");
                $('#form_edit_orden').trigger('reset');

                datatable.ajax.reload();
            }else{              
                $('#alert_edit_ord').hide('slow');
                $('#alert_noedit_ord').hide();
                $('#alert_noedit_ord').show(1000);
                $('#edencargado').select2("val","");
                $('#edservicios').select2("val","");
                $('#form_edit_orden').trigger('reset');
                datatable.ajax.reload();
            }
        });
        e.preventDefault();
    });




    /* ****************************************************** */
    /* ****************** FUNCIONES VARIAS ****************** */
    /* ****************************************************** */
    
    function asignarOrdenVehExist(){

        $('#form_asignar_orden').submit(e=>{
        
            let placa       = $('#veh_asignado').val();
            let conduct     = $('#as-conduct').val();
            let encargado   = $('#as-encargado').val();
            let serv        = $('select#as-servicios').val();
            let obscliente  = $('#as-obscliente').val();
            let dgmec       = $('#as-dgmec').val();
            let proced      = $('#as-proced').val();
            let repuest     = $('#as-repuest').val();
            let obsad       = $('#as-obsad').val();

            funcion = "asignarOrden"
                
            $.post('../controllers/ordenController.php',
            {funcion,placa,conduct,encargado,serv,obscliente,dgmec,proced,repuest,obsad},(response2)=>{

                if(response2=='add orden'){
                    resetAsigOrdForm();
                    $('#alert_as_ord').show(1000);
                    datatable.ajax.reload();

                }else{
                    limpiarAlertas()
                    $('#alert_noas_ord').show(1000);
                    datatable.ajax.reload();
                }
                
            })
            e.preventDefault();
        });

    }

    function limpiarAlertas(){
        $('#alert_add_ord').hide();
        $('#alert_as_ord').hide();
        $('#alert_noadd_ord').hide();
        $('#alert_noas_ord').hide();
    }

    function resetAsigOrdForm(){
        $('#veh_asignado').select2("val","");
        $('#as-encargado').select2("val","");
        $('#as-servicios').select2("val","");
        $('#form_asignar_orden').trigger('reset');
    }

    function resetCrearOrdForm(){
        $('#encargado').select2("val","");
        $('#servicios').select2("val","");
        $('#form_crear_orden').trigger('reset');
    }



    /* ****************************************************** */
    /* ********** FUNCIONES MENU CONSEXUAL ***************** */
    /* ****************************************************** */

    /* Ocultar menu contx al hacer click */
    $(document).click(function(e){
        if(e.button == 0){
            console.log("fuera");
            $('#contextMenu').hide('fast');

        }
    })


    /* Quitar menu al retirar el mouse de el */
    // $('#contextMenu').mouseleave(function(){
    //     $('#contextMenu').hide('fast');
    // })


    /* Al hacer doble click sobre una fila, redireccionar a la vista
    Detalles de la orden */    
    $('#tabla_products tbody').on( 'dblclick', 'tr', function () {
        clearTimeout(TimeFn);
        /* Obtener los datos de la fila seleccionada */
        let datos = datatable.row(this).data();
        let idOrden= datos.idOrden;

        window.location.href ='ord_det.php' + "?id=" + idOrden;
    });
    $('#tabla_veh tbody').on( 'dblclick', 'tr', function () {
        clearTimeout(TimeFn);
        /* Obtener los datos de la fila seleccionada */
        let datos = datatable.row(this).data();
        let idOrden= datos.idOrden;

        // window.location.href ='ord_det.php' + "?id=" + idOrden;
    });


    /* Ejecucion del menu contextual al hacer click sobre x fila y las 
    Opciones del menu contextual con su funcion a ejecutar */
    $('#tabla_products tbody').off('click','tr').on( 'click', 'tr', function (e) {

        /* Switch cambiar opciones menu */
        $('#asigOrd').replaceWith("<a id='pdfOrden' href='#'>Generar PDF</a>")

        clearTimeout(TimeFn);

        /* Obtener los datos de la fila seleccionada */
        let datos   = datatable.row(this).data();
        let idOrden = datos.idOrden;

        TimeFn = setTimeout(function(){

            /* al hacer click o toque, deplegar menu */
            $("#contextMenu").css("top", e.pageY -10);
            $("#contextMenu").css("left", e.pageX -10);
            $("#contextMenu").show("fast");

            $('#contextMenu').off('click').on('click',function(e){

                    switch(e.target.id){

                    case "abrir":
                        window.location.href ='ord_det.php' + "?id=" + idOrden;
                    break;

                    case "pdfOrden":
                        generarPDF(idOrden);
                        e.preventDefault();
                    break;

                    case 'editar':
                        /* Oculta cualquier dialogo de alerta visible en cambiar pass */
                        $('#alert_edit_ord').hide();
                        $('#alert_noedit_ord').hide();

                        editarOrden(idOrden);

                    break

                    case "eliminar":
                        eliminarOrden(idOrden);  
                    break;
                    case "cancelar":
                        $('#contextMenu').hide('fast');
                        e.preventDefault();

                    break;
                }
            })
        },300)

    });
    $('#tabla_veh tbody').off('click','tr').on( 'click', 'tr', function (e) {

        /* Switch cambiar opciones menu */
        $('#pdfOrden').replaceWith("<a id='asigOrd' href='#'>Asignar nueva orden</a>");

        clearTimeout(TimeFn);

        /* Obtener los datos de la fila seleccionada */
        let datos   = dtVehiculos.row(this).data();
        let matr = datos.placa;

        TimeFn = setTimeout(function(){

            /* al hacer click o toque, deplegar menu */
            $("#contextMenu").css("top", e.pageY -10);
            $("#contextMenu").css("left", e.pageX -10);
            $("#contextMenu").show("fast");

            $('#contextMenu').off('click').on('click',function(e){

                    switch(e.target.id){

                    case "abrir":
                        window.location.href ='veh_det.php' + "?id=" + matr;
                    break;

                    case "asigOrd":
                        e.preventDefault();
                        console.log("asigh");
                        /* Crear una funcion para cuando se asigne una n oorden */
                        $('#mod_ed_orden').modal();

                        // generarPDF(matr);
                    break;

                    case 'editar':
                        e.preventDefault();

                        // $('#alert_edit_ord').hide();
                        // $('#alert_noedit_ord').hide();

                        // editarOrden(matr);

                    break

                    case "eliminar":
                        // eliminarOrden(matr);  
                    break;
                    case "cancelar":
                        $('#contextMenu').hide('fast');
                        e.preventDefault();

                    break;
                }
            })
        },300)

    })


    /* Eventos al seleccionar fila */
    $('#tabla_products tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else if(datatable.$('tr.selected')) {
            datatable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
    $('#tabla_veh tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else if(dtVehiculos.$('tr.selected')) {
            dtVehiculos.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

    /* deseleccionar la fila seleccionada al hacer click fuera de la tabla */
    $(document).click(function(event) { 
        let $target = $(event.target);
        if(!$target.closest('#tabla_products').length && 
        $('#tabla_products').is(":visible")) {
          $('#tabla_products tbody tr').removeClass('selected');
        }else if(!$target.closest('#tabla_veh').length && 
        $('#tabla_veh').is(":visible")) {
          $('#tabla_veh tbody tr').removeClass('selected');
        }    
    });

    /* ************** FIN MENU CONSEXUAL ***************** */

})


/* DATATABLE A ESPA??OL */
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
        "collection": "Colecci??n",
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
        "last": "??ltimo",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "processing": "Procesando...",
    "search": "Buscar:",
    "searchBuilder": {
        "add": "A??adir condici??n",
        "button": {
            "0": "Constructor de b??squeda",
            "_": "Constructor de b??squeda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condici??n",
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangr??a",
        "title": {
            "0": "Constructor de b??squeda",
            "_": "Constructor de b??squeda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de b??squeda",
            "_": "Paneles de b??squeda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total}",
        "emptyPanes": "Sin paneles de b??squeda",
        "loadMessage": "Cargando paneles de b??squeda",
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
                "_": "??Est?? seguro que desea eliminar %d filas?",
                "1": "??Est?? seguro que desea eliminar 1 fila?"
            }
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">M??s informaci??n&lt;\\\\\\\/a&gt;).&lt;\\\/a&gt;<\/a>"
        },
        "multi": {
            "title": "M??ltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aqu??, de lo contrario conservar??n sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
        }
    }
} 
