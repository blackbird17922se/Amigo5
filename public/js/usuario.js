$(document).ready(function(){

    var funcion ="";

    var height =$(window).height();

    $('#cont-seccion').height(height);
    
    /* Obtener el id del usuario */
    var id_usuario = $('#id_usuario').val();
    // console.log(id_usuario);
    buscarUsuario(id_usuario);

    function buscarUsuario(id){
        funcion="buscarUsuario";
        /* Hacer peticion ajax post */
        /* "url"{datos a pasarle}(respuesta) */
        $.post("../controllers/usuarioController.php", {funcion,id}, (response) => {
            // console.log(response);
          
            /* Variables de la vista Perfil */
            let identificacion ='';
            let nomApe ='';     // Nombre y Apellidos
            let cargo ='';

            /* Variable para mostrar el nombre en el menu inicio */
            let nombre ='';

            const USUARIO = JSON.parse(response);

            /* a traves de la cntante puedo acceder a los nombres claves */
            identificacion += `${USUARIO.identificacion}`;
            nomApe += `${USUARIO.nombre} ${USUARIO.apellido}`;
            cargo += `${USUARIO.cargo}`;
            nombre += `${USUARIO.nombre}`;

            $('#nomUsuario').html(nomApe);
            $('#cargo').html(cargo);
            $('#identificacion').html(identificacion);
            $('#nomUsuMenu').html(nombre);
            
            /* Reemplazar atributos (valores contenidos) de html */
            /* Cargar la url de la foto */
            $('#avatarMenu').attr('src',USUARIO.foto);
            $('#avatarVerPerfil').attr('src',USUARIO.foto);
        });
    }

    $(document).on('click','#op_nombre',(e) => {
        // console.log("op_nombre");
        funcion = "capturarDatos";

        $.post("../controllers/usuarioController.php",{id_usuario, funcion},(response) => {
            // console.log(response);
            const USUARIO2 = JSON.parse(response);
            $('#nombre').val(USUARIO2.nombre);
            $('#apellido').val(USUARIO2.apellido);
        })
    })

    /* solo analizar formulario */
    /* nombre formulario. envio por submit(evento=>...) */
    $('#form_edit_usu').submit(e=>{
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();

        funcion = 'editarPerfil';
        $.post('../controllers/usuarioController.php',{funcion, nombre, apellido, id_usuario}, (response) => {
            // console.log(response);
            if(response == true){
                $('#editarPerfil').modal('hide');

                /* Actualizar el front end */
                buscarUsuario(id_usuario);
            }
        });
        e.preventDefault();
    })


    /* Oculta cualquier dialogo de alerta visible en cambiar pass */
    $(document).on('click','#op_pass',(e) => {
        $('#alert_edit_pass').hide();
    });

    $('#form_edit_pass').submit(e => {
        // passActual passNuevo passNuevoConfirm
        let passActual = $('#passActual').val();
        let passNuevo = $('#passNuevo').val();
        let passNuevoConfirm = $('#passNuevoConfirm').val();

        if(passNuevo === passNuevoConfirm){
            funcion = 'cambiarPass';
            $.post("../controllers/usuarioController.php",{funcion, passActual, passNuevo, passNuevoConfirm, id_usuario}, (response) => {
                console.log(response);
                if(response == true){
                    $('#alert_edit_pass').hide('slow');
                    $('#alert_noCoincid_pass').hide();
                    $('#alert_noedit_pass').hide();
                    $('#alert_edit_pass').show(1000);
                    $('#form_edit_pass').trigger('reset');
                }else{
                    $('#alert_noCoincid_pass').hide();
                    $('#alert_edit_pass').hide();
                    $('#alert_noedit_pass').hide('slow');
                    $('#alert_noedit_pass').show(1000);

                }
                e.preventDefault();             
            })
        }else{
            $('#alert_noedit_pass').hide();
            $('#alert_edit_pass').hide();
            $('#alert_noCoincid_pass').hide('slow');
            $('#alert_noCoincid_pass').show(1000);
        }
        e.preventDefault();
    })

    $('#form_edit_avatar').submit(e=>{
        /* Formdata: usese cundo un formulario trabaja con enctype="multipart/form-data"> */
        let formData = new FormData($('#form_edit_avatar')[0]);
        // Datos a pasarle
        $.ajax({
            type: "POST",
            url: "../controllers/usuarioController.php",
            cache: false,
            processData: false,
            contentType: false,
            data: formData   
        }).done(function(response){ //Cuando se envie entonces...retorna una respuesta
            // console.log(response);
            const JSONIMG = JSON.parse(response);

            if(JSONIMG.alerta == 'edit'){
                buscarUsuario(id_usuario);

                /* Reemplazar atributos (valores contenidos) de html */
                // $('#avatarMenu').attr('src',JSONIMG.rutaNuevaImg);
                // $('#avatarVerPerfil').attr('src',JSONIMG.rutaNuevaImg);

                $('form_edit_avatar').trigger('reset');
                $('#mod_avatar').modal('hide');
            }else{
                $('#alert_noedit_avatar').hide('slow');
                $('#alert_noedit_avatar').show(1000);
                $('#alert_noedit_avatar').hide(2000);
                $('#form_edit_avatar').trigger('reset');

            }



        });
        e.preventDefault();
    })
})