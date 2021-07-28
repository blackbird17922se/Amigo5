<?php

include '../models/servicio.php';

$servicio = new Servicio();

switch ($_POST['funcion']) {

    case 'cargarTservicios':
        
        $servicio->cargarTservicios();
        $json = array();


        foreach($servicio->objetos as $objeto){
            $json[]=array(
                'id_serv' => $objeto->id_serv,
                'nom_serv' => $objeto->nom_serv
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;

    break;


    case 'crearServicio':
        $nom_serv = $_POST['nom_serv'];
        $servicio->crearServicio($nom_serv);
    break;

    case 'listarServicios':
        $servicio->listarServicios();
        $json=array();
        foreach($servicio->objetos as $objeto){
            $json[]=array(
                'id_serv'=>$objeto->id_serv,
                'nom_serv'=>$objeto->nom_serv
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;

    case 'editarTservicio':
        $id = $_POST['id_edit_tServ'];
        $nom_serv = $_POST['nom_serv'];
        $servicio->editarTservicio($id, $nom_serv);
    break;

    case 'borrarServicio':
        $id_serv = $_POST['ID'];
        $servicio->borrarServicio($id_serv);
    break;
    
    default:
        # code...
        break;
}