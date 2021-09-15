<?php
session_start();
$r=array();
if(isset($_POST['idm']) && !empty($_POST['idm'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$idm=iseguro($cone, $_POST['idm']);
	$id=iseguro($cone, $_SESSION['idusu']);
	if(vaccesom($cone,$id,$idm,1)){
		if(isset($_POST['idu']) && !empty($_POST['idu']) && isset($_POST['idmod']) && !empty($_POST['idmod']) && isset($_POST['niv']) && !empty($_POST['niv'])){
			$idu=iseguro($cone,$_POST['idu']);
			$idmod=iseguro($cone,$_POST['idmod']);
			$niv=iseguro($cone,$_POST['niv']);
			$cmu=mysqli_query($cone,"SELECT idmodusuario FROM modusuario WHERE idmodulo=$idmod AND idusuario=$idu;");
			if($rmu=mysqli_fetch_assoc($cmu)){
				$idmous=$rmu['idmodusuario'];
				if($niv==3){
					if(mysqli_query($cone,"UPDATE modusuario SET estado=0, usuario=$id WHERE idmodusuario=$idmous;")){
						$r['m']=amensajesu("Permiso actualizado");
						$r['e']=true;					
					}else{
						$r['m']=amensajeda("Error al actualizar");
						$r['e']=false;
					}
				}else{
					if(mysqli_query($cone,"UPDATE modusuario SET nivel=$niv, estado=1, usuario=$id WHERE idmodusuario=$idmous;")){
						$r['m']=amensajesu("Permiso actualizado");
						$r['e']=true;
					}else{
						$r['m']=amensajeda("Error al actualizar");
						$r['e']=false;
					}
				}
			}else{
				if($niv!=3){
					if(mysqli_query($cone,"INSERT INTO modusuario (nivel, estado, usuario, idmodulo, idusuario) VALUES ($niv, 1, $id, $idmod, $idu)")){
						$r['m']=amensajesu("Permiso actualizado");
						$r['e']=true;
					}else{
						$r['m']=amensajeda("Error al actualizar");
						$r['e']=false;
					}
				}else{
					$r['m']=amensajesu("Permiso actualizado");
					$r['e']=true;
				}
			}
			mysqli_free_result($cmu);
		}else{

		}
	}else{
		$r['m']=amensajeda("Acceso restringido");
		$r['e']=false;
	}
	mysqli_close($cone);
}else{
	$r['m']="¡Módulo!";
	$r['e']=false;
}
echo json_encode($r);
?>