<?php
session_start();
if(!empty($_SESSION['rol'])){
    include './layouts/head.php';
    include './layouts/menu.php';



    if($_GET['id']){

        $idOrden = $_GET['id'];

        include '../models/orden.php';
        $ordenes = new Orden;
        $ordenes -> obtenerOrden($idOrden);

        foreach($ordenes->objetos as $objeto){
            $idOrden   = $objeto->id_orden;
            $fechaOrd   = $objeto->fecha_orden;
            $placa      = $objeto->placa;
            $conduct    = $objeto ->conductor;
            $encargado  = $objeto ->encargado;
            $id_tipo_serv  = $objeto ->tipo_serv;
            $obscliente = $objeto ->observ_cliente;
            $dgmec      = $objeto ->dgmec;
            $proced     = $objeto ->proced;
            $repuest    = $objeto ->repuest;
            $obsad      = $objeto ->obsad;
        }




    }else{
        echo "ALERTA! NO SE PUDO CARGAR LOS DATOS DE LA ORDEN";
    }
?>

<link rel="stylesheet" href="../public/css/ord_det.css">
<input type="hidden" id="idOrden" value="<?php echo $idOrden ?>">


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



<div class="all-content-wrapper" id="fre">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo-pro">
                    <a href="index.html"><img class="main-logo" src="../public/img/logo/logo.png" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-advance-area">
        <div class="header-top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="header-top-wraper">

                        <!-- Barra de modulos -->
                            <div class="row bsuperior" id="modulBar-det">
                                <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                    <div class="menu-switcher-pro">
                                        <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                <i class="fa fa-bars"></i>
                                            </button>
                                    </div>
                                </div>
                                <div id="conMenu" class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        <ul class="nav navbar-nav mai-top-nav">
                                            <li class="nav-item"><a href="main.php" class="nav-link">Home</a>
                                            </li>
                                            <li class="nav-item"><a href="usuario.php" class="nav-link">Usuarios</a>
                                            </li>
                                            <li class="nav-item"><a href="mecanico.php" class="nav-link">Mecanicos</a>
                                            </li>
                                            <li class="nav-item"><a href="ord_veh.php" class="nav-link">Órdenes y vehículos</a>
                                            </li>
                                          
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="header-right-info">
                                        <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                            
                                            <li>
                                                <a href="../controllers/logout.php" title="Cerrar sesión">
                                                    <span class="fa fa-power-off author-log-ic"></span>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>



                            <!-- Barra Tareas -->
                            <div class="row" id="toolbar-det">
                                <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                    <ul class="nav navbar-nav mai-top-nav">
                                        <!-- Boton volver -->
                                        <li class="nav-item" >
                                            <a href="ord_veh.php" class="nav-link btn-tb" title="Volver al listado de órdenes">
                                                <i class="fa fa-arrow-circle-left btn-arrow-back"></i>
                                                <span> Atrás</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12" id="">
                                    <div class="header-top-menu tabl-d-n">
                                        <ul class="nav navbar-nav mai-top-nav">
                               
                                            <li class="nav-item">
                                                <a href="#" id="btn-tb-pdf" class="nav-link btn-tb">
                                                    <i class="fa fa-file btn-tb-pdf"></i>
                                                    <span>Generar PDF</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" id="btn-tb-edit" class="nav-link btn-tb">
                                                    <i class="fa fa-edit btn-tb-edit"></i>Editar
                                                </a>
                                            </li>
                                            <li class="nav-item" title="Elimina la orden de trabajo permanentemente">
                                                <a href="#" id="btn-tb-delete" class="nav-link btn-tb">
                                                    <i class="fa fa-times btn-tb-delete"></i>Eliminar
                                                </a>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul class="mobile-menu-nav">
                                    <li><a data-toggle="collapse" data-target="#Charts" href="#">Home <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul class="collapse dropdown-header-top">
                                            <li><a href="index.html">Dashboard v.1</a></li>
                                            <li><a href="index-1.html">Dashboard v.2</a></li>
                                            <li><a href="index-3.html">Dashboard v.3</a></li>
                                            <li><a href="product-list.html">Product List</a></li>
                                            <li><a href="product-edit.html">Product Edit</a></li>
                                            <li><a href="product-detail.html">Product Detail</a></li>
                                            <li><a href="product-cart.html">Product Cart</a></li>
                                            <li><a href="product-payment.html">Product Payment</a></li>
                                            <li><a href="analytics.html">Analytics</a></li>
                                            <li><a href="widgets.html">Widgets</a></li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#demo" href="#">Mailbox <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="demo" class="collapse dropdown-header-top">
                                            <li><a href="mailbox.html">Inbox</a>
                                            </li>
                                            <li><a href="mailbox-view.html">View Mail</a>
                                            </li>
                                            <li><a href="mailbox-compose.html">Compose Mail</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#others" href="#">Miscellaneous <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="others" class="collapse dropdown-header-top">
                                            <li><a href="file-manager.html">File Manager</a></li>
                                            <li><a href="contacts.html">Contacts Client</a></li>
                                            <li><a href="projects.html">Project</a></li>
                                            <li><a href="project-details.html">Project Details</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                            <li><a href="404.html">404 Page</a></li>
                                            <li><a href="500.html">500 Page</a></li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="#">Interface <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="Miscellaneousmob" class="collapse dropdown-header-top">
                                            <li><a href="google-map.html">Google Map</a>
                                            </li>
                                            <li><a href="data-maps.html">Data Maps</a>
                                            </li>
                                            <li><a href="pdf-viewer.html">Pdf Viewer</a>
                                            </li>
                                            <li><a href="x-editable.html">X-Editable</a>
                                            </li>
                                            <li><a href="code-editor.html">Code Editor</a>
                                            </li>
                                            <li><a href="tree-view.html">Tree View</a>
                                            </li>
                                            <li><a href="preloader.html">Preloader</a>
                                            </li>
                                            <li><a href="images-cropper.html">Images Cropper</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Charts <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="Chartsmob" class="collapse dropdown-header-top">
                                            <li><a href="bar-charts.html">Bar Charts</a>
                                            </li>
                                            <li><a href="line-charts.html">Line Charts</a>
                                            </li>
                                            <li><a href="area-charts.html">Area Charts</a>
                                            </li>
                                            <li><a href="rounded-chart.html">Rounded Charts</a>
                                            </li>
                                            <li><a href="c3.html">C3 Charts</a>
                                            </li>
                                            <li><a href="sparkline.html">Sparkline Charts</a>
                                            </li>
                                            <li><a href="peity.html">Peity Charts</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#Tablesmob" href="#">Tables <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="Tablesmob" class="collapse dropdown-header-top">
                                            <li><a href="static-table.html">Static Table</a>
                                            </li>
                                            <li><a href="data-table.html">Data Table</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#formsmob" href="#">Forms <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="formsmob" class="collapse dropdown-header-top">
                                            <li><a href="basic-form-element.html">Basic Form Elements</a>
                                            </li>
                                            <li><a href="advance-form-element.html">Advanced Form Elements</a>
                                            </li>
                                            <li><a href="password-meter.html">Password Meter</a>
                                            </li>
                                            <li><a href="multi-upload.html">Multi Upload</a>
                                            </li>
                                            <li><a href="tinymc.html">Text Editor</a>
                                            </li>
                                            <li><a href="dual-list-box.html">Dual List Box</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#Appviewsmob" href="#">App views <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="Appviewsmob" class="collapse dropdown-header-top">
                                            <li><a href="basic-form-element.html">Basic Form Elements</a>
                                            </li>
                                            <li><a href="advance-form-element.html">Advanced Form Elements</a>
                                            </li>
                                            <li><a href="password-meter.html">Password Meter</a>
                                            </li>
                                            <li><a href="multi-upload.html">Multi Upload</a>
                                            </li>
                                            <li><a href="tinymc.html">Text Editor</a>
                                            </li>
                                            <li><a href="dual-list-box.html">Dual List Box</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a data-toggle="collapse" data-target="#Pagemob" href="#">Pages <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                        <ul id="Pagemob" class="collapse dropdown-header-top">
                                            <li><a href="login.html">Login</a>
                                            </li>
                                            <li><a href="register.html">Register</a>
                                            </li>
                                            <li><a href="lock.html">Lock</a>
                                            </li>
                                            <li><a href="password-recovery.html">Password Recovery</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu end -->
<!-- Ya que la barra secundaria (La azul oscura) es una barra que va cambiando segun la
vista a mostrar, se incluyo en las vistas a mostar, alli tambien se cierras estos divs abiertos
 -->



   
<div class="container" id="cont-seccion">
    <div class="row">
        <div class="col-md-12">
            <h1>Orden de Trabajo Número: <?php echo $idOrden;?> </h1>
        </div>
    </div>

    <div class="row">
        <!--Div Lista-->
        <div id="orden_det" class="col-md-6">
            <h3>Detalles</h3>
            <ul>
                <li><span class="tit-list-det">Fecha de Creación:</span><?php echo $fechaOrd?></li>
                <li><span class="tit-list-det">Matrícula del vehículo:</span><?php echo $placa?></li>
                <li><span class="tit-list-det">Conductor:</span><?php echo $conduct?></li>
                <li><span class="tit-list-det">Mecánico encargado:</span><?php echo $encargado?></li>

                <li class="long-det"><span class="tit-list-det">Observaciones del Cliente:</span>
                    <p><?php echo $obscliente?></p>
                </li>
                <!-- <li id="fxe" class="long-det"><span class="tit-list-det">Observaciones del Cliente:</span>
                    <p id="xe"><?php //echo $obscliente?></p>
                </li> -->
                <li class="long-det"><span class="tit-list-det">Diagnóstico del Mecánico:</span>
                    <p><?php echo $dgmec?></p>
                </li>
                <li class="long-det"><span class="tit-list-det">Procedimientos realizados:</span>
                    <p><?php echo $proced?></p>
                </li>
                <li class="long-det"><span class="tit-list-det">Repuestos utilizados:</span>
                    <p><?php echo $repuest?></p>
                </li>
                <li class="long-det"><span class="tit-list-det">Observaciones Adicionales:</span>
                    <p><?php echo $obsad?></p>
                </li>
            </ul>
            
            <h3>Servicios a realizar:</h3>
            <ul id="listServ">
                <?php
                    $servArray=explode(",", $id_tipo_serv);

                    foreach ($servArray as $serv){
                        $ordenes->listarServicios($serv);
    
                        foreach($ordenes->objetos as $objNomServ){
                ?>
                            <li><?php echo $objNomServ->nom_serv;?></li>
                <?php
                        }
                    }
                ?>
            </ul>
        </div>

        <div class="col-md-6">
            <h3>Fotos</h3>
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
<script src="../public/js/ord_det.js"></script>