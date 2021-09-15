<?php
session_start();
if(isset($_POST['idm']) && !empty($_POST['idm'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$idm=iseguro($cone, $_POST['idm']);
	$no=iseguro($cone, $_SESSION['nousu']);
	$id=iseguro($cone, $_SESSION['idusu']);
	$lo=iseguro($cone, $_SESSION['local']);
		if(vaccesom($cone,$id,$idm,1)){
			$idv=iseguro($cone,$_POST['idv']);
?>
						<table class="table table-bordered table-hover">
					  		<thead>
					  		<tr>
					  			<th>#</th>
					  			<th>PRODUCTO</th>
					  			<th>CANT.</th>
					  			<th>PU</th>
					  			<th>TOTAL</th>
					  			<th>ACCIÓN</th>
					  		</tr>
					  		</thead>
<?php
						$cd=mysqli_query($cone,"SELECT p.nombre, dv.iddetventa, dv.cantidad, dv.subtotal, dv.preunitario, um.abreviatura FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto INNER JOIN unimedida um ON p.idunimedida=um.idunimedida WHERE idventa=$idv;");
						if(mysqli_num_rows($cd)>0){
							$n=0;
							$t=0;
							while($rd=mysqli_fetch_assoc($cd)){
								$n++;
								$t=$t+$rd['subtotal'];
?>
							<tr>
								<td><?php echo $n; ?><input type="hidden" id="cant<?php echo $rd['iddetventa']; ?>" value="<?php echo $rd['cantidad']; ?>"></td>
								<td><?php echo $rd['nombre']; ?></td>
								<td><?php echo $rd['cantidad']." ".$rd['abreviatura']; ?></td>
								<td><?php echo is_null($rd['preunitario']) ? ($rd['subtotal']/$rd['cantidad']) : $rd['preunitario']; ?></td>
								<td><?php echo $rd['subtotal']; ?></td>
								<td>
									<div class="btn-group btn-group-xs">
									  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
									  <button type="button" class="btn btn-default" title="Editar Cantidad" onclick="prodesedican(<?php echo $idm.", ".$idv.", ".$rd['iddetventa']; ?>);"><i class="fa fa-cart-plus"></i></button>
									  <button type="button" class="btn btn-default" title="Eliminar" onclick="prodesedieli(<?php echo $idm.", ".$idv.", ".$rd['iddetventa']; ?>);"><i class="fa fa-trash"></i></button>
									  <?php } ?>
									</div>
								</td>
							</tr>
<?php
							}
						}
						mysqli_free_result($cd);
?>
							<tr>
								<th colspan="4">OPERACIÓN GRAVADA</th>
								<th><?php echo n_22decimal($t/1.18); ?></th>
								<th></th>
							</tr>
							<tr>
								<th colspan="4">IGV</th>
								<th><?php echo n_22decimal(($t*0.18)/1.18); ?></th>
								<th></th>
							</tr>
							<tr>
								<th colspan="4">TOTAL</th>
								<th><?php echo n_22decimal($t); ?></th>
								<th></th>
							</tr>
						</table>
<?php
		}
	mysqli_close($cone);
}
?>