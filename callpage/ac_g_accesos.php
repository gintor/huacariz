<?php 
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$r=array();
$r['e']=false;
if(isset($_POST['acc']) && !empty($_POST['acc'])){

	$id=iseguro($cone, $_SESSION['idusu']);
	$lo=iseguro($cone, $_SESSION['local']);
	$acc=iseguro($cone,$_POST['acc']);
	$idm=iseguro($cone,$_POST['idm']);
	

		if($acc=="addusu"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['con1']) && !empty($_POST['con1']) && isset($_POST['con2']) && !empty($_POST['con2'])){
					$usu=iseguro($cone, $_POST['usu']);
					$nusu=iseguro($cone, $_POST['nusu']);
					$con1=sha1(iseguro($cone, $_POST['con1']));
					$con2=sha1(iseguro($cone, $_POST['con2']));
					if($con1===$con2){
						$cu=mysqli_query($cone,"SELECT * FROM usuario WHERE idpersona=$usu OR usuario='$nusu';");
						if($ru=mysqli_fetch_assoc($cu)){
							$r['m']=mensajeda("El colaborador seleccionado ya tiene un usuario creado o el usuario ya existe");
						}else{
							if(mysqli_query($cone,"INSERT INTO usuario (usuario, idpersona, estado, contrasenia) VALUES ('$nusu', $usu, 1, '$con1');")){
								$r['m']=mensajesu("Usuario registrado correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al registrar el usuario, vuelva a intentarlo");
							}
						}
						mysqli_free_result($cu);
					}else{
						$r['m']=mensajeda("Las contraseñas no coinciden");
					}
				}else{
					$r['m']=mensajeda("Todos los campos son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="estusu"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					$cu=mysqli_query($cone,"SELECT estado FROM usuario WHERE idusuario=$idf;");
					if($ru=mysqli_fetch_assoc($cu)){
						$est=$ru['estado']==1 ? 0 : 1;
						$mest=$ru['estado']==1 ? "desactivado" : "activado";
						if(mysqli_query($cone,"UPDATE usuario SET estado=$est WHERE idusuario=$idf;")){
							$r['m']=mensajesu("Usuario $mest correctamente");
							$r['e']=true;
						}else{
							$r['m']=mensajeda("Error al cambiar estado, vuelva a intentarlo");
						}
					}else{
						$r['m']=mensajeda("Error el usuario no existe");
					}
					mysqli_free_result($cu);
				}else{
					$r['m']=mensajeda("Faltan datos");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="conusu"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					$con1=sha1(iseguro($cone,$_POST['con1']));
					$con2=sha1(iseguro($cone,$_POST['con2']));
					if($con1===$con2){
						if(mysqli_query($cone,"UPDATE usuario SET contrasenia='$con1' WHERE idusuario=$idf;")){
							$r['m']=mensajesu("Contraseña cambiada");
							$r['e']=true;
						}else{
							$r['m']=mensajeda("Error al cambiar la contraseña, vuelva a intentarlo");
						}
					}else{
						$r['m']=mensajeda("Las contraseñas no coinciden");
					}
				}else{
					$r['m']=mensajeda("Faltan datos");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}
	mysqli_close($cone);
}else{
	$r['m']=mensajeda("No envio acción");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
?>