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


		//if(isset($_POST['fecv']) && !empty($_POST['fecv'])){
			//$fecv=iseguro($cone,$_POST['fecv']);

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
		<span class="titulo"><i class="fa fa-check-square-o text-muted"></i> Validación de <?php echo $fecv; ?></span>
		<hr>
<?php
			
			//conexion
			$conn = new SQLite3('C:/SFS_v1.3.2/bd/BDFacturador.db');

			if($conn){
				$q="SELECT * FROM DOCUMENTO";//WHERE FEC_CARG='$fecv'
				$rs=$conn->query($q);
		?>
			<div class="table-responsive">
			<table class="table table-bordered table-hover" id="t_vali">
				<thead>
				<tr>
					<th>#</th>
					<th>ACCIÓN</th>
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
				while($fi=$rs->fetchArray(SQLITE3_ASSOC)){
					$n++;
					$tip_docu=$fi['TIP_DOCU'];
					$num_docu=$fi['NUM_DOCU'];
					$fec_carg=vacio(fmysql($fi['FEC_CARG']));
					$fec_cargo=$fi['FEC_CARG'];
					$fec_gene=vacio(ftmysql($fi['FEC_GENE']));
					$fec_gener=$fi['FEC_GENE'];
					$fec_envi=vacio(ftmysql($fi['FEC_ENVI']));
					$fec_envio=$fi['FEC_ENVI'];
					$des_obse=vacio($fi['DES_OBSE']);
					$des_obser=$fi['DES_OBSE'];
					$nom_arch=$fi['NOM_ARCH'];
					$ind_situ=$fi['IND_SITU'];
					$cd=mysqli_query($cone,"SELECT iddfacturador FROM dfacturador WHERE num_docu='$num_docu'");
					if($rd=mysqli_fetch_assoc($cd)){
						if(mysqli_query($cone,"UPDATE dfacturador SET tip_docu='$tip_docu', fec_carg=$fec_carg, fec_gene=$fec_gene, fec_envi=$fec_envi, des_obse=$des_obse, nom_arch='$nom_arch', ind_situ='$ind_situ' WHERE num_docu='$num_docu'")){
							$men="Editado<br>";
						}else{
							$men="Error Editar<br>";
						}
					}else{
						if(mysqli_query($cone,"INSERT INTO dfacturador (tip_docu, num_docu, fec_carg, fec_gene, fec_envi, des_obse, nom_arch, ind_situ) VALUES('$tip_docu', '$num_docu', $fec_carg, $fec_gene, $fec_envi, $des_obse, '$nom_arch', '$ind_situ');")){
							$men="Registrado<br>";
						}else{
							$men="Error Registrar<br>";
						}
					}

					if($ind_situ=='03' || $ind_situ=='04' || $ind_situ=='11' || $ind_situ=='12'){

						$origen='C:/SFS_v1.3.2/sunat_archivos/sfs/DATA/'.$nom_arch;
						$destino='C:/SFS_v1.3.2/sunat_archivos/sfs/DATA/archivados/'.$nom_arch;

						if(file_exists($origen.".cab")){
							rename($origen.".cab",$destino.".cab");
							//unlink($origen.".cab");
							$men.=" cab";
						}
						if(file_exists($origen.".det")){
							rename($origen.".det",$destino.".det");
							//unlink($origen.".det");
							$men.=" det";
						}
						if(file_exists($origen.".tri")){
							rename($origen.".tri",$destino.".tri");
							//unlink($origen.".tri");
							$men.=" tri";
						}
						if(file_exists($origen.".ley")){
							rename($origen.".ley",$destino.".ley");
							//unlink($origen.".ley");
							$men.=" ley";
						}
						if(file_exists($origen.".rel")){
							rename($origen.".rel",$destino.".rel");
							//unlink($origen.".rel");
							$men.=" rel";
						}
						if(file_exists($origen.".acv")){
							rename($origen.".acv",$destino.".acv");
							//unlink($origen.".acv");
							$men.=" acv";
						}
						if(file_exists($origen.".cba")){
							rename($origen.".cba",$destino.".cba");
							//unlink($origen.".cba");
							$men.=" cba";
						}
						if(file_exists($origen.".rdi")){
							rename($origen.".rdi",$destino.".rdi");
							rename($origen.".trd",$destino.".trd");
							//unlink($origen.".rdi");
							$men.=" rdi";
						}
						if(file_exists($origen.".trd")){
							rename($origen.".trd",$destino.".trd");
							//unlink($origen.".rdi");
							$men.=" trd";
						}
					}
		?>
				<tr>
					<td><?php echo $n; ?></td>
					<td><?php echo $men; ?></td>
					<td><?php echo $tip_docu; ?></td>
					<td><?php echo $num_docu; ?></td>
					<td><?php echo $fec_cargo; ?></td>
					<td><?php echo $fec_gener; ?></td>
					<td><?php echo $fec_envio; ?></td>
					<td><?php echo $nom_arch; ?></td>
					<td><?php echo estadodocu($ind_situ); ?></td>
					<td><?php echo $des_obser; ?></td>
				</tr>
		<?php
				}
		?>
				</tbody>
			</table>
			</div>
<script>
	$("#t_vali").DataTable();
</script>
		<?php
				$conn->close();
			}else{
				echo "Error de conección a la BD del facturador";
			}
		//}else{
			//echo mensajeda("Ingrese fecha para validar");
		//}



	}else{
		echo mensajeda("Acceso restringido, no tiene permisos de administrador");
	}
}else{
	echo "Sin permisos";
}
?>