    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $mod; ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body text-center">
          <img src="<?php echo ROOT ?>images/logoemp.png">
          <br><br><br>
          <hr>
          <h1 class="text-muted"><?php echo nombrelocal($cone,$_SESSION['local']); ?></h1>
          <hr>
          <h1 class="text-muted">FACTURADOR</h1>
          <hr>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->