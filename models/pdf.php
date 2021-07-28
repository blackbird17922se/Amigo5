<?php
include_once 'orden.php';

function getHtml($idOrden){
    $orden = new Orden();


    $orden->obtenerOrden($idOrden);

    foreach ($orden->objetos as $objeto) {
        $idOrden   = $objeto->id_orden;
        $fechaOrd   = $objeto->fecha_orden;
        $placa      = $objeto->placa;
        $conduct    = $objeto ->conductor;
        $encargado  = $objeto ->encargado;
        $id_tipo_serv  = $objeto ->tipo_serv;
        $obscliente = $objeto ->observ_cliente;
        $dgmec      = $objeto ->dgmec;
        $proced     = $objeto ->proced;
        $repuest    = $objeto ->repuest;
        $obsad      = $objeto ->obsad;

    }

    $plantilla='
        <header class="clearfix">
            <h2>FARMACIA VILLA LUZ</h2>
            <h2>Cra 3 #6-54</h2>
            <h2>NIT 1.074.557.664-1</h2>
        </header>

        <p>'.$idOrden.'</p>
        <p>'.$fechaOrd.'</p>
        <p>'.$placa.'</p>
        <p>'.$conduct.'</p>
        <p>'.$encargado.'</p>
        <p>'.$id_tipo_serv.'</p>
        <p>'.$obscliente.'</p>
        <p>'.$dgmec.'</p>
        <p>'.$proced.'</p>
        <p>'.$repuest.'</p>
        <p>'.$obsad.'</p>
    ';
    return $plantilla;
}