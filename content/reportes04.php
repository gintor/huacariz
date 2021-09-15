<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Productos Vendidos</a></li>
              <li><a href="#tab_2" data-toggle="tab">Ventas</a></li>
              <li><a href="#tab_3" data-toggle="tab">Ventas Antiguas</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_reppro" class="form-horizontal">
                  <div class="form-group">
                    <label for="desde" class="col-sm-1 control-label">Desde</label>

                    <div class="col-sm-2 valida">
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="iniven" name="iniven" autocomplete="off" placeholder="dd/mm/aaaa (INICIO)">
                        <span class="fa fa-calendar form-control-feedback"></span>
                      </div>
                    </div>
                    <label for="cliente" class="col-sm-1 control-label">Hasta</label>
                    <div class="col-sm-2 valida">
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="finven" name="finven" autocomplete="off" value="<?php echo date("d/m/Y") ?>">
                        <span class="fa fa-calendar form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="col-sm-3 valida">
                      <select class="form-control" name="local" id="local">
                        <option value="">Seleccione el local</option>
                        <option value="t">Todos los locales</option>
                        <?php
                        $cl=mysqli_query($cone, "SELECT idlocal, nombre, direccion FROM local WHERE estado=1 ORDER BY nombre, direccion ASC;");
                        if(mysqli_num_rows($cl)>0){
                          while($rl=mysqli_fetch_assoc($cl)){
                        ?>
                        <option value="<?php echo $rl['idlocal']; ?>"><?php echo utf8_encode($rl['nombre'])." - ".utf8_encode($rl['direccion']); ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cl);
                        ?>
                      </select>
                    </div>

                    <div class="col-sm-1 valida">
                      <button type="submit" id="b_rprod" class="btn btn-default">Buscar</button>
                    </div>
                    <div class="col-sm-1 valida">
                      <button type="button" id="b_eprod" class="btn bg-aqua" onclick="bexpopro();">Exportar</button>
                    </div>

                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_rprod">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario-->
                <form action="" id="f_repped" class="form-horizontal">
                  <div class="form-group">
                    <!--<label for="cliente" class="col-sm-1 control-label">Cliente</label>-->
                    <div class="col-sm-3 valida">
                      <select name="clientep" id="clientep" class="form-control select2" style="width: 100%;">
                        <option value="t">TODOS LOS CLIENTES</option>
                      </select>
                    </div>

                    <div class="col-sm-2 valida">
                      <div class="form-group has-feedback">
                        <label for="aaa" class="sr-only">Desde</label>
                        <input type="text"  class="form-control" id="iniped" name="iniped" autocomplete="off" placeholder="dd/mm/aaaa (INICIO)">
                        <span class="fa fa-calendar form-control-feedback"></span>
                      </div>
                    </div>

                    <div class="col-sm-2 valida">
                      <div class="form-group has-feedback">
                        <label for="aaa" class="sr-only">Hasta</label>
                        <input type="text"  class="form-control" id="finped" name="finped" placeholder="dd/mm/aaaa" autocomplete="off" value="<?php echo date("d/m/Y") ?>">
                        <span class="fa fa-calendar form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="col-sm-2 valida">
                      <select class="form-control" name="est" id="est">
                        <option value="2">ACTIVAS</option>
                        <option value="3">ANULADAS</option>
                      </select>
                    </div>
                    <div class="col-sm-1 valida">
                      <button type="submit" id="b_rped" class="btn btn-default">Buscar</button>
                    </div>
                    <div class="col-sm-1 valida">
                      <button type="button" id="b_eped" class="btn bg-aqua" onclick="bexpoven();">Exportar</button>
                    </div>

                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">

                  <div class="col-md-12" id="r_rped">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <div class="tab-pane" id="tab_3">
                <!--Formulario-->
                <form action="" id="f_reppeda" class="form-horizontal">
                  <div class="form-group">
                    <!--<label for="cliente" class="col-sm-1 control-label">Cliente</label>-->
                    <div class="col-sm-3 valida">
                      <select name="clientepa" id="clientepa" class="form-control select2" style="width: 100%;">
                        <option value="t">TODOS LOS CLIENTES</option>
                      </select>
                    </div>

                    <div class="col-sm-2 valida">
                      <div class="form-group has-feedback">
                        <label for="aaa" class="sr-only">Desde</label>
                        <input type="text"  class="form-control" id="inipeda" name="inipeda" autocomplete="off" placeholder="dd/mm/aaaa (INICIO)">
                        <span class="fa fa-calendar form-control-feedback"></span>
                      </div>
                    </div>

                    <div class="col-sm-2 valida">
                      <div class="form-group has-feedback">
                        <label for="aaa" class="sr-only">Hasta</label>
                        <input type="text"  class="form-control" id="finpeda" name="finpeda" placeholder="dd/mm/aaaa" autocomplete="off" value="09/09/2018">
                        <span class="fa fa-calendar form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="col-sm-2 valida">
                      <select class="form-control" name="esta" id="esta">
                        <option value="2">ACTIVAS</option>
                        <option value="3">ANULADAS</option>
                      </select>
                    </div>
                    <div class="col-sm-1 valida">
                      <button type="submit" id="b_rpeda" class="btn btn-default">Buscar</button>
                    </div>
                    <div class="col-sm-1 valida">
                      <button type="button" id="b_epeda" class="btn bg-aqua" onclick="bexpovena();">Exportar</button>
                    </div>

                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">

                  <div class="col-md-12" id="r_rpeda">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>

    </section>
    <!-- /.content -->
