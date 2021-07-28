<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
    include './layouts/body.php';
    include './layouts/scripts.php';
}else{
    session_destroy();
    header('Location: ../');
}