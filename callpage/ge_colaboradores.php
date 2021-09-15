<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['local']);
if(vlogin($cone, $no, $id)){
	$t=iseguro($cone,$_GET['q']);
	$c=mysqli_query($cone, "SELECT idpersona, nombre FROM persona WHERE relacion=3 AND (nombre LIKE '%$t%' OR numerodoc LIKE '%$t%') ORDER BY nombre ASC;");
	if(mysqli_num_rows($c)>0){
		while($r=mysqli_fetch_assoc($c)){
			$data[]=array('id'=>$r['idpersona'], 'text'=>utf8_encode($r['nombre']));
		}
	}else{
		$data[]=array('id'=>'0', 'text'=>'NO SE ENCONTRO COINCIDENCIAS');
	}
	mysqli_free_result($c);
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($data);
}
mysqli_close($cone);