<?php
session_start();
include 'cone.php';
//include '../cons.php';
include 'func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
if(vlogin($cone, $no, $id)){
	$d=array();
	if(isset($_POST['acon']) && !empty($_POST['acon']) && isset($_POST['ncon']) && !empty($_POST['ncon']) && isset($_POST['rcon']) && !empty($_POST['rcon'])){
		if(strlen($_POST['ncon'])>=8){
			$acon=sha1(iseguro($cone,$_POST['acon']));
			$ncon=sha1(iseguro($cone,$_POST['ncon']));
			$rcon=sha1(iseguro($cone,$_POST['rcon']));
			if($ncon===$rcon){
				$cc=mysqli_query($cone,"SELECT nombre FROM usuario WHERE idusuario=$id AND contrasenia='$acon';");
				if($rc=mysqli_fetch_assoc($cc)){
					if(mysqli_query($cone,"UPDATE usuario SET contrasenia='$ncon' WHERE idusuario=$id;")){
						$d['m']=mensajesu("Se cambio la contraseña!!!");
						$d['e']=true;
					}else{
						$d['m']=mensajeda("Error al cambiar la contraseña, vuelva a intentarlo.");
						$d['e']=false;
					}
				}else{
					$d['m']=mensajeda("La contraseña actual es incorrecta.");
					$d['e']=false;
				}
				mysqli_free_result($cc);
			}else{
				$d['m']=mensajeda("Las contraseñas no coinciden.");
				$d['e']=false;
			}
		}else{
			$d['m']=mensajeda("La nueva contraseña debe tener mínimo 8 caracteres.");
			$d['e']=false;
		}
	}else{
		$d['m']=mensajeda("Todos los campos son obligatorios.");
		$d['e']=false;
	}
}else{
  	$d['m']=mensajeda("Acceso restringido.");
	$d['e']=false;
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>