    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $mod; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo ROOT."inicio/01" ?>"><i class="fa fa-home"></i> Inicio</a></li>
        <?php if($mod!="Inicio"){ ?>
        <li class="active"><?php echo $mod; ?></li>
        <?php } ?>
      </ol>
    </section>