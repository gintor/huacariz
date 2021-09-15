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

	if(isset($_POST['cant']) && !empty($_POST['cant'])){
		if(isset($_POST['iddv']) && !empty($_POST['iddv'])){
			$cant=n_22decimal(iseguro($cone,$_POST['cant']));
			$iddv=iseguro($cone,$_POST['iddv']);

			$cp=mysqli_query($cone,"SELECT preunitario FROM detventa WHERE iddetventa=$iddv;");
			if($rp=mysqli_fetch_assoc($cp)){
				$st=$rp['preunitario']*$cant;
				if(mysqli_query($cone,"UPDATE detventa SET cantidad=$cant, subtotal=$st WHERE iddetventa=$iddv;")){
					$r['e']=true;
					$r['m']=mensajesu("Cantidad editada");
				}else{
					$r['m']=mensajeda("Error al editar cantidad");
				}
			}else{
				$r['m']=mensajeda("Datos invalidos");
			}
			mysqli_free_result($cp);

		}else{
			$r['m']=mensajeda("Faltan datos");
		}
	}else{
		$r['m']=mensajeda("No ingreso una cantidad");
	}

	

}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);

?>