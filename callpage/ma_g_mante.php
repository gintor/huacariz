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
	

		if($acc=="addpro"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['cat']) && !empty($_POST['cat']) && isset($_POST['umed']) && !empty($_POST['umed']) && isset($_POST['prov']) && !empty($_POST['prov']) && isset($_POST['proc']) && !empty($_POST['proc']) && isset($_POST['pnor']) && !empty($_POST['pnor']) && isset($_POST['pesp']) && !empty($_POST['pesp']) && isset($_POST['padp']) && !empty($_POST['padp'])){
					$nom=imseguro($cone, $_POST['nom']);
					$cat=iseguro($cone, $_POST['cat']);
					$umed=iseguro($cone, $_POST['umed']);
					$prov=iseguro($cone, $_POST['prov']);
					$cbar=iseguro($cone, $_POST['cbar']);
					$proc=iseguro($cone, $_POST['proc']);
					$des=iseguro($cone, $_POST['des']);
					$pnor=iseguro($cone, $_POST['pnor']);
					$pesp=iseguro($cone, $_POST['pesp']);
					$padp=iseguro($cone, $_POST['padp']);

						$cu=mysqli_query($cone,"SELECT idproducto FROM producto WHERE nombre='$nom';");
						if($ru=mysqli_fetch_assoc($cu)){
							$r['m']=mensajeda("El producto ya se encuentra registrado");
						}else{
							if(mysqli_query($cone,"INSERT INTO producto (idcategoria, idunimedida, proveedor, nombre, codbarras, procedencia, descripcion, precioven, preciovenesp, preciovenadp, estado, idusuario) VALUES ($cat, $umed, $prov, '$nom', '$cbar', $proc, '$des', $pnor, $pesp, $padp, 1, $id);")){
								$r['m']=mensajesu("Producto registrado correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al registrar el producto, vuelva a intentarlo");
							}
						}
						mysqli_free_result($cu);

				}else{
					$r['m']=mensajeda("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="estpro"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					$cu=mysqli_query($cone,"SELECT estado FROM producto WHERE idproducto=$idf;");
					if($ru=mysqli_fetch_assoc($cu)){
						$est=$ru['estado']==1 ? 0 : 1;
						$mest=$ru['estado']==1 ? "desactivado" : "activado";
						if(mysqli_query($cone,"UPDATE producto SET estado=$est WHERE idproducto=$idf;")){
							$r['m']=mensajesu("Producto $mest correctamente");
							$r['e']=true;
						}else{
							$r['m']=mensajeda("Error al cambiar estado, vuelva a intentarlo");
						}
					}else{
						$r['m']=mensajeda("Error el producto no existe");
					}
					mysqli_free_result($cu);
				}else{
					$r['m']=mensajeda("Faltan datos");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="edipro"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['cat']) && !empty($_POST['cat']) && isset($_POST['umed']) && !empty($_POST['umed']) && isset($_POST['prov']) && !empty($_POST['prov']) && isset($_POST['proc']) && !empty($_POST['proc']) && isset($_POST['pnor']) && !empty($_POST['pnor']) && isset($_POST['pesp']) && !empty($_POST['pesp']) && isset($_POST['padp']) && !empty($_POST['padp']) && isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=imseguro($cone, $_POST['idf']);
					$nom=imseguro($cone, $_POST['nom']);
					$cat=iseguro($cone, $_POST['cat']);
					$umed=iseguro($cone, $_POST['umed']);
					$prov=iseguro($cone, $_POST['prov']);
					$cbar=iseguro($cone, $_POST['cbar']);
					$proc=iseguro($cone, $_POST['proc']);
					$des=iseguro($cone, $_POST['des']);
					$pnor=iseguro($cone, $_POST['pnor']);
					$pesp=iseguro($cone, $_POST['pesp']);
					$padp=iseguro($cone, $_POST['padp']);

							$q="UPDATE producto SET idcategoria=$cat, idunimedida=$umed, proveedor=$prov, nombre='$nom', codbarras='$cbar', procedencia=$proc, descripcion='$des', precioven=$pnor, preciovenesp=$pesp, preciovenadp=$padp, idusuario=$id WHERE idproducto=$idf;";
							if(mysqli_query($cone,$q)){
								$r['m']=mensajesu("Producto editado correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al editar el producto, vuelva a intentarlo ".$q);
							}
						

				}else{
					$r['m']=mensajeda("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="addloc"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['ser']) && !empty($_POST['ser']) && isset($_POST['tpre']) && !empty($_POST['tpre'])){
					$nom=imseguro($cone, $_POST['nom']);
					$dir=iseguro($cone, $_POST['dir']);
					$ser=imseguro($cone, $_POST['ser']);
					$tpre=iseguro($cone, $_POST['tpre']);

						$cu=mysqli_query($cone,"SELECT idlocal FROM local WHERE nombre='$nom';");
						if($ru=mysqli_fetch_assoc($cu)){
							$r['m']=mensajeda("El local ya se encuentra registrado");
						}else{
							if(mysqli_query($cone,"INSERT INTO local (nombre, direccion, estado, seriecom, tipoprecio) VALUES ('$nom', '$dir', 1, '$ser', $tpre);")){
								$r['m']=mensajesu("Local registrado correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al registrar el local, vuelva a intentarlo");
							}
						}
						mysqli_free_result($cu);

				}else{
					$r['m']=mensajeda("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="estloc"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					$cu=mysqli_query($cone,"SELECT estado FROM local WHERE idlocal=$idf;");
					if($ru=mysqli_fetch_assoc($cu)){
						$est=$ru['estado']==1 ? 0 : 1;
						$mest=$ru['estado']==1 ? "desactivado" : "activado";
						if(mysqli_query($cone,"UPDATE local SET estado=$est WHERE idlocal=$idf;")){
							$r['m']=mensajesu("Local $mest correctamente");
							$r['e']=true;
						}else{
							$r['m']=mensajeda("Error al cambiar estado, vuelva a intentarlo");
						}
					}else{
						$r['m']=mensajeda("Error el local no existe");
					}
					mysqli_free_result($cu);
				}else{
					$r['m']=mensajeda("Faltan datos");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="ediloc"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['ser']) && !empty($_POST['ser']) && isset($_POST['tpre']) && !empty($_POST['tpre']) && isset($_POST['idf']) && !empty($_POST['idf'])){
					$nom=imseguro($cone, $_POST['nom']);
					$dir=iseguro($cone, $_POST['dir']);
					$ser=imseguro($cone, $_POST['ser']);
					$tpre=iseguro($cone, $_POST['tpre']);
					$idf=iseguro($cone, $_POST['idf']);

						$cu=mysqli_query($cone,"SELECT idlocal FROM local WHERE nombre='$nom' AND idlocal!=$idf;");
						if($ru=mysqli_fetch_assoc($cu)){
							$r['m']=mensajeda("El nombre del local ya se encuentra registrado");
						}else{
							if(mysqli_query($cone,"UPDATE local SET nombre='$nom', direccion='$dir', seriecom='$ser', tipoprecio=$tpre WHERE idlocal=$idf;")){
								$r['m']=mensajesu("Local editado correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al editar el local, vuelva a intentarlo");
							}
						}
						mysqli_free_result($cu);

				}else{
					$r['m']=mensajeda("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="addent"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['rel']) && !empty($_POST['rel']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['ndoc']) && !empty($_POST['ndoc']) && isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['dis']) && !empty($_POST['dis']) && isset($_POST['tcli']) && !empty($_POST['tcli'])){
					$nom=imseguro($cone, $_POST['nom']);
					$rep=imseguro($cone, $_POST['rep']);
					$tip=iseguro($cone, $_POST['tip']);
					$rel=iseguro($cone, $_POST['rel']);
					$tdoc=iseguro($cone, $_POST['tdoc']);
					$ndoc=iseguro($cone, $_POST['ndoc']);
					$tfij=iseguro($cone, $_POST['tfij']);
					$tmov=iseguro($cone, $_POST['tmov']);
					$dir=iseguro($cone, $_POST['dir']);
					$dis=iseguro($cone, $_POST['dis']);
					$tcli=iseguro($cone, $_POST['tcli']);
					$cor=iseguro($cone, $_POST['cor']);
					$des=(iseguro($cone, $_POST['des'])/100);

						$cu=mysqli_query($cone,"SELECT idpersona FROM persona WHERE numerodoc='$ndoc';");
						if($ru=mysqli_fetch_assoc($cu)){
							$r['m']=mensajeda("El número de documento ya se encuentra registrado");
						}else{
							if(mysqli_query($cone,"INSERT INTO persona (tipo, nombre, tipodocumento, numerodoc, telfijo, telmovil, direccion, correo, representante, tipocli, estado, descuento, relacion, iddistrito) VALUES ($tip, '$nom', '$tdoc', '$ndoc', '$tfij', '$tmov', '$dir', '$cor', '$rep', $tcli, 1, $des, $rel, $dis);")){
								$r['m']=mensajesu("Entidad registrada correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al registrar la entidad, vuelva a intentarlo");
							}
						}
						mysqli_free_result($cu);

				}else{
					$r['m']=mensajeda("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="estent"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					$cu=mysqli_query($cone,"SELECT estado FROM persona WHERE idpersona=$idf;");
					if($ru=mysqli_fetch_assoc($cu)){
						$est=$ru['estado']==1 ? 0 : 1;
						$mest=$ru['estado']==1 ? "desactivado" : "activado";
						if(mysqli_query($cone,"UPDATE persona SET estado=$est WHERE idpersona=$idf;")){
							$r['m']=mensajesu("Entidad $mest correctamente");
							$r['e']=true;
						}else{
							$r['m']=mensajeda("Error al cambiar estado, vuelva a intentarlo");
						}
					}else{
						$r['m']=mensajeda("Error la entidad no existe no existe");
					}
					mysqli_free_result($cu);
				}else{
					$r['m']=mensajeda("Faltan datos");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="edient"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['rel']) && !empty($_POST['rel']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['ndoc']) && !empty($_POST['ndoc']) && isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['dis']) && !empty($_POST['dis']) && isset($_POST['tcli']) && !empty($_POST['tcli']) && isset($_POST['idf']) && !empty($_POST['idf'])){
					$idf=iseguro($cone,$_POST['idf']);
					$nom=imseguro($cone, $_POST['nom']);
					$rep=imseguro($cone, $_POST['rep']);
					$tip=iseguro($cone, $_POST['tip']);
					$rel=iseguro($cone, $_POST['rel']);
					$tdoc=iseguro($cone, $_POST['tdoc']);
					$ndoc=iseguro($cone, $_POST['ndoc']);
					$tfij=iseguro($cone, $_POST['tfij']);
					$tmov=iseguro($cone, $_POST['tmov']);
					$dir=iseguro($cone, $_POST['dir']);
					$dis=iseguro($cone, $_POST['dis']);
					$tcli=iseguro($cone, $_POST['tcli']);
					$cor=iseguro($cone, $_POST['cor']);
					$des=(iseguro($cone, $_POST['des'])/100);

						$cu=mysqli_query($cone,"SELECT idpersona FROM persona WHERE numerodoc='$ndoc' AND idpersona!=$idf;");
						if($ru=mysqli_fetch_assoc($cu)){
							$r['m']=mensajeda("El número de documento ya se encuentra registrado en otra entidad");
						}else{
							if(mysqli_query($cone,"UPDATE persona SET tipo=$tip, nombre='$nom', tipodocumento='$tdoc', numerodoc='$ndoc', telfijo='$tfij', telmovil='$tmov', direccion='$dir', correo='$cor', representante='$rep', tipocli=$tcli, descuento=$des, relacion=$rel, iddistrito=$dis WHERE idpersona=$idf;")){
								$r['m']=mensajesu("Entidad editada correctamente");
								$r['e']=true;
							}else{
								$r['m']=mensajeda("Error al editar la entidad, vuelva a intentarlo");
							}
						}
						mysqli_free_result($cu);

				}else{
					$r['m']=mensajeda("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}//->
	mysqli_close($cone);
}else{
	$r['m']=mensajeda("No envio acción");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
?>