$(document).ready(function(){

    var funcion;
    var edit = false;   // bandera

    cargarTservicios();
    cambiarBotonNAtributo();


    function cargarTservicios(consulta){
        funcion = 'cargarTservicios';
        // ajax
        $.post('../controllers/tServicioController.php',{consulta,funcion},(response)=>{
            console.log(response);
            const TSERVS = JSON.parse(response);
            let template = '';
            TSERVS.forEach(tServ=>{
                template+=`
                <tr tServId="${tServ.id_serv}" tServNom="${tServ.nom_serv}">
                    <td>${tServ.nom_serv}</td>
                    <td>
                        <button class="editarServ btn btn-success" title="editar" type="button" data-toggle="modal" data-target="#mod_n_serv">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
    
                        <button class="borrarServ btn btn-danger" title="borrar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `;
            });
            $('#tabla_tServ').html(template);
        })
    }

    // evento para las busquedas en el input Buscar
    $(document).on('keyup','#busq-serv',function(){
        let valor = $(this).val();
        if(valor != ''){
            cargarTservicios(valor);
        }else{
            cargarTservicios();
        }
    });


    /* CREAR O EDITAR */
    $('#form_crear_serv').submit(e=>{

        let nom_serv = $('#nom_serv').val();
        let id_edit_tServ = $('#id_edit_tServ').val();

        if(edit == false){
            funcion = "crearServicio";
        }else{
            funcion = "editarTservicio";
        }


        $.post("../controllers/tServicioController.php",{funcion,id_edit_tServ, nom_serv},(response) => {

            if(response == 'add'){

                limpiarAlertas()
                $('#alert_add_serv').show(1000);
                $('#form_crear_serv').trigger('reset');
                cargarTservicios();

            }else if(response == 'noadd'){

                limpiarAlertas()
                $('#alert_noadd_serv').show(1000);

            }else if(response == 'edit'){

                limpiarAlertas()
                $('#alert_ed_serv').show(1000);
                $('#form_crear_serv').trigger('reset');
                cargarTservicios();

            }else if(response == 'noedit'){

                limpiarAlertas()
                $('#alert_noadd_serv').show(1000);

            }
            edit = false;
        });
        e.preventDefault();

    });


    $(document).on('click','.editarServ',(e)=>{
        limpiarAlertas();
        console.log("edd");
        const ELEM = $(this)[0].activeElement.parentElement.parentElement;
        const ID = $(ELEM).attr('tServId');
        const NOMB = $(ELEM).attr('tServNom');
        console.log(ID+NOMB);
        $('#id_edit_tServ').val(ID);
        $('#nom_serv').val(NOMB);
        edit=true;
    });

    /* Funcionalidad Boton Eliminar */
    $(document).on('click','.borrarServ',(e)=>{
        funcion = "borrarServicio";

        const ELEM = $(this)[0].activeElement.parentElement.parentElement;

        const ID = $(ELEM).attr('tServId');
        const NOMB = $(ELEM).attr('tServNom');

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
                $.post('../controllers/tServicioController.php',{ID,funcion},(response)=>{

                    if(response=='borrado'){
                        cargarTservicios();                            
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+ NOMB,
                            'No se pudo eliminar el tipo de servicio.',
                            'error'
                        )
                        cargarTservicios();
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
        $('#alert_add_serv').hide();
        $('#alert_noadd_serv').hide();
        $('#alert_ed_serv').hide();
    }

    /* Limpiar modal de alertas */
    $(document).on('click', '#op_n_serv', function(){
        limpiarAlertas();
        $('#form_crear_serv').trigger('reset');
    });


}); 