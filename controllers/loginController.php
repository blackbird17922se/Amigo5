<?php
include_once '../models/sesion.php';

session_start();
$idUsu = $_POST['idUsu'];
$pass   = $_POST['pass'];

echo "holla";
echo $idUsu.$pass;

$sesion = new Sesion();

$sesion->logIn($idUsu, $pass);

/* 
 * Si existe una sesion en curso y se esta reintentando ingresar al 
 * login, entonces redireccionar al main. de lo contrario... 
*/
if(!empty($_SESSION['rol'])){
    header('Location: ../views/ord_veh.php');
}else{
    /* si en la consulta a la base de datos se encntro coincidencia de usuario y pas.. entonces.. */
    if(!empty($sesion->objetos)){
        foreach($sesion->objetos as $objeto){
            $_SESSION['idUsu']  = $objeto->identificacion;
            $_SESSION['rol']    = $objeto->cargo;
            $_SESSION['nomUsu'] = $objeto->nombre;
            $_SESSION['nomFotoPerfil'] = $objeto->foto;
        }
        header('Location: ../views/ord_veh.php');
    }else{
    
        header('Location: ../');
    }

}

foreach($sesion->objetos as $objeto){
   print_r($objeto);
}