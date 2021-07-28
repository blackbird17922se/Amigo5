<?php
include 'conexion.php';

class Usuario{
    var $objetos;

    public function __construct(){
        $bd = new Conexion();
        $this->acceso = $bd->pdo;
    }

    function obtenerDatos($id){
        $sql = "SELECT * FROM usuario WHERE identificacion = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id
        ));
        /* fetchallbuscara TODAS las coincidencias de la consulta */
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function editarPerfil($id, $nombre, $apellido){
        $sql = "UPDATE usuario SET nombre = :nombre, apellido = :apellido WHERE identificacion = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id'      => $id,
            'nombre'   => $nombre,
            'apellido' => $apellido
        ));
        // $this->objetos = $query->fetchall();
    }

    function cambiarPass($passActual, $passNuevo, $id){
        $sql = "SELECT pass FROM usuario WHERE identificacion = :id AND pass = :passActual";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':passActual' => $passActual,
            ':id' => $id
        ));
        $this->objetos = $query->fetchall();

        if(!empty($this->objetos)){
            $sql = "UPDATE usuario SET pass = :passNuevo WHERE identificacion = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':passNuevo' => $passNuevo,
                ':id' => $id
            ));
            echo true;
        }else{
            echo false;
        }
    }

    function cambiarFoto($id, $nombreImg){
        /* Cuando un usuaro actualia su imagen, eliminarla de las carpetas */
        $sql = "SELECT foto FROM usuario WHERE identificacion = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id
        ));

        /* Contendra la url de la foto antigua: */
        $this->objetos = $query->fetchall();

        /* Actualiar url foto */
        $sql = "UPDATE usuario SET foto = :nombreImg WHERE identificacion = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':nombreImg' => $nombreImg,
            ':id' => $id
        ));
        return $this->objetos;
    }



    function buscar(){
            $usu_actual = $_SESSION['idUsu'];
        if(!empty($_POST['consulta'])){
            



            $consulta = $_POST['consulta'];
            $sql="SELECT * FROM usuario WHERE nombre LIKE :consulta AND identificacion != :usu_actual";
            $query = $this->acceso->prepare($sql);
            /* %% Pasa  la variable $consulta como una cadena al LIKE */
            $query->execute(array(
                ':consulta'=>"%$consulta%",
                ':usu_actual' => $usu_actual
                ));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql = "SELECT * FROM usuario WHERE nombre NOT LIKE '' AND identificacion != :usu_actual ORDER BY nombre";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':usu_actual' => $usu_actual));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

    function crearUsuario($nombre, $apellido, $id_usu, $pass, $cargo, $foto, $estado){
        /* Primero, consultar por la identificacion si el usuario ya existe */
        $sql = "SELECT identificacion FROM usuario WHERE identificacion = :id_usu";
        $query = $this->acceso->prepare($sql);
        $query->execute([ ':id_usu' => $id_usu]);
        $this->objetos = $query->fetchall();

        if(empty($this->objetos)){
            $sql = "INSERT INTO usuario(identificacion, nombre, apellido, cargo, estado, foto, pass) VALUES(:identificacion, :nombre, :apellido, :cargo, :estado, :foto, :pass)";
            $query = $this->acceso->prepare($sql);
            $query->execute([         
                ':identificacion' => $id_usu, 
                ':nombre'         => $nombre, 
                ':apellido'       => $apellido, 
                ':cargo'          => $cargo, 
                ':estado'         => $estado, 
                ':foto'           => $foto,
                ':pass'           => $pass   
            ]);
            echo 'add';

        }else{
            echo 'noadd';
        }

    }

    function borrar($id){
        $sql = "DELETE FROM usuario WHERE identificacion = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));

        if(!empty($query->execute(array(':id' => $id)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }

}