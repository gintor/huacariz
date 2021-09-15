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
			if(isset($_POST['sdia']) && !empty($_POST['sdia']) && isset($_POST['act']) && !empty($_POST['act']) && isset($_POST['glo']) && !empty($_POST['glo'])){
				$mean=iseguro($cone,$_POST['mean']);
				$meana=explode("/",$mean);
				$mes=$meana[0];
				$anio=$meana[1];
				$freg=fmysql(iseguro($cone,$_POST['freg']));
				$nope=vacio(iseguro($cone,$_POST['nope']));
				$sdia=iseguro($cone,$_POST['sdia']);
				$cue=vacio(iseguro($cone,$_POST['cue']));
				$act=iseguro($cone,$_POST['act']);
				$glo=iseguro($cone,$_POST['glo']);
				$obs=iseguro($cone,$_POST['obs']);

				$cco=mysqli_query($cone,"SELECT MAX(codigo) ucod FROM movimiento WHERE idsubdiario=$sdia AND anio='$anio' AND mes=$mes;");
				if($rco=mysqli_fetch_assoc($cco)){
					$nco=$rco['ucod']+1;
				}else{
					$nco=1;
				}
				mysqli_free_result($cco);
				$q="INSERT INTO movimiento (codigo, fecregistro, anio, mes, glosa, observacion, numoperacion, estado, usuario, idsubdiario, idcuenta, idactividad) VALUES ($nco, '$freg', '$anio', $mes, '$glo', '$obs', $nope, 1, $id, $sdia, $cue, $act);";
				if(mysqli_query($cone,$q)){
					$r['m']=mensajesu("Movimiento registrado correctamente");
					$r['e']=true;
				}else{
					$r['m']=mensajeda("Error, vuelva a intentarlo->".mysqli_error($cone)."->".$q);
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("SubDiario, Actividad y Glosa son obligatorios ");
				$r['e']=false;
			}
		}elseif($acc=="edi"){
			if(isset($_POST['act']) && !empty($_POST['act']) && isset($_POST['sdia']) && !empty($_POST['sdia']) && isset($_POST['glo']) && !empty($_POST['glo'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$mean=iseguro($cone,$_POST['mean']);
				$meana=explode("/",$mean);
				$mes=$meana[0];
				$anio=$meana[1];
				$nope=vacio(iseguro($cone,$_POST['nope']));
				$sdia=iseguro($cone,$_POST['sdia']);
				$sdiaa=iseguro($cone,$_POST['sdiaa']);
				$cue=vacio(iseguro($cone,$_POST['cue']));
				$act=iseguro($cone,$_POST['act']);
				$glo=iseguro($cone,$_POST['glo']);
				$obs=iseguro($cone,$_POST['obs']);

				if($sdia!=$sdiaa){
					$cco=mysqli_query($cone,"SELECT MAX(codigo) ucod FROM movimiento WHERE idsubdiario=$sdia AND anio='$anio' AND mes=$mes;");
					if($rco=mysqli_fetch_assoc($cco)){
						$nco=$rco['ucod']+1;
					}else{
						$nco=1;
					}
					mysqli_free_result($cco);
					$nncod=", codigo='$nco'";
				}else{
					$nncod="";
				}
				if(mysqli_query($cone,"UPDATE movimiento SET glosa='$glo', observacion='$obs', numoperacion=$nope, usuario=$id, idsubdiario=$sdia, idcuenta=$cue, idactividad=$act $nncod WHERE idmovimiento=$idmov;")){
					$r['m']=mensajesu("Movimiento editado correctamente");
					$r['e']=true;
				}else{
					$r['m']=mensajeda("Error, vuelva a intentarlo");
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("SubDiario, actividad y Glosa son obligatorios ");
				$r['e']=false;
			}
		}elseif($acc=="est"){
			if(isset($_POST['idmov']) && !empty($_POST['idmov'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$est=iseguro($cone,$_POST['est']);
				$nest=$est==1 ? 0 : 1;
				if(mysqli_query($cone,"UPDATE movimiento SET estado=$nest WHERE idmovimiento=$idmov;")){
					$r['m']=mensajesu("Estado cambiado");
					$r['e']=true;
				}else{
					$r['m']=mensajeda("Error, vuelva a intentarlo");
					$r['e']=false;
				}

			}else{
				$r['m']=mensajeda("No se enviaron datos");
				$r['e']=false;
			}
		}elseif($acc=="eli"){
			if(isset($_POST['idmov']) && !empty($_POST['idmov'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$cdm=mysqli_query($cone,"SELECT iddetallemov FROM detallemov WHERE idmovimiento=$idmov;");
				if(mysqli_num_rows($cdm)>0){
					$r['m']=mensajeda("Error al eliminar, ya cuenta con registros en detalle.");
					$r['e']=false;
				}else{
					if(mysqli_query($cone,"DELETE FROM movimiento WHERE idmovimiento=$idmov;")){
						$r['m']=mensajesu("Movimiento eliminado");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error, vuelva a intentarlo");
						$r['e']=false;
					}
				}
			}else{
				$r['m']=mensajeda("No se enviaron datos");
				$r['e']=false;
			}
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($r);	
	}

	mysqli_close($cone);
}
?>