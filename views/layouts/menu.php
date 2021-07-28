<div class="left-sidebar-pro">
    <nav id="sidebar" class="active">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img id="avatarMenu" src="../public/img/usuarios/<?php echo $_SESSION['nomFotoPerfil']?>" class=" elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a id="nomUsuMenu" href="perfil.php" title="Perfil" class="d-block"><?php echo $_SESSION['nomUsu'] ?></a>
                    </div>
                </div>

        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">


          


                <ul class="metismenu" id="menu1">
                    
                    <li><a title="Seleccione para gestionar los tipos de servicios o vehículos" href="atributos.php"><i class="fa big-icon fa-cogs icon-wrap" aria-hidden="true"></i> <span class="mini-sub-pro">Atributos</span></a></li>
                    <li><a title="Acerca de Aero" href="#"><i class="fa big-icon fa-exclamation-circle icon-wrap" aria-hidden="true"></i> <span class="mini-sub-pro">Acerca de...</span></a></li>
                </ul>
            </nav>
        </div>
    </nav>
</div>
<input type="hidden" id="id_us" value="<?php echo $_SESSION['idUsu'] ?>">
<!-- CONTINUA EN HEADER.PHP -->