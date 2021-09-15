<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$idm=iseguro($cone, $_POST['idm']);
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['local']);
$estado=iseguro($cone, $_POST['est']);
$clientep=iseguro($cone,$_POST['clientep']);
$iniped=fmysql(iseguro($cone,$_POST['iniped']));
$finped=fmysql(iseguro($cone,$_POST['finped']));
	if(isset($clientep) && !empty($clientep) && isset($iniped) && !empty($iniped) && isset($finped) && !empty($finped) ){
		if ($clientep=="t") {
			$wu="";
		}else {
			$wu= "AND p.idpersona=$clientep";
		}
			$c="SELECT v.idventa, u.usuario, l.nombre AS tienda, v.fecha, p.idpersona, p.nombre, v.descuento, tp.tipopag, td.tipodoc, LPAD(dv.numero, 8,'0') AS numdoc, l.seriecom FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN caja c ON c.idcaja=v.idcaja INNER JOIN usuario u ON c.idusuario = u.idusuario INNER JOIN tipopag tp ON v.idtipopag= tp.idtipopag INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN tipodoc td ON dv.idtipodoc=td.idtipodoc WHERE v.estado=$estado AND (date_format(v.fecha, '%Y-%m-%d') BETWEEN '$iniped' AND '$finped') $wu";
			//echo $c;
			$cp=mysqli_query($cone,$c);
			if (mysqli_num_rows($cp)>0) {
		?>
		<hr>
		<table id="dtventas" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
		  <thead>
				<tr>
					<th style="font-size:12px;">TIENDA</th>
					<th style="font-size:12px;">CAJERA/O</th>
					<th style="font-size:12px;">FECHA</th>
          <th style="font-size:12px;">CLIENTE</th>
					<th style="font-size:12px;">DOCUMENTO</th>
					<th style="font-size:12px;">T.PAGO</th>
          <th style="font-size:12px;">MONTO</th>
          <th style="font-size:12px;">DETALLE</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($rcp=mysqli_fetch_assoc($cp)){
						$idped=$rcp['idventa'];
						$cdv=mysqli_query($cone,"SELECT dv.*, p.nombre, p.precioven FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$idped;");
					    if(mysqli_num_rows($cdv)>0){
					        $n=0;
					        $st=0;
					        while($rdv=mysqli_fetch_assoc($cdv)){
					          $n++;
					          $st=$st+$rdv['subtotal'];
					        }
					        //$de=n_22decimal($st*$rcp['descuento']);
							?>
								<tr> <!--Fila de ventas-->
									<td style="font-size:12px;"> <?php echo $rcp['tienda']?> </td> <!--columna TIENDA-->
									<td><?php echo $rcp['usuario']?></td> <!--columna CAJERO-->
									<td><?php echo date('d/m/Y H:i', strtotime($rcp['fecha']))?></td> <!--columna FECHA-->
			            <td><?php echo $rcp['nombre']?></td> <!--columna CLIENTE-->
									<td><?php echo substr($rcp['tipodoc'],0,1).$rcp['seriecom']."-".$rcp['numdoc'];?></td>
									<td><?php echo $rcp['tipopag']; ?></td>
									<td><?php echo "S/ ". n_22decimal($st-$de);?></td> <!--columna MONTO-->
									<td>
										<a class="btn btn-info btn-xs" href="#" data-toggle="modal" data-target="#modal"><i class="fa fa-info-circle" onclick="detped(<?php echo $rcp['idventa']?>)"></i></a>
									</td> <!--columna DETALLE-->
								</tr>
								<?php
								}else{
									echo mensajeda("No se encontraron items en el detalle");
								}
						}
					 ?>
			  </tbody>
			</table>
			<script>
			$('#dtventas').DataTable({
				"order": [[2,"asc"]]
			});
			</script>
		<?php
	}else {
			echo mensajeda("No se encontraron resultados");
		}

}else{
		echo mensajeda("Error: Debe seleccionar al menos un valor en cada campo");
	}
  mysqli_close($cone);

?>
