<?php
include_once 'call/cone.php';
include_once 'cons.php';
include_once 'call/func.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Generador archivos planos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="container">
  <div class="row">
    <div class="col-sm-12 text-center">
      <h2>Generador de archivos planos</h2>
      <hr>
      <form class="form-inline" method="POST" name="fcom">
        <div class="form-group">
          <input type="number" class="form-control" id="des" name="des" placeholder="Desde">
        </div>
        <div class="form-group">
          <input type="number" class="form-control" id="has" name="has" placeholder="Hasta">
        </div>
        <div class="form-group">
          <select name="tdoc" id="tdoc" class="form-control">
            <option value="">Tipo Documento</option>
            <option value="2">Boleta</option>
            <option value="3">Factura</option>
          </select>
        </div>
        <div class="form-group">
        <select name="loc" id="loc" class="form-control">
          <option value="">Local</option>
          <?php
            $cl=mysqli_query($cone, "SELECT idlocal, nombre FROM local WHERE estado=1;");
            if(mysqli_num_rows($cl)>0){
              while($rl=mysqli_fetch_assoc($cl)){
          ?>
            <option value="<?php echo $rl['idlocal'] ?>"><?php echo $rl['nombre'] ?></option>
          <?php
              }
            }else{
          ?>
            <option value="">No se hallaron locales</option>
          <?php
            }
            mysqli_free_result($cl);
          ?>
          </select>
        </div>
        <button type="submit" class="btn btn-info">Generar</button>
      </form>
      <?php
      if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['has']) && !empty($_POST['has']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['loc']) && !empty($_POST['loc'])){
        $des=iseguro($cone, $_POST['des']);
        $has=iseguro($cone, $_POST['has']);
        $tdoc=iseguro($cone, $_POST['tdoc']);
        $loc=iseguro($cone, $_POST['loc']);
        if($des<$has){

          $s_tc=$tdoc==2 ? '03' : '01';
          $s_pr=$tdoc==2 ? 'B' : 'F';

          $cv=mysqli_query($cone, "SELECT LPAD(dv.numero,8,'0') num, v.idventa, v.fecha, p.nombre, p.tipodocumento, p.numerodoc, l.seriecom, l.s_codlocal FROM venta v INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN persona p ON v.cliente=p.idpersona WHERE v.idlocal=$loc AND dv.idtipodoc=$tdoc AND (dv.numero BETWEEN $des AND $has)");
          if(mysqli_num_rows($cv)>0){
      ?>
      <hr>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Numero</th>
            <th>Cliente</th>
            <th>Monto</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
      <?php
            $n=0;
            while($rv=mysqli_fetch_assoc($cv)){
              $n++;
              $idv=$rv['idventa'];

              

              //obtenemos el detalle
              $cde=mysqli_query($cone, "SELECT u.s_coduni, de.cantidad, de.subtotal, de.preunitario, p.idproducto, p.nombre FROM detventa de INNER JOIN producto p ON de.idproducto=p.idproducto INNER JOIN unimedida u ON p.idunimedida=u.idunimedida WHERE de.idventa=$idv;");
              if(mysqli_num_rows($cde)>0){
                $tt=0;
                $p="";
                $det="";
                while($rde=mysqli_fetch_assoc($cde)){
                  $tt=$tt+$rde['subtotal'];

                  //generamos el .det
                  $vu=($rde['preunitario']/1.18);
                  $bi=$vu*$rde['cantidad'];
                  $igv_item=$bi*0.18;
                  $pvu_igv=$rde['preunitario'];

                  $det.=$rde['s_coduni']."|".n_22decimal($rde['cantidad'])."|".$rde['idproducto']."|-|".$rde['nombre']."|".n_22decimal($vu)."|".n_22decimal($igv_item)."|1000|".n_22decimal($igv_item)."|".n_22decimal($bi)."|IGV|VAT|10|18.00|-|0.00|0.00||||0.00|-|0.00|0.00|||0.00|-|0.00|0.00|||0.0|".n_22decimal($pvu_igv)."|".n_22decimal($bi)."|0.00|".PHP_EOL;

                }
              }
              mysqli_free_result($cde);

            //Generamos .cab
            $f=explode(" ", $rv['fecha']);
            $fven=$f[0];
            $tven=$f[1];
            $s_codloc=$rv['s_codlocal'];
            $tdocp=$rv['tipodocumento'];
            $ndocp=$rv['numerodoc'];
            $nomcli=$rv['nombre'];
            $vv=($tt/1.18);
						$igv=$vv*0.18;
            $pv=$tt;
            
            if($nomcli=="SIN NOMBRE"){
              $nomcli="NO ESPECIFICADO";
              $tdocp="0";
              $ndocp="0";
            }
            
            $cab="0101|$fven|$tven|-|$s_codloc|$tdocp|$ndocp|$nomcli|PEN|".n_22decimal($igv)."|".n_22decimal($vv)."|".n_22decimal($pv)."|0.00|0.00|0.00|".n_22decimal($pv)."|2.1|2.0|";
										
            //Generamos tri
            $tri="1000|IGV|VAT|".n_22decimal($vv)."|".n_22decimal($igv)."|";

            //Generamos ley
            $rpva=explode(".",n_22decimal($pv));
            $rpvl=strtoupper(convertir($rpva[0]))." CON ".$rpva[1]."/100";
            $ley="1000|$rpvl|";

            //datos de la empresa
            $ce=mysqli_query($cone,"SELECT ruc FROM datos WHERE iddatos=1;");
            if($re=mysqli_fetch_assoc($ce)){
              $ruc=$re['ruc'];
            }
            mysqli_free_result($ce);
            
            $ruta="C:/txt/";
            $ntxt=$ruc."-".$s_tc."-".$s_pr.$rv['seriecom']."-".$rv['num'];

            $txtcab=fopen($ruta.$ntxt.".cab","a");
            fwrite($txtcab,$cab);
            fclose($txtcab);
            $txtdet=fopen($ruta.$ntxt.".det","a");
            fwrite($txtdet,$det);
            fclose($txtdet);
            $txtley=fopen($ruta.$ntxt.".ley","a");
            fwrite($txtley,$ley);
            fclose($txtley);
            $txttri=fopen($ruta.$ntxt.".tri","a");
            fwrite($txttri,$tri);
            fclose($txttri);


      ?>
          <tr>
            <td><?php echo $n ?></td>
            <td class="text-left"><?php echo $s_pr.$rv['seriecom'].'-'.$rv['num'] ?></td>
            <td class="text-left"><?php echo $rv['nombre']." [".$rv['numerodoc']."]" ?></td>
            <td class="text-right"><?php echo n_22decimal($tt) ?></td>
            <td class="text-right">generados en C:/txt</td>
          </tr>
      <?php
            }
      ?>
        </tbody>
      </table>
      <?php
          }else{
            echo mensajeda("No se encontraron resultados");
          }
          mysqli_free_result($cv);

        }else{
          echo mensajeda("El primer valor no puede ser mayor o igual al segundo.");
        }
      ?>

      <?php
      }else{
        echo mensajeda("Ingrese datos en todos los campos.");
      }
      ?>


    </div>
    <div class="col-sm-12 text-center">
      <h2>Generar archivos de anulaciones</h2>
      <hr>
      <form class="form-inline" method="POST" name="fbaj">
        <div class="form-group">
          <input type="number" class="form-control" id="desb" name="desb" placeholder="Desde">
        </div>
        <div class="form-group">
          <input type="number" class="form-control" id="hasb" name="hasb" placeholder="Hasta">
        </div>
        <div class="form-group">
          <select name="tdocb" id="tdocb" class="form-control">
            <option value="">Tipo Documento</option>
            <option value="2">Boleta</option>
            <option value="3">Factura</option>
          </select>
        </div>
        <div class="form-group">
          <select name="locb" id="locb" class="form-control">
            <option value="">Local</option>
          <?php
            $cl=mysqli_query($cone, "SELECT idlocal, nombre FROM local WHERE estado=1;");
            if(mysqli_num_rows($cl)>0){
              while($rl=mysqli_fetch_assoc($cl)){
          ?>
            <option value="<?php echo $rl['idlocal'] ?>"><?php echo $rl['nombre'] ?></option>
          <?php
              }
            }else{
          ?>
            <option value="">No se hallaron locales</option>
          <?php
            }
            mysqli_free_result($cl);
          ?>
          </select>
        </div>
        <button type="submit" class="btn btn-info">Generar</button>
      </form>
      <?php
      if(isset($_POST['desb']) && !empty($_POST['desb']) && isset($_POST['hasb']) && !empty($_POST['hasb']) && isset($_POST['tdocb']) && !empty($_POST['tdocb']) && isset($_POST['locb']) && !empty($_POST['locb'])){
        $desb=iseguro($cone, $_POST['desb']);
        $hasb=iseguro($cone, $_POST['hasb']);
        $tdocb=iseguro($cone, $_POST['tdocb']);
        $locb=iseguro($cone, $_POST['locb']);
        if($desb<$hasb){
          //datos de la empresa
          $ce=mysqli_query($cone,"SELECT ruc FROM datos WHERE iddatos=1;");
          if($re=mysqli_fetch_assoc($ce)){
            $ruc=$re['ruc'];
          }
          mysqli_free_result($ce);

          $cv=mysqli_query($cone, "SELECT LPAD(dv.numero,8,'0') num, v.idventa, v.fecha, v.fecbaja, v.numbaja, p.nombre, p.tipodocumento, p.numerodoc, l.seriecom FROM venta v INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN persona p ON v.cliente=p.idpersona WHERE v.idlocal=$locb AND fecbaja IS NOT NULL AND dv.idtipodoc=$tdocb AND (dv.numero BETWEEN $desb AND $hasb)");
          if(mysqli_num_rows($cv)>0){
          ?>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Número</th>
                <th>Monto</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
          <?php
            $a=0;
            while($rv=mysqli_fetch_assoc($cv)){
              $idv=$rv['idventa'];

              if($rv['nombre']=="SIN NOMBRE"){
                $nomcli="NO ESPECIFICADO";
                $tdocp="0";
                $ndocp="0";
              }

              //obtenemos el total
              $cde=mysqli_query($cone, "SELECT SUM(subtotal) tot FROM detventa WHERE idventa=$idv;");
              if($rde=mysqli_fetch_assoc($cde)){
                
                $pc=$rde['tot']/1.18;
                $igv=$pc*0.18;
                if($tdocb==2){

                  $rdi=date('Y-m-d', strtotime($rv['fecha']))."|".$rv['fecbaja']."|03|B".$rv['seriecom']."-".$rv['num']."|".$rv['tipodocumento']."|".$rv['numerodoc']."|PEN|".n_22decimal($pc)."|0.00|0.00|0.00|0.00|0.00|".n_22decimal($rde['tot'])."||||||0|0|0|3|";

                  $trd="1|1000|IGV|VAT|".n_22decimal($pc)."|".n_22decimal($igv)."|";

                  $ruta="C:/txt/";
									$ntxt=$ruc."-RC-".date('Ymd', strtotime($rv['fecbaja']))."-".num3($rv['numbaja']);
									$txtrdi=fopen($ruta.$ntxt.".rdi","a");
									fwrite($txtrdi,$rdi);
									fclose($txtrdi);
									$txttrd=fopen($ruta.$ntxt.".trd","a");
									fwrite($txttrd,$trd);
									fclose($txttrd);

                }elseif($tdocb==3){

                  $cba=date('Y-m-d', strtotime($rv['fecha']))."|".$rv['fecbaja']."|01|F".$rv['seriecom']."-".$rv['num']."|ERROR EN LA EMISION|";

									$ruta="C:/txt/";
									$ntxt=$ruc."-RA-".date('Ymd', strtotime($rv['fecbaja']))."-".num3($rv['numbaja']);
									$txtcba=fopen($ruta.$ntxt.".cba","a");
									fwrite($txtcba,$cba);
									fclose($txtcba);

                }
              }
              $a++;
          ?>
              <tr>
                <td><?php echo $a ?></td>
                <td><?php echo ($tdocb==3 ? 'F' : 'B').$rv['seriecom']."-".$rv['num'] ?></td>
                <td><?php echo $rde['tot'] ?></td>
                <td>generados en C:/txt</td>
              </tr>
          <?php
            }
          ?>
            </tbody>
          </table>
          <?php
          }else{
            echo mensajeda("No se encontraron documentos anulados.");
          }
          mysqli_free_result($cv);
        }else{
          echo mensajeda("El primer valor no puede ser mayor o igual al segundo.");
        }
      }
      ?>
    </div>

  </div>
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
