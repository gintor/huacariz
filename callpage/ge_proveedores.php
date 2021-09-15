<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
if(vlogin($cone, $no, $id)){
	$b=iseguro($cone,$_GET['q']);
	$c=mysqli_query($cone,"SELECT idpersona, nombre FROM persona WHERE relacion=2 AND ((nombre LIKE '%$b%') OR (numerodoc LIKE '%$b%'));");
	if(mysqli_num_rows($c)>0){
		while($r=mysqli_fetch_assoc($c)){
			$data[]=array('id'=>$r['idpersona'], 'text'=>$r['nombre']);
		}
	}else{
		$data[] = array('id' => '0', 'text' => 'SIN COINCIDENCIAS');
	}
}else{
	$data[] = array('id' => '0', 'text' => 'ACCESO RESTRINGIDO');
}
echo json_encode($data);
?>