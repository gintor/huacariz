


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
		$xml="C:/SFS_v1.2/sunat_archivos/sfs/FIRMA/$com.xml";
		if(is_file($xml)){


			$a_xml=simplexml_load_file($xml);
			$tipcom=$a_xml->xpath('cbc:InvoiceTypeCode');
			$numcom=$a_xml->xpath('cbc:ID');
			$nom=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyName/cbc:Name');
			$dir=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cac:AddressLine/cbc:Line');
			$dis=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cbc:District');
			$pro=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cbc:CountrySubentity');
			$dep=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cbc:CityName');
			$ruc=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyIdentification/cbc:ID');
			$fecemi=$a_xml->xpath('cbc:IssueDate');
			$cli=$a_xml->xpath('cac:AccountingCustomerParty/cac:Party/cac:PartyLegalEntity/cbc:RegistrationName');
			$numdoc=$a_xml->xpath('cac:AccountingCustomerParty/cac:Party/cac:PartyIdentification/cbc:ID');
			$cod=$a_xml->xpath('ext:UBLExtensions/ext:UBLExtension/ext:ExtensionContent/ds:Signature/ds:SignedInfo/ds:Reference/ds:DigestValue');
			//productos
		    $numpro=$a_xml->xpath('cac:InvoiceLine');
			$can=$a_xml->xpath('cac:InvoiceLine/cbc:InvoicedQuantity');
			$pre=$a_xml->xpath('cac:InvoiceLine/cac:PricingReference/cac:AlternativeConditionPrice/cbc:PriceAmount');
			$nompro=$a_xml->xpath('cac:InvoiceLine/cac:Item/cbc:Description');
			//fin productos

			//calculos
			//$des=$a_xml->xpath('cac:LegalMonetaryTotal/cbc:AllowanceTotalAmount');
			$igv=$a_xml->xpath('cac:TaxTotal/cbc:TaxAmount');
			$og=$a_xml->xpath('cac:TaxTotal/cac:TaxSubtotal/cbc:TaxableAmount');
			$tot=$a_xml->xpath('cac:LegalMonetaryTotal/cbc:PayableAmount');
			//guía
			$gui=$a_xml->xpath('cac:DespatchDocumentReference/cbc:ID');


			switch ($tipcom[0]) {
				case '01':
					$tc="FACTURA ELECTRONICA";
					break;
				
				case '03':
					$tc="BOLETA DE VENTA ELECTRONICA";
					break;
			}



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
			    $printer -> text($nom[0]."\n");
			    $printer -> selectPrintMode();
			    $printer -> text($dir[0]."\n");
			    $printer -> text($dis[0]." ".$pro[0]." ".$dep[0]."\n");
			    $printer -> text("RUC: ".$ruc[0]."\n");
			    $printer -> setEmphasis(true);
			    $printer -> text($tc."\n");
			    $printer -> selectPrintMode();
			    $printer -> text($numcom[0]."\n");
			    
			    $printer -> feed();
			    $printer -> text("Fecha Emisión: ".fnormal($fecemi[0])."\n");
			    $printer -> text("Señor(es): ".$cli[0]."\n");
			    $printer -> text("RUC/DNI: ".$numdoc[0]."\n");
			    $printer -> feed();
			    
			    for ($i=0; $i < count($numpro); $i++) {
			    	$printer -> setJustification(Printer::JUSTIFY_LEFT);
			    	$printer -> text($can[$i]." ".$nompro[$i]."\n");
			    	$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			    	$pv1=n_22decimal(floatval($pre[$i])*floatval($can[$i]));
			    	$printer -> text(espacios(n_22decimal(floatval($pre[$i]))).espacios($pv1)."\n");
			    }
			    $printer -> feed();
			    //$printer -> text("DESCUENTO: S/ ".$des[0]."\n");
			    $printer -> text("OP. GRAVADA:".espacios($og[0])."\n");
			    $printer -> text("IGV:".espacios($igv[0])."\n");
			    $printer -> text("IMPORTE TOTAL:".espacios($tot[0])."\n");
			    $printer -> feed();
			    $printer -> setJustification(Printer::JUSTIFY_CENTER);

			    //imprimir datos guía
			    if($gui[0]!=""){
			    	$printer -> feed();
			    	$printer -> text("GUÍA DE REMISIÓN REMITENTE: ".$gui[0]."\n");
			    	$printer -> feed();
			    }
			    //fin imprimir datos guía

				$printer -> pdf417Code($cod[0]);
			    $printer -> text($cod[0]."\n");
			    $printer -> feed();
			    $printer -> text("GRACIAS POR SU PREFERENCIA\n");
			    $printer -> text("Representación impresa del comprobante electrónico. Puede verificarla
utilizando su clave SOL\n");
			    $printer -> feed(2);


			    $printer -> cut();
			    
			    /* Close printer */
			    $printer -> close();
			} catch (Exception $e) {
			    echo "No se puede imprimir en la impresora: " . $e -> getMessage() . "\n";
			}
		}else{
			echo mensajeda("Aún no genera el <b>XML</b> en el facturador. <br>$com");
		}
	}else{
		echo mensajeda("No envio datos");
	}
}else{
	echo mensajeda("Acceso restringido");
}