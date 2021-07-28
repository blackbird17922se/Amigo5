<?php
/*
 * SESION.PHP
 * Este modulo se encarga de consultar en la bd al usuario
 * al momento de iniciar sesion.
 * Tambien destruye la sesion al salir de la misma
*/
include_once 'conexion.php';

class Sesion{
    var $objetos;
    public function __construct()
    {
        $bd = new Conexion();
        $this->acceso = $bd->pdo;
    }

    function logIn($idUsu, $pass){
        $sql = "SELECT * FROM usuario WHERE identificacion = :idUsu AND pass = :pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':idUsu' => $idUsu,
            ':pass' => $pass
        ));

        $this->objetos = $query->fetchall();
        // $objetos = $query->fetchall();

        return $this->objetos;


        // foreach($objetos as $objeto){
        //     /* Objeto->campo del password */
        //     $pasActual = $objeto->pass;
        // }

        // if(strpos($pasActual, '$2y$10$')===0){
        //     if(password_verify($pass, $pasActual)){
        //         return true;
        //     }
        // }else{
        //     if($pass == $pasActual){                
        //         return true;
        //     }
        // }

    }
}