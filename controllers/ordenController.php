<?php
require_once('../vendor/autoload.php');

include '../models/orden.php';

$ordenes = new Orden;

switch ($_POST['funcion']) {

    case 'asignarOrden':
        
        $placa      = $_POST['placa'];
        $conduct    = ucwords($_POST['conduct']);
        $encargado  = $_POST['encargado'];
        $nTipo      = implode(",",$_POST['serv']);
        $tipo_serv  = $nTipo;
        $obscliente = $_POST['obscliente'];
        $dgmec      = $_POST['dgmec'];
        $proced     = $_POST['proced'];
        $repuest    = $_POST['repuest'];
        $obsad      = $_POST['obsad'];

        $ordenes -> asignarOrden($placa, $conduct, $encargado, $tipo_serv, $obscliente, $dgmec, $proced, $repuest, $obsad);


    break;

    case 'cargarOrdenes':

        $ordenes->listarOrdenes();
        $json=array();

        foreach($ordenes->objetos as $objeto){

            $id_orden  = $objeto->id_orden;
            $idMecanic = $objeto->encargado;

            $ordenes->obtenerServicios($id_orden);

            foreach($ordenes->objetos as $objServicio){

                $servString = $objServicio->tipo_serv;

                $servArray=explode(",", $servString);
                
                $jsonNomServ=array();
                foreach ($servArray as $serv){
                    $ordenes->listarServicios($serv);

                    foreach($ordenes->objetos as $objNomServ){
                        $jsonNomServ[]=array(
                            $objNomServ->nom_serv
    
                        );
                    }
                }
            }

            $ordenes->obtenerMecanico($idMecanic);
            foreach($ordenes->objetos as $objMecanic){
                $mecLider = $objMecanic->nom_comp_encargado;
            }


            $json[]=array(

                'idOrden'      => $objeto->id_orden,
                'fechaOrd'      => $objeto->fecha_orden,
                'placa'      => $objeto->placa,
                'conduct'    => $objeto->conductor,
                'encargado'  => $mecLider,
                // 'encargado'  => $objeto->encargado,
                'tipo_serv'  => $jsonNomServ,
                'obscliente' => $objeto->observ_cliente,
                'dgmec'      => $objeto->dgmec,
                'proced'     => $objeto->proced,
                'repuest'    => $objeto->repuest,
                'obsad'      => $objeto->obsad,

            );

        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        
    break;

    case 'cargarOrdenesVehiculoX':

    $id = $_POST['matr'];

        $ordenes->cargarOrdenesVehiculoX($id);
        $json=array();

        foreach($ordenes->objetos as $objeto){

            $id_orden  = $objeto->id_orden;
            $idMecanic = $objeto->encargado;

            $ordenes->obtenerServicios($id_orden);

            foreach($ordenes->objetos as $objServicio){

                $servString = $objServicio->tipo_serv;

                $servArray=explode(",", $servString);
                
                $jsonNomServ=array();
                foreach ($servArray as $serv){
                    $ordenes->listarServicios($serv);

                    foreach($ordenes->objetos as $objNomServ){
                        $jsonNomServ[]=array(
                            $objNomServ->nom_serv
    
                        );
                    }
                }
            }

            $ordenes->obtenerMecanico($idMecanic);
            foreach($ordenes->objetos as $objMecanic){
                $mecLider = $objMecanic->nom_comp_encargado;
            }


            $json[]=array(

                'idOrden'      => $objeto->id_orden,
                'fechaOrd'      => $objeto->fecha_orden,
                'placa'      => $objeto->placa,
                'conduct'    => $objeto->conductor,
                'encargado'  => $mecLider,
                // 'encargado'  => $objeto->encargado,
                'tipo_serv'  => $jsonNomServ,
                'obscliente' => $objeto->observ_cliente,
                'dgmec'      => $objeto->dgmec,
                'proced'     => $objeto->proced,
                'repuest'    => $objeto->repuest,
                'obsad'      => $objeto->obsad,

            );

        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        
    break;

    case'borrarOrden':
        $idOrden = $_POST['idOrden'];
        $ordenes->borrarOrden($idOrden);


    break;

    case 'abrirOrden':
        // header("Location: ../views/ord_det.php");
        $id = $_POST['idOrd'];
        $json=array();

        $ordenes->obtenerOrden($id);

        foreach($ordenes->objetos as $objOrd){
            $json[]= array(
                'placa' => $objOrd->placa
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;

    break;

    case 'cargarDatosOrden':
        $id = $_POST['idOrden'];
        $json = array();

        $ordenes->obtenerOrden($id);

        foreach($ordenes->objetos as $objeto){
            $json[] = array(
                'idOrden'      => $objeto->id_orden,
                'fechaOrd'      => $objeto->fecha_orden,
                'placa'      => $objeto->placa,
                'conduct'    => $objeto->conductor,
                'encargado'  => $objeto->encargado,
                'tipo_serv'  => $objeto->tipo_serv,
                'obscliente' => $objeto->observ_cliente,
                'dgmec'      => $objeto->dgmec,
                'proced'     => $objeto->proced,
                'repuest'    => $objeto->repuest,
                'obsad'      => $objeto->obsad,
            );
        }
        $jsonStr = json_encode($json);
        echo $jsonStr;




    break;

    case 'editarOrden':
        // {funcion,idOrden,conduct,encargado,serv,obscliente,dgmec,proced,repuest,obsad},
        $idOrden = $_POST['idOrden'];
        $conduct = $_POST['conduct'];
        $encargado = $_POST['encargado'];
        $serv      = implode(",",$_POST['serv']);
        $obscliente = $_POST['obscliente'];
        $dgmec = $_POST['dgmec'];
        $proced = $_POST['proced'];
        $repuest = $_POST['repuest'];
        $obsad = $_POST['obsad'];
        $ordenes->editarOrden($idOrden,$conduct,$encargado,$serv,$obscliente,$dgmec,$proced,$repuest,$obsad);

    break;

    
    default:
        # code...
        break;
}