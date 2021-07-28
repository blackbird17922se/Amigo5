<?php
include 'conexion.php';

class Mecanico{

    var $objetos;

    public function __construct(){
        $bd = new Conexion();
        $this->acceso = $bd->pdo;
    }

    function crearMecanico($id_mec, $nombre, $apellido, $telef, $esp_mec, $estado){
        $sql = "SELECT identificacion FROM mecanicos WHERE identificacion = :id_mec";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id_mec'   => $id_mec]);
        $this->objetos = $query->fetchall();

        if(empty($this->objetos)){
            $sql = "INSERT INTO mecanicos(identificacion, nombre, apellido, telefono, especialidad, estado) 
            VALUES(:id_mec, :nombre, :apellido, :telef, :esp_mec, :estado)";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                ':id_mec'   => $id_mec, 
                ':nombre'   => $nombre, 
                ':apellido' => $apellido, 
                ':telef'    => $telef, 
                ':esp_mec'  => $esp_mec, 
                ':estado'   => $estado
            ]);
            echo 'add';
        }else{
            echo 'noadd';
        }
    }    

    function cargarMecanico(){
        if(!empty($_POST['consulta'])){
            $consulta = $_POST['consulta'];

            $sql = "SELECT * FROM mecanicos WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute([':consulta'=>"%$consulta%"]);
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM mecanicos ORDER BY nombre";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }


    function editarMecanico($id_mec, $nombre, $apellido, $telef, $esp_mec, $estado){
        $sql = "UPDATE mecanicos SET nombre=:nombre, apellido=:apellido, telefono=:telef,
        especialidad =:esp_mec, estado=:estado WHERE identificacion = :id_mec";
        $query = $this->acceso->prepare($sql);
        $query->execute([
            ':id_mec'   => $id_mec, 
            ':nombre'   => $nombre, 
            ':apellido' => $apellido, 
            ':telef'    => $telef, 
            ':esp_mec'  => $esp_mec, 
            ':estado'   => $estado
        ]);
        echo 'edit';


    }


    function borrarMecanico($id_mec){
        $sql = "DELETE FROM mecanicos WHERE identificacion=:id_mec";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id_mec' => $id_mec]);

        if(!empty($query->execute([':id_mec' => $id_mec]))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }

    function listarMecanicos(){
        $sql='SELECT * FROM mecanicos WHERE estado="activo" ORDER BY nombre ASC';
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}