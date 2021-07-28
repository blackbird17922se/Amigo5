$(document).ready(function(){


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
                    // let modelo = $('#modelo').val();

                    let placaReg ="";
                    
                    funcion = "crearvehiculo";
            
                    $.post("../controllers/vehiController.php",
                    {funcion, cliente, email, placa, marca, telef, refer, modelo, tipo, color},
                    (response) => {
                        console.log(response);
                        if(response=="add"){

                            placaReg =  $('#placa').val();
            
                            $('#alert_add_mec').hide('slow');
                            $('#alert_noadd_mec').hide();
                            $('#alert_add_mec').show(1000);
                            $('#form_crear_mecanico').trigger('reset');
                            // mod_n_orden
                            $('#mod_n_veh').modal('hide');    // Ocultar modadl veh"

                            $('#mod_n_orden').modal();    // Desplegar Modal Nuevo orden

                            asignarOrden(placaReg);

                            // cargarMecanico();
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






            } else if (result.isDenied) {
              Swal.fire('Changes are not saved', '', 'info')
            }
          })


        // Swal.fire({
        //     title: '¿Qué tipo de orden desea crear?',
        //     showDenyButton: true,
        //     showCancelButton: true,
        //     confirmButtonText: `Para un vehículo nuevo`,
        //     denyButtonText: `Para un vehículo existente.`,
        //   }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //       Swal.fire('Saved!', '', 'success')
        //     } else if (result.isDenied) {
        //       Swal.fire('Changes are not saved', '', 'info')
        //     }
        //   })

        //   mod_n_veh

        // const swalWithBootstrapButtons = Swal.mixin({
        //     customClass: {
        //       confirmButton: 'btn btn-success m-1',
        //       cancelButton: 'btn btn-danger m-1'
        //     },
        //     buttonsStyling: false
        // })
         
        // swalWithBootstrapButtons.fire({
        //     title: '¿Está seguro que desea eliminar al mecánico ?',
        //     text: "Esta acción ya no se podrá deshacer.",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: 'Eliminar',
        //     cancelButtonText: 'Cancelar',
        //     reverseButtons: true
        // }).then((result) => {
        //     if (result.value) {
        //         console.log(ID_MEC);
        //         $.post('../controllers/mecanicoController.php',{ID_MEC,funcion},(response)=>{
        //             if(response=='borrado'){

        //                 swalWithBootstrapButtons.fire(
        //                     'Eliminado '+NOM+'!',
        //                     'El mecánico ha sido eliminado.',
        //                     'success'
        //                 )
        //                 cargarMecanico();
                      
        //             }else{
        //                 swalWithBootstrapButtons.fire(
        //                     'Error al eliminar '+NOM,
        //                     'Ha pasado un error fatal.',
        //                     'error'
        //                 )
        //                 cargarMecanico();
        //             }
        //         })
        //     } else if (result.dismiss === Swal.DismissReason.cancel) {
        //     }
        // });
    })


    function asignarOrden(placaReg){
        const PLACAREG = placaReg;

        $('#placaReg').val(PLACAREG);
    }

})