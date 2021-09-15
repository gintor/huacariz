
          <!-- Main content -->
              <section class="content">
                <div class="row">
                  <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Validar</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Estados</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                          <!--Formulario-->
                          <form id="f_validar" class="form-inline">
                                <!-- <div class="form-group has-feedback">
                                  <label for="fecv">Fecha</label>
                                  <input type="text" class="form-control" id="fecv" name="fecv" autocomplete="off" placeholder="dd/mm/aaaa" value="<?php //echo date("d/m/Y"); ?>">
                                  <span class="fa fa-calendar form-control-feedback"></span>
                                </div> -->
                                <button type="button" id="b_validar" class="btn btn-default">Validar</button>
                          </form>
                          <!--Fin Formulario-->
                          <!--div resultados-->
                          <div class="row">
                            <div class="col-md-12" id="r_validar">

                            </div>
                          </div>
                          <!--fin div resultados-->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                          <!--Formulario-->
                          <form action="" id="f_estados" class="form-inline">
                                <div class="form-group has-feedback">
                                  <label for="inie">Desde</label>
                                  <input type="text"  class="form-control" id="inie" name="inie" autocomplete="off" placeholder="dd/mm/aaaa">
                                  <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                  <label for="fine">Hasta</label>
                                  <input type="text"  class="form-control" id="fine" name="fine" placeholder="dd/mm/aaaa" autocomplete="off" value="<?php echo date("d/m/Y") ?>">
                                  <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                                <button type="button" id="b_estados" class="btn btn-default">Buscar</button>
                          </form>
                          <!--Fin Formulario-->
                          <!--div resultados-->
                          <div class="row">

                            <div class="col-md-12" id="r_estados">

                            </div>
                          </div>
                          <!--fin div resultados-->
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                  </div>
                </div>

              </section>
              <!-- /.content -->


<script>

</script>
