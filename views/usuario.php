<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
?>    
    
    <!-- MODALS -->
    <!-- modal nuevo usuario -->
    <div class="modal fade" id="mod_n_usuario" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="card-title">Gestion de usuarios</h3>
                    </div>
                    <div class="card-body">

                        <form id="form_crear_usu">

                            <!-- <input type="hidden" id="id_usuario" value="<?php echo $_SESSION['idUsu'] ?>"> -->

                            <div class="form-group">
                                <label for="id_usu">Identificación</label>
                                <input type="number" class="form-control" name="id_usu" id="id_usu" required >
                                <small id="id_usuHelp" class="form-text text-muted">Diligencie el numero de identificación del usuario</small>
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" required>
                                <small id="nombreHelp" class="form-text text-muted">Diligencie el nombre del usuario</small>

                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" aria-describedby="apellidoHelp" required>
                                <small id="apellidoHelp" class="form-text text-muted">Diligencie los apellidos del usuario</small>

                            </div>

                            <div class="form-group">
                                <label for="pass">Asigne una contraseña</label>
                                <input type="password" class="form-control" id="pass" name="pass" aria-describedby="passHelp" required>
                                <small id="apellidoHelp" class="form-text text-muted">Asigne una contraseña al usuario</small>

                            </div>

                            <div id="" name="cargo" class="form-group">
                                <label for="cargo">Cargo</label>
                                <select id="cargo" name="cargo" class="form-control"required >
                                    <option>Seleccionar</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="supervisor">Supervisor</option>
                                    
                                </select>
                                <small id="cargopHelp" class="form-text text-muted">Diligencie el cargo a desempeñar el usuario</small>
                            </div>

                                    <!-- ALERTAS -->
                            <div class="alert alert-success text-center" id="alert_add_usu" style="display: none;">
                                <span><i class="fa fa-check"></i> Usuario creado exitosamente.</span>
                            </div>

                            <div class="alert alert-danger text-center" id="alert_noadd_usu" style="display: none;">
                                <span><i class="fa fa-times"></i> El usuario ingresado ya existe.</span>
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

    <div class="breadcome-area">
            <div class="container-fluid" id="optionBarUsu">
                <div class="row">
                    <div id="cont-options" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list single-page-breadcome">
                            
                            <div class="row">
                                <div class="col-lg-5 col-md-0 col-sm-1 col-xs-12">
                                    <h1 class="tit-optionBar" style="color: white;">Usuarios</h1>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        <ul class="nav navbar-nav mai-top-nav">
                                            <li><a data-toggle="modal" id="op_n_usuario" data-target="#mod_n_usuario" href="" class="btn-opt"><i class="fa fa-user" aria-hidden="true"></i> Nuevo Usuario</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO -->
    <div class="single-product-tab-area mg-tb-15">
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Buscar usuario</h3>
                        <div class="input-group">
                            <input id="buscar-usuario" type="text" class="form-control float-left" placeholder="Ingrese el nombre del usuario">
                            <div class="input-group-append">
                                <buttom class="btn btn-default"><i class="fa fa-search"></i></buttom>
                            </div>
                        </div>
                    </div>

                    <!-- CARD BODY QUE CONTENDRA USUARIOS 
                    LOS CARGA JAVASCRIPT-->
                    <div class="card-body">
                        <div id="cb-usuarios" class="row d-flex align-items-stretch">
                        </div> 
                    </div>

                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>

    <?php
    include './layouts/scripts.php';
}else{
    session_destroy();
    header('Location: ../');
}
?>
<script src="../public/js/gestion_usuario.js"></script>