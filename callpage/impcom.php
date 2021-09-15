<?php
session_start();
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$no=iseguro($cone, $_SESSION['nousu']);
	$lo=iseguro($cone, $_SESSION['local']);
	if(vlogin($cone, $no, $id)){
		if(isset($_POST['com']) && !empty($_POST['com'])){
			$com=iseguro($cone,$_POST['com']);

			$xml="C:/SFS_v1.2/sunat_archivos/sfs/FIRMA/$com.xml";
			if(is_file($xml)){
				$a_xml=simplexml_load_file($xml);
				$nom=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyName/cbc:Name');
				$dir=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cac:AddressLine/cbc:Line');
				$dis=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cbc:District');
				$pro=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cbc:CountrySubentity');
				$dep=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress/cbc:CityName');
				$ruc=$a_xml->xpath('cac:AccountingSupplierParty/cac:Party/cac:PartyIdentification/cbc:ID');
				$cod=$a_xml->xpath('ext:UBLExtensions/ext:UBLExtension/ext:ExtensionContent/ds:Signature/ds:SignedInfo/ds:Reference/ds:DigestValue');

				$numpro=$a_xml->xpath('cac:InvoiceLine');
				$can=$a_xml->xpath('cac:InvoiceLine/cbc:InvoicedQuantity');
				$pre=$a_xml->xpath('cac:InvoiceLine/cac:PricingReference/cac:AlternativeConditionPrice/cbc:PriceAmount');
				$nompro=$a_xml->xpath('cac:InvoiceLine/cac:Item/cbc:Description');

				$docide=$a_xml->xpath('cac:AccountingCustomerParty/cac:Party/cac:PartyIdentification/cbc:ID');

				echo var_dump($docide)."<br>";
				echo $docide[0]['schemeID']."<br>";
				echo $docide[0]."<br>";
				
				for ($i=0; $i < count($numpro); $i++) { 
					echo $can[$i]." ".$nompro[$i]."".$pre[$i]."<br>";
				}
				
			}else{
				echo mensajeda("Aún no genera el <b>XML</b> en el facturador ".$xml);
			}
		}else{
			echo mensajeda("No envio datos");
		}
	}else{
		echo mensajeda("Acceso restringido");
	}
?>