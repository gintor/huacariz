<?php
session_start();
include 'cone.php';
include 'func.php';
$d=array();
if(isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['pas']) && !empty($_POST['pas']) && isset($_POST['loc']) && !empty($_POST['loc'])){
	$usu=iseguro($cone, $_POST['usu']);
	$pas=iseguro($cone, $_POST['pas']);
	$loc=iseguro($cone, $_POST['loc']);
	$cl=mysqli_query($cone, "SELECT idlocal FROM local WHERE idlocal=$loc");
	if($rl=mysqli_fetch_assoc($cl)){
		$c=mysqli_query($cone,"SELECT u.idusuario, u.contrasenia, p.nombre, u.estado FROM usuario u INNER JOIN persona p ON u.idpersona=p.idpersona WHERE usuario='$usu';");
		if ($r=mysqli_fetch_assoc($c)){
				$pas=sha1($pas);
				if($r['contrasenia']===$pas){
					if($r['estado']==1){
						$d['exito']=true;
						$d['mensaje']=mensajesu("Bienvenido");
						$_SESSION['nousu']=$r['nombre'];
						$_SESSION['idusu']=$r['idusuario'];
						$_SESSION['local']=$loc;
					}else{
						$d['exito']=false;
						$d['mensaje']=mensajeda("Usuario bloqueado");
					}
				}else{
					$d['exito']=false;
					$d['mensaje']=mensajeda("Usuario o contraseña incorrectos");
				}
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajeda("Usuario o contraseña incorrectos");
		}
		mysqli_free_result($c);
	}else{
		$d['exito']=false;
		$d['mensaje']=mensajeda("No eligió un local válido");
	}
	mysqli_free_result($cl);
}else{
	$d['exito']=false;
	$d['mensaje']=mensajeda("Todos los campos son obligatorios");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>