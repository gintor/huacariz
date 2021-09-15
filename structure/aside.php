  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="height: 65px;">
        <div class="pull-left image">
          <img src="<?php echo ROOT; ?>fotos/nofoto.jpg" class="img-circle" alt="Foto">
        </div>
        <div class="pull-left info">
          <p style="white-space: normal;"><?php echo $no; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU NAVEGACIÓN</li>
        <?php
        $cm=mysqli_query($cone,"SELECT LPAD(m.idmodulo,2,'0') AS num, nombre, icono FROM modulo m INNER JOIN modusuario mu ON m.idmodulo=mu.idmodulo WHERE m.estado=1 AND mu.estado=1 AND mu.idusuario=$id;");
        if(mysqli_num_rows($cm)){
          while($rm=mysqli_fetch_assoc($cm)){
        ?>
          <li id="<?php echo $rm['num'].amigable($rm['nombre']); ?>"><a href="<?php echo ROOT.amigable($rm['nombre'])."/".$rm['num']; ?>"><i class="fa <?php echo $rm['icono'] ?>"></i> <span><?php echo $rm['nombre']; ?></span></a></li>
        <?php
          }
        }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>