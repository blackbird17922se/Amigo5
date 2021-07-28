<?php
session_start();
if(!empty($_SESSION['rol'])){
    header('Location: controllers/loginController.php');
}else{
    session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="public/css/bootstrap.min.css">

    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/style2.css">

    <!-- font awess -->
    <!-- <link rel="stylesheet" href="public/css/css/all.min.css"> -->
</head>



<body id="body-login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12 cont-logo">
                <img  width="200px" height="150px"  src="public/img/logo.png" alt="logo de amigo">
            </div>
        </div>
    </div>
        

    <div class="row">
        <div class="col-lg-4 col-lg-offset-7 col-md-offset-2 col-md-8 col-sm-12">
            <div class="cont-frm-log">
                <h1>INICIAR SESIÓN</h1>
                <form action="controllers/loginController.php" method="POST">
                    <div class="form-group">
                        <label class="control-label" for="idUsu">Identificación del Usuario</label>                            
                        <input type="number" placeholder="12345678" title="Escriba el nombre de usuario con el cual se registró en amigo" name="idUsu" id="idUsu" class="form-control input" required>               
                        <span class="help-block small">Ingrese su numero con el cual se registro</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pass">CONTRASEÑA</label>                      
                        <input type="password" title="Ingrese su contraseña" placeholder="******" value="" name="pass" id="pass" class="form-control input" required>
                        <span class="help-block small">Escriba su contraseña</span>
                        <!-- <input type="hidden" name="auth" value="auth"/> -->
                    </div>
                    <!-- <button class="btn btn-success btn-block loginbtn">Ingresar</button> -->
                    <input type="submit" class="btn" value="iniciar sesion">

                </form>
            </div>
        </div>
    </div> 

</body>
<script src="./public/js/login.js"></script>
</html>
<?php
}
?>