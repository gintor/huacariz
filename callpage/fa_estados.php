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

	if(vaccesom($cone,$id,$idm,1) || vaccesom($cone,$id,$idm,2)){


		if(isset($_POST['inie']) && !empty($_POST['inie']) && isset($_POST['fine']) && !empty($_POST['fine'])){
			$inie=fmysql(iseguro($cone,$_POST['inie']));
			$fine=fmysql(iseguro($cone,$_POST['fine']));
		  if($fine>=$inie){
		  	function estadodocu($doc){
		  		switch ($doc) {
		  			case '01':
		  				return "Por Generar XML";
		  				break;
		  			case '02':
		  				return "XML Generado";
		  				break;
		  			case '03':
		  				return "Enviado y Aceptado SUNAT";
		  				break;
		  			case '04':
		  				return "Enviado y Aceptado SUNAT con Obs.";
		  				break;
		  			case '05':
		  				return "Rechazado por SUNAT";
		  				break;
		  			case '06':
		  				return "Con Errores";
		  				break;
		  			case '07':
		  				return "Por Validar XML";
		  				break;
		  			case '08':
		  				return "Enviado a SUNAT Por Procesar";
		  				break;
		  			case '09':
		  				return "Enviado a SUNAT Procesando";
		  				break;
		  			case '10':
		  				return "Rechazado por SUNAT";
		  				break;
		  			case '11':
		  				return "Enviado y Aceptado SUNAT";
		  				break;
		  			case '12':
		  				return "Enviado y Aceptado SUNAT con Obs.";
		  				break;
		  		}
		  	}

?>
		<br>
		<span class="titulo"><i class="fa fa-check-square-o text-muted"></i> Estados del <?php echo $inie; ?> al <?php echo $fine; ?></span>
		<hr>
<?php
			$c=mysqli_query($cone,"SELECT * FROM dfacturador WHERE DATE_FORMAT(fec_carg,'%Y-%m-%d') BETWEEN '$inie' AND '$fine' ORDER BY num_docu ASC;");
			if(mysqli_num_rows($c)>0){
?>
			<div class="table-responsive">
			<table class="table table-bordered table-hover" id="t_esta">
				<thead>
				<tr>
					<th>#</th>
					<th>TIP_DOCU</th>
					<th>NUM_DOCU</th>
					<th>FEC_CARG</th>
					<th>FEC_GENE</th>
					<th>FEC_ENVI</th>
					<th>NOM_ARCH</th>
					<th>IND_SITU</th>
					<th>DES_OBSE</th>
				</tr>
				</thead>
				<tbody>
<?php
				$n=0;
				while($r=mysqli_fetch_assoc($c)){
					$n++;
?>
				<tr>
					<td><?php echo $n; ?></td>
					<td><?php echo $r['tip_docu']; ?></td>
					<td><?php echo $r['num_docu']; ?></td>
					<td><?php echo $r['fec_carg']; ?></td>
					<td><?php echo $r['fec_gene']; ?></td>
					<td><?php echo $r['fec_envi']; ?></td>
					<td><?php echo $r['nom_arch']; ?></td>
					<td><?php echo estadodocu($r['ind_situ']); ?></td>
					<td><?php echo $r['des_obse']; ?></td>
				</tr>
<?php
				}
			}
			mysqli_free_result($c);
?>
				</tbody>
			</table>
			</div>
<script>
	$("#t_esta").DataTable();
</script>
<?php
		  }else{
				echo mensajeda("La fecha inicial no puede ser mayor a la final");
		  }
		}else{
			echo mensajeda("Ingrese ambas fechas");
		}



	}else{
		echo mensajeda("Acceso restringido, no tiene permisos de administrador");
	}
	mysqli_close($cone);
}else{
	echo "Sin permisos";
}
?>