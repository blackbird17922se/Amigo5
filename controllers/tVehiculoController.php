<?php

include '../models/tVehiculo.php';

$tVehiculo = new Tvehiculo();

switch ($_POST['funcion']) {

    case 'cargarTvehiculos':
        
        $tVehiculo->cargarTvehiculos();
        $json = array();


        foreach($tVehiculo->objetos as $objeto){
            $json[]=array(
                'id_tVeh' => $objeto->id_tveh,
                'nom_tVeh' => $objeto->nom_tveh
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;

    break;


    case 'crearTvehiculo':
        $nom_tVeh = $_POST['nom_tVeh'];
        $tVehiculo->crearTvehiculo($nom_tVeh);
    break;

    case 'listarTvehiculos':
        $tVehiculo->listarTvehiculos();
        $json=array();
        foreach($tVehiculo->objetos as $objeto){
            $json[]=array(
                'id_tveh'=>$objeto->id_tveh,
                'nom_tveh'=>$objeto->nom_tveh
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;

    case 'editarTvehiculo':
        $id = $_POST['id_edit_tVeh'];
        $nom_tVeh = $_POST['nom_tVeh'];
        $tVehiculo->editarTvehiculo($id, $nom_tVeh);
    break;

    case 'borrarTveh':
        $id_tVeh = $_POST['ID'];
        $tVehiculo->borrarTveh($id_tVeh);
    break;
    
    default:
        # code...
        break;
}