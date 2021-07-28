<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
?> 
<link rel="stylesheet" href="../public/css/atributos_mod.css">  
    
        <!-- MODALS -->
        <!-- modal nuevo VEHICULO -->
        <div class="modal fade" id="mod_n_tVeh" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="card-header">
                            <button data-dismiss="modal" aria-label="close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="card-title">Gestionar Tipo de Vehículo</h3>
                        </div>
                        <div class="card-body">

                            <form id="form_crear_tVeh">
                   
                                <input type="hidden"  id="id_edit_tVeh" class="form-control" value="">
                            
                                <div class="form-group">
                                    <label for="nom_tVeh">Nombre del tipo de vehículo</label>
                                    <input type="text" class="form-control" id="nom_tVeh" required >
                                </div>


                                <!-- ALERTAS -->
                                <div class="alert alert-success text-center" id="alert_add_tVeh" style="display: none;">
                                    <span><i class="fa fa-check"></i> Tipo de vehículo creado exitosamente.</span>
                                </div>

                                <div class="alert alert-success text-center" id="alert_ed_tVeh" style="display: none;">
                                    <span><i class="fa fa-check"></i> Tipo de vehículo editado exitosamente.</span>
                                </div>

                                <div class="alert alert-danger text-center" id="alert_noadd_tVeh" style="display: none;">
                                    <span><i class="fa fa-times"></i> El Tipo de vehículo ya se encuentra registrado..</span>
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

        <!-- modal nuevo serv -->
        <div class="modal fade" id="mod_n_serv" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="card-header">
                            <button data-dismiss="modal" aria-label="close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="card-title">Nuevo Servicio</h3>
                        </div>
                        <div class="card-body">

                            <form id="form_crear_serv">

                                <input type="hidden"  id="id_edit_tServ" class="form-control" value="">

                                <div class="form-group">
                                    <label for="nom_serv">Nombre del servicio</label>
                                    <input type="text" class="form-control" id="nom_serv" required >
                                </div>


                                <!-- ALERTAS -->
                                <div class="alert alert-success text-center" id="alert_add_serv" style="display: none;">
                                    <span><i class="fa fa-check"></i> Servicio creado exitosamente.</span>
                                </div>

                                <div class="alert alert-success text-center" id="alert_ed_serv" style="display: none;">
                                    <span><i class="fa fa-check"></i> Servicio editado exitosamente.</span>
                                </div>

                                <div class="alert alert-danger text-center" id="alert_noadd_serv" style="display: none;">
                                    <span><i class="fa fa-times"></i> El servicio ya se encuentra registrado..</span>
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
            <div class="container-fluid" id="optionBarServ">
                <div class="row">
                    <div id="cont-options" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list single-page-breadcome">
                            
                            <div class="row">
                                <div class="col-lg-5 col-md-0 col-sm-1 col-xs-12">
                                    <h1 class="tit-optionBar">Gestión de Atributos</h1>
                                    <p class="ds-optionBar">Gestione los atributos como los tipos de vehículos y servicios con los cuales trabaja, estos apareceran al momento de registrar una orden de trabajo</p>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        
                                        <ul class="nav navbar-nav mai-top-nav">
                                            <li><a data-toggle="modal" id="op_n_tVeh" data-target="#mod_n_tVeh" href="" class="btn-opt"><i class="fas fa-truck" aria-hidden="true"></i> Nuevo Tipo de Vehículo</a></li>
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


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a id="nav-l-veh" href="#tVeh" class="nav-link active" data-toggle="tab"> Tipos de Vehículos</a></li>
                            <li class="nav-item"><a id="nav-l-serv" href="#tServ" class="nav-link" data-toggle="tab">Tipos de Servicios</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">

                        <!-- panel Vehículo -->
                            <div class="tab-pane active" id="tVeh">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar Vehículo</div>
                                        <div class="input-group">
                                            <input id="busq-tVeh" type="text" class="form-control float-left" placeholder="Ingrese nombre del tipo de vehículo">
                                            <!-- <div class="input-group-append">
                                                <buttom class="btn btn-default"><i class="fa fa-search"></i></buttom>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                        <table class="table table-hover text-nowrap">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-active" id="tabla_tVeh">

                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>

                            <!-- panel tipo -->
                            <div class="tab-pane" id="tServ">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar servicio</div>
                                        <div class="input-group">
                                            <input id="busq-serv" type="text" class="form-control float-left" placeholder="Ingrese nombre del tipo de servicio">
                                            <!-- <div class="input-group-append">
                                                <buttom class="btn btn-default"><i class="fa fa-search"></i></buttom>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                        <table class="table table-hover text-nowrap">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-active" id="tabla_tServ">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    
</div>

    <?php
    include './layouts/scripts.php';
}else{
    session_destroy();
    header('Location: ../');
}
?>
<script src="../public/js/tVehiculos.js"></script>
<script src="../public/js/tServicios.js"></script>