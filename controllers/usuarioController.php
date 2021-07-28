<?php
include '../models/usuario.php';
$usuario = new Usuario();

session_start();
$idUsuarioSes = $_SESSION['idUsu'];
$urlFotosPerfil = '../public/img/usuarios/';

switch ($_POST['funcion']) {
    case 'buscarUsuario':
        $json = array();
        $usuario->obtenerDatos($_POST['id']);
        /* Recorrer los datos del objeto */
        /* objetoUsuario-> acceder a la propidad objetos (que contiene los datos de la consulta) */
        foreach($usuario->objetos as $objeto){
            /* Pasolos datospot json */
            $json[] = array(
                /* nombre clave => objeto->nombreCampoBD */
                'identificacion' => $objeto->identificacion,
                'nombre'         => $objeto->nombre,
                'apellido'       => $objeto->apellido,
                'cargo'          => $objeto->cargo,
                'estado'         => $objeto->estado,
                'foto'           => $urlFotosPerfil.$objeto->foto
            );

            /* 
             * Actualizar la variable sesion con el nombre del usuario.
             * Ayuda cuando el usuario a editado su nombre permitiendo
             * que en el menu tambien aparezca el nombre actualizado 
             */
            $_SESSION['nomUsu'] = $objeto->nombre;
            
        }

        /* json_encode devuelve un string de json codificado */
        /* le paso el indice 0 porque solo va a obtner un resultado */
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    break;

    case 'capturarDatos':
        $json = array();
        $usuario->obtenerDatos($_POST['id_usuario']);

        foreach($usuario->objetos as $objeto){
            $json[] = array(
                'nombre' => $objeto->nombre,
                'apellido' => $objeto->apellido
            );
        }

        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    break;

    case 'editarPerfil':
        $id = $_POST['id_usuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];

        $usuario->editarPerfil($id, $nombre, $apellido);

        echo true;
    break;

    case 'cambiarPass':
        $id = $_POST['id_usuario'];
        $passActual = $_POST['passActual'];
        $passNuevo = $_POST['passNuevo'];
        $passNuevoConfirm = $_POST['passNuevoConfirm'];

        $usuario->cambiarPass($passActual, $passNuevo, $id);

    break;

    // Ese cambiarFoto viene desde el formulario
    case 'cambiarFoto':

        /* Analizar el formato de la imagen */
        if(
            ($_FILES['foto']['type'] == 'image/jpeg') 
            || ($_FILES['foto']['type'] == 'image/jpg') 
            || ($_FILES['foto']['type'] == 'image/png') 
            || ($_FILES['foto']['type'] == 'image/bmp')
        ){
            /* foto: vine desde el nombre del input de la foto */
            /* Contiene el nombre y la extension del archivo seleccionado */
            /* iniq: proporciona un identificador unico */
            $nombreImg = uniqid() . '-' . $_FILES['foto']['name'];

            /* Guardar la ruta donde estara la imagen */
            $ruta = $urlFotosPerfil.$nombreImg;

            /* Mover la imagen a x ubicacion */
            move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);

            /* Almacenar url en bd */
            $usuario->cambiarFoto($idUsuarioSes, $nombreImg);
            foreach($usuario->objetos as $objeto){
                /* Elininar archivo antiguo */
                unlink($urlFotosPerfil.$objeto->foto);
            }

            /* Actualizar la variable sesion de la foto */
            $_SESSION['nomFotoPerfil'] = $ruta;

            $json = array();
            $json[]=array(
                'rutaNuevaImg' => $ruta,
                'alerta' => 'edit'
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }else{
            $json = array();
            $json[]=array(
                'alerta' => 'noedit'
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }

    break;

    case 'cargarUsuarios':
        $json=array();

        $usuario->buscar();

        foreach ($usuario->objetos as $objeto) {
            $json[] = array(
                'identificacion' => $objeto->identificacion,
                'nombre' => $objeto->nombre,
                'apellido' => $objeto->apellido,
                'estado' => $objeto->estado,
                'cargo' => $objeto->cargo,
                'foto' => $objeto->foto
            );
        }

        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;

    case 'crearUsuario':
        $id_usu   = $_POST['id_usu'];
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $pass     = $_POST['pass'];
        $cargo    = $_POST['cargo'];
        $estado    = 'activo';
        // Foto por defecto
        $foto     = 'public/img/usuarios/stand/default.png';

        $usuario -> crearUsuario($nombre, $apellido, $id_usu, $pass, $cargo, $foto, $estado);

    break;

    case 'borrar':
        /* OJO: $_POST['ID'] viene desde labratorio.js en la const ID = $(ELEM).attr('labId'); */
        $id = $_POST['ID'];
        $usuario->borrar($id);
    break;


    
    
    default:
        # code...
        break;
}