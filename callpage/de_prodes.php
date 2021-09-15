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
		$r=array();
		$r['e']=false;
		if(vaccesom($cone,$id,$idm,1)){
			$acc=iseguro($cone,$_POST['acc']);
			$idf=iseguro($cone,$_POST['idf']);
			$can=n_22decimal(iseguro($cone,$_POST['can']));
			switch ($acc) {
				case 'add':
					$_SESSION['pro'][$idf]=$can;
					$r['e']=true;
					$r['m']="Producto agregado";
					break;
				case 'can':
					$_SESSION['pro'][$idf]=$can;
					$r['e']=true;
					$r['m']="Cantidad editada";
					break;
				case 'eli':
					unset($_SESSION['pro'][$idf]);
					$r['e']=true;
					$r['m']="Producto eliminado";
					break;
				case 'des':
					unset($_SESSION['pro']);
					$r['e']=true;
					$r['m']="Productos eliminados";
					break;
			}
		}
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($r);

	mysqli_close($cone);
}
?>