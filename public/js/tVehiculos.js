$(document).ready(function(){

    var funcion;
    var edit = false;   // bandera

    cargarTvehiculos();
    cambiarBotonNAtributo();

    function cargarTvehiculos(consulta){
        funcion = 'cargarTvehiculos';
        $.post('../controllers/tVehiculoController.php',{consulta,funcion},(response)=>{
            const TVEHS = JSON.parse(response);
            let template = '';
            TVEHS.forEach(tVeh=>{
                template+=`
                <tr tVehId="${tVeh.id_tVeh}" tVehNom="${tVeh.nom_tVeh}">
                    <td>${tVeh.nom_tVeh}</td>
                    <td>
                        <button class="editar btn btn-success" title="editar" type="button" data-toggle="modal" data-target="#mod_n_tVeh">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
    
                        <button class="borrar btn btn-danger" id="del" title="borrar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `;
            });
            $('#tabla_tVeh').html(template);
        })
    }

    // evento para las busquedas en el input Buscar
    $(document).on('keyup','#busq-tVeh',function(){
        let valor = $(this).val();
        if(valor != ''){
            cargarTvehiculos(valor);
        }else{
            cargarTvehiculos();
        }
    });

    $('#form_crear_tVeh').submit(e=>{

        let nom_tVeh = $('#nom_tVeh').val();
        let id_edit_tVeh = $('#id_edit_tVeh').val();

        if(edit == false){
            funcion = "crearTvehiculo";
        }else{
            funcion = "editarTvehiculo";
        }

        $.post("../controllers/tVehiculoController.php",{funcion, id_edit_tVeh, nom_tVeh},(response) => {
            if(response == 'add'){
                $('#alert_add_tVeh').show(1000);
                $('#form_crear_tVeh').trigger('reset');
                cargarTvehiculos();
            }else if(response == 'noadd'){

                limpiarAlertas()
                $('#alert_noadd_tVeh').show(1000);

            }else if(response == 'edit'){
                limpiarAlertas()
                $('#alert_ed_tVeh').show(1000);
                $('#form_crear_tVeh').trigger('reset');
                cargarTvehiculos();
            }else if(response == 'noedit'){
                limpiarAlertas()
                $('#alert_noadd_tVeh').show(1000);
            }
            edit = false;
        });
        e.preventDefault();
    });

    $(document).on('click','.editar',(e)=>{
        limpiarAlertas();
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('tVehId');
        const NOMB = $(ELEM).attr('tVehNom');
        $('#id_edit_tVeh').val(ID);
        $('#nom_tVeh').val(NOMB);
        edit=true;
    });

    /* Funcionalidad Boton Eliminar */
    $(document).on('click','.borrar',(e)=>{
        funcion = "borrarTveh";

        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('tVehId');
        const NOMB = $(ELEM).attr('tVehNom');
        console.log(ID + NOMB);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-1',
                cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
        });
            
        swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar el tipo '+NOMB+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.post('../controllers/tVehiculoController.php',{ID,funcion},(response)=>{

                    if(response=='borrado'){
                        cargarTvehiculos();
                        
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+NOMB,
                            'No se pudo eliminar el tipo de vehículo.',
                            'error'
                        )
                        cargarTvehiculos();
                    }
                })
            }
        });
        e.preventDefault();
    });



    /********************* FUNCIONALIDADES *********************/

    /* Cambia los botones nuevo Servicio o Vehiculo en la barra de opciones 
    dependiendo la pestaña del atributo que se muestre */
    function cambiarBotonNAtributo(){
        $('#nav-l-serv').on('click',function(){
            $('#op_n_tVeh').replaceWith("<a data-toggle='modal' id='op_n_serv' data-target='#mod_n_serv' href='' class='btn-opt'><i class='fas fa-tools' aria-hidden='true'></i> Nuevo Tipo de Servicio</a>");
    
        });

        $('#nav-l-veh').on('click',function(){
            $('#op_n_serv').replaceWith("<a data-toggle='modal' id='op_n_tVeh' data-target='#mod_n_tVeh' href='' class='btn-opt'><i class='fas fa-truck' aria-hidden='true'></i> Nuevo Tipo de Vehículo</a>");
        });
    }

    function limpiarAlertas(){
        $('#alert_add_tVeh').hide();
        $('#alert_noadd_tVeh').hide();
        $('#alert_ed_tVeh').hide();
    }

    /* Limpiar modal de alertas */
    $(document).on('click', '#op_n_tVeh', function(){
        limpiarAlertas();
        $('#form_crear_tVeh').trigger('reset');
    });

});
