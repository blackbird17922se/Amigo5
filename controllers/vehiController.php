<?php
include "../models/vehiculo.php";
$vehiculo = new Vehiculo;

switch ($_POST['funcion']) {

    /************************ CREAR ************************/
    case 'crearvehiculo':
        $cliente    = ucwords($_POST['cliente']); 
        $email      = $_POST['email']; 
        $marca      = $_POST['marca']; 
        $telef      = $_POST['telef']; 
        $placa      = strtoupper($_POST['placa']);
        $refer      = ucwords($_POST['refer']);
        $modelo     = $_POST['modelo'];
        $tipo       = $_POST['tipo'];
        $color      = ucwords($_POST['color']);

        $vehiculo->crearVehiculo($cliente, $email, $marca, $telef, $placa, $refer, $modelo, $tipo, $color);
    break;


    /********************** CARGAR **********************/
    case 'cargarVehiculos':
        $vehiculo->cargarVehiculos();
        $json = array();

        foreach($vehiculo->objetos as $objeto){

            $id_tveh = $objeto->tipo;

            $vehiculo->obtenerTvehiculo($id_tveh);
            foreach($vehiculo->objetos as $objTveh){
                $nom_tveh = $objTveh->nom_tveh;
            }



            $json[] = array(

                "placa"       => $objeto->placa,
                "marca"       => $objeto->marca,
                "refer"       => $objeto->refer,
                "modelo"      => $objeto->modelo,
                "color"       => $objeto->color,
                "tipo_veh"    => $nom_tveh,
                "cliente"     => $objeto->nom_conduct,
                "pendient"    => $objeto->pendientes

            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;


    /************* CARGAR DATOS DE UN X VEHICULO *************/
    case 'cargarDatosVehX':

        $matr = $_POST['matr'];
        $vehiculo->cargarDatosVehX($matr);
        $json = array();

        foreach($vehiculo->objetos as $objeto){

            $id_tveh = $objeto->tipo;

            $vehiculo->obtenerTvehiculo($id_tveh);
            foreach($vehiculo->objetos as $objTveh){
                $nom_tveh = $objTveh->nom_tveh;
            }

            $json[] = array(

                "placa"       => $objeto->placa,
                "marca"       => $objeto->marca,
                "refer"       => $objeto->refer,
                "model"      => $objeto->modelo,
                "color"       => $objeto->color,
                "tVeh"        => $nom_tveh,
                "cliente"     => $objeto->nom_conduct,
                "telef"     => $objeto->telef1,
                "email"     => $objeto->email,
                "pendient"    => $objeto->pendientes

            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;


    /************************ EDITAR ************************/
    case 'editarvehiculo':

        // define("ID_MEC", $_POST['id_mec']);
        $id_mec     = $_POST['id_mec'];
        $nombre     = $_POST['nombre']; 
        $apellido   = $_POST['apellido']; 
        $telef      = $_POST['telef']; 
        $esp_mec    = $_POST['esp_mec'];
        $estado     = $_POST['estado'];

        $vehiculo->editarvehiculo($id_mec, $nombre, $apellido, $telef, $esp_mec, $estado);
        // $vehiculo->editarvehiculo(ID_MEC, $nombre, $apellido, $telef, $esp_mec, $estado);

    break;


    /************************ EDITAR ************************/
    case 'borrarvehiculo':
        $id_mec = $_POST['ID_MEC'];
        $vehiculo->borrarvehiculo($id_mec);
    break;


    case 'listarVehiculos':
        $vehiculo->listarVehiculos();
        $json=array();
        foreach($vehiculo->objetos as $objeto){
            $json[]=array(
                'placa'=>$objeto->placa,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;

    
    default:
        # code...
        break;
}

