<?php 
session_start();

include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['local']);
$acc=iseguro($cone,$_POST['acc']);
$idm=iseguro($cone,$_POST['idm']);
$r=array();
$r['e']=false;
if(vaccesom($cone, $id, $idm, 1)){

	if(isset($_POST['cli']) && !empty($_POST['cli'])){
		if(isset($_POST['idv']) && !empty($_POST['idv'])){
			$cli=iseguro($cone,$_POST['cli']);
			$idv=iseguro($cone,$_POST['idv']);
			//consultamos que no hayan cambiado el estado
			$cv=mysqli_query($cone,"SELECT idventa FROM venta WHERE idventa=$idv AND estado=1;");
			if($rv=mysqli_fetch_assoc($cv)){

				//buscamos su descuento
				$cd=mysqli_query($cone,"SELECT descuento FROM persona WHERE idpersona=$cli");
				if($rd=mysqli_fetch_assoc($cd)){
					if($rd['descuento']==""){
						$descu=0;
					}else{
						$descu=$rd['descuento'];
					}
				}
				mysqli_free_result($cd);

				$cu="UPDATE venta SET cliente=$cli, descuento=$descu WHERE idventa=$idv;";
				if(mysqli_query($cone,$cu)){

					$r['m']=mensajesu("Se cambió el cliente correctamente");
					if($rd['descuento']>0){
						$r['m'].=mensajesu("Tiene <b>".($rd['descuento']*100)."%</b> de descuento, solo en nuestros productos");
					}
					$r['e']=true;

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

					//calculamos nuevos precios
					$cdv=mysqli_query($cone,"SELECT p.nombre, p.$tp, p.procedencia, dv.iddetventa, dv.cantidad FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$idv;");
					if(mysqli_num_rows($cdv)>0){
						while($rdv=mysqli_fetch_assoc($cdv)){
							$iddeve=$rdv['iddetventa'];
							if($rd['descuento']>0 && $rdv['procedencia']==1){
								$pvu=n_22decimal($rdv[$tp]-$rdv[$tp]*$rd['descuento']);
							}else{
								$pvu=$rdv[$tp];
							}
							$suto=n_22decimal($pvu*$rdv['cantidad']);
							if(!mysqli_query($cone,"UPDATE detventa SET subtotal=$suto, preunitario=$pvu WHERE iddetventa=$iddeve;")){
								$r['m']=mensajesu("Error al editar el precio de: ".$rdv['nombre']);
							}
						}
					}
					mysqli_free_result($cdv);

				}else{
					$r['m']=mensajeda("No se pudo cambiar al cliente");
				}
			}else{
				$r['m']=mensajeda("El despacho cambio de estado o ya fue eliminado. Actualice!!!");
			}

		}else{
			$r['m']=mensajeda("Faltan datos");
		}
	}else{
		$r['m']=mensajeda("No ingreso un cliente");
	}

	

}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);

?>