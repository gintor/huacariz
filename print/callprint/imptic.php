


<?php
session_start();
/* Change to the correct path if you copy this example! */
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
include_once '../../call/cone.php';
include_once '../../cons.php';
include_once '../../call/func.php';
$id=iseguro($cone, $_SESSION['idusu']);
$no=iseguro($cone, $_SESSION['nousu']);
$lo=iseguro($cone, $_SESSION['local']);
if(vlogin($cone, $no, $id)){
	if(isset($_POST['com']) && !empty($_POST['com'])){
		$com=iseguro($cone,$_POST['com']);

		$cv=mysqli_query($cone,"SELECT v.fecha, v.descuento, dv.numero, pe.nombre FROM venta v INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN persona pe ON v.cliente=pe.idpersona WHERE v.idventa=$com;");
		if($rv=mysqli_fetch_assoc($cv)){


			/**
			 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
			 * then share it (you can use a firewall so that it can only be seen locally).
			 *
			 * Use a WindowsPrintConnector with the share name to print.
			 *
			 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
			 * "Receipt Printer), the following commands work:
			 *
			 *  echo "Hello World" > testfile
			 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
			 *  del testfile
			 */
			try {
			    // Enter the share name for your USB printer here
			    $connector = null;
			    $connector = new WindowsPrintConnector("Ticketera");

			    /* Print a "Hello world" receipt" */
			    $printer = new Printer($connector);
			    $printer -> setJustification(Printer::JUSTIFY_CENTER);
			    $printer -> setEmphasis(true);
			    //$printer -> text("INDUSTRIA ALIMENTARIA HUACARIZ SAC\n");
			    $printer -> text("TICKET-".$rv['numero']."\n");
			    $printer -> selectPrintMode();
			   
			    $printer -> feed();
			    $printer -> text("Fecha Emisión: ".ftnormal($rv['fecha'])."\n");
			    $printer -> text("Señor(es): ".$rv['nombre']."\n");
			    $printer -> feed();
			    
			    $cdv=mysqli_query($cone,"SELECT dv.cantidad, dv.subtotal, dv.preunitario, p.nombre FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$com;");
			    if(mysqli_num_rows($cdv)>0){
			    	$stt=0;
			    	while($rdv=mysqli_fetch_assoc($cdv)){
			    		$printer -> setJustification(Printer::JUSTIFY_LEFT);
				    	$printer -> text($rdv['cantidad']." ".$rdv['nombre']."\n");
				    	$printer -> setJustification(Printer::JUSTIFY_RIGHT);
				    	$printer -> text(espacios(n_22decimal($rdv['preunitario'])).espacios(n_22decimal($rdv['subtotal']))."\n");
				    	$stt=$stt+$rdv['subtotal'];
			    	}
			    }
			    mysqli_free_result($cdv);

			    $printer -> feed();
			    //$printer -> text("SUB TOTAL: S/ ".n_22decimal($stt)."\n");
			    //$printer -> text("DESCUENTO: S/ ".n_22decimal($rv['descuento']*$stt)."\n");
			    $printer -> text("IMPORTE TOTAL:".espacios(n_22decimal($stt))."\n");
			    $printer -> feed();
			    $printer -> setJustification(Printer::JUSTIFY_CENTER);

			    $printer -> feed();
			    $printer -> text("GRACIAS POR SU PREFERENCIA\n");
			    $printer -> feed(2);


			    $printer -> cut();
			    
			    /* Close printer */
			    $printer -> close();
			} catch (Exception $e) {
			    echo "No se puede imprimir en la impresora: " . $e -> getMessage() . "\n";
			}
		}else{
			mensajeda("No se encuentra el ticket");
		}
		mysqli_free_result($cv);
	}else{
		echo mensajeda("No envio datos");
	}
}else{
	echo mensajeda("Acceso restringido");
}