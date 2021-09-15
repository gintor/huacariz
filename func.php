<?php
function iseguro($conex,$val)
{
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}
function imseguro($conex,$val)
{
    $val=mb_strtoupper($val,'UTF-8');
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}
function inseguro($conex,$val)
{
    $val=mb_strtolower($val,'UTF-8');
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}
function vlogin($con, $no, $id){
    if(isset($no) && !empty($no) && isset($id) && !empty($id)){
        $cu=mysqli_query($con,"SELECT * FROM usuario WHERE idusuario=$id AND nombre='$no';");
        if($ru=mysqli_fetch_assoc($cu)){
            return true;
        }else{
            return false;
        }
        mysqli_free_result($cu);
    }else{
        return false;
    }
}
function nombre($con, $id){
    $id=iseguro($con, $id);
    if($id!=NULL){
        $cn=mysqli_query($con, "SELECT apepaterno, apematerno, nombres FROM persona p INNER JOIN miembro m ON p.idpersona=m.idpersona INNER JOIN usuario u ON m.idmiembro=u.idmiembro WHERE u.idusuario=$id;");
        if($rn=mysqli_fetch_assoc($cn)){
            return $rn['apepaterno']." ".$rn['apematerno']." ".$rn['nombres'];
        }else{
            return "-";
        }
        mysqli_free_result($cn);
    }else{
        return "-";
    }
}
function nombreper($con, $id){
    $id=iseguro($con, $id);
    if($id!=NULL){
        $cn=mysqli_query($con, "SELECT apepaterno, apematerno, nombres FROM persona WHERE idpersona=$id;");
        if($rn=mysqli_fetch_assoc($cn)){
            return $rn['apepaterno']." ".$rn['apematerno']." ".$rn['nombres'];
        }else{
            return "-";
        }
        mysqli_free_result($cn);
    }else{
        return "-";
    }
}
function nombremie($con, $idm){
    $idm=iseguro($con, $idm);
    if($idm!=NULL){
        $cn=mysqli_query($con, "SELECT apepaterno, apematerno, nombres FROM persona p INNER JOIN miembro m ON p.idpersona=m.idpersona WHERE m.idmiembro=$idm;");
        if($rn=mysqli_fetch_assoc($cn)){
            return $rn['apepaterno']." ".$rn['apematerno']." ".$rn['nombres'];
        }else{
            return "-";
        }
        mysqli_free_result($cn);
    }else{
        return "-";
    }
}
function nombreemp($con,$idem){
    $idem=iseguro($con, $idem);
    if($idem!=NULL){
        $cn=mysqli_query($con, "SELECT razonsocial FROM empresa WHERE idempresa=$idem;");
        if($rn=mysqli_fetch_assoc($cn)){
            return $rn['razonsocial'];
        }else{
            return "-";
        }
        mysqli_free_result($cn);
    }else{
        return "-";
    }
}
function redireccinar(){
    header ("Location: ".ROOT);
}
function restringido(){
    return "<h4 class='text text-warning text-center'><i class='fa fa-exclamation-triangle'></i> Acceso restringido</h4>";
}
function amigable1($str) {

    setlocale(LC_ALL,'es_ES.UTF8');
    $delimiter = '-';
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', html_entity_decode($str));
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}
function amigable($url) {

// Tranformamos todo a minusculas

$url = strtolower(html_entity_decode(trim($url)));

//Rememplazamos caracteres especiales latinos

$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

$repl = array('a', 'e', 'i', 'o', 'u', 'n');

$url = str_replace ($find, $repl, $url);

// Añaadimos los guiones

$find = array(' ', '&', '\r\n', '\n', '+'); 
$url = str_replace ($find, '-', $url);

// Eliminamos y Reemplazamos demás caracteres especiales

$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

$repl = array('', '-', '');

$url = preg_replace ($find, $repl, $url);

return $url;

}
function mensajesu($men){
    return "<h4 class='text-center text-muted'><i class='fa fa-check-circle text-green'></i> $men</h4>";
}
function mensajeda($men){
    return "<h4 class='text-center text-muted'><i class='fa fa-warning text-yellow'></i> $men</h4>";
}
function amensajesu($men){
    return "<i class='fa fa-check-circle text-green'></i> $men";
}
function amensajeda($men){
    return "<i class='fa fa-warning text-yellow'></i> $men";
}
function vaccesom($con,$usu,$mod,$niv){
    $usu=iseguro($con,$usu);
    $mod=iseguro($con,$mod);
    $niv=iseguro($con,$niv);
    $cmu=mysqli_query($con,"SELECT idmodusuario FROM modusuario WHERE idusuario=$usu AND idmodulo=$mod AND nivel=$niv AND estado=1;");
    if($rmu=mysqli_fetch_assoc($cmu)){
        return true;
    }else{
        return false;
    }
    mysqli_free_result($cmu);
}
function fmiembro($con,$id){
    $id=iseguro($con,$id);
    $cfm=mysqli_query($con,"SELECT fecingreso FROM miembro m INNER JOIN usuario u ON m.idmiembro=u.idmiembro WHERE idusuario=$id;");
    if($rfm=mysqli_fetch_assoc($cfm)){
        return date("d/m/Y", strtotime($rfm['fecingreso']));
    }else{
        return "-";
    }
}
function nmes($num){
    $nm=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");
    return $nm[$num-1];
}
function tmovimiento($tip){
    switch ($tip) {
        case 1:
            return "Ingreso";
            break;
        case 2:
            return "Egreso";
            break;
        default:
            return "Error";
            break;
    }
}
function fnormal($fec){
    if($fec!=""){
        $fece=explode("-",$fec);
        if(checkdate($fece[1],$fece[2],$fece[0])){
            return date("d/m/Y", strtotime($fec));
        }else{
            return "Error";
        }
    }else{
        return "-";
    }
}
function fmysql($fec){
    $fece=explode("/",$fec);
    if(checkdate($fece[1],$fece[0],$fece[2])){
        return date("Y-m-d", strtotime(str_replace("/","-",$fec)));
    }else{
        return "Error";
    }
}
function estado($est){
        switch ($est) {
        case 1:
            return "<span class='label label-success'>Activo</span>";
            break;
        case 0:
            return "<span class='label label-danger'>Inactivo</span>";
            break;
        default:
            return "Error";
            break;
    }
}
function codmovimiento($con, $idmov){
    $idmov=iseguro($con,$idmov);
    $cco=mysqli_query($con,"SELECT mo.codigo, mo.mes, mo.anio, sd.codigo AS csdiario FROM movimiento mo INNER JOIN subdiario sd ON mo.idsubdiario=sd.idsubdiario WHERE mo.idmovimiento=$idmov;");
    if($rco=mysqli_fetch_assoc($cco)){
        switch (strlen($rco['mes'])) {
            case 1:
                $mes="0".$rco['mes'];
                break;
            case 2:
                $mes=$rco['mes'];
                break;
        }
        switch (strlen($rco['codigo'])) {
            case 1:
                $codigo="000".$rco['codigo'];
                break;
            case 2:
                $codigo="00".$rco['codigo'];
                break;
            case 3:
                $codigo="0".$rco['codigo'];
                break;
            case 4:
                $codigo=$rco['codigo'];
                break;
        }
        return $rco['csdiario'].$mes.$rco['anio'].$codigo;
    }else{
        return "Error";
    }
}
function vacio($data){
    if($data != ''){
    return "'$data'";
    }else{
    return "NULL";
    }
}
function centrocostos($con,$idcc){
    $idcc=iseguro($con,$idcc);
    $ccc=mysqli_query($con,"SELECT p.idproyecto, LPAD(cc.codigo,5,'0') AS cod FROM centrocostos cc INNER JOIN actividad a ON cc.idactividad=a.idactividad INNER JOIN componente c ON a.idcomponente=c.idcomponente INNER JOIN proyecto p ON c.idproyecto=p.idproyecto WHERE idcentrocostos=$idcc;");
    if($rcc=mysqli_fetch_assoc($ccc)){
        return codproyecto($rcc['idproyecto'])."-".$rcc['cod'];
    }else{
        return "Error";
    }
}
function lcentrocostos($con,$idcc){
    $idcc=iseguro($con,$idcc);
    $ccc=mysqli_query($con,"SELECT a.nombre AS actividad, c.nombre AS componente, p.nombre AS proyecto, e.nombre AS elemento, e.tipo FROM centrocostos cc INNER JOIN actividad a ON cc.idactividad=a.idactividad INNER JOIN componente c ON a.idcomponente=c.idcomponente INNER JOIN proyecto p ON c.idproyecto=p.idproyecto INNER JOIN elemento e ON cc.idelemento=e.idelemento WHERE idcentrocostos=$idcc;");
    if($rcc=mysqli_fetch_assoc($ccc)){
        return eletipo($rcc['tipo'])."-".$rcc['elemento']." (".$rcc['actividad']."-".$rcc['componente']."-".$rcc['proyecto'].")";
    }else{
        return "Error";
    }
}
function numcuenta($con, $idcue){
    $idcue=iseguro($con,$idcue);
    if($idcue!=NULL){
        $ccu=mysqli_query($con,"SELECT numcuenta FROM cuenta WHERE idcuenta=$idcue;");
        if($rcu=mysqli_fetch_assoc($ccu)){
            return $rcu['numcuenta'];
        }else{
            return "-";
        }
    }else{
        return "-";
    }
}
function aglosa($glo){
    if(!is_null($glo)){
        return strlen(html_entity_decode($glo))>18 ? substr(html_entity_decode($glo),0,18)."..." : $glo;
    }else{
        return "-";
    }
}
function codproyecto($idp){
    if(!is_null($idp)){
        switch (strlen($idp)) {
            case 1:
                $c="P0".$idp;
                break;
            case 2:
                $c="P".$idp;
                break;
        }
        return $c;
    }else{
        return "-";
    }
}
function codcomponente($idc){
    if(!is_null($idc)){
        switch (strlen($idc)) {
            case 1:
                $c="C0".$idc;
                break;
            case 2:
                $c="C".$idc;
                break;
        }
        return $c;
    }else{
        return "-";
    }
}
function codactividad($ida){
    if(!is_null($ida)){
        switch (strlen($ida)) {
            case 1:
                $c="A0".$ida;
                break;
            case 2:
                $c="A".$ida;
                break;
        }
        return $c;
    }else{
        return "-";
    }
}
function codpresupuesto($idp){
    if(!is_null($idp)){
        switch (strlen($idp)) {
            case 1:
                $c="PRE0".$idp;
                break;
            case 2:
                $c="PRE".$idp;
                break;
        }
        return $c;
    }else{
        return "-";
    }
}
function eletipo($tip){
    $t="";
    if($tip!=""){
        switch ($tip) {
            case 1:
                $t="I";
                break;
            case 2:
                $t="G";
                break;
        }
    }
    return $t;
}
function estcivil($ec){
    switch ($ec) {
        case 1:
            $e="SOLTERO(A)";
            break;
        case 2:
            $e="CASADO(A)";
            break;
        case 3:
            $e="VIUDO(A)";
            break;
        case 4:
            $e="DIVORCIADO(A)";
            break;
        case 5:
            $e="CONVIVIENTE";
            break;
    }
    return $e;
}
function n_2decimal($num){
    return number_format((float)$num, 2, '.', ''); 
}
function disprodep($con, $iddis){
    $iddis=iseguro($con, $iddis);
    $c=mysqli_query($con,"SELECT d.nombre AS dis, p.nombre AS pro, de.nombre AS dep FROM distrito d INNER JOIN provincia p ON d.idprovincia=p.idprovincia INNER JOIN departamento de ON p.iddepartamento=de.iddepartamento WHERE d.iddistrito=$iddis;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['dis']." - ".$r['pro']." - ".$r['dep'];
    }else{
        return "-";
    }
}
function tpago($con,$idtp){
    $idtp=iseguro($con,$idtp);
    $c=mysqli_query($con,"SELECT * FROM tipopago;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['descripcion'];
    }else{
        return "-";
    }
}
function tdocumento($con,$idtd){
    $idtd=iseguro($con,$idtd);
    $c=mysqli_query($con,"SELECT * FROM tipodocumento;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['descripcion'];
    }else{
        return "-";
    }
}

//Elianex
function nombredenom($con,$iddenom){
    $iddenom=iseguro($con, $iddenom);
    if($iddenom!=NULL){
        $cn=mysqli_query($con, "SELECT nombre,codigo FROM denominacion WHERE iddenominacion=$iddenom;");
        if($rn=mysqli_fetch_assoc($cn)){
            return $rn['codigo']." ".$rn['nombre'];
        }else{
            return "-";
        }
        mysqli_free_result($cn);
    }else{
        return "-";
    }
}
function estador($est){
        switch ($est) {
        case 1:
            return "<span class='label label-info'>Pendiente</span>";
            break;
        case 2:
            return "<span class='label label-warning'>Rendido Parcial</span>";
            break;
         case 3:
            return "<span class='label label-success'>Rendido</span>";
            break;
         case 4:
            return "<span class='label label-default'>Inactivo</span>";
            break;
        case 5:
            return "<span class='label label-danger'>Vencido</span>";
            break;
        default:
            return "Error";
            break;
    }
}
function estadore($est){
        switch ($est) {
        case 1:
            return "<span class='label label-info'>Pendiente</span>";
            break;
        case 2:
            return "<span class='label label-primary'>Por Aprobar</span>";
            break;
         case 3:
            return "<span class='label label-warning'>Observado</span>";
            break;
         case 4:
            return "<span class='label label-success'>Aprobado</span>";
            break;
        case 5:
            return "<span class='label label-danger'>Inactivo</span>";
            break;
        default:
            return "Error";
            break;
    }
}
function foto($con,$idp){
    $cp=mysqli_query($con,"SELECT foto FROM persona WHERE idpersona=$idp;");
    if($rp=mysqli_fetch_assoc($cp)){
        if(is_file("fotos/".$rp['foto'])){
            return "fotos/".$rp['foto'];
        }else{
            return "fotos/nofoto.png";
        }
    }else{
        return "fotos/nofoto.png";
    }
}
function exigraactivo($con,$idp){
    $idp=iseguro($con,$idp);
    $c=mysqli_query($con,"SELECT m.idmiembro FROM miembro m INNER JOIN miegrado mg ON m.idmiembro=mg.idmiembro WHERE m.idpersona=$idp AND mg.estado=1;");
    if($r=mysqli_fetch_assoc($c)){
        return true;
    }else{
        return false;
    }
    mysqli_free_result($c);
}
function idmieactivo($con,$idp){
    $idp=iseguro($con,$idp);
    $c=mysqli_query($con,"SELECT idmiembro FROM miembro WHERE idpersona=$idp AND estado=1;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['idmiembro'];
    }else{
        return "";
    }
}
function exicaractivo($con,$idp){
    $idp=iseguro($con,$idp);
    $c=mysqli_query($con,"SELECT m.idmiembro FROM miembro m INNER JOIN miecargo mc ON m.idmiembro=mc.idmiembro WHERE m.idpersona=$idp AND mc.estado=1;");
    if($r=mysqli_fetch_assoc($c)){
        return true;
    }else{
        return false;
    }
    mysqli_free_result($c);
}
function exisecactiva($con,$idp){
    $idp=iseguro($con,$idp);
    $c=mysqli_query($con,"SELECT m.idmiembro FROM miembro m INNER JOIN miecomponente mc ON m.idmiembro=mc.idmiembro WHERE m.idpersona=$idp AND mc.estado=1;");
    if($r=mysqli_fetch_assoc($c)){
        return true;
    }else{
        return false;
    }
    mysqli_free_result($c);
}
function exicuoactiva($con,$idp){
    $idp=iseguro($con,$idp);
    $c=mysqli_query($con,"SELECT m.idmiembro FROM miembro m INNER JOIN moncuota mc ON m.idmiembro=mc.idmiembro WHERE m.idpersona=$idp AND mc.estado=1;");
    if($r=mysqli_fetch_assoc($c)){
        return true;
    }else{
        return false;
    }
    mysqli_free_result($c);
}
function malta($con,$idma){
    $idma=iseguro($con,$idma);
    $c=mysqli_query($con,"SELECT motivo FROM motivoalta WHERE idmotivoalta=$idma;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['motivo'];
    }else{
        return "-";
    }
    mysqli_free_result($c);
}
function mbaja($con,$idmb){
    if(!is_null($idmb)){
        $idmb=iseguro($con,$idmb);
        $c=mysqli_query($con,"SELECT motivo FROM motivobaja WHERE idmotivobaja=$idmb;");
        if($r=mysqli_fetch_assoc($c)){
            return $r['motivo'];
        }else{
            return "-";
        }
        mysqli_free_result($c);
    }else{
        return "-";
    }
}
?>