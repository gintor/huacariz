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
        $cu=mysqli_query($con,"SELECT idusuario FROM usuario u INNER JOIN persona p ON u.idpersona=p.idpersona WHERE u.idusuario=$id AND p.nombre='$no';");
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

function ftnormal($fecha){
    if(is_null($fecha)){
        return "";
    }elseif($fecha==""){
        return "";
    }elseif($fecha=="1969-12-31 00:00:00"){
        return "";
    }elseif($fecha=="1970-01-01 00:00:00"){
        return "";
    }elseif($fecha=="0000-00-00 00:00:00"){
        return "";
    }else{
        $fec=@date("d/m/Y H:i:s",strtotime($fecha));
        return $fec;
    }
}
function ftmysql($fecha){
    if(is_null($fecha)){
        return "";
    }elseif($fecha==""){
        return "";
    }else{
        $fec=@date("Y-m-d H:i:s",strtotime(str_replace('/', '-',$fecha)));
        return $fec;
    }
}

function nombreusu($con, $idu){
    $id=iseguro($con, $idu);
    if($id!=""){
        $cn=mysqli_query($con, "SELECT p.nombre FROM persona p INNER JOIN usuario u ON p.idpersona=u.idpersona WHERE u.idusuario=$idu;");
        if($rn=mysqli_fetch_assoc($cn)){
            return $rn['nombre'];
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
function amigable($str) {

    setlocale(LC_ALL,'es_ES.UTF8');
    $delimiter = '-';
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', html_entity_decode($str));
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}
function mensajesu($men){
    return "<h4 style='color:#999999;' class='text-center'><i class='fa fa-check-circle text-green'></i> $men</h4>";
}
function mensajeda($men){
    return "<h4 style='color:#999999;' class='text-center'><i class='fa fa-warning text-yellow'></i> $men</h4>";
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
function nmes($num){
    $nm=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");
    return $nm[$num-1];
}

function fnormal($fec){
    $fece=explode("-",$fec);
    if(checkdate($fece[1],$fece[2],$fece[0])){
        return date("d/m/Y", strtotime($fec));
    }else{
        return "Error";
    }
}
function fmysql($fec){
  if ($fec!="") {
      $fece=explode("/",$fec);
      if(checkdate($fece[1],$fece[0],$fece[2])){
          return date("Y-m-d", strtotime(str_replace("/","-",$fec)));
      }else{
          return "";
      }
    }else {
      return "";
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
function turno($tur){
    switch ($tur) {
        case 1:
            return "PRIMERO";
            break;
        case 2:
            return "SEGUNDO";
            break;
        default:
            return "Error";
            break;
    }
}
function estadocaja($ec){
    switch ($ec) {
        case 1:
            return "<span class='label label-warning'>Abierta</span>";
            break;
        case 2:
            return "<span class='label label-success'>Cerrada</span>";
            break;
        default:
            return "Error";
            break;
    }
}
function estadoventa($ec){
    switch ($ec) {
        case 1:
            return "<span class='label label-warning'>PE</span>";
            break;
        case 2:
            return "<span class='label label-success'>CO</span>";
            break;
        case 3:
            return "<span class='label label-danger'>AN</span>";
            break;
        default:
            return "Error";
            break;
    }
}
function vacio($data){
    if($data != ''){
    return "'$data'";
    }else{
    return "NULL";
    }
}
function nombrelocal($con, $idl){
    $cl=mysqli_query($con, "SELECT nombre, direccion FROM local WHERE idlocal=$idl;");
    if($rl=mysqli_fetch_assoc($cl)){
        return utf8_encode($rl['nombre'])." - ".utf8_encode($rl['direccion']);
    }else{
        return "-";
    }
    mysqli_free_result($cl);
}
function nompersona($con,$idper){
    $idper=iseguro($con,$idper);
    $c=mysqli_query($con,"SELECT nombre FROM persona WHERE idpersona=$idper;");
    if($r=mysqli_fetch_assoc($c)){
        return utf8_encode($r['nombre']);
    }else{
        return "-";
    }
}
function n_12decimal($num){
    return number_format($num, 1, '.', '');
}
function n_22decimal($num){
    return number_format($num, 2, '.', '');
}
function tipodocumento($td){
    switch ($td) {
        case 1:
            return "DNI";
            break;
        case 4:
            return "CE";
            break;
        case 6:
            return "RUC";
            break;
        case 7:
            return "PASAPORTE";
            break;
        default:
            return "ERROR";
            break;
    }
}
function tmovcaja($tmc){
    switch ($tmc) {
        case 1:
            return "Ingreso";
            break;
        case 2:
            return "Egreso";
            break;
        default:
            return "";
            break;
    }
}

function disubicacion($con,$dis){
    $dis=iseguro($con,$dis);
    $cu=mysqli_query($con,"SELECT departamento, provincia, distrito FROM departamento de INNER JOIN provincia pr ON de.iddepartamento=pr.iddepartamento INNER JOIN distrito di ON pr.idprovincia=di.idprovincia WHERE di.iddistrito=$dis;");
    if($ru=mysqli_fetch_assoc($cu)){
        return $ru['departamento']."-".$ru['provincia']."-".$ru['distrito'];
    }else{
        return "-";
    }
}

function tipocli($tc){
    switch ($tc) {
        case 1:
            return "Común";
            break;
        case 2:
            return "Alianza";
            break;
        case 3:
            return "Distribuidor";
            break;
        case 4:
            return "Paquetes";
            break;
        case 5:
            return "Supermercado";
            break;
        case 6:
            return "Mina";
            break;
        default:
            return "Error";
            break;
    }
}

function relacionper($re){
    switch ($re) {
        case 1:
            return "Cliente";
            break;
        case 2:
            return "Proveedor";
            break;
        case 3:
            return "Colaborador";
            break;
        default:
            return "Error";
            break;
    }
}

function tipprecio($tp){
    switch ($tp) {
        case 1:
            return "Normal";
            break;
        case 2:
            return "Especial";
            break;
        case 3:
            return "ADP";
            break;
        default:
            return "Error";
            break;
    }
}

function proprocedencia($pp){
    switch ($pp) {
        case 1:
            return "Producido (Interno)";
            break;
        case 2:
            return "Mercaderia (Externo)";
            break;
        default:
            return "Error";
            break;
    }
}

function enttipo($t){
    switch ($t) {
        case 1:
            return "NATURAL";
            break;
        case 2:
            return "JURÍDICA";
            break;
        default:
            return "ERROR";
            break;
    }
}

function entrelacion($r){
    switch ($r) {
        case 1:
            return "CLIENTE";
            break;
        case 2:
            return "PROVEEDOR";
            break;
        case 3:
            return "COLABORADOR";
            break;
        default:
            return "ERROR";
            break;
    }
}

function ubigeo($con,$iddis){
    if($con!="" && $iddis!=""){
        $iddis=iseguro($con,$iddis);
        $cu=mysqli_query($con,"SELECT di.distrito, pr.provincia, de.departamento FROM distrito di INNER JOIN provincia pr ON di.idprovincia=pr.idprovincia INNER JOIN departamento de ON pr.iddepartamento=de.iddepartamento WHERE di.iddistrito=$iddis;");
        if($ru=mysqli_fetch_assoc($cu)){
            return $ru['distrito']." - ".$ru['provincia']." - ".$ru['departamento'];
        }else{
            return "-";
        }
        mysqli_free_result($cu);
    }else{
        return "-";
    }
}

function s_codlocal($con,$loc){
    $loc=iseguro($con,$loc);
    $c=mysqli_query($con,"SELECT s_codlocal FROM local WHERE idlocal=$loc;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['s_codlocal'];
    }else{
        return "";
    }
    mysqli_free_result($c);
}

function  s_tipcom($con, $idtd){
    $idtd=iseguro($con,$idtd);
    $c=mysqli_query($con,"SELECT s_tipcom FROM tipodoc WHERE idtipodoc=$idtd;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['s_tipcom'];
    }else{
        return "";
    }
    mysqli_free_result($c);
}

function  sercom($con, $lo){
    $lo=iseguro($con,$lo);
    $c=mysqli_query($con,"SELECT seriecom FROM local WHERE idlocal=$lo;");
    if($r=mysqli_fetch_assoc($c)){
        return $r['seriecom'];
    }else{
        return "";
    }
    mysqli_free_result($c);
}

function numdoc($n){
    switch (strlen($n)) {
        case 1:
            return '0000000'.$n;
            break;
        case 2:
            return '000000'.$n;
            break;
        case 3:
            return '00000'.$n;
            break;
        case 4:
            return '0000'.$n;
            break;
        case 5:
            return '000'.$n;
            break;
        case 6:
            return '00'.$n;
            break;
        case 7:
            return '0'.$n;
            break;
        case 8:
            return $n;
            break;
    }
}
//convertir numero a letras
function basico($numero) {
$valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve','diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete','dieciocho','diecinueve','veinte','veintiuno','veintidos','veintitres','veinticuatro','veinticinco','veintiséis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}
 
function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. basico($x);
}
 
function centenas($n) {
$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
if( $n >= 100) {
if ( $n % 100 == 0 ) {
return $cientos[$n];
} else {
$u = (int) substr($n,0,1);
$d = (int) substr($n,1,2);
return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
}
} else return decenas($n);
}
 
function miles($n) {
if($n > 999) {
if( $n == 1000) {return 'mil';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-3);
$x = (int)substr($n,-3);
if($c == 1) {$cadena = 'mil '.centenas($x);}
else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
else $cadena = centenas($c). ' mil';
return $cadena;
}
} else return centenas($n);
}
 
function millones($n) {
if($n == 1000000) {return 'un millón';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-6);
$x = (int)substr($n,-6);
if($c == 1) {
$cadena = ' millón ';
} else {
$cadena = ' millones ';
}
return miles($c).$cadena.(($x > 0)?miles($x):'');
}
}
function convertir($n) {
switch (true) {
case ( $n >= 1 && $n <= 29) : return basico($n); break;
case ( $n >= 30 && $n < 100) : return decenas($n); break;
case ( $n >= 100 && $n < 1000) : return centenas($n); break;
case ($n >= 1000 && $n <= 999999): return miles($n); break;
case ($n >= 1000000): return millones($n);
}
}
//fin convertir numero a letras

function num3($n){
    switch (strlen($n)) {
        case 1:
            return "00".$n;
            break;
        case 2:
            return "0".$n;
            break;
        case 3:
            return $n;
            break;
    }
}

function espacios($n){
    switch (strlen($n)) {
        case 4:
            return " S/     ".$n;
            break;
        case 5:
            return " S/    ".$n;
            break;
        case 6:
            return " S/   ".$n;
            break;
        case 7:
            return " S/  ".$n;
            break;
        case 8:
            return " S/ ".$n;
            break;
        default:
            return " S/ ".$n;
            break;
    }
}
?>