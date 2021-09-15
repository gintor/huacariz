<?php 
session_start();
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$idm=iseguro($cone,$_POST['idm']);

	$r=array();
	$r['m']="";

	if(vaccesom($cone, $id, $idm, 1) || vaccesom($cone, $id, $idm, 2)){



		if(isset($_POST['cli']) && !empty($_POST['cli'])){
			$cli=iseguro($cone,$_POST['cli']);	

			$cd=mysqli_query($cone,"SELECT descuento FROM persona WHERE idpersona=$cli");
			if($rd=mysqli_fetch_assoc($cd)){
				if($rd['descuento']>0){
					$r['m']=mensajesu("Se aplicará <b>".($rd['descuento']*100)."%</b> de descuento, solo en nuestros productos");
				}
			}
			mysqli_free_result($cd);

		}
		
	}
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($r);

	mysqli_close($cone);

?>