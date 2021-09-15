<?php 
session_start();
if(isset($_POST['acc']) && !empty($_POST['acc'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$acc=iseguro($cone,$_POST['acc']);
	$idm=iseguro($cone,$_POST['idm']);
	if(vaccesom($cone, $id, $idm, 1)){

		$r=array();
		if($acc=="add"){
			if(isset($_POST['mie']) && !empty($_POST['mie']) && isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['con']) && !empty($_POST['con'])){
				$mie=iseguro($cone,$_POST['mie']);
				$usu=iseguro($cone,$_POST['usu']);
				$con=sha1(iseguro($cone,$_POST['con']));
				$est=count($_POST['est'])==1 ? 1 : 0;
				$cnu=mysqli_query($cone,"SELECT idusuario FROM usuario WHERE nombre='$usu';");
				if($rnu=mysqli_fetch_assoc($cnu)){
					$r['m']=mensajeda("El usuario ya existe");
					$r['e']=false;
				}else{
					if(mysqli_query($cone,"INSERT INTO usuario (nombre, contrasenia, estado, idmiembro, usuario) VALUES ('$usu', '$con', $est, $mie, $id);")){
						$r['m']=mensajesu("Usuario registrado correctamente");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error, vuelva a intentarlo");
						$r['e']=false;
					}
				}
				mysqli_free_result($cnu);
			}else{
				$r['m']=mensajeda("Miembro, usuario y contraseña son obligatorios");
				$r['e']=false;
			}
		}elseif($acc=="edit"){
			if(isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['idu']) && !empty($_POST['idu'])){
				$idu=iseguro($cone,$_POST['idu']);
				$usu=iseguro($cone,$_POST['usu']);
				$est=count($_POST['est'])==1 ? 1 : 0;
				$cnu=mysqli_query($cone,"SELECT idusuario FROM usuario WHERE idusuario!=$idu AND nombre='$usu';");
				if($rnu=mysqli_fetch_assoc($cnu)){
					$r['m']=mensajeda("El usuario ya existe");
					$r['e']=false;
				}else{
					if(mysqli_query($cone,"UPDATE usuario SET nombre='$usu', estado=$est WHERE idusuario=$idu;")){
						$r['m']=mensajesu("Usuario editado correctamente");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error, vuelva a intentarlo");
						$r['e']=false;
					}
				}
				mysqli_free_result($cnu);
			}else{
				$r['m']=mensajeda("El usuario es obligatorio");
				$r['e']=false;
			}
		}elseif($acc=="cont"){
			if(isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['rcon']) && !empty($_POST['rcon'])){
				$idu=iseguro($cone,$_POST['idu']);
				$con=sha1(iseguro($cone,$_POST['con']));
				$rcon=sha1(iseguro($cone,$_POST['rcon']));
				if($con==$rcon){
					if(mysqli_query($cone,"UPDATE usuario SET contrasenia='$con', usuario=$id WHERE idusuario=$idu;")){
						$r['m']=mensajesu("Se cambio la contraseña");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error al cambiar la contraseña");
						$r['e']=false;
					}
				}else{
					$r['m']=mensajeda("Las contraseñas no coinciden");
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("Ambos campos son obligatorios");
				$r['e']=false;
			}
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($r);	
	}

	mysqli_close($cone);
}
?>