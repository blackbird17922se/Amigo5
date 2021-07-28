<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
?> 
<link rel="stylesheet" href="../public/css/atributos_mod.css">  
    
        <!-- MODALS -->
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
                                    <h1 class="tit-optionBar">Tipos de servicios</h1>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        
                                        <ul class="nav navbar-nav mai-top-nav">
                                            <li><a data-toggle="modal" id="op_n_serv" data-target="#mod_n_serv" href="" class="btn-opt"><i class="fa fa-user" aria-hidden="true"></i> Nuevo Servicio</a></li>
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


        <div class="single-product-tab-area mg-tb-15">
            <div class="single-pro-review-area">
                <div class="container-fluid">
                    <div id="myTabContent" class="tab-content custom-product-edit">
                               <!-- OPCION 1 -->
                               <div class="product-tab-list tab-pane fade active in" id="ordenes">
                            <section class="tabla">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Servicios</h3>
                                    </div>

                                    <div class="card-body">
                                        <table id="tabla_serv" class="display table table-hover text-nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Acción</th>
                                                    <th>Nombre</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>              
                                    </div>

                                    <div class="card-footer">
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    
</div>

    <?php
    include './layouts/scripts.php';
}else{
    session_destroy();
    header('Location: ../');
}
?>
<script src="../public/js/datatables.js"></script>
<script src="../public/js/servicios.js"></script>