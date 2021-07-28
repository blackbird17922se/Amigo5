$(document).ready(function(){
    cargarMecanico();
    var funcion;

    /*
     * FLAGEDIT: BANDERA EDITAR
     * Indicara al sistema cuando se quiere crear o editar un mecanico.
     * La bandera se inicia en false, de esa manera en $('#form_crear_mecanico')
     * al hacer el submit el sistema analizara la bandera
     * 
     * Si al hacer click en el boton de editar
     * (ejecutara entonces: $(document).on('click','.editar'...)
     * y la bandera cambiara a true y el sistema editara
     * 
     * De lo contrario, la bandera permanecera en false, de esa manera
     * el sistema tomara la opcion de crear
    */
    // var flagEdit = false;


    /* MOSTRAR U OCULTAR CAMPOS AL CREAR NUEVO MECANICO */
    // $(document).on('click','#op_n_mecanico', e=>{
    //     // $('#div_estado').css("visibility","hidden");
    //     // $('#estado').hide();
    //     $('#lab_estado').css("display","none");

    //     $('#lab_id_mec').css("display","block");
    //     $('#id_mec').attr("type","number");
    //     // flagEdit = false;
    //     console.log(flagEdit);
    // })



    /*************** CREAR ***************/ 
    $('#form_crear_mecanico').submit(e =>{

        let id_mec = $('#id_mec').val();
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();
        let telef = $('#telef').val();
        let esp_mec = $('#esp_mec').val();
        let estado = $('#estado').val();

        /* Condicional para determinar accion */
        // if(flagEdit == false){
        //     estado = $('#estadoDefault').val();
        // }else{
        //     funcion = "editarMecanico";
        // }
        
        funcion = "crearMecanico";

        $.post("../controllers/mecanicoController.php",{funcion, id_mec, nombre, apellido, telef, esp_mec, estado},(response) => {
            // console.log(response);
            if(response=="add"){

                $('#alert_add_mec').hide('slow');
                $('#alert_noadd_mec').hide();
                $('#alert_add_mec').show(1000);
                $('#form_crear_mecanico').trigger('reset');
                cargarMecanico();
            }
            if(response=="noadd"){

                $('#alert_add_mec').hide();
                $('#alert_noadd_mec').hide('slow');
                $('#alert_noadd_mec').show(1000);
                cargarMecanico();
            }
        });

        e.preventDefault();
    });



    /*************** EDITAR ***************/

    /* Oculta cualquier dialogo de alerta visible */
    $(document).on('click','.editar',(e) => {
        $('#alert_edit_mec').hide();
        $('#alert_noedit_mec').hide();
    });

    $('#form_edit_mecanico').submit(e =>{

        let id_mec = $('#id_mec_edit').val();
        let nombre = $('#nombre_ed').val();
        let apellido = $('#apellido_ed').val();
        let telef = $('#telef_ed').val();
        let esp_mec = $('#esp_mec_ed').val();
        let estado = $('#estado_ed').val();

        funcion = "editarMecanico";

        $.post("../controllers/mecanicoController.php",{funcion, id_mec, nombre, apellido, telef, esp_mec, estado},(response) => {
            console.log(response);

            if(response=="edit"){
                $('#alert_edit_mec').hide('slow');
                $('#alert_noedit_mec').hide();
                $('#alert_edit_mec').show(1000);
                cargarMecanico();
            }else{
                $('#alert_edit_mec').hide('slow');
                $('#alert_noedit_mec').hide();
                $('#alert_noedit_mec').show(1000);

            }
            // e.preventDefault();
            /* retornar a false para permitir crear nuevamente un mec */
            // flagEdit=false;

        });

        e.preventDefault();
    })

    /* CARGAR LOS MECANICOS O BUSCAR X MECANICO */
    function cargarMecanico(consulta){
        funcion = 'cargarMecanico';

        console.log(consulta);
        $.post('../controllers/mecanicoController.php',{consulta,funcion},(response)=>{
            console.log(response);
            const MECANICOS = JSON.parse(response);
            let plantilla='';

            MECANICOS.forEach(mecanico =>{
                plantilla += `
                    <div id_mec="${mecanico.id_mec}" mecnom="${mecanico.nombre}" mecape="${mecanico.apellido}"
                     mectel="${mecanico.telef}" mecesp="${mecanico.esp_mec}" mecest="${mecanico.estado}" 
                     class="col-12 col-sm-6 col-md-4 align-items-stretch">

                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">
                                ${mecanico.esp_mec}
                            </div>

                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b> ${mecanico.nombre}  ${mecanico.apellido}</b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fa fa-lg fa-user"></i></span>Número Identificador: ${mecanico.id_mec} </li>                             
                                            <li class="small"><span class="fa-li"><i class="fa fa-lg fa-phone"></i></span>Número de contacto: ${mecanico.telef} </li>                             
                                            <li class="small"><span class="fa-li"><i class="fa fa-ticket"></i></span>Estado: ${mecanico.estado} </li>                            
                                        </ul>
                                    </div>
                                   
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div class="text-right">
                                
                                    <button class="editar btn btn-success" type="button" data-toggle="modal" data-target="#mod_edit_mecanico">
                                        <i class="fa fa-pencil"></i> Editar
                                    </button>
                                    <button class="borrar btn btn-danger">
                                        <i class="fa fa-close"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#cb_mecanico').html(plantilla);
        })
    }

    /* DETERMINAR SI SE ESTA EJECUTANDO O NO UNA BUSQUEDA DE MECANICO */
    $(document).on('keyup','#buscar_mecanico',function(){
        let valor = $(this).val();
        if(valor != ''){
            cargarMecanico(valor);
        }else{
            cargarMecanico();
        }
    });


    /* EDITAR */
    $(document).on('click','.editar', e=>{
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        /* 
         * MOSTRAR U OCULTAR CAMPOS AL EDITAR MECANICO
         * Oculta el campo identificacion junto con su label.
         * Activar el div que contiene la lista desplegable de "estado"
         * para qu el usuario pueda activar o desactivar al mecanico.
        */
        // $('#id_mec').attr("type","hidden");
        // $('#div_estado').css("display","block");
        // $('#lab_id_mec').css("display","none");

        /* 
         * los atributos los trae desde la tarjeta de usuario (la plantilla).
         * los valores y los id son traidos desde la parte :
         * <div id_mec="${mecanico.id_mec}" mecNom="${mecanico.nombre}" clas...
        */

        const ID_MEC = $(ELEM).attr('id_mec');
        const NOM = $(ELEM).attr('mecnom');
        const APE = $(ELEM).attr('mecape');
        const TEL = $(ELEM).attr('mectel');
        const ESP = $(ELEM).attr('mecesp');
        const EST = $(ELEM).attr('mecest');

        $('#id_mec_edit').val(ID_MEC);
        $('#nombre_ed').val(NOM);
        $('#apellido_ed').val(APE);
        $('#telef_ed').val(TEL);
        $('#esp_mec_ed').val(ESP);
        $('#estado_ed').val(EST);

        // flagEdit=true;
        // console.log(flagEdit);


    });

        /******************************************************************************/
    /* FUNCION BORRAR */

    $(document).on('click','.borrar', e =>{

        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID_MEC = $(ELEM).attr('id_mec');
        const NOM = $(ELEM).attr('mecnom');
        funcion = "borrarMecanico";

        /* Alerta */
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success m-1',
              cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
        })
         
        swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar al mecánico '+NOM+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                console.log(ID_MEC);
                $.post('../controllers/mecanicoController.php',{ID_MEC,funcion},(response)=>{
                    if(response=='borrado'){

                        swalWithBootstrapButtons.fire(
                            'Eliminado '+NOM+'!',
                            'El mecánico ha sido eliminado.',
                            'success'
                        )
                        cargarMecanico();
                      
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+NOM,
                            'Ha pasado un error fatal.',
                            'error'
                        )
                        cargarMecanico();
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            }
        });
    });
})