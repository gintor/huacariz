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
		if($acc=="adddes"){
			if(vaccesom($cone, $id, $idm, 1)){
				if(!empty($_SESSION['pro'])){
					if(isset($_POST['cli']) && !empty($_POST['cli'])){
						$cli=iseguro($cone,$_POST['cli']);

						//obtenemos el descuento
						$cd=mysqli_query($cone,"SELECT descuento FROM persona WHERE idpersona=$cli;");
						if($rd=mysqli_fetch_assoc($cd)){
							$des=$rd['descuento'];
						}else{
							$des=0;
						}

							//obtenemos tipo de precio
							$cpl=mysqli_query($cone,"SELECT tipoprecio FROM local WHERE idlocal=$lo;");
							if($rpl=mysqli_fetch_assoc($cpl)){
								switch ($rpl['tipoprecio']) {
									case 1:
										$tp="precioven";
										break;
									case 2:
										$tp="preciovenesp";
										break;
									case 3:
										$tp="preciovenadp";
										break;
								}
							}
							mysqli_free_result($cpl);
							//fin obtener tipo de precio
						
							if(mysqli_query($cone,"INSERT INTO venta (fecha, estado, idlocal, cliente, idusuario, descuento) VALUES (NOW(), 1, $lo, $cli, $id, $des);")){
								$idd=mysqli_insert_id($cone);
								$n=0;
								foreach ($_SESSION['pro'] as $idp => $cant) {
									$c=mysqli_query($cone,"SELECT idproducto, procedencia, $tp FROM producto WHERE idproducto=$idp;");
									if($r=mysqli_fetch_assoc($c)){
										if($r['procedencia']==1 && $des>0){
											$pvu=n_22decimal($r[$tp]-$r[$tp]*$des);
										}else{
											$pvu=$r[$tp];
										}
										$st=n_22decimal($cant*$pvu);
										if(mysqli_query($cone,"INSERT INTO detventa (idventa, idproducto, cantidad, subtotal, preunitario) VALUES ($idd, $idp, $cant, $st, $pvu);")){
											$n++;
										}
									}
									mysqli_free_result($c);
								}
								$r['e']=true;
								$r['m']=mensajesu("Despacho resgistrado, con $n productos");
								unset($_SESSION['pro']);
							}else{
								$r['m']=mensajeda("No se pudo abrir caja, vuelva a intentarlo".mysqli_error($cone));
							}
					}else{
						$r['m']=mensajeda("Elija un cliente");
					}
				}else{
					$r['m']=mensajeda("Aún no agrega ningún producto");
				}
			}else{
				$r['m']=mensajeda("Acceso restringido");
			}
		}elseif($acc=="elides"){
			$idf=iseguro($cone,$_POST['idf']);
			$c=mysqli_query($cone, "SELECT idventa, idusuario FROM venta WHERE idventa=$idf AND estado=1;");
			if($r=mysqli_fetch_assoc($c)){

					if(mysqli_query($cone, "DELETE FROM detventa WHERE idventa=$idf;")){
						if(mysqli_query($cone,"DELETE FROM venta WHERE idventa=$idf;")){
							$r['e']=true;
							$r['m']=mensajesu("Despacho eliminado");
						}else{
							$r['m']=mensajeda("No se pudo eliminar el despacho");
						}
					}else{
						$r['m']=mensajeda("No se pudo eliminar los productos");
					}

			}else{
				$r['m']=mensajeda("El despacho ya fue cobrado o no existe. Actualice!!!");
			}
			mysqli_free_result($c);
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($r);	


	mysqli_close($cone);
}
?>