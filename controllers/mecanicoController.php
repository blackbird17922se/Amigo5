<?php
include "../models/mecanico.php";
$mecanico = new Mecanico;

switch ($_POST['funcion']) {

    /************************ CREAR ************************/
    case 'crearMecanico':

        $id_mec     = $_POST['id_mec']; 
        $nombre     = $_POST['nombre']; 
        $apellido   = $_POST['apellido']; 
        $telef      = $_POST['telef']; 
        $esp_mec    = $_POST['esp_mec'];
        $estado     = "activo";
        // la fecha de ingreso es insertada por la bd (Current TIMESTAMP)

        $mecanico->crearMecanico($id_mec, $nombre, $apellido, $telef, $esp_mec, $estado);
    break;


    /********************** CARGAR O BUSCAR **********************/
    case 'cargarMecanico':
        
        $mecanico->cargarMecanico();
        $json=array();
        foreach($mecanico->objetos as $objeto){
            $json[] = array(                
                'id_mec'    => $objeto->identificacion,
                'nombre'    => $objeto->nombre,
                'apellido'  => $objeto->apellido,
                'telef'     => $objeto->telefono,
                'esp_mec'   => $objeto->especialidad,
                'estado'    => $objeto->estado,
            );
        }

        $jsonstring = json_encode($json);
        echo $jsonstring;

    break;



    /************************ EDITAR ************************/
    case 'editarMecanico':

        // define("ID_MEC", $_POST['id_mec']);
        $id_mec     = $_POST['id_mec'];
        $nombre     = $_POST['nombre']; 
        $apellido   = $_POST['apellido']; 
        $telef      = $_POST['telef']; 
        $esp_mec    = $_POST['esp_mec'];
        $estado     = $_POST['estado'];

        $mecanico->editarMecanico($id_mec, $nombre, $apellido, $telef, $esp_mec, $estado);
        // $mecanico->editarMecanico(ID_MEC, $nombre, $apellido, $telef, $esp_mec, $estado);

    break;


    /************************ EDITAR ************************/
    case 'borrarMecanico':
        $id_mec = $_POST['ID_MEC'];
        $mecanico->borrarMecanico($id_mec);
    break;

    case 'listarMecanicos':
        $mecanico->listarMecanicos();
        $json=array();
        foreach($mecanico->objetos as $objeto){
            $json[]=array(
                'id_mec'=>$objeto->identificacion,
                'nom_mec'=>$objeto->nombre
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;



    
    default:
        # code...
        break;
}

