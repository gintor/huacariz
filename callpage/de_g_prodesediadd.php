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

	if(isset($_POST['prod']) && !empty($_POST['prod']) && isset($_POST['cant']) && !empty($_POST['cant'])){
		if(isset($_POST['idv']) && !empty($_POST['idv'])){
			$prod=iseguro($cone,$_POST['prod']);
			$cant=iseguro($cone,$_POST['cant']);
			$idv=iseguro($cone,$_POST['idv']);

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
			//obtenemos el descuento
			$cd=mysqli_query($cone,"SELECT descuento FROM venta WHERE idventa=$idv;");
			if($rd=mysqli_fetch_assoc($cd)){
				$des=$rd['descuento'];
			}else{
				$des=0;
			}
			mysqli_free_result($cd);
			//fin obtenemos el descuento

			$cp=mysqli_query($cone,"SELECT $tp, procedencia FROM producto WHERE idproducto=$prod;");
			if($rp=mysqli_fetch_assoc($cp)){
				if($des>0 && $rp['procedencia']==1){
					$pvu=n_22decimal($rp[$tp]-$rp[$tp]*$des);
				}else{
					$pvu=$rp[$tp];
				}
				$st=n_22decimal($pvu*$cant);
				if(mysqli_query($cone,"INSERT INTO detventa (idventa, idproducto, cantidad, subtotal, preunitario) VALUES ($idv, $prod, $cant, $st, $pvu);")){
					$r['e']=true;
					$r['m']=mensajesu("Producto agregado");
				}else{
					$r['m']=mensajeda("Error al agrega producto");
				}
			}else{
				$r['m']=mensajeda("Datos invalidos");
			}
			mysqli_free_result($cp);
		}else{
			$r['m']=mensajeda("Faltan datos");
		}
	}else{
		$r['m']=mensajeda("Elija un producto junto con la cantidad");
	}

	

}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);

?>