  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo ROOT."inicio/01" ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php echo substr($spre1,0,1); ?></b><?php echo substr($spre2,0,1); ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $spre1; ?></b><?php echo $spre2; ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <p style="color: white; padding-top: 15px; font-size: 1em;"><?php echo nombrelocal($cone, $_SESSION['local']); ?></p>
          </li>
          
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo ROOT; ?>fotos/nofoto.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $no; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo ROOT; ?>fotos/nofoto.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $no; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat" id="bm_ccontrasenia" data-toggle="modal" data-target="#m_ccontrasenia">Contraseña</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo ROOT."salir.php" ?>" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>