<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';
    include './layouts/header.php';
?> 

        <!-- MENU CONTEXTUAL -->
        <ul id="contextMenu" class="dropdown-menu" role="menu"  aria-labelledby="mnu">

            <li><a id="abrir" href="#">Abrir</a></li>
            <li><a id="pdfOrden" href="#">Generar PDF</a></li>
            <li role="presentation" class="divider"></li>

            <li><a id="editar" href="#">Editar</a></li>
            <li><a id="eliminar" href="#">Eliminar</a></li>
            <li role="presentation" class="divider"></li>

            <li><a id="cancelar" href="#">Cancelar</a></li>
        </ul>

        <!-- modal NUEVO VEHICULO -->
        <div class="modal fade" id="mod_n_veh" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="card-header">
                            <button data-dismiss="modal" aria-label="close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="card-title">Nuevo Vehículo</h3>
                        </div>
                        <div class="card-body">

                            <form id="form_crear_veh">

                                <div class="form-group">
                                    <label for="cliente">Nombres del cliente o empresa</label>
                                    <input type="text" class="form-control capit" name="cliente" id="cliente" placeholder="Ej: Pepe Sierra">
                                </div>

                                <div class="form-group">
                                    <label for="telef">Número de contacto</label>
                                    <input type="number" name="telef" id="telef" class="form-control" placeholder="Ej: 32000000">
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Ej: pepesierra@gmail.com">
                                </div>

                                <div class="form-group">
                                    <label for="placa">Placa del vehículo</label>
                                    <input type="text" id="placa" class="form-control upper" placeholder="Ej: afp69" required>
                                </div>

                                <div class="form-group">
                                    <label for="marca">Marca del vehículo</label>
                                    <input type="text" name="marca" id="marca" class="form-control capit" placeholder="Ej: Ford"  >
                                </div>

                                <div class="form-group">
                                    <label for="refer">Referencia o serie del vehículo</label>
                                    <input type="text" name="refer" id="refer" class="form-control capit" placeholder="Ej: F-150"  >
                                </div>

                                <div class="form-group">
                                    <label for="modelo">Modelo del vehículo</label>
                                    <input type="number" name="modelo" id="modelo" class="form-control" placeholder="Ej: 1999"  >
                                </div>

                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" name="color" id="color" class="form-control capit" placeholder="Ej: Verde Oliva"  >
                                </div>

                                <div class="form-group">
                                    <label for="tveh">*Tipo de Vehículo</label>
                                    <select id="tveh" class="tveh form-control select2" style="width: 100%;">
                                    </select>
                                </div>                          

                                <!-- ALERTAS -->
                                <div class="alert alert-danger text-center" id="alert_noadd_veh" style="display: none;">
                                    <span><i class="fas fa-times"></i> La matrícula del vehículo ya se encuentra registrada..</span>
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

        <!-- modal NUEVA ORDEN -->
        <div class="modal fade js-example-basic-single" id="mod_n_orden" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="card-header">
                            <button data-dismiss="modal" aria-label="close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="card-title">Nueva Orden</h3>
                        </div>
                        <div class="card-body">

                            <form id="form_crear_orden">

                                <div class="form-group">
                                    <h4>Matrícula: <span id="pholderMatr"></span></h4>
                                </div>

                                <div class="form-group">
                                    <label for="conduct">Nombre del conductor</label>
                                    <input type="text" class="form-control capit" id="conduct" placeholder="Ej: Pepe Sierra">
                                </div>

                                <div class="form-group">
                                    <label for="encargado">Mecánico Líder Encargado del Servicio</label>
                                    <select id="encargado" class="encargado form-control select2" style="width: 100%;" required>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Servicios a realizar</label>
                                    <select id="servicios" class="servicios select2-mult form-control" multiple="multiple" style="width: 100%;">
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="obscliente">Observaciones del Cliente</label>
                                    <textarea  class="form-control" id="obscliente" cols="30" rows="10" placeholder="Ej: El carro presenta un sonido extraño cuando arranco…"></textarea>
                                    <small id="obsclienteHelp" class="form-text text-muted">Ingrese las observaciones que el cliente indique</small>
                                </div>
                            
                        
                                <h3 class="text-center">Diagnostico del Mecanico</h3>
                                <p class="text-center">diligencie solo si el mecanico ya realizo el dignostico.</p>

                                <div class="form-group">
                                    <label for="dgmec">Observaciones de los Mecánicos</label>
                                    <textarea  class="form-control" name="dgmec" id="dgmec" cols="30" rows="10" placeholder="Ej: Al vehículo se le debe revisar el sistema de embrague"></textarea>
                                    <!-- <input type="text" class="form-control" name="dgmec" id="dgmec"  placeholder="Ej: Al vehículo jjse le debe revisar el sistema de embrague"> -->
                                    <small id="dgmecHelp" class="form-text text-muted">Ingrese las observaciones indicadas por los mecánicos</small>
                                </div>


                                <!-- PROCEDIMEINTOS -->

                                <h3 class="text-center">Procedimientos</h3>
                                <p class="text-center">diligencie solo cuando se le halla efectuado los respectivos procedimientos.</p>

                                <div class="form-group">
                                    <label for="proced">Procedimientos realizados</label>
                                    <textarea  class="form-control" name="proced" id="proced" cols="30" rows="10" placeholder="Ej: Al vehículo se le debe revisar el sistema de embrague"></textarea>
                                    <small id="procedHelp" class="form-text text-muted">Ingrese las observaciones indicadas por los mecánicos</small>
                                </div>

                                <div class="form-group">
                                    <label for="repuest">Repuestos</label>
                                    <textarea  class="form-control" name="repuest" id="repuest" cols="30" rows="10" placeholder="Ej: Chafaldrana"></textarea>
                                    <small id="repuestHelp" class="form-text text-muted">Ingrese los repuestos usados</small>
                                </div>

                                <div class="form-group">
                                    <label for="obsad">Observaciones adicionales</label>
                                    <textarea  class="form-control" name="obsad" id="obsad" cols="30" rows="10" placeholder="Ej: texto adicional"></textarea>
                                    <small id="obsadHelp" class="form-text text-muted">Ingrese las observaciones a considerar</small>
                                </div>


                                <!-- ALERTAS -->
                                <div class="alert alert-success text-center" id="alert_add_ord" style="display: none;">
                                    <span><i class="fa fa-check"></i> Orden registrada.</span>
                                </div>

                                <div class="alert alert-danger text-center" id="alert_noadd_ord" style="display: none;">
                                    <span><i class="fa fa-times"></i> Ocurrió un error fatal al registrar la orden.</span>
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

        <!-- modal ORDEN VEHICULO EVISTENTE -->
        <div class="modal fade js-example-basic-single" id="mod_orden_veh_exist" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="card-header">
                            <button data-dismiss="modal" aria-label="close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="card-title">Nueva Orden</h3>
                        </div>
                        <div class="card-body">

                            <form id="form_asignar_orden">

                                <div class="form-group">
                                    <label for="veh_asignado">Seleccione el vehículo a asignarle nueva orden</label>
                                    <select id="veh_asignado" class="veh_asignado form-control select2" style="width: 100%;" required>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="conduct">Nombre del conductor</label>
                                    <input type="text" class="form-control capit" id="as-conduct" placeholder="Ej: Pepe Sierra">
                                </div>

                                <div class="form-group">
                                    <label for="encargado">Mecánico Líder Encargado del Servicio</label>
                                    <select id="as-encargado" class="encargado form-control select2" style="width: 100%;" required>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Servicios a realizar</label>
                                    <select id="as-servicios" class="servicios select2-mult form-control" multiple="multiple" style="width: 100%;">
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="obscliente">Observaciones del Cliente</label>
                                    <textarea  class="form-control" id="as-obscliente" cols="30" rows="10" placeholder="Ej: El carro presenta un sonido extraño cuando arranco…"></textarea>
                                    <small id="obsclienteHelp" class="form-text text-muted">Ingrese las observaciones que el cliente indique</small>
                                </div>
                            
                        
                                <h3 class="text-center">Diagnostico del Mecanico</h3>
                                <p class="text-center">diligencie solo si el mecanico ya realizo el dignostico.</p>

                                <div class="form-group">
                                    <label for="dgmec">Observaciones de los Mecánicos</label>
                                    <textarea  class="form-control" name="dgmec" id="as-dgmec" cols="30" rows="10" placeholder="Ej: Al vehículo se le debe revisar el sistema de embrague"></textarea>
                                    <!-- <input type="text" class="form-control" name="dgmec" id="dgmec"  placeholder="Ej: Al vehículo jjse le debe revisar el sistema de embrague"> -->
                                    <small id="dgmecHelp" class="form-text text-muted">Ingrese las observaciones indicadas por los mecánicos</small>
                                </div>


                                <!-- PROCEDIMEINTOS -->

                                <h3 class="text-center">Procedimientos</h3>
                                <p class="text-center">diligencie solo cuando se le halla efectuado los respectivos procedimientos.</p>

                                <div class="form-group">
                                    <label for="proced">Procedimientos realizados</label>
                                    <textarea  class="form-control" name="proced" id="as-proced" cols="30" rows="10" placeholder="Ej: Al vehículo se le debe revisar el sistema de embrague"></textarea>
                                    <small id="procedHelp" class="form-text text-muted">Ingrese las observaciones indicadas por los mecánicos</small>
                                </div>

                                <div class="form-group">
                                    <label for="repuest">Repuestos</label>
                                    <textarea  class="form-control" name="repuest" id="as-repuest" cols="30" rows="10" placeholder="Ej: Chafaldrana"></textarea>
                                    <small id="repuestHelp" class="form-text text-muted">Ingrese los repuestos usados</small>
                                </div>

                                <div class="form-group">
                                    <label for="obsad">Observaciones adicionales</label>
                                    <textarea  class="form-control" name="obsad" id="as-obsad" cols="30" rows="10" placeholder="Ej: texto adicional"></textarea>
                                    <small id="obsadHelp" class="form-text text-muted">Ingrese las observaciones a considerar</small>
                                </div>


                                <!-- ALERTAS -->
                                <div class="alert alert-success text-center" id="alert_as_ord" style="display: none;">
                                    <span><i class="fa fa-check"></i> Orden asignada.</span>
                                </div>

                                <div class="alert alert-danger text-center" id="alert_noas_ord" style="display: none;">
                                    <span><i class="fa fa-times"></i> Ocurrió un error fatal al asignar la orden.</span>
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

        <!-- modal EDITAR ORDEN -->
        <div class="modal fade js-example-basic-single" id="mod_ed_orden" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="card-header">
                            <button data-dismiss="modal" aria-label="close" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="card-title">Editar Orden</h3>
                        </div>
                        <div class="card-body">

                            <form id="form_edit_orden">

                                <input type="hidden" id="idOrdenEdit" value="">

                                <div class="form-group">
                                    <h4>Nro. Orden: <span id="titIdOrdenEd"></span></h4>
                                </div>

                                <div class="form-group">
                                    <h4>Matrícula: <span id="titMatrEd"></span></h4>
                                </div>

                                <div class="form-group">
                                    <label for="conduct">Nombre del conductor</label>
                                    <input type="text" class="form-control capit" id="edconduct" placeholder="Ej: Pepe Sierra">
                                </div>

                                <div class="form-group">
                                    <label for="edencargado">Mecánico Líder Encargado del Servicio</label>
                                    <select id="edencargado" class="encargado form-control select2" style="width: 100%;" required>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Servicios a realizar</label>
                                    <select id="edservicios" class="servicios select2-mult form-control" multiple="multiple" style="width: 100%;">
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edobscliente">Observaciones del Cliente</label>
                                    <textarea  class="form-control" id="edobscliente" cols="30" rows="10" placeholder="Ej: El carro presenta un sonido extraño cuando arranco…"></textarea>
                                    <small id="edobsclienteHelp" class="form-text text-muted">Ingrese las observaciones que el cliente indique</small>
                                </div>
                            
                        
                                <h3 class="text-center">Diagnostico del Mecanico</h3>
                                <p class="text-center">diligencie solo si el mecanico ya realizo el dignostico.</p>

                                <div class="form-group">
                                    <label for="eddgmec">Observaciones de los Mecánicos</label>
                                    <textarea  class="form-control" id="eddgmec" cols="30" rows="10" placeholder="Ej: Al vehículo se le debe revisar el sistema de embrague"></textarea>
                                    <!-- <input type="text" class="form-control" name="dgmec" id="eddgmec"  placeholder="Ej: Al vehículo jjse le debe revisar el sistema de embrague"> -->
                                    <small id="eddgmecHelp" class="form-text text-muted">Ingrese las observaciones indicadas por los mecánicos</small>
                                </div>


                                <!-- PROCEDIMIENTOS -->

                                <h3 class="text-center">Procedimientos</h3>
                                <p class="text-center">diligencie solo cuando se le halla efectuado los respectivos procedimientos.</p>

                                <div class="form-group">
                                    <label for="edproced">Procedimientos realizados</label>
                                    <textarea  class="form-control" id="edproced" cols="30" rows="10" placeholder="Ej: Al vehículo se le debe revisar el sistema de embrague"></textarea>
                                    <small id="edprocedHelp" class="form-text text-muted">Ingrese las observaciones indicadas por los mecánicos</small>
                                </div>

                                <div class="form-group">
                                    <label for="edrepuest">Repuestos</label>
                                    <textarea  class="form-control" id="edrepuest" cols="30" rows="10" placeholder="Ej: Chafaldrana"></textarea>
                                    <small id="edrepuestHelp" class="form-text text-muted">Ingrese los repuestos usados</small>
                                </div>

                                <div class="form-group">
                                    <label for="edobsad">Observaciones adicionales</label>
                                    <textarea  class="form-control" name="obsad" id="edobsad" cols="30" rows="10" placeholder="Ej: texto adicional"></textarea>
                                    <small id="edobsadHelp" class="form-text text-muted">Ingrese las observaciones a considerar</small>
                                </div>


                                <!-- ALERTAS -->
                                <div class="alert alert-success text-center" id="alert_edit_ord" style="display: none;">
                                    <span><i class="fa fa-check"></i> Orden editada.</span>
                                </div>

                                <div class="alert alert-danger text-center" id="alert_noedit_ord" style="display: none;">
                                    <span><i class="fa fa-times"></i> Ocurrió un error fatal al editar la orden.</span>
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
            <!-- Barra de opciones -->
            <div class="container-fluid" id="optionBar">
                <div class="row" >
                    <div id="cont-options" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list single-page-breadcome" >
                            
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-1 col-xs-12">
                                    <h3 class="tit-optionBar" style="color: white;">Órdenes y Vehículos</h3>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                
                                        <ul id="myTab3" class="nav navbar-nav mai-top-nav">
                                            <li class="nav-op active">
                                                <a href="#ordenes" class="btn-opt" id="ord" data-toggle="tab">
                                                    <i class="fa fa-clone btn-ordenes" aria-hidden="true"></i> Órdenes
                                                </a>
                                            </li>
                                            <li class="nav-op">
                                                <a href="#vehiculos" class="btn-opt" id="vehop" data-toggle="tab">
                                                    <i class="fa fa-car" aria-hidden="true"></i> Vehículos
                                                </a>
                                            </li>
                                            <li class="nav-op">
                                                <a id="op_n_orden" href="#" class="btn-opt">
                                                    <i class="fa fa-file" aria-hidden="true"></i> Nueva orden
                                                </a>
                                            </li>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- CIERRE DE header-advance-area (desde header.php) -->

   
    <!-- Single pro tab start-->
    <div class="single-product-tab-area mg-tb-15">
        <!-- Main content -->
        


 
        <!-- Single pro tab review Start-->
        <div class="single-pro-review-area">
            <div class="container-fluid">
                <p>Has clic sobre una fila para desplegar el menú de opciones. Doble clic para ver más detalles de la orden o vehículo.</p>
                <div class="">

                    <div id="myTabContent" class="tab-content custom-product-edit">

                        <!-- OPCION ORDENES DE TRABAJO -->
                        <div class="tab-pane active" id="ordenes">
                            <div class="card card-success">
                                
                                <div class="card-body p-0 table-responsive">
                                <table id="tabla_products" class="display table table-hover text-nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nro. Orden</th>
                                                <th>Fecha de Registro</th>
                                                <th>Matrícula</th>
                                                <th>Conductor</th>
                                                <th>Mec. Líder Encargado</th>
                                                <th>Servicios a realizar</th>
                                                <th>Observaciones del cliente</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table> 

                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>

                        <!-- OPCION VEHICULOS -->
                        <div class="tab-pane" id="vehiculos">
                            <div class="card card-success">
                                
                                <div class="card-body p-0 table-responsive">
                                <table id="tabla_veh" class="display table table-hover text-nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Matrícula</th>
                                                <th>Marca</th>
                                                <th>Denominación</th>
                                                <th>Modelo</th>
                                                <th>Color</th>
                                                <th>Tipo de vehículo</th>
                                                <th>Cliente</th>
                                                <th>Pendientes</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- CIERRE DE all-content-wrapper (desde header.php) -->



    <?php
    include './layouts/scripts.php';
}else{
    session_destroy();
    header('Location: ../');
}
?>
<!-- <script src="../public/js/datatables.js"></script> -->
<script src="../public/js/jquery.dataTables.min.js"></script>
<script src="../public/js/ord_veh.js"></script>