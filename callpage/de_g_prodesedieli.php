<?php 
session_start();

include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['local']);
$acc=iseguro($cone,$_POST['acc']);
$idm=iseguro($cone,$_POST['idm']);
$r=array();
$r['e']=false;
if(vaccesom($cone, $id, $idm, 1)){
		if(isset($_POST['iddv']) && !empty($_POST['iddv'])){
			$iddv=iseguro($cone,$_POST['iddv']);
			if(mysqli_query($cone,"DELETE FROM detventa WHERE iddetventa=$iddv;")){
				$r['m']=mensajesu("Producto eliminado");
				$r['e']=true;
			}else{
				$r['m']=mensajeda("Error al eliminar");
			}
		}else{
			$r['m']=mensajeda("Faltan datos");
		}
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);

?>