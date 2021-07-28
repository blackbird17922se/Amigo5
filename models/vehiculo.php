<?php
include 'conexion.php';

class Vehiculo{

    var $objetos;

    public function __construct(){
        $bd = new Conexion();
        $this->acceso = $bd->pdo;
    }

    function crearVehiculo($cliente, $email, $marca, $telef, $placa, $refer, $modelo, $tipo, $color){
        $sql = "SELECT placa FROM vehiculos WHERE placa = :placa";
        $query = $this->acceso->prepare($sql);
        $query->execute([':placa'   => $placa]);
        $this->objetos = $query->fetchall();

        if(empty($this->objetos)){
            $sql = "INSERT INTO vehiculos(placa, nom_conduct, email, telef1, marca, refer, modelo, tipo, color) 
            VALUES(:placa, :cliente, :email, :telef, :marca, :refer, :modelo, :tipo, :color)";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                ':placa'   => $placa, 
                ':cliente'   => $cliente, 
                ':email' => $email, 
                ':telef'    => $telef, 
                ':marca'  => $marca, 
                ':refer'   => $refer,
                ':modelo'   => $modelo,
                ':tipo'   => $tipo,
                ':color'   => $color,
            ]);
            echo 'add';
        }else{
            echo 'noadd';
        }
    } 
    
    function cargarVehiculos(){
        $sql = "SELECT * FROM vehiculos";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }


    function editarVehiculo($id_mec, $cliente, $email, $telef, $marca, $refer){
        $sql = "UPDATE vehiculos SET cliente=:cliente, email=:email, telef1=:telef,
        marca =:marca, refer=:refer WHERE identificacion = :id_mec";
        $query = $this->acceso->prepare($sql);
        $query->execute([
            ':id_mec'   => $id_mec, 
            ':cliente'   => $cliente, 
            ':email' => $email, 
            ':telef'    => $telef, 
            ':marca'  => $marca, 
            ':refer'   => $refer
        ]);
        echo 'edit';


    }


    function borrarVehiculo($id_mec){
        $sql = "DELETE FROM vehiculos WHERE identificacion=:id_mec";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id_mec' => $id_mec]);

        if(!empty($query->execute([':id_mec' => $id_mec]))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }

    /* Lista todos los vehiculos por placa */
    /* Util para cuando se desea asignar la orden a un vehiculo existente */
    function listarVehiculos(){
        $sql = "SELECT placa FROM vehiculos";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /* Consultar el tipo de vehiculo por id, muy usada al momento de 
    mostrar todos los vehiculos para cargar el nombre, no el id del tipo de veh */
    function obtenerTvehiculo($id){
        $sql = "SELECT nom_tveh FROM tvehiculo WHERE id_tveh = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id' => $id]);
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /* Usese para consultar los datos de X vehiculo por matricula */
    function cargarDatosVehX($matr){
        $sql = "SELECT * FROM vehiculos WHERE placa = :matr";
        $query = $this->acceso->prepare($sql);
        $query->execute([':matr' => $matr]);
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}