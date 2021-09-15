<?php 
session_start();
if(isset($_POST['acc']) && !empty($_POST['acc'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$lo=iseguro($cone, $_SESSION['local']);
	$acc=iseguro($cone,$_POST['acc']);
	$idm=iseguro($cone,$_POST['idm']);
	

		$r=array();
		$r['e']=false;
		if($acc=="addcaj"){
			if(vaccesom($cone, $id, $idm, 1)){
				$cc=mysqli_query($cone, "SELECT idcaja FROM caja WHERE idusuario=$id AND estado=1 AND idlocal=$lo;");
				if(mysqli_num_rows($cc)>0){
					$r['m']=mensajeda("Aún tiene una caja abierta");
				}else{
					$fec=date("Y-m-d H:i:s");
					$tur=date("G")<=12 ? 1 : 2;
					if(mysqli_query($cone,"INSERT INTO caja (idusuario, fecapertura, estado, turno, idlocal) VALUES ($id, '$fec', 1, $tur, $lo);")){
						$r['e']=true;
						$r['m']=mensajesu("Caja abierta");
					}else{
						$r['m']=mensajeda("No se pudo abrir caja, vuelva a intentarlo".mysqli_error($cone));
					}
				}
				mysqli_free_result($cc);
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="elicaj"){
			if(vaccesom($cone, $id, $idm, 1)){
				$idf=iseguro($cone,$_POST['idf']);
				$c=mysqli_query($cone, "SELECT * FROM caja WHERE idcaja=$idf;");
				if($r=mysqli_fetch_assoc($c)){
					if($r['idusuario']==$id){
						if(mysqli_query($cone, "DELETE FROM caja WHERE idcaja=$idf;")){
							$r['e']=true;
							$r['m']=mensajesu("Caja Eliminada");
						}else{
							$r['m']=mensajeda("Imposible eliminar la caja, ya presenta ventas o movimientos");
						}
					}else{
						$r['m']=mensajeda("Sólo se puede eliminar cajas abiertas por uno mismo");
					}
				}else{
					$r['m']=mensajeda("Datos inválidos");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="cobdes"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf']) && isset($_POST['dven']) && !empty($_POST['dven']) && isset($_POST['tpag']) && !empty($_POST['tpag'])){
					$idf=iseguro($cone,$_POST['idf']);
					$dven=iseguro($cone,$_POST['dven']);
					$tpag=iseguro($cone,$_POST['tpag']);
					$idca=iseguro($cone,$_POST['idca']);
					$des=iseguro($cone,$_POST['des']);
					$tdocp=iseguro($cone,$_POST['tdocp']);
					$ndocp=iseguro($cone,$_POST['ndocp']);
					$ttot=iseguro($cone,$_POST['ttot']);
					$mrec=iseguro($cone,$_POST['mrec']);
					$nomcli=iseguro($cone,$_POST['nomcli']);
					$ftven=date("Y-m-d H:i:s");
					$fven=date("Y-m-d", strtotime($ftven));
					$tven=date("H:i:s", strtotime($ftven));

					if($tpag==1 && ($ttot-$des*$ttot)>$mrec){
						$r['m']=mensajeda("El monto recibido es menor al monto por pagar");
					}else{
						if($dven==3 && $tdocp!=6){
							$r['m']=mensajeda("Se require que el cliente tenga registrado un numero de <b>RUC</b>");
						}else{
							if($dven==3 && strlen($ndocp)!=11){
								$r['m']=mensajeda("El <b>RUC</b> registrado no es válido, no se le puede emitir una factura");
							}else{
								if(mysqli_query($cone,"UPDATE venta SET idcaja=$idca, estado=2, idtipopag=$tpag, descuento=$des, fecha='$ftven' WHERE idventa=$idf;")){
									$cnd=mysqli_query($cone,"SELECT max(dv.numero) as num FROM venta v INNER JOIN docventa dv ON v.idventa=dv.idventa WHERE v.idlocal=$lo AND dv.idtipodoc=$dven;");
									if($rnd=mysqli_fetch_assoc($cnd)){
										$nd=$rnd['num']+1;
									}else{
										$nd=1;
									}
									if(mysqli_query($cone,"INSERT INTO docventa (numero, estado, idventa, idtipodoc) VALUES ($nd, 1, $idf, $dven);")){
										
										
										//generar .cab
										$s_codloc=s_codlocal($cone,$lo);
										$vv=n_22decimal(($ttot/1.18));
										$vdes=n_22decimal($vv*$des);
										$rvv=n_22decimal($vv-$vdes);
										$igv=n_22decimal($rvv*0.18);
										$pv=n_22decimal($rvv+$igv);
										
										$cab="0101|$fven|$tven|-|$s_codloc|$tdocp|$ndocp|$nomcli|PEN|".$igv."|".$rvv."|".$pv."|".$vdes."|0.00|0.00|".$pv."|2.1|2.0|";
										//generar acv
										$acv="false|00|".$des."|PEN|".$vdes."|PEN|".$vv."|";
										//generar .det
										$cdv=mysqli_query($cone,"SELECT um.s_coduni, dv.cantidad, p.idproducto, p.s_codprod, p.nombre, dv.subtotal FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto INNER JOIN unimedida um ON p.idunimedida=um.idunimedida WHERE dv.idventa=$idf;");
										if(mysqli_num_rows($cdv)>0){
											$det="";
											while($rdv=mysqli_fetch_assoc($cdv)){
												
												$vu=n_22decimal(($rdv['subtotal'])/n_22decimal($rdv['cantidad']*1.18));
												$bi=n_22decimal($vu*$rdv['cantidad']);
												$igv_item=n_22decimal($bi*0.18);
												$pvu_igv=n_22decimal($vu*1.18);

												$det.=$rdv['s_coduni']."|".$rdv['cantidad']."|".$rdv['idproducto']."|-|".$rdv['nombre']."|".$vu."|".$igv_item."|1000|".$igv_item."|".$bi."|IGV|VAT|10|18.00|-|0.00|0.00|||||-|0.00|0.00||||".$pvu_igv."|".$bi."|0.00|".PHP_EOL;
												
											}
										}
										mysqli_free_result($cdv);
										//Generamos tri
										$rigv=n_22decimal($rvv*0.18);
										$tri="1000|IGV|VAT|".$rvv."|".$rigv."|";
										//Generamos ley
										$rpva=explode(".",n_22decimal($pv));
										$rpvl=strtoupper(convertir($rpva[0]))." CON ".$rpva[1]."/100";
										$ley="1000|$rpvl|";

										//Generamos los archivos
										if($dven!=1){
											//datos de la empresa
											$ce=mysqli_query($cone,"SELECT ruc FROM datos WHERE iddatos=1;");
											if($re=mysqli_fetch_assoc($ce)){
												$ruc=$re['ruc'];
											}
											mysqli_free_result($ce);
											switch ($dven) {
												case 2:
													$ptd="B";
													break;
												case 3:
													$ptd="F";
													break;
											}
											
											$ntxt=$ruc."-".s_tipcom($cone,$dven)."-".$ptd.sercom($cone,$lo)."-".numdoc($nd);
											$txtcab=fopen($ntxt.".cab","a");
											fwrite($txtcab,$cab);
											fclose($txtcab);
											$txtacv=fopen($ntxt.".acv","a");
											fwrite($txtacv,$acv);
											fclose($txtacv);
											$txtdet=fopen($ntxt.".det","a");
											fwrite($txtdet,$det);
											fclose($txtdet);
											$txtley=fopen($ntxt.".ley","a");
											fwrite($txtley,$ley);
											fclose($txtley);
											$txttri=fopen($ntxt.".tri","a");
											fwrite($txttri,$tri);
											fclose($txttri);
										}

										//mensajes
										if($mrec!=""){
											$cam=($mrec-n_12decimal($pv));
											$vu="<br>Vuelto: <b>".$cam."</b>";
										}
										$r['m']=mensajesu("Despacho cobrado ".$vu."<br>cabecera: ".$cab."<br>".$det."<br>".$ntxt);
										$r['e']=true;

									}else{
										$r['m']=mensajesu("Error al registrar el documento de venta ".mysqli_error($cone));
									}
								}else{
									$r['m']=mensajeda("Error, vuelva a intentarlo");
									$r['e']=false;
								}
							}
						}
					}
				}else{
					$r['m']=mensajeda("Elija un <b>Documento de Venta</b> y un <b>Tipo de Pago</b>");
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="addmov"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['mon']) && !empty($_POST['mon'])){
					$idf=iseguro($cone,$_POST['idf']);
					$des=iseguro($cone,$_POST['des']);
					$tip=iseguro($cone,$_POST['tip']);
					$mon=iseguro($cone,$_POST['mon']);
					if(mysqli_query($cone,"INSERT INTO movcaja (tipo, descripcion, monto, fecha, idcaja) VALUES ( $tip, '$des', $mon, NOW(), $idf);")){
						$r['m']=mensajesu("Movimiento resgistrado correctamente");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error, vuelva a intentarlo");
						$r['e']=false;
					}
				}else{
					$r['m']=mensajeda("Todos los campos son obligatorios");
					$r['e']=false;
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="canven"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					if(mysqli_query($cone,"UPDATE venta SET estado=3, idusuario=$id WHERE idventa=$idf")){
						$r['m']=mensajesu("Venta cancelada");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error al cancelar la venta, vuelva a intentarlo");
						$r['e']=false;
					}
				}else{
					$r['m']=mensajeda("No se enviaron datos");
					$r['e']=false;
				}
			}
		}elseif($acc=="cercaj"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					if(mysqli_query($cone,"UPDATE caja SET estado=2, idusuario=$id, feccierre=NOW() WHERE idcaja=$idf")){
						$r['m']=mensajesu("Caja cerrada");
						$r['e']=true;
					}else{
						$r['m']=mensajeda("Error al cerrar la caja, vuelva a intentarlo");
						$r['e']=false;
					}
				}else{
					$r['m']=mensajeda("No se enviaron datos");
					$r['e']=false;
				}
			}
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($r);	


	mysqli_close($cone);
}
?>