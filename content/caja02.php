<?php
if(vaccesom($cone, $id, $idm, 2) || vaccesom($cone, $id, $idm, 1)){
?>
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
        <div class="box-body">
          <div class="col-md-12">
            <form class="form-inline" id="f_bcajas">
              <div class="form-group has-feedback">
                <label for="fec">Fecha</label>
                <input type="text" class="form-control" name="fec" id="fec" placeholder="dd/mm/aaaa" autocomplete="off" value="<?php echo date("d/m/Y") ?>">
                <span class="fa fa-calendar form-control-feedback"></span>
              </div>
              <button type="submit" class="btn btn-default">Buscar</button>
            </form>
          </div>
          <div class="col-md-12" id="d_cajas">
            
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
<?php
}
?>