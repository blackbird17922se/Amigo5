<?php

include 'conexion.php';

class Orden{

    var $objetos;

    public function __construct()
    {
        $bd = new Conexion;
        $this->acceso = $bd->pdo;
    }

    function asignarOrden($placa, $conduct, $encargado, $tipo_serv, $obscliente, $dgmec, $proced, $repuest, $obsad){
        $sql="INSERT INTO orden (placa, conductor, tipo_serv, observ_cliente, encargado, dgmec, 
        proced, repuest, obsad)
        VALUES(:placa, :conduct, :tipo_serv, :obscliente, :encargado, 
        :dgmec, :proced, :repuest, :obsad)";
        $query = $this->acceso->prepare($sql);
        $query->execute([
            'placa'          => $placa, 
            'conduct'      => $conduct,    
            'encargado'      => $encargado,    
            'tipo_serv'      => $tipo_serv, 
            'obscliente' => $obscliente, 
            'dgmec'          => $dgmec, 
            'proced'         => $proced, 
            'repuest'        => $repuest, 
            'obsad'          => $obsad
            // 'pendientes'     => $pendientes 
            
        ]);
        echo "add orden";
    }


    function listarOrdenes(){
        $sql = "SELECT * FROM orden ORDER BY id_orden";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;    
    }

    function cargarOrdenesVehiculoX($id){
        $sql = "SELECT * FROM orden WHERE placa = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id' => $id]);
        $this->objetos=$query->fetchall();
        return $this->objetos;  
    }

    function listarServicios($sr){
        $sql="SELECT nom_serv FROM servicio WHERE id_serv = :sr";
        $query = $this->acceso->prepare($sql);
        $query->execute([":sr" => $sr]);
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }

    function obtenerServicios($id){
        $sql="SELECT tipo_serv FROM orden WHERE id_orden = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute([":id" => $id]);
        $this->objetos=$query->fetchall();
        return $this->objetos;



    }

    function borrarOrden($idOrden){
        $sql = "DELETE FROM orden WHERE id_orden = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $idOrden));

        if(!empty($query->execute(array(':id' => $idOrden)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }

    }

    function obtenerOrden($idOrden){
        $sql = "SELECT * FROM orden WHERE id_orden = :idOrden";
        $query = $this->acceso->prepare($sql);
        $query->execute([':idOrden' => $idOrden]);
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function obtenerMecanico($id){
        $sql = "SELECT CONCAT(mecanicos.nombre,' ', mecanicos.apellido) AS nom_comp_encargado FROM mecanicos WHERE identificacion = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id' => $id]);
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }


    function editarOrden($idOrden,$conduct,$encargado,$serv,$obscliente,$dgmec,$proced,$repuest,$obsad){
        $sql = "UPDATE orden SET
        conductor = :conduct,
        encargado = :encargado,
        tipo_serv = :serv,
        observ_cliente = :obscliente,
        dgmec = :dgmec,
        proced = :proced,
        repuest = :repuest,
        obsad = :obsad
        WHERE id_orden = :id";

        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id'         => $idOrden,
            ':conduct'    => $conduct,
            ':encargado'  => $encargado,
            ':serv'       => $serv,
            ':obscliente' => $obscliente,
            ':dgmec'      => $dgmec,
            ':proced'     => $proced,
            ':repuest'    => $repuest,
            ':obsad'      => $obsad
        ));
        echo "edit";
    }

}