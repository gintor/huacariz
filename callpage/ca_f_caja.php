<?php
session_start();
if(isset($_POST['acc']) && !empty($_POST['acc'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$acc=iseguro($cone,$_POST['acc']);
	$idm=iseguro($cone,$_POST['idm']);
	$lo=iseguro($cone, $_SESSION['local']);
	if(vaccesom($cone, $id, $idm, 1)){
		if($acc=="addcaj"){
?>
		<div class="text-center">
			<span class="subtitulo"><i class="fa fa-calendar-o text-gray"></i> <?php echo date("d/m/Y"); ?></span>
		</div>
          <div class="text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
          	<?php if(date("G")<=13){ ?>
          		<h4>PRIMER TURNO</h4>
          	<?php }else{ ?>
          		<h4>SEGUNDO TURNO</h4>
          	<?php } ?>
          </div>
          <div id="d_resultado">
 
          </div>
<?php
		}elseif($acc=="elicaj"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT * FROM caja WHERE idcaja=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Está por eliminar la caja con:</h4>
					<h4 class="text-red"><small>Fecha de Apertura: </small><?php echo ftnormal($rm['fecapertura']); ?></h4>
					<h4 class="text-red"><small>Aperturada por: </small><?php echo nombreusu($cone, $rm['idusuario']); ?></h4>
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
		}elseif($acc=="cobdes"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$idca=iseguro($cone,$_POST['idca']);
				$cv=mysqli_query($cone,"SELECT v.fecha, p.nombre, p.descuento, p.tipodocumento, p.numerodoc FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona WHERE idventa=$idf;");
				if($rv=mysqli_fetch_assoc($cv)){
?>
				<table class="table table-hover table-bordered">
					<tr>
						<th>CLIENTE</th>
						<td colspan="3"><?php echo $rv['nombre']; ?></td>
					</tr>
					<tr>
						<th><?php echo tipodocumento($rv['tipodocumento']); ?></th>
						<td><?php echo $rv['numerodoc']; ?></td>
						<th>FECHA</th>
						<td><?php echo ftnormal($rv['fecha']); ?></td>
					</tr>
				</table>
				  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              <input type="hidden" name="idf" value="<?php echo $idf; ?>">
	              <input type="hidden" name="des" value="<?php echo $rv['descuento']; ?>">
	              <input type="hidden" name="idca" value="<?php echo $idca; ?>">
	              <input type="hidden" name="tdocp" value="<?php echo $rv['tipodocumento']; ?>">
	              <input type="hidden" name="ndocp" value="<?php echo $rv['numerodoc']; ?>">
	              <input type="hidden" name="nomcli" value="<?php echo $rv['nombre']; ?>">
<?php

					$cdv=mysqli_query($cone,"SELECT dv.*, p.nombre, p.procedencia FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$idf;");
					if(mysqli_num_rows($cdv)>0){
?>
				<table class="table table-hover table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>PRODUCTO</th>
						<th>CANT.</th>
						<th>PVU</th>
						<th>TOTAL</th>
					</tr>
					</thead>
<?php
						$n=0;
						$st=0;
						while($rdv=mysqli_fetch_assoc($cdv)){
							$n++;
							if($rdv['procedencia']==1 && $rv['descuento']>0){
								$dd="(".($rv['descuento']*100)."% Dto)";
							}else{
								$dd="";
							}
							$pv=$rdv['subtotal'];
							$st=$st+$pv;
							
?>
					<tr>
						<td><?php echo $n; ?></td>
						<td><?php echo $rdv['nombre']." <small>".$dd."</small>"; ?></td>
						<td><?php echo $rdv['cantidad']; ?></td>
						<td><?php echo $rdv['preunitario']; ?></td>
						<td><?php echo $rdv['subtotal']; ?></td>
					</tr>
<?php
						}
						
?>
					<tr>
						<th colspan="4">OPERACIÓN GRAVADA</th>
						<th><?php echo n_22decimal($st/1.18); ?></th>
					</tr>
					<tr>
						<th colspan="4">IGV</th>
						<th><?php echo n_22decimal($st-($st/1.18)); ?></th>
					</tr>
					<tr>
						<th colspan="4">PRECIO VENTA</th>
						<th><?php echo n_22decimal($st); ?></th>
					</tr>
				</table>
				<input type="hidden" name="ttot" value="<?php echo $st; ?>">
<?php
					}
					mysqli_free_result($cdv);
?>
				<div class="form-group">
					<label for="dven" class="col-sm-2 control-label">D. VENTA</label>
				    <div class="col-sm-4">
				      <select class="form-control" id="dven" name="dven">
				      	<option value="">DOCUMENTO VENTA</option>
<?php
						$ctd=mysqli_query($cone,"SELECT * FROM tipodoc WHERE estado=1;");
						if(mysqli_num_rows($ctd)>0){
							while($rtd=mysqli_fetch_assoc($ctd)){
?>
							<option value="<?php echo $rtd['idtipodoc']; ?>"><?php echo $rtd['tipodoc']; ?></option>
<?php
							}
						}
						mysqli_free_result($ctd);
?>
				      </select>
				    </div>
				    <label for="tpag" class="col-sm-2 control-label">T. PAGO</label>
				    <div class="col-sm-4">
				      <select class="form-control" id="tpag" name="tpag">
				      	<option value="">TIPO PAGO</option>
<?php
						$ctp=mysqli_query($cone,"SELECT * FROM tipopag WHERE estado=1;");
						if(mysqli_num_rows($ctp)>0){
							while($rtp=mysqli_fetch_assoc($ctp)){
?>
							<option value="<?php echo $rtp['idtipopag']; ?>"><?php echo $rtp['tipopag']; ?></option>
<?php
							}
						}
						mysqli_free_result($ctp);
?>
				      </select>
				    </div>
				</div>
				<div class="form-group">
					<label for="ngui" class="col-sm-2 control-label"># GUÍA R.</label>
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="ngui" id="ngui">
				    </div>
				    <label for="mrec" class="col-sm-3 control-label d_mrec">MONTO RECIBIDO</label>
				    <div class="col-sm-3 d_mrec">
						<input type="number" class="form-control" name="mrec" id="mrec">
				    </div>
				</div>
				<script>
					$(".d_mrec").hide();
					$("#tpag").change(function(){
						if($(this).val()==1){
							$(".d_mrec").show();
						}else{
							$(".d_mrec").hide();
						}
					});
				</script>
	            <div id="d_resultado">
	 
	          	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cv);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="addmov"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);

?>
				<div class="form-group">
				    <label for="des" class="col-sm-2 control-label">DESCRIPCIÓN</label>
				    <div class="col-sm-10">
				    	<input type="hidden" name="acc" value="<?php echo $acc; ?>">
			            <input type="hidden" name="idm" value="<?php echo $idm; ?>">
			            <input type="hidden" name="idf" value="<?php echo $idf; ?>">
						<input type="text" class="form-control" name="des" id="des">
				    </div>
				</div>
				<div class="form-group">
				    <label for="tip" class="col-sm-2 control-label">TIPO</label>
				    <div class="col-sm-4">
				    	<select class="form-control" name="tip" id="tip">
				    		<option value="1">INGRESO</option>
				    		<option value="2" selected="selected">EGRESO</option>
				    	</select>
				    </div>
				    <label for="mon" class="col-sm-2 control-label">MONTO</label>
				    <div class="col-sm-4">
				    	<input type="number" class="form-control" name="mon" id="mon">
				    </div>
				</div>

				  
	            <div id="d_resultado">
	 
	          	</div>
<?php
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="canven"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cv=mysqli_query($cone, "SELECT p.nombre, dv.numero, l.seriecom, LPAD(dv.numero,7,'0') AS num, td.tipodoc FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN tipodoc td ON dv.idtipodoc=td.idtipodoc INNER JOIN local l ON v.idlocal=l.idlocal WHERE v.idventa=$idf;");
				if($rv=mysqli_fetch_assoc($cv)){
?>
				<div class="form-group">
				    <div class="col-sm-12 text-center">
				    	<h4><i class="fa fa-info-circle text-red"></i> Confirme que desea cancelar la venta:</h4>
				    	<h4 class="text-green"><?php echo $rv['nombre']; ?></h4>
				    	<h4 class="text-red"><?php echo substr($rv[tipodoc],0,1).$rv['seriecom']."-".$rv['num']; ?></h4>

				    </div>
				    <div class="col-sm-12">
				    	<input type="hidden" name="acc" value="<?php echo $acc; ?>">
			            <input type="hidden" name="idm" value="<?php echo $idm; ?>">
			            <input type="hidden" name="idf" value="<?php echo $idf; ?>">
				    </div>
				</div>				  
	            <div id="d_resultado">
	 
	          	</div>
<?php
				}else{
					echo mensajeda("Datos invalido");
				}
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="infoven"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				//$idca=iseguro($cone,$_POST['idca']);

				$cd=mysqli_query($cone,"SELECT * FROM datos WHERE iddatos=1;");
				if($rd=mysqli_fetch_assoc($cd)){
?>
				<table class="table table-bordered table-hover text-center">
					<tr>
						<th><?php echo $rd['razonsocial']; ?></th>
					</tr>
					<tr>
						<td><?php echo " RUC: ".$rd['ruc']." | ".$rd['direccion']." | ".disubicacion($cone,$rd['iddistrito']); ?></td>
					</tr>

<?php
				}


				$cv=mysqli_query($cone,"SELECT v.fecha, p.nombre, p.descuento, p.tipodocumento, p.numerodoc, td.tipodoc, LPAD(dv.numero,8,'0') as num, l.seriecom, td.s_tipcom, td.idtipodoc FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN tipodoc td ON dv.idtipodoc=td.idtipodoc INNER JOIN local l ON v.idlocal=l.idlocal WHERE v.idventa=$idf;");
				if($rv=mysqli_fetch_assoc($cv)){
?>

					<tr>
						<td><?php echo $rv['tipodoc'].": ".$rv['seriecom']."-".$rv['num']; ?></td>
					</tr>
					<tr>
						<td>CLIENTE: <?php echo $rv['nombre']." ".tipodocumento($rv['tipodocumento']).": ".$rv['numerodoc']; ?></td>
					</tr>
					<tr>
						<td><?php echo ftnormal($rv['fecha']); ?></td>
					</tr>
				</table>
				  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              <input type="hidden" name="idf" value="<?php echo $idf; ?>">
	              <input type="hidden" name="des" value="<?php echo $rv['descuento']; ?>">
	              <input type="hidden" name="idca" value="<?php echo $idca; ?>">
	              <input type="hidden" name="tdocp" value="<?php echo $rv['tipodocumento']; ?>">
	              <input type="hidden" name="ndocp" value="<?php echo $rv['numerodoc']; ?>">
<?php
					$cdv=mysqli_query($cone,"SELECT dv.*, p.nombre FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$idf;");
					if(mysqli_num_rows($cdv)>0){
?>
				<table class="table table-hover table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>PRODUCTO</th>
						<th>CANT.</th>
						<th>PVU</th>
						<th>TOTAL</th>
					</tr>
					</thead>
<?php
						$n=0;
						$st=0;
						while($rdv=mysqli_fetch_assoc($cdv)){
							$n++;
							$st=$st+$rdv['subtotal'];
							$pvu=$rdv['preunitario'];
?>
					<tr>
						<td><?php echo $n; ?></td>
						<td><?php echo $rdv['nombre']; ?></td>
						<td><?php echo $rdv['cantidad']; ?></td>
						<td><?php echo $pvu; ?></td>
						<td><?php echo $rdv['subtotal']; ?></td>
					</tr>
<?php
						}
						$de=$rv['descuento'];
?>
					<tr>
						<th colspan="4">OPERACIÓN GRAVADA</th>
						<th><?php echo n_22decimal($st/1.18); ?></th>
					</tr>
					<tr>
						<th colspan="4">IGV</th>
						<th><?php echo n_22decimal($st-($st/1.18)); ?></th>
					</tr>
					<tr>
						<th colspan="4">PRECIO VENTA</th>
						<th><?php echo n_22decimal($st); ?></th>
					</tr>
				</table>
<?php
					}
					mysqli_free_result($cdv);
?>
	            <div id="d_resultado" class="text-center">
<?php
	if($rv['idtipodoc']==1){
?>
	 				<button type="button" class="btn bg-orange" onclick="imptic(<?php echo $idf; ?>);"><i class="fa fa-print"></i></button>
<?php
	}else{
?>
	 				<button type="button" class="btn bg-orange" onclick="impcom('<?php echo $rd['ruc']."-".$rv['s_tipcom']."-".substr($rv['tipodoc'],0,1).$rv['seriecom']."-".$rv['num'] ?>');"><i class="fa fa-print"></i></button>
<?php
	}
?>
	          	</div>
	          	<div id="d_impcom"></div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cv);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="cercaj"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
?>
				<div class="form-group">
				    <div class="col-sm-12 text-center">
				    	<h4><i class="fa fa-info-circle text-red"></i> Confirme que desea cerrar la caja</h4>
				    </div>
				    <div class="col-sm-12">
				    	<input type="hidden" name="acc" value="<?php echo $acc; ?>">
			            <input type="hidden" name="idm" value="<?php echo $idm; ?>">
			            <input type="hidden" name="idf" value="<?php echo $idf; ?>">
				    </div>
				</div>				  
	            <div id="d_resultado">
	 
	          	</div>
<?php

			}else{
				echo mensajeda("Faltan datos");
			}
		}
	}
	mysqli_close($cone);
}
?>