<?php

include 'conexion.php';

class Tvehiculo{

    var $objetos;

    public function __construct(){
        $bd = new Conexion;
        $this->acceso = $bd->pdo;
    }

    function crearTvehiculo($nom_tVeh){
        $sql = "SELECT nom_tVeh FROM Tvehiculo WHERE nom_tVeh = :nom_tVeh";
        $query = $this->acceso->prepare($sql);
        $query->execute([
            'nom_tVeh' => $nom_tVeh
        ]);
        $this->objetos = $query->fetchall();

        if(empty($this->objetos)){
            $sql = "INSERT INTO Tvehiculo(nom_tVeh) VALUES (:nom_tVeh)";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                'nom_tVeh' => $nom_tVeh
            ]);
            echo 'add';
        }else{
            echo 'noadd';
        }

    }

    function cargarTvehiculos(){

        if(!empty($_POST['consulta'])){
            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM tvehiculo WHERE nom_tveh LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM tvehiculo WHERE nom_tveh NOT LIKE '' ORDER BY id_tveh";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }


    }

    function editarTvehiculo($id, $nom_tVeh){
        $sql="SELECT nom_tveh FROM tvehiculo WHERE nom_tveh = :nom_tveh";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nom_tveh' => $nom_tVeh]);
        $this->objetos = $query->fetchall();

        if(!empty($this->objetos)){
            echo "noedit";
        }else if(empty($this->objetos)){
            $sql = "UPDATE tvehiculo SET nom_tveh = :nom_tveh WHERE id_tveh = :id_tveh";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                'nom_tveh' => $nom_tVeh,
                'id_tveh' => $id
            ]);
            echo "edit";
        }
    }

    function borrarTveh($id_tVeh){
        $sql = "DELETE FROM tvehiculo WHERE id_tVeh=:id_tVeh";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_tVeh' => $id_tVeh));

        if(!empty($query->execute(array(':id_tVeh' => $id_tVeh)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }

    function listarTvehiculos(){
        $sql="SELECT * FROM tvehiculo ORDER BY nom_tveh ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }


}