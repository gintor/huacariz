<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$idm=iseguro($cone, $_POST['idm']);
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['lo']);
$localped=iseguro($cone,$_POST['local']);
$iniven=fmysql(iseguro($cone,$_POST['iniven']));
$finven=fmysql(iseguro($cone,$_POST['finven']));
	if(isset($localped) && !empty($localped) && isset($iniven) && !empty($iniven) && isset($finven) && !empty($finven)){

		$cprod=mysqli_query($cone,"SELECT p.idproducto, um.abreviatura, p.nombre FROM producto p INNER JOIN unimedida um ON p.idunimedida=um.idunimedida where p.estado=1");
			if (mysqli_num_rows($cprod)>0) {
?>
				<hr>
				<table id="dtprod" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
					<thead>
						<tr>
							<th style="font-size:12px;">PRODUCTO VENDIDO</th>
							<th style="font-size:12px;">UNIDAD DE MEDIDA</th>
							<th style="font-size:12px;">CANTIDAD</th>
						</tr>
					</thead>
					<tbody>
<?php
			if ($localped=="t") {
				$wl="";
			}else {
				$wl= "AND l.idlocal=$localped";
			}


				while($rcprod=mysqli_fetch_assoc($cprod)){

					$prod=$rcprod['idproducto'];
					$c="SELECT dv.* FROM venta v INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN detventa dv ON v.idventa=dv.idventa INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE v.estado=2 AND (date_format(v.fecha, '%Y-%m-%d') BETWEEN '$iniven' AND '$finven') AND p.idproducto=$prod $wl";

					$cv=mysqli_query($cone,$c);

					if (mysqli_num_rows($cv)>0){
						$cant=0;
						while($rcv=mysqli_fetch_assoc($cv)){
							$cant=$cant+$rcv['cantidad'];
								}
								?>
									<tr> <!--Fila de ventas-->
										<td style="font-size:12px;"> <?php echo $rcprod['nombre']; ?> </td> <!--columna NOMBRE-->
										<td style="font-size:12px;"> <?php echo $rcprod['abreviatura']; ?> </td> <!--columna UNIDAD DE MEDIDA-->
										<td style="font-size:12px;"> <?php echo $cant; ?> </td> <!--columna CANTIDAD-->
									</tr>
<?php
							}
				}
?>
					  </tbody>
					</table>
					<script>
					$('#dtprod').DataTable({
						"order": [[2,"desc"]]
					});
					</script>
<?php
		}
}else{
		echo mensajeda("Error: Debe seleccionar las fechas y el local");
	}
  mysqli_close($cone);

?>
