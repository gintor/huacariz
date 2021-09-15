<?php
session_start();
if(isset($_POST['acc']) && !empty($_POST['acc'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$acc=iseguro($cone,$_POST['acc']);
	$idm=iseguro($cone,$_POST['idm']);
	if(vaccesom($cone, $id, $idm, 1)){
		if($acc=="addpro"){
?>
					  <div class="form-group">
		                <label for="nom" class="col-sm-2 control-label">Nombre<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <input type="text" name="nom" id="nom" class="form-control" placeholder="Nombre producto">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="cat" class="col-sm-2 control-label">Categoría<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="cat" id="cat" class="form-control">
<?php
							$cca=mysqli_query($cone,"SELECT idcategoria, categoria FROM categoria WHERE estado=1 ORDER BY categoria ASC;");
							if(mysqli_num_rows($cca)>0){
								while($rca=mysqli_fetch_assoc($cca)){
?>
								<option value="<?php echo $rca['idcategoria']; ?>"><?php echo $rca['categoria']; ?></option>
<?php
								}
							}
							mysqli_free_result($cca);
?>
							</select>
		                </div>
		                <label for="umed" class="col-sm-2 control-label">U. Medida<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="umed" id="umed" class="form-control">
<?php
							$cum=mysqli_query($cone,"SELECT idunimedida, nombre FROM unimedida WHERE estado=1 ORDER BY nombre ASC;");
							if(mysqli_num_rows($cum)>0){
								while($rum=mysqli_fetch_assoc($cum)){
?>
								<option value="<?php echo $rum['idunimedida']; ?>"><?php echo $rum['nombre']; ?></option>
<?php
								}
							}
							mysqli_free_result($cum);
?>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="prov" class="col-sm-2 control-label">Proveedor<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <select name="prov" id="prov" class="form-control" style="width: 100%;">
		                  	
		                  </select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="cbar" class="col-sm-2 control-label">C. Barras</label>
		                <div class="col-sm-4">
							<input type="cbar" name="cbar" class="form-control" placeholder="Código Barras">
		                </div>
		                <label for="proc" class="col-sm-2 control-label">Procedencia<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="proc" id="proc" class="form-control">
								<option value="1">Producido (Interno)</option>
								<option value="2">Mercaderia (Externo)</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="des" class="col-sm-2 control-label">Descripción</label>
		                <div class="col-sm-10">
		                  <input type="text" name="des" id="des" class="form-control" placeholder="Descripción producto">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="pnor" class="col-sm-2 control-label">P. Normal<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="number" name="pnor" id="pnor" class="form-control" placeholder="Precio normal">
		                </div>
		                <label for="pesp" class="col-sm-2 control-label">P. Espec.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="number" name="pesp" id="pesp" class="form-control" placeholder="Precio especial">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="padp" class="col-sm-2 control-label">P. ALIANZAS<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="number" name="padp" id="padp" class="form-control" placeholder="Precio ADP">
		                </div>
		              </div>
					  <div id="d_resultado">

					  </div>
					  <script>
					  	  //select2 para busqueda de productos
						  $( "#prov" ).select2({
						      placeholder: 'BUSCAR PROVEEDOR',   
						      ajax: {
						          url: base+"callpage/ge_proveedores.php",
						          dataType: 'json',
						          delay: 250,
						          data: function (params) {
						              return {
						                  q: params.term // search term
						              };
						          },
						          processResults: function (data) {
						              return {
						                  results: data
						              };
						          },
						          cache: true
						      },
						      minimumInputLength: 3
						  });
					  </script>
<?php


		}elseif($acc=="estpro"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT nombre, estado FROM producto WHERE idproducto=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Está por <b><?php echo $rm['estado']==1 ? "desactivar" : "activar"; ?></b> el:</h4>
					<h4 class="text-red"><small>Producto: </small><?php echo $rm['nombre']; ?></h4>
					
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              	<input type="hidden" name="idf" value="<?php echo $idf; ?>">
				</div>

			<div id="d_resultado">
 
        	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="edipro"){
		  if(isset($_POST['idf']) && !empty($_POST['idf'])){
		  	$idf=iseguro($cone,$_POST['idf']);
			$cc=mysqli_query($cone,"SELECT p.*, pe.nombre as prov FROM producto p INNER JOIN persona pe ON p.proveedor=pe.idpersona WHERE p.idproducto=$idf");
			if($rr=mysqli_fetch_assoc($cc)){
?>
					  <div class="form-group">
		                <label for="nom" class="col-sm-2 control-label">Nombre<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <input type="hidden" name="idf" value="<?php echo $idf; ?>">
		                  <input type="text" name="nom" id="nom" class="form-control" placeholder="Nombre producto" value="<?php echo $rr['nombre']; ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="cat" class="col-sm-2 control-label">Categoría<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="cat" id="cat" class="form-control">
<?php
							$cca=mysqli_query($cone,"SELECT idcategoria, categoria FROM categoria WHERE estado=1 ORDER BY categoria ASC;");
							if(mysqli_num_rows($cca)>0){
								while($rca=mysqli_fetch_assoc($cca)){
?>
								<option value="<?php echo $rca['idcategoria']; ?>" <?php echo $rca['idcategoria']==$rr['idcategoria'] ? "selected" : ""; ?>><?php echo $rca['categoria']; ?></option>
<?php
								}
							}
							mysqli_free_result($cca);
?>
							</select>
		                </div>
		                <label for="umed" class="col-sm-2 control-label">U. Medida<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="umed" id="umed" class="form-control">
<?php
							$cum=mysqli_query($cone,"SELECT idunimedida, nombre FROM unimedida WHERE estado=1 ORDER BY nombre ASC;");
							if(mysqli_num_rows($cum)>0){
								while($rum=mysqli_fetch_assoc($cum)){
?>
								<option value="<?php echo $rum['idunimedida']; ?>" <?php echo $rum['idunimedida']==$rr['idunimedida'] ? "selected" : ""; ?>><?php echo $rum['nombre']; ?></option>
<?php
								}
							}
							mysqli_free_result($cum);
?>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="prov" class="col-sm-2 control-label">Proveedor<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <select name="prov" id="prov" class="form-control" style="width: 100%;">
		                  	<option value="<?php echo $rr['proveedor']; ?>"><?php echo $rr['prov']; ?></option>
		                  </select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="cbar" class="col-sm-2 control-label">C. Barras</label>
		                <div class="col-sm-4">
							<input type="cbar" name="cbar" class="form-control" placeholder="Código Barras" value="<?php echo $rr['codbarras'] ?>">
		                </div>
		                <label for="proc" class="col-sm-2 control-label">Procedencia<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="proc" id="proc" class="form-control">
								<option value="1" <?php echo $rr['procedencia']==1 ? "selected" : ""; ?>>Producido (Interno)</option>
								<option value="2" <?php echo $rr['procedencia']==2 ? "selected" : ""; ?>>Mercaderia (Externo)</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="des" class="col-sm-2 control-label">Descripción</label>
		                <div class="col-sm-10">
		                  <input type="text" name="des" id="des" class="form-control" placeholder="Descripción producto" value="<?php echo $rr['descripcion']; ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="pnor" class="col-sm-2 control-label">P. Normal<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="number" name="pnor" id="pnor" class="form-control" placeholder="Precio normal" value="<?php echo $rr['precioven'] ?>">
		                </div>
		                <label for="pesp" class="col-sm-2 control-label">P. Espec.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="number" name="pesp" id="pesp" class="form-control" placeholder="Precio especial" value="<?php echo $rr['preciovenesp'] ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="padp" class="col-sm-2 control-label">P. ALIANZAS<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="number" name="padp" id="padp" class="form-control" placeholder="Precio ADP" value="<?php echo $rr['preciovenadp']; ?>">
		                </div>
		              </div>
					  <div id="d_resultado">

					  </div>
					  <script>
					  	  //select2 para busqueda de productos
						  $( "#prov" ).select2({
						      placeholder: 'BUSCAR PROVEEDOR',   
						      ajax: {
						          url: base+"callpage/ge_proveedores.php",
						          dataType: 'json',
						          delay: 250,
						          data: function (params) {
						              return {
						                  q: params.term // search term
						              };
						          },
						          processResults: function (data) {
						              return {
						                  results: data
						              };
						          },
						          cache: true
						      },
						      minimumInputLength: 3
						  });
					  </script>
<?php
			}else{
				echo mensajeda("Datos invalidos");
			}
			mysqli_free_result($cc);
		  }else{
		  	echo mensajeda("Faltan datos");
		  }

		}elseif($acc=="infopro"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cc=mysqli_query($cone,"SELECT pr.*, pe.nombre AS prov, ca.categoria, um.nombre AS umed FROM producto pr INNER JOIN persona pe ON pr.proveedor=pe.idpersona INNER JOIN categoria ca ON pr.idcategoria=ca.idcategoria INNER JOIN unimedida um ON pr.idunimedida=um.idunimedida WHERE pr.idproducto=$idf;");
				if($rr=mysqli_fetch_assoc($cc)){
?>
				<table class="table table-bordered table-hover">
					<tr>
						<th>NOMBRE</th>
						<td colspan="3"><?php echo $rr['nombre']; ?></td>
					</tr>
					<tr>
						<th>CATEGORÍA</th>
						<td><?php echo $rr['categoria']; ?></td>
						<th>U. MEDIDA</th>
						<td><?php echo $rr['umed']; ?></td>
					</tr>
					<tr>
						<th>PROVEEDOR</th>
						<td colspan="3"><?php echo $rr['prov']; ?></td>
					</tr>
					<tr>
						<th>COD. BARRAS</th>
						<td><?php echo $rr['codbarras']; ?></td>
						<th>PROCEDENCIA</th>
						<td><?php echo proprocedencia($rr['procedencia']); ?></td>
					</tr>
					<tr>
						<th>DESCRIPCIÓN</th>
						<td colspan="3"><?php echo $rr['descripcion']; ?></td>
					</tr>
					<tr>
						<th>P. NORMAL</th>
						<td><?php echo $rr['precioven']; ?></td>
						<th>P. ESPECIAL</th>
						<td><?php echo $rr['preciovenesp']; ?></td>
					</tr>
					<tr>
						<th>P. ALIANZAS</th>
						<td><?php echo $rr['preciovenadp']; ?></td>
						<th>ESTADO</th>
						<td><?php echo estado($rr['estado']); ?></td>
					</tr>
					<tr>
						<th>POR</th>
						<td colspan="3"><?php echo nombreusu($cone,$rr['idusuario']); ?></td>
					</tr>
				</table>
<?php
				}else{
					echo mensajeda("Datos invalidos");
				}
				mysqli_free_result($cc);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="addloc"){
?>
					  <div class="form-group">
		                <label for="nom" class="col-sm-2 control-label">Nombre<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <input type="text" name="nom" id="nom" class="form-control" placeholder="Nombre local">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dir" class="col-sm-2 control-label">Dirección<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="text" name="dir" id="dir" class="form-control" placeholder="Dirección local">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="ser" class="col-sm-2 control-label">Serie<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="ser" name="ser" class="form-control" placeholder="Serie documentos">
		                </div>
		                <label for="tpre" class="col-sm-2 control-label">T. Precio<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tpre" id="tpre" class="form-control">
								<option value="1">NORMAL</option>
								<option value="2">ESPECIAL</option>
								<option value="3">ALIANZAS</option>
							</select>
		                </div>
		              </div>
					  <div id="d_resultado">

					  </div>
<?php
		}elseif($acc=="estloc"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT nombre, estado FROM local WHERE idlocal=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Está por <b><?php echo $rm['estado']==1 ? "desactivar" : "activar"; ?></b> el:</h4>
					<h4 class="text-red"><small>Local: </small><?php echo $rm['nombre']; ?></h4>
					
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              	<input type="hidden" name="idf" value="<?php echo $idf; ?>">
				</div>

			<div id="d_resultado">
 
        	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="ediloc"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
			  $idf=iseguro($cone,$_POST['idf']);
			  $cl=mysqli_query($cone, "SELECT * FROM local WHERE idlocal=$idf;");
			  if($rl=mysqli_fetch_assoc($cl)){
?>
					  <div class="form-group">
		                <label for="nom" class="col-sm-2 control-label">Nombre<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <input type="hidden" name="idf" value="<?php echo $idf; ?>">
		                  <input type="text" name="nom" id="nom" class="form-control" placeholder="Nombre local" value="<?php echo $rl['nombre']; ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dir" class="col-sm-2 control-label">Dirección<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="text" name="dir" id="dir" class="form-control" placeholder="Dirección local" value="<?php echo $rl['direccion'] ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="ser" class="col-sm-2 control-label">Serie<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="ser" name="ser" class="form-control" placeholder="Serie documentos" value="<?php echo $rl['seriecom']; ?>">
		                </div>
		                <label for="tpre" class="col-sm-2 control-label">T. Precio<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tpre" id="tpre" class="form-control">
								<option value="1" <?php echo $rl['tipoprecio']==1 ? "selected" : ""; ?>>NORMAL</option>
								<option value="2" <?php echo $rl['tipoprecio']==2 ? "selected" : ""; ?>>ESPECIAL</option>
								<option value="3" <?php echo $rl['tipoprecio']==3 ? "selected" : ""; ?>>ALIANZAS</option>
							</select>
		                </div>
		              </div>
					  <div id="d_resultado">

					  </div>
<?php
			  }else{
			  	echo mensajeda("Datos invalidos");
			  }
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="addent"){
?>
					  <div class="form-group">
		                <label for="nom" class="col-sm-2 control-label">Nombre<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <input type="text" name="nom" id="nom" class="form-control" placeholder="Nombre o Razón Social">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="rep" class="col-sm-2 control-label">Represent.</label>
		                <div class="col-sm-10">
		                  <input type="text" name="rep" id="rep" class="form-control" placeholder="Representante">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="tip" class="col-sm-2 control-label">Tipo<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tip" id="tip" class="form-control">
								<option value="1">NATURAL</option>
								<option value="2">JURÍDICA</option>
							</select>
		                </div>
		                <label for="rel" class="col-sm-2 control-label">Relación<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="rel" id=rel" class="form-control">
								<option value="1">CLIENTE</option>
								<option value="2">PROVEEDOR</option>
								<option value="3">COLABORADOR</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		              	<label for="tdoc" class="col-sm-2 control-label">T. Doc.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tdoc" id="tdoc" class="form-control">
								<option value="6">RUC</option>
								<option value="1">DNI</option>
								<option value="4">CE</option>
								<option value="7">PASAPORTE</option>
							</select>
		                </div>
		                <label for="ndoc" class="col-sm-2 control-label">N. Doc.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="ndoc" name="ndoc" class="form-control" placeholder="Número documento">
		                </div>
		              </div>
		              <div class="form-group">
		              	<label for="tfij" class="col-sm-2 control-label">T. Fijo</label>
		                <div class="col-sm-4">
							<input type="tfij" name="tfij" class="form-control" placeholder="Teléfono fijo">
		                </div>
		                <label for="tmov" class="col-sm-2 control-label">T. Móvil</label>
		                <div class="col-sm-4">
							<input type="tmov" name="tmov" class="form-control" placeholder="Teléfono móvil">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dir" class="col-sm-2 control-label">Dirección<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="text" name="dir" id="dir" class="form-control" placeholder="Dirección">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dep" class="col-sm-2 control-label">Depart.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="dep" id="dep" class="form-control" onchange="lprovincias(this.value)">
								<option value="">DEPARTAMENTO</option>
<?php
							$cd=mysqli_query($cone, "SELECT iddepartamento, departamento FROM departamento ORDER BY departamento ASC;");
							if(mysqli_num_rows($cd)>0){
								while($rd=mysqli_fetch_assoc($cd)){
?>
								<option value="<?php echo $rd['iddepartamento']; ?>"><?php echo html_entity_decode($rd['departamento']); ?></option>
<?php
								}
							}
							mysqli_free_result($cd);
?>
							</select>
		                </div>
		                <label for="pro" class="col-sm-2 control-label">Prov.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="pro" id="provincia" class="form-control" onchange="ldistritos(this.value)">
								<option value="">PROVINCIA</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dis" class="col-sm-2 control-label">Dist.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="dis" id="distrito" class="form-control">
								<option value="">DISTRITO</option>
							</select>
		                </div>
		                <label for="tcli" class="col-sm-2 control-label">T. Cliente<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tcli" id="tcli" class="form-control">
								<option value="1">COMÚN</option>
								<option value="2">ALIANZA</option>
								<option value="3">DISTRIBUIDOR</option>
								<option value="4">PAQUETES</option>
								<option value="5">SUPERMERCADO</option>
								<option value="6">MINA</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		              	<label for="cor" class="col-sm-2 control-label">Correo</label>
		                <div class="col-sm-4">
							<input type="cor" name="cor" class="form-control" placeholder="Correo">
		                </div>
		                <label for="des" class="col-sm-2 control-label">Descuento</label>
		                <div class="col-sm-4">
							<input type="number" name="des" class="form-control" placeholder="0%-100%">
		                </div>
		              </div>
		              
					  <div id="d_resultado">

					  </div>
<?php
		}elseif($acc=="estent"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT nombre, estado FROM persona WHERE idpersona=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Está por <b><?php echo $rm['estado']==1 ? "desactivar" : "activar"; ?></b> el:</h4>
					<h4 class="text-red"><small>Entidad: </small><?php echo $rm['nombre']; ?></h4>
					
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              	<input type="hidden" name="idf" value="<?php echo $idf; ?>">
				</div>

			<div id="d_resultado">
 
        	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="edient"){
		  if(isset($_POST['idf']) && !empty($_POST['idf'])){
		  	$idf=iseguro($cone,$_POST['idf']);
		  	$ce=mysqli_query($cone,"SELECT * FROM persona WHERE idpersona=$idf;");
		  	if($re=mysqli_fetch_assoc($ce)){
		  		$iddis=$re['iddistrito'];
		  		$cu=mysqli_query($cone,"SELECT pr.idprovincia, de.iddepartamento FROM distrito di INNER JOIN provincia pr ON di.idprovincia=pr.idprovincia INNER JOIN departamento de ON pr.iddepartamento=de.iddepartamento WHERE di.iddistrito=$iddis;");
		  		if($ru=mysqli_fetch_assoc($cu)){
		  			$idpro=$ru['idprovincia'];
		  			$iddep=$ru['iddepartamento'];
		  		}
		  		mysqli_free_result($cu);
?>
					  <div class="form-group">
		                <label for="nom" class="col-sm-2 control-label">Nombre<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <input type="hidden" name="idf" value="<?php echo $idf; ?>">
		                  <input type="text" name="nom" id="nom" class="form-control" placeholder="Nombre o Razón Social" value="<?php echo $re['nombre']; ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="rep" class="col-sm-2 control-label">Represent.</label>
		                <div class="col-sm-10">
		                  <input type="text" name="rep" id="rep" class="form-control" placeholder="Representante" value="<?php echo $re['representante']; ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="tip" class="col-sm-2 control-label">Tipo<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tip" id="tip" class="form-control">
								<option value="1" <?php echo $re['tipo']==1 ? "selected" : ""; ?>>NATURAL</option>
								<option value="2" <?php echo $re['tipo']==2 ? "selected" : ""; ?>>JURÍDICA</option>
							</select>
		                </div>
		                <label for="rel" class="col-sm-2 control-label">Relación<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="rel" id=rel" class="form-control">
								<option value="1" <?php echo $re['relacion']==1 ? "selected" : ""; ?>>CLIENTE</option>
								<option value="2" <?php echo $re['relacion']==2 ? "selected" : ""; ?>>PROVEEDOR</option>
								<option value="3" <?php echo $re['relacion']==3 ? "selected" : ""; ?>>COLABORADOR</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		              	<label for="tdoc" class="col-sm-2 control-label">T. Doc.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tdoc" id="tdoc" class="form-control">
								<option value="6" <?php echo $re['tipodocumento']==6 ? "selected" : ""; ?>>RUC</option>
								<option value="1" <?php echo $re['tipodocumento']==1 ? "selected" : ""; ?>>DNI</option>
								<option value="4" <?php echo $re['tipodocumento']==4 ? "selected" : ""; ?>>CE</option>
								<option value="7" <?php echo $re['tipodocumento']==7 ? "selected" : ""; ?>>PASAPORTE</option>
							</select>
		                </div>
		                <label for="ndoc" class="col-sm-2 control-label">N. Doc.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<input type="ndoc" name="ndoc" class="form-control" placeholder="Número documento" value="<?php echo $re['numerodoc'] ?>">
		                </div>
		              </div>
		              <div class="form-group">
		              	<label for="tfij" class="col-sm-2 control-label">T. Fijo</label>
		                <div class="col-sm-4">
							<input type="tfij" name="tfij" class="form-control" placeholder="Teléfono fijo" value="<?php echo $re['telfijo']; ?>">
		                </div>
		                <label for="tmov" class="col-sm-2 control-label">T. Móvil</label>
		                <div class="col-sm-4">
							<input type="tmov" name="tmov" class="form-control" placeholder="Teléfono móvil" value="<?php echo $re['telmovil'] ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dir" class="col-sm-2 control-label">Dirección<small class="text-red">*</small></label>
		                <div class="col-sm-10">
		                  <input type="text" name="dir" id="dir" class="form-control" placeholder="Dirección" value="<?php echo $re['direccion']; ?>">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dep" class="col-sm-2 control-label">Depart.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="dep" id="dep" class="form-control" onchange="lprovincias(this.value)">
								<option value="">DEPARTAMENTO</option>
<?php
							$cd=mysqli_query($cone, "SELECT iddepartamento, departamento FROM departamento ORDER BY departamento ASC;");
							if(mysqli_num_rows($cd)>0){
								while($rd=mysqli_fetch_assoc($cd)){
?>
								<option value="<?php echo $rd['iddepartamento']; ?>" <?php echo $rd['iddepartamento']==$iddep ? "selected" : ""; ?>><?php echo $rd['departamento']; ?></option>
<?php
								}
							}
							mysqli_free_result($cd);
?>
							</select>
		                </div>
		                <label for="pro" class="col-sm-2 control-label">Prov.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="pro" id="provincia" class="form-control" onchange="ldistritos(this.value)">
								<option value="">PROVINCIA</option>
<?php
							$cp=mysqli_query($cone, "SELECT idprovincia, provincia FROM provincia WHERE iddepartamento=$iddep ORDER BY provincia ASC;");
							if(mysqli_num_rows($cp)){
								while ($rp=mysqli_fetch_assoc($cp)) {
?>
								<option value="<?php echo $rp['idprovincia']; ?>" <?php echo $rp['idprovincia']==$idpro ? "selected" : ""; ?>><?php echo $rp['provincia']; ?></option>
<?php
								}
							}
							mysqli_free_result($cp);
?>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="dis" class="col-sm-2 control-label">Dist.<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="dis" id="distrito" class="form-control">
								<option value="">DISTRITO</option>
<?php
							$cd=mysqli_query($cone, "SELECT iddistrito, distrito FROM distrito WHERE iddistrito=$iddis ORDER BY distrito ASC;");
							if(mysqli_num_rows($cd)){
								while ($rd=mysqli_fetch_assoc($cd)) {
?>
								<option value="<?php echo $rd['iddistrito']; ?>" <?php echo $rd['iddistrito']==$iddis ? "selected" : ""; ?>><?php echo $rd['distrito']; ?></option>
<?php
								}
							}
							mysqli_free_result($cd);
?>
							</select>
		                </div>
		                <label for="tcli" class="col-sm-2 control-label">T. Cliente<small class="text-red">*</small></label>
		                <div class="col-sm-4">
							<select name="tcli" id="tcli" class="form-control">
								<option value="1" <?php echo $re['tipocli']==1 ? "selected" : ""; ?>>COMÚN</option>
								<option value="2" <?php echo $re['tipocli']==2 ? "selected" : ""; ?>>ALIANZA</option>
								<option value="3" <?php echo $re['tipocli']==3 ? "selected" : ""; ?>>DISTRIBUIDOR</option>
								<option value="4" <?php echo $re['tipocli']==4 ? "selected" : ""; ?>>PAQUETES</option>
								<option value="5" <?php echo $re['tipocli']==5 ? "selected" : ""; ?>>SUPERMERCADO</option>
								<option value="6" <?php echo $re['tipocli']==6 ? "selected" : ""; ?>>MINA</option>
							</select>
		                </div>
		              </div>
		              <div class="form-group">
		              	<label for="cor" class="col-sm-2 control-label">Correo</label>
		                <div class="col-sm-4">
							<input type="cor" name="cor" class="form-control" placeholder="Correo" value="<?php echo $re['correo']; ?>">
		                </div>
		                <label for="des" class="col-sm-2 control-label">Descuento</label>
		                <div class="col-sm-4">
							<input type="number" name="des" class="form-control" placeholder="0%-100%" value="<?php echo ($re['descuento']*100) ?>">
		                </div>
		              </div>
		              
					  <div id="d_resultado">

					  </div>
<?php
			}else{
				echo mensajeda("Datos inválidos");
			}
			mysqli_free_result($ce);
		  }else{
		  	echo mensajeda("Faltan datos");
		  }
		}elseif($acc=="infoent"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cc=mysqli_query($cone,"SELECT * FROM persona WHERE idpersona=$idf;");
				if($rr=mysqli_fetch_assoc($cc)){
?>
				<table class="table table-bordered table-hover">
					<tr>
						<th>NOMBRE (RS)</th>
						<td colspan="3"><?php echo $rr['nombre']; ?></td>
					</tr>
					<tr>
						<th>REPRESENTANTE</th>
						<td colspan="3"><?php echo $rr['representante']; ?></td>
					</tr>
					<tr>
						<th>TIPO</th>
						<td><?php echo enttipo($rr['tipo']); ?></td>
						<th>RELACIÓN</th>
						<td><?php echo entrelacion($rr['relacion']); ?></td>
					</tr>
					<tr>
						<th>T. DOCUMENTO</th>
						<td><?php echo tipodocumento($rr['tipodocumento']); ?></td>
						<th>N. DOCUMENTO</th>
						<td><?php echo $rr['numerodoc']; ?></td>
					</tr>
					<tr>
						<th>T. FIJO</th>
						<td><?php echo $rr['telfijo']; ?></td>
						<th>N. MÓVIL</th>
						<td><?php echo $rr['telmovil']; ?></td>
					</tr>
					<tr>
						<th>DIRECCIÓN</th>
						<td colspan="3"><?php echo $rr['direccion']; ?></td>
					</tr>
					<tr>
						<th>UBICACIÓN</th>
						<td colspan="3"><?php echo ubigeo($cone, $rr['iddistrito']); ?></td>
					</tr>
					<tr>
						<th>T. CLIENTE</th>
						<td><?php echo tipocli($rr['tipocli']); ?></td>
						<th>DESCUENTO</th>
						<td><?php echo $rr['descuento']; ?></td>
					</tr>
					<tr>
						<th>CORREO</th>
						<td><?php echo $rr['correo']; ?></td>
						<th>ESTADO</th>
						<td><?php echo estado($rr['estado']); ?></td>
					</tr>
				</table>
<?php
				}else{
					echo mensajeda("Datos invalidos");
				}
				mysqli_free_result($cc);
			}else{
				echo mensajeda("Faltan datos");
			}
		}//<-
	}
	mysqli_close($cone);
}
?>