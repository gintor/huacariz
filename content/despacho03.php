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
          <div class="col-md-8" id="f_despachar">
            <form class="form-horizontal" id="f_despacho">
              <div class="form-group">
                <label for="cli" class="col-sm-2 control-label">Cliente</label>
                <div class="col-sm-8">
                  <select class="form-control" id="cli" name="cli" onchange="descli(this.value);">
                  </select>
                  <input type="hidden" name="acc" value="adddes">
                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
                </div>
                <div class="col-sm-2 text-right">
                  <button type="button" class="btn btn-info" onclick="ma_f_mante(3, 'addent', 0);"><i class="fa fa-plus"></i> Agregar</button>
                </div>
              </div>
              <div class="form-group">
                <label for="pro0" class="col-sm-2 control-label">Producto</label>
                <div class="col-sm-5">
                  <select class="form-control" id="pro0" name="pro0">
                  </select>
                </div>
                <label for="can0" class="col-sm-1 control-label">Cant.</label>
                <div class="col-sm-2">
                  <input type="number" class="form-control" id="can0" name="can0" value="1">
                </div>
                <div class="col-sm-2 text-right">
                  <button type="button" class="btn bg-orange" onclick="prodes(<?php echo $idm.",'add',0"; ?>);"><i class="fa fa-plus"></i></button>
                </div>
              </div>
              <div class="form-group" id="d_prodes">
                
              </div>
              <div class="form-group" id="d_descprodes">
                
              </div>
              <div class="form-group" id="r_prodes">
                
              </div>
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <button type="button" id="bg_despacho" class="btn btn-primary">Guardar</button>
                  <button type="button" class="btn btn-default" onclick="prodes(<?php echo "1 ,'des',0"; ?>);">Cancelar</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-4 table-responsive text-right" id="d_despachos">
            
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