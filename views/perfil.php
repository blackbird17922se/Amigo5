<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
?>

<!-- modal cambiar nombre -->
<div class="modal fade" id="editarPerfil" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="card-title">Cambiar nombre de perfil</h3>
                </div>
                <div class="card-body">

                    <form id="form_edit_usu">

                        <input type="hidden" id="id_usuario" value="<?php echo $_SESSION['idUsu'] ?>">

                        <div class="form-group">
                            <label for="nombre">Ingrese su nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" required>
                        </div>

                        <div class="form-group">
                            <label for="apellido">Ingrese su apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" aria-describedby="apellidoHelp" required>
                        </div>
                </div>
                <div class="card-footer botModal">
                    <button type="submit" class="btn-lh btn-lh-azul">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn-lh btn-lh-gris">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal cambiar pass -->
<div class="modal fade" id="mod_pass" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="card-title">Cambiar contraseña</h3>
                </div>
                <div class="card-body">

                    <form id="form_edit_pass">
                    
                        <div class="form-group">
                            <label for="passActual">Escriba su contraseña actual</label>
                            <input type="password" class="form-control" id="passActual" name="passActual" aria-describedby="passActualHelp" required>
                        </div>

                        <div class="form-group">
                            <label for="passNuevo">Escriba su nueva contraseña</label>
                            <input type="password" class="form-control" id="passNuevo" name="passNuevo" aria-describedby="passNuevoHelp" required>
                        </div>

                        <div class="form-group">
                            <label for="passNuevoConfirm">Escriba su contraseña nuevamente para confirmar</label>
                            <input type="password" class="form-control" id="passNuevoConfirm" name="passNuevoConfirm" aria-describedby="passNuevoConfirmHelp" required>
                        </div>
                        

                        <!-- ALERTAS -->
                        <div class="alert alert-success text-center" id="alert_edit_pass" style="display: none;">
                            <span><i class="fa fa-check"></i> Contraseña cambiada exitosamente.</span>
                        </div>

                        <div class="alert alert-danger text-center" id="alert_noedit_pass" style="display: none;">
                            <span><i class="fa fa-times"></i> La contraseña ingresada es incorrecta. Por favor reingrese su contraseña actual.</span>
                        </div>
                        <div class="alert alert-danger text-center" id="alert_noCoincid_pass" style="display: none;">
                            <span><i class="fa fa-times"></i> Las contraseñas ingresadas no coinciden. Por favor reingrese la contraseña en ambos campos.</span>
                        </div>
                </div>
                <div class="card-footer botModal">
                    <button type="submit" class="btn-lh btn-lh-azul">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn-lh btn-lh-gris">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal cambiar imagen avatar -->
<div class="modal fade" id="mod_avatar" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="card-title">Cambiar imagen</h3>
                </div>
                <div class="card-body">

                    <form id="form_edit_avatar" enctype="multipart/form-data">

                        <h3 class="card-body-title">Elige una nueva imagen para tu perfil</h3>

                        <input type="file" name="foto" class="form-control" accept=".jpg, .png, .jpeg, .bmp">
                        <input type="hidden" name="funcion" value="cambiarFoto">
                        
                        <!-- ALERTAS --> 
                        <div class="alert alert-danger text-center" id="alert_noedit_avatar" style="display: none;">
                            <span><i class="fa fa-times"></i> No se pude editar la foto actual.</span>
                        </div>
              
                </div>
                <div class="card-footer botModal">
                    <button type="submit" class="btn-lh btn-lh-azul">Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn-lh btn-lh-gris">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    
<div class="container" id="cont-seccion">
    <div class="row">
        <div class="col-md-6">
            <h1>¿Qué deseas hacer en tu perfil?</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <ul class="menuPerfil">
                <li><a data-toggle="modal" id="op_nombre" data-target="#editarPerfil" href=""> <i class="fa fa-external-link-square text-success sub-icon-mg"></i> Cambiar mi nombre</a></li>
                <li><a data-toggle="modal" id="op_pass" data-target="#mod_pass" href=""> <i class="fa fa-external-link-square text-success sub-icon-mg"></i> Cambiar mi contraseña</a></li>
                <li><a data-toggle="modal" id="op_avatar" data-target="#mod_avatar" href=""> <i class="fa fa-external-link-square text-success sub-icon-mg"></i> Cambiar mi imagen</a></li>
            </ul>
        </div>

        <div class="col-md-6 infoPerfil">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <img id="avatarVerPerfil" src="" alt="">
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 ">
                <ul>
                    <li id="nomUsuario" style="font-weight: 700;">Nombre Usuario</li>
                    <li id="cargo">Cargo</li>
                    <li id="identificacion">Identificacion</li>
                </ul>

            </div>

        </div>
    </div>
</div>
  
<!-- <script src="../public/plugins/jquery/jquery.min.js"></script> -->

<?php
    include './layouts/scripts.php';
}else{
    session_destroy();
    header('Location: ../');
}
?>
<script src="../public/js/usuario.js"></script>
