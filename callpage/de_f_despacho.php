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
		if($acc=="edides"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$c=mysqli_query($cone,"SELECT v.cliente, v.estado, p.descuento FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona WHERE v.idventa=$idf;");
				if($r=mysqli_fetch_assoc($c)){
					if($r['estado']==1){
?>
					  <div class="form-group">
		                <label for="clie" class="col-sm-2 control-label">Cliente</label>
		                <div class="col-sm-10">
		                  <select class="form-control" id="clie" name="clie" style="width: 100%;" onchange="prodesedicli(<?php echo $idm.",".$idf; ?>,this.value);">
		                  	<option value="<?php echo $r['cliente'] ?>"><?php echo nompersona($cone,$r['cliente']); ?></option>
		                  </select>
		                </div>
		              </div>
					  <div class="form-group">
		                <label for="prod" class="col-sm-2 control-label">Producto</label>
		                <div class="col-sm-5">
		                  <select class="form-control" id="prod" name="prod" style="width: 100%;">
		                  </select>
		                </div>
		                <label for="cant" class="col-sm-1 control-label">Cant.</label>
		                <div class="col-sm-2">
		                  <input type="number" class="form-control" id="cant" name="cant" value="1">
		                </div>
		                <div class="col-sm-2 text-right">
		                  <button type="button" class="btn bg-orange" id="b_prodesedi" onclick="prodesediadd(<?php echo $idm.", ".$idf; ?>);"><i class="fa fa-plus"></i></button>
		                </div>
		              </div>
					  <div id="de_despro">
					  	
					  </div>
					  <div id="d_resultado">
<?php
					  if($r['descuento']>0){
						echo mensajesu("Tiene <b>".($r['descuento']*100)."%</b> de descuento, solo en nuestros productos");
					  }
?>
					  </div>
					  <script>
					  	  //select2 para busqueda de productos
						  $( "#prod" ).select2({
						      placeholder: 'BUSCAR PRODUCTO',   
						      ajax: {
						          url: base+"callpage/ge_productos.php",
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
						    //select2 para busqueda de clientes
						  $( "#clie" ).select2({
						      placeholder: 'BUSCAR CLIENTE',   
						      ajax: {
						          url: base+"callpage/ge_clientes.php",
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
						echo mensajeda("Ya no se puede editar el despacho porque cambio de estado");
					}
				}else{
					echo mensajeda("Datos invalidos");
				}
				mysqli_free_result($c);
			}
		}elseif($acc=="elides"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT cliente, fecha FROM venta WHERE idventa=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Está por <b>eliminar</b> el despacho a:</h4>
					<h4 class="text-red"><small>Clinte: </small><?php echo nompersona($cone, $rm['cliente']); ?></h4>
					<h4 class="text-red"><small>Fecha: </small><?php echo fnormal($rm['fecha']); ?></h4>
					
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
		}
	}
	mysqli_close($cone);
}
?>