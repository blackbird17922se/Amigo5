$(document).ready(function(){


    var funcion = "";
    var idOrden = $('#idOrden').val();


    $('.select2').select2();
    $('.select2-mult').select2();

    var height =$(window).height();

    $('#cont-seccion').height(height);

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


    /* Funcionalidad Boton Generar PDF */
    $('#btn-tb-pdf').on('click',function(e){
        $.post('../controllers/PDFController.php',{idOrden},(response)=>{
            window.open('../pdf/pdf-'+idOrden+'.pdf','_blank');
        });
        e.preventDefault();
    });


    /* Funcionalidad Boton Eliminar */
    $('#btn-tb-delete').on('click',function(e){
        funcion = "borrarOrden";

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-1',
                cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
        });
            
        swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar la orden '+idOrden+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.post('../controllers/ordenController.php',{idOrden,funcion},(response)=>{
                    // datatable;
                    if(response=='borrado'){

                        swalWithBootstrapButtons.fire(
                            'Eliminada '+idOrden+'!',
                            'la Orden ha sido eliminada.',
                            'success'
                        )
                        // datatable.ajax.reload();
                        window.location.href = "ord_veh.php"
                        
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+idOrden,
                            'No se pudo eliminar la orden.',
                            'error'
                        )
                        // datatable.ajax.reload();
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            }
        });
        e.preventDefault();
    });


    /* Funcionalidad Boton Editar */
    $('#btn-tb-edit').on('click',function(e){
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
    });

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
                $('#cont-seccion').load(" #cont-seccion")

            }else{              
                $('#alert_edit_ord').hide('slow');
                $('#alert_noedit_ord').hide();
                $('#alert_noedit_ord').show(1000);
                $('#edencargado').select2("val","");
                $('#edservicios').select2("val","");
                $('#form_edit_orden').trigger('reset');
            }
        });
        e.preventDefault();
    });

})