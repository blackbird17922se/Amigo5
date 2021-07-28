<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
?>    
    
    <!-- MODALS -->
    <!-- modal nuevo mecanico -->
    <div class="modal fade" id="mod_n_mecanico" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="card-title">Nuevo mecánico</h3>
                    </div>
                    <div class="card-body">

                        <form id="form_crear_mecanico">

                            <div class="form-group">
                                <label id="lab_id_mec" for="id_mec">Numero de identificación del mecánico</label>
                                <input type="number" class="form-control" name="id_mec" id="id_mec" placeholder="Ej: 107000000" required >
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombres</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Luis Felipe" required >
                            </div>

                            <div class="form-group">
                                <label for="apellido">Apellidos</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Ej: Agudelo Restrepo" required >
                            </div>

                            <div class="form-group">
                                <label for="telef">Número Telefónico</label>
                                <input type="number" name="telef" id="telef" class="form-control" placeholder="Ej: 304123456" required >
                            </div>
            
                            <div class="form-group">
                                <label for="esp_mec">Especialidad del mecánico</label>
                                <select id="esp_mec" class="form-control" required >
                                    <option value="">Seleccione...</option>
                                    <option value="electricidad">Electricidad</option>
                                    <option value="transmision">Transmisión</option>
                                </select>
                            </div>

                            <input type="hidden" id="estado">

                            <!-- ALERTAS -->
                            <div class="alert alert-success text-center" id="alert_add_mec" style="display: none;">
                                <span><i class="fa fa-check"></i> Registro exitoso.</span>
                            </div>

                            <div class="alert alert-danger text-center" id="alert_noadd_mec" style="display: none;">
                                <span><i class="fa fa-times"></i> La identificación del mecánico ya se encuentra registrada.</span>
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

    <!-- modal EDITAR mecanico -->
    <div class="modal fade" id="mod_edit_mecanico" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="card-title">Editar mecánico</h3>
                    </div>
                    <div class="card-body">

                        <form id="form_edit_mecanico">

                            <input type="hidden" id="id_mec_edit" value="">

                            <div class="form-group">
                                <label for="nombre_ed">Nombres</label>
                                <input type="text"  id="nombre_ed" class="form-control" placeholder="Ej: Luis Felipe" required >
                            </div>

                            <div class="form-group">
                                <label for="apellido_ed">Apellidos</label>
                                <input type="text" name="apellido_ed" id="apellido_ed" class="form-control" placeholder="Ej: Agudelo Restrepo" required >
                            </div>

                            <div class="form-group">
                                <label for="telef_ed">Número Telefónico</label>
                                <input type="number" id="telef_ed" class="form-control" placeholder="Ej: 304123456" required >
                            </div>
            
                            <div class="form-group">
                                <label for="esp_mec_ed">Especialidad del mecánico</label>
                                <select id="esp_mec_ed" class="form-control" required >
                                    <option value="">Seleccione...</option>
                                    <option value="electricidad">Electricidad</option>
                                    <option value="transmision">Transmisión</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label id="lab_estado" for="estado_ed">Estado</label>
                                <select id="estado_ed" name="estado_ed" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                                <small id="estadopHelp" class="form-text text-muted">Estado en la aplicación</small>
                            </div>           

                            <!-- ALERTA -->
                            <div class="alert alert-success text-center" id="alert_edit_mec" style="display: none;">
                                <span><i class="fa fa-check"></i> Información del Mecánico editada.</span>
                            </div>

                            <div class="alert alert-danger text-center" id="alert_noedit_mec" style="display: none;">
                                <span><i class="fa fa-times"></i> Ha ocurrido un error fatal y no se ha podido completar la operación..</span>
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
            <div class="container-fluid" id="optionBarMec">
                <div class="row">
                    <div id="cont-options"class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list single-page-breadcome">
                            
                            <div class="row">
                                <div class="col-lg-5 col-md-0 col-sm-1 col-xs-12">
                                    <h1 class="tit-optionBar">Gestión Mecánicos</h1>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        <ul class="nav navbar-nav mai-top-nav">
                                            <li><a data-toggle="modal" id="op_n_mecanico" data-target="#mod_n_mecanico" href="" class="btn-opt"><i class="fa fa-wrench" aria-hidden="true"></i> Nuevo mecánico</a></li>
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
                        <h3 class="card-title">Buscar mecánico</h3>
                        <div class="input-group">
                            <input id="buscar_mecanico" type="text" class="form-control float-left" placeholder="Ingrese el nombre del usuario">
                            <div class="input-group-append">
                                <buttom class="btn btn-default"><i class="fa fa-search"></i></buttom>
                            </div>
                        </div>
                    </div>

                    <!-- CARD BODY QUE CONTENDRA USUARIOS 
                    LOS CARGA JAVASCRIPT-->
                    <div class="card-body">
                        <div id="cb_mecanico" class="row d-flex align-items-stretch">
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
<script src="../public/js/mecanico.js"></script>