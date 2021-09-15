<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
if(vlogin($cone, $no, $id)){
	if(isset($_POST['iddep']) && !empty($_POST['iddep'])){
		$iddep=iseguro($cone,$_POST['iddep']);
		$c=mysqli_query($cone,"SELECT idprovincia, provincia FROM provincia WHERE iddepartamento=$iddep ORDER BY provincia ASC;");
		if(mysqli_num_rows($c)>0){
?>
				<option value="">PROVINCIA</option>
<?php
			while($r=mysqli_fetch_assoc($c)){
?>
				<option value="<?php echo $r['idprovincia']; ?>"><?php echo $r['provincia']; ?></option>
<?php
			}
		}else{
?>
				<option value="">SIN DATOS</option>
<?php
		}
		mysqli_free_result($c);
	}elseif(isset($_POST['idpro']) && !empty($_POST['idpro'])){
		$idpro=iseguro($cone,$_POST['idpro']);
		$c=mysqli_query($cone,"SELECT iddistrito, distrito FROM distrito WHERE idprovincia=$idpro ORDER BY distrito ASC;");
		if(mysqli_num_rows($c)>0){
?>
				<option value="">DISTRITO</option>
<?php
			while($r=mysqli_fetch_assoc($c)){
?>
				<option value="<?php echo $r['iddistrito']; ?>"><?php echo $r['distrito']; ?></option>
<?php
			}
		}else{
?>
				<option value="">SIN DATOS</option>
<?php
		}
		mysqli_free_result($c);
	}
}else{
?>
	<option value="">RESTRINGIDO</option>
<?php
}
?>