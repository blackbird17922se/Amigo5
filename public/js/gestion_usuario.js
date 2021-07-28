$(document).ready(function(){
    var funcion;
    var edit = false;

    /* buscara los campos de lista desplegable con la clase select2 + la funcion interna select2*/
    // $('.select2').select2();
    buscarUsuario();

    

    /* CREAR USUARIO */
    $('#form_crear_usu').submit(e=>{
        /* recibir los datos del formulario al hacer click en el boton submit */
        /* val(): obtiene el valor en el imput */
        let id_usu = $('#id_usu').val();
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();
        let pass = $('#pass').val();
        let cargo = $('#cargo').val();
        console.log(cargo);
        
        funcion="crearUsuario";
        
        $.post('../controllers/usuarioController.php',{funcion,nombre,apellido,id_usu,pass,cargo},(response)=>{
            console.log(response);
            e.preventDefault();

            if(response=='add'){
                $('#alert_add_usu').hide('slow');
                $('#alert_add_usu').show(1000);
                $('#alert_add_usu').hide(2000);
                $('#form_crear_usu').trigger('reset');
                buscarUsuario();
            }
            if(response=='edit'){
                $('#edit-usuario').hide('slow');
                $('#edit-usuario').show(1000);
                $('#edit-usuario').hide(2000);
                $('#form_crear_usu').trigger('reset');
                buscarUsuario();
            }
            if(response=='noadd'){
                $('#alert_noadd_usu').hide('slow');
                $('#alert_noadd_usu').show(1000);
                $('#alert_noadd_usu').hide(2000);
                $('#form_crear_usu').trigger('reset');
            }
            if(response=='noedit'){
                $('#alert_noadd_usu').hide('slow');
                $('#alert_noadd_usu').show(1000);
                $('#alert_noadd_usu').hide(2000);
                $('#form_crear_usu').trigger('reset');
            }
            // edit = false;
        })
        e.preventDefault();
    });


    /* BUSCAR USUARIO */
    function buscarUsuario(consulta){
        funcion = 'cargarUsuarios';

        $.post('../controllers/usuarioController.php',{consulta,funcion},(response)=>{
            console.log(response);

            const USUARIOS = JSON.parse(response);
            let template = '';
            USUARIOS.forEach(usuario=>{

             

                template+=`

                    <div usuId="${usuario.identificacion}" usuNom="${usuario.nombre}" class="col-12 col-sm-6 col-md-4 align-items-stretch">

                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0">
                            ${usuario.cargo}
                        </div>

                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b> ${usuario.nombre}  ${usuario.apellido}</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fa fa-lg fa-user"></i></span>Número Identificador: ${usuario.identificacion} </li>                             
                                        <li class="small"><span class="fa-li"><i class="fa fa-ticket"></i></span>Estado: ${usuario.estado} </li>                             
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                <img src="../${usuario.foto}" alt="user-avatar" class="img-circle img-fluid">
                              </div>
                            </div>
                        </div>

                        
                        <div class="card-footer">
                            <div class="text-right">
                            
                                <button class="borrar btn btn-danger">
                                    <i class="fa fa-close"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
             
                `;
            });

            $('#cb-usuarios').html(template);
        })
    }


    /* BUSQUEDAS EN EL CAMPO BUSCAR */
    $(document).on('keyup','#buscar-usuario',function(){
        let valor = $(this).val();
        if(valor != ''){
            buscarUsuario(valor);
        }else{
            buscarUsuario();
        }
    });


    /* ELIMINAR USUARIO */
    $(document).on('click','.borrar',(e)=>{
        var funcion = "borrar";
        const ELEM = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const ID = $(ELEM).attr('usuId');
        const NOMB = $(ELEM).attr('usuNom');
        // console.log(ID + NOMB);

        // Alerta

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: '¿Está seguro que desea eliminar el usuario '+NOMB+'?',
            text: "Esta acción ya no se podrá deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controllers/usuarioController.php',{ID,funcion},(response)=>{
                    console.log(response);
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado '+NOMB+'!',
                            'El usuario ha sido eliminado.',
                            'success'
                        )
                        buscarUsuario();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error al eliminar '+NOMB,
                            'No se pudo eliminar el usuario.',
                            'error'
                        )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
 
            }
          })
    });


})