<?php
include_once 'call/cone.php';
include_once 'cons.php';
include_once 'call/func.php';

?>
<form method="post">
	<label for="fec">Fecha</label>
	<input type="date" name="fec" id="fec" required="required">
	<button type="submit">Buscar</button>
</form>
<?php
if(isset($_POST['fec']) && !empty($_POST['fec'])){
	echo $_POST['fec']."<br>";
	$fec=fnormal(iseguro($cone,$_POST['fec']));
	//conexion
	$conn = new SQLite3('C:/SFS_v1.2/bd/BDFacturador.db');

	if($conn){
		$q="SELECT * FROM DOCUMENTO WHERE FEC_CARG='$fec'";
		$rs=$conn->query($q);
?>
	<table border="1">
		<tr>
			<th>#</th>
			<th>En Base</th>
			<th>TIP_DOCU</th>
			<th>NUM_DOCU</th>
			<th>FEC_CARG</th>
			<th>FEC_GENE</th>
			<th>FEC_ENVI</th>
			<th>DES_OBSE</th>
			<th>NOM_ARCH</th>
			<th>IND_SITU</th>
			<th>MENSAJE</th>
		</tr>
<?php
		$n=0;
		while($fi=$rs->fetchArray(SQLITE3_ASSOC)){
			$n++;
			$tip_docu=$fi['TIP_DOCU'];
			$num_docu=$fi['NUM_DOCU'];
			$fec_carg=vacio(fmysql($fi['FEC_CARG']));
			$fec_gene=vacio(ftmysql($fi['FEC_GENE']));
			$fec_envi=vacio(ftmysql($fi['FEC_ENVI']));
			$des_obse=vacio($fi['DES_OBSE']);
			$nom_arch=$fi['NOM_ARCH'];
			$ind_situ=$fi['IND_SITU'];
			$cd=mysqli_query($cone,"SELECT iddfacturador FROM dfacturador WHERE num_docu='$num_docu'");
			if($rd=mysqli_fetch_assoc($cd)){
				$cond="SI";
				if(mysqli_query($cone,"UPDATE dfacturador SET tip_docu='$tip_docu', fec_carg=$fec_carg, fec_gene=$fec_gene, fec_envi=$fec_envi, des_obse=$des_obse, nom_arch='$nom_arch', ind_situ='$ind_situ' WHERE num_docu='$num_docu'")){
					$men="Editado";
				}else{
					$men="Error Editar";
				}
			}else{
				$cond="NO";
				if(mysqli_query($cone,"INSERT INTO dfacturador (tip_docu, num_docu, fec_carg, fec_gene, fec_envi, des_obse, nom_arch, ind_situ) VALUES('$tip_docu', '$num_docu', $fec_carg, $fec_gene, $fec_envi, $des_obse, '$nom_arch', '$ind_situ');")){
					$men="Agregado";
				}else{
					$men="Error Agregar";
				}
			}

			if($ind_situ=='03' || $ind_situ=='04' || $ind_situ=='11' || $ind_situ=='12'){

				$origen='C:/SFS_v1.2/sunat_archivos/sfs/DATA/'.$nom_arch;
				$destino='C:/SFS_v1.2/sunat_archivos/sfs/DATA/antiguos/'.$nom_arch;

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
					//unlink($origen.".rdi");
					$men.=" rdi";
				}
			}
?>
		<tr>
			<td><?php echo $n; ?></td>
			<td><?php echo $cond; ?></td>
			<td><?php echo $tip_docu; ?></td>
			<td><?php echo $num_docu; ?></td>
			<td><?php echo $fec_carg; ?></td>
			<td><?php echo $fec_gene; ?></td>
			<td><?php echo $fec_envi; ?></td>
			<td><?php echo $des_obse; ?></td>
			<td><?php echo $nom_arch; ?></td>
			<td><?php echo $ind_situ; ?></td>
			<td><?php echo $men; ?></td>
		</tr>
<?php
		}
?>
	</table>
<?php
	}else{
		echo "Error de conección a la BD del facturador";
	}

}else{
	echo "No se envio nada";
}

?>