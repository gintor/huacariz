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
			if(isset($_POST['tmov']) && !empty($_POST['tmov']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['tpag']) && !empty($_POST['tpag']) && isset($_POST['tot']) && !empty($_POST['tot']) && isset($_POST['cue']) && !empty($_POST['cue']) && isset($_POST['act']) && !empty($_POST['act']) && isset($_POST['mie']) && !empty($_POST['mie']) && isset($_POST['emp']) && !empty($_POST['emp']) && isset($_POST['glo']) && !empty($_POST['glo'])){
				$mean=iseguro($cone,$_POST['mean']);
				$meana=explode("/",$mean);
				$mes=$meana[0];
				$anio=$meana[1];
				$tmov=iseguro($cone,$_POST['tmov']);
				$freg=fmysql(iseguro($cone,$_POST['freg']));
				$tdoc=iseguro($cone,$_POST['tdoc']);
				$sdoc=iseguro($cone,$_POST['sdoc']);
				$ndoc=iseguro($cone,$_POST['ndoc']);
				$fdoc=fmysql(iseguro($cone,$_POST['fdoc']));
				$tot=iseguro($cone,$_POST['tot']);
				$mon=iseguro($cone,$_POST['mon']);
				$nope=iseguro($cone,$_POST['nope']);
				$sdia=iseguro($cone,$_POST['sdia']);
				$tpag=iseguro($cone,$_POST['tpag']);
				$cue=iseguro($cone,$_POST['cue']);
				$act=iseguro($cone,$_POST['act']);
				$mie=iseguro($cone,$_POST['mie']);
				$emp=iseguro($cone,$_POST['emp']);
				$glo=iseguro($cone,$_POST['glo']);
				$obs=iseguro($cone,$_POST['obs']);

				$cco=mysqli_query($cone,"SELECT MAX(codigo) ucod FROM movimiento WHERE idsubdiario=$sdia AND anio='$anio' AND mes=$mes;");
				if($rco=mysqli_fetch_assoc($cco)){
					$nco=$rco['ucod']+1;
				}else{
					$nco=1;
				}
				mysqli_free_result($cco);
				if(mysqli_query($cone,"INSERT INTO movimiento (tipomovimiento, codigo, fecregistro, anio, mes, glosa, observacion, serdocumento, numdocumento, fecdocumento, total, numoperacion, estado, usuario, idmoneda, idsubdiario, idtipodocumento, idtipopago, idcuenta, idmiembro, idactividad, idempresa) VALUES ($tmov, $nco, '$freg', '$anio', $mes, '$glo', '$obs', '$sdoc', $ndoc, '$fdoc', $tot, '$nope', 1, $id, $mon, $sdia, $tdoc, $tpag, $cue, $mie, $act, $emp);")){
					$r['m']=mensajesu("Movimiento registrado correctamente");
					$r['e']=true;
				}else{
					$r['m']=mensajeda("Error, vuelva a intentarlo");
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("Tipo Movimiento, Tipo Documento, Total, Moneda, Tipo Pago, Cuenta, Actividad, Miembro, Empresa, y Glosa son obligatorios ");
				$r['e']=false;
			}
		}elseif($acc=="edi"){
			if(isset($_POST['idmov']) && !empty($_POST['idmov']) && isset($_POST['tmov']) && !empty($_POST['tmov']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['tpag']) && !empty($_POST['tpag']) && isset($_POST['tot']) && !empty($_POST['tot']) && isset($_POST['cue']) && !empty($_POST['cue']) && isset($_POST['act']) && !empty($_POST['act']) && isset($_POST['mie']) && !empty($_POST['mie']) && isset($_POST['emp']) && !empty($_POST['emp']) && isset($_POST['glo']) && !empty($_POST['glo'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$mean=iseguro($cone,$_POST['mean']);
				$meana=explode("/",$mean);
				$mes=$meana[0];
				$anio=$meana[1];
				$tmov=iseguro($cone,$_POST['tmov']);
				$tdoc=iseguro($cone,$_POST['tdoc']);
				$sdoc=iseguro($cone,$_POST['sdoc']);
				$ndoc=iseguro($cone,$_POST['ndoc']);
				$fdoc=fmysql(iseguro($cone,$_POST['fdoc']));
				$tot=iseguro($cone,$_POST['tot']);
				$mon=iseguro($cone,$_POST['mon']);
				$nope=iseguro($cone,$_POST['nope']);
				$sdia=iseguro($cone,$_POST['sdia']);
				$sdiaa=iseguro($cone,$_POST['sdiaa']);
				$tpag=iseguro($cone,$_POST['tpag']);
				$cue=iseguro($cone,$_POST['cue']);
				$act=iseguro($cone,$_POST['act']);
				$mie=iseguro($cone,$_POST['mie']);
				$emp=iseguro($cone,$_POST['emp']);
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
				if(mysqli_query($cone,"UPDATE movimiento SET tipomovimiento=$tmov, anio='$anio', mes=$mes, glosa='$glo', observacion='$obs', serdocumento='$sdoc', numdocumento=$ndoc, fecdocumento='$fdoc', total=$tot, numoperacion='$nope', usuario=$id, idmoneda=$mon, idsubdiario=$sdia, idtipodocumento=$tdoc, idtipopago=$tpag, idcuenta=$cue, idmiembro=$mie, idactividad=$act, idempresa=$emp $nncod WHERE idmovimiento=$idmov;")){
					$r['m']=mensajesu("Movimiento editado correctamente");
					$r['e']=true;
				}else{
					$r['m']=mensajeda("Error, vuelva a intentarlo");
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("Tipo Movimiento, Tipo Documento, Total, Moneda, Tipo Pago, Cuenta, Actividad, Miembro, Empresa, y Glosa son obligatorios ");
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
				if(mysqli_query($cone,"DELETE FROM movimiento WHERE idmovimiento=$idmov;")){
					$r['m']=mensajesu("Movimiento eliminado");
					$r['e']=true;
				}else{
					$r['m']=mensajeda("Error, vuelva a intentarlo");
					$r['e']=false;
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