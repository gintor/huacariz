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

		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
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
			if(!empty($_SESSION['pro'])){
				$n=0;
				$tot=0;

				//obtenemos tipo de precio
				$cpl=mysqli_query($cone,"SELECT tipoprecio FROM local WHERE idlocal=$lo;");
				if($rpl=mysqli_fetch_assoc($cpl)){
					switch ($rpl['tipoprecio']) {
						case 1:
							$tp="precioven";
							break;
						case 2:
							$tp="preciovenesp";
							break;
						case 3:
							$tp="preciovenadp";
							break;
					}
				}
				mysqli_free_result($cpl);
				//fin obtener tipo de precio

				foreach ($_SESSION['pro'] as $idp => $cant) {
					$n++;
					$c=mysqli_query($cone,"SELECT p.nombre, $tp, um.abreviatura FROM producto p INNER JOIN unimedida um ON p.idunimedida=um.idunimedida WHERE idproducto=$idp;");
					if($r=mysqli_fetch_assoc($c)){
							$st=n_22decimal($cant*$r[$tp]);
							$tot=$tot+$st;
?>
				<tr>
					<td><?php echo $n; ?></td>
					<td><?php echo $r['nombre']; ?></td>
					<td><?php echo n_22decimal($cant)." ".$r['abreviatura']; ?><input type="hidden" id="lcan<?php echo $idp; ?>" value="<?php echo $cant; ?>"></td>
					<td><?php echo $r['precioven']; ?></td>
					<td><?php echo $st; ?></td>
					<td>
						<div class="btn-group btn-group-xs">
						  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
						  <button type="button" class="btn btn-default" title="Editar Cantidad" onclick="prodes(<?php echo $idm.", 'can',".$idp; ?>);"><i class="fa fa-cart-plus"></i></button>
						  <button type="button" class="btn btn-default" title="Eliminar" onclick="prodes(<?php echo $idm.",'eli',".$idp; ?>);"><i class="fa fa-trash"></i></button>
						  <?php } ?>
						</div>
					</td>
				</tr>
<?php
					}
					mysqli_free_result($c);
				}
			}
?>
				<tr>
					<th colspan="4">TOTAL</th>
					<th><?php echo n_22decimal($tot); ?></th>
					<th></th>
				</tr>
			</table>
<?php
		}

	mysqli_close($cone);
}
?>