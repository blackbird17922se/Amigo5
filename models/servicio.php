<?php

include 'conexion.php';

class Servicio{

    var $objetos;

    public function __construct(){
        $bd = new Conexion;
        $this->acceso = $bd->pdo;
    }

    function crearServicio($nom_serv){
        $sql = "SELECT nom_serv FROM servicio WHERE nom_serv = :nom_serv";
        $query = $this->acceso->prepare($sql);
        $query->execute([
            'nom_serv' => $nom_serv
        ]);
        $this->objetos = $query->fetchall();

        if(empty($this->objetos)){
            $sql = "INSERT INTO servicio(nom_serv) VALUES (:nom_serv)";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                'nom_serv' => $nom_serv
            ]);
            echo 'add';
        }else{
            echo 'noadd';
        }

    }

    function cargarTservicios(){

        if(!empty($_POST['consulta'])){
            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM servicio WHERE nom_serv LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM servicio WHERE nom_serv NOT LIKE '' ORDER BY id_serv";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }


    }

    function editarTservicio($id, $nom_serv){
        $sql="SELECT nom_serv FROM servicio WHERE nom_serv = :nom_serv";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nom_serv' => $nom_serv]);
        $this->objetos = $query->fetchall();

        if(!empty($this->objetos)){
            echo "noedit";
        }else if(empty($this->objetos)){
            $sql = "UPDATE servicio SET nom_serv = :nom_serv WHERE id_serv = :id_serv";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                'nom_serv' => $nom_serv,
                'id_serv' => $id
            ]);
            echo "edit";
        }
    }

    function borrarServicio($id_serv){
        $sql = "DELETE FROM servicio WHERE id_serv=:id_serv";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_serv' => $id_serv));

        if(!empty($query->execute(array(':id_serv' => $id_serv)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }

    function listarServicios(){
        $sql="SELECT * FROM servicio ORDER BY nom_serv ASC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}