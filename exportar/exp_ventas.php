<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$clientep=iseguro($cone,$_GET['cl']);
$iniped=fmysql(iseguro($cone,$_GET['fi']));
$finped=fmysql(iseguro($cone,$_GET['ff']));
$estado=iseguro($cone,$_GET['est']);
if(isset($clientep) && !empty($clientep) && isset($iniped) && !empty($iniped) && isset($finped) && !empty($finped) && isset($estado) && !empty($estado)){
      $fecha = @date("d-m-Y");

      //Inicio de la instancia para la exportación en Excel
      //header('Content-type: application/vnd.ms-excel');
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=ventas_$iniped-al-$finped.xls");
      header("Pragma: no-cache");
      header("Expires: 0");
?>
      <table border=1>
        <tr>
              <th colspan="11"><font face="arial" color="#FF5C26" size="3">REPORTE DE VENTAS <?php echo $estado==2 ? "ACTIVAS" : "ANULADAS";?></font></th>
        </tr>
        <tr>
              <td colspan="11"></td>
        </tr>
<?php
          if ($clientep=="t") {
              $wu="";
            }else {
              $wu= "AND p.idpersona=$clientep";
            }
            $c="SELECT v.idventa, u.usuario as cajero, us.usuario as despachador, l.nombre AS tienda, v.fecha, p.idpersona, p.nombre, v.descuento, tp.tipopag, td.tipodoc, LPAD(dv.numero, 8,'0') AS numdoc, l.seriecom FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN caja c ON c.idcaja=v.idcaja INNER JOIN usuario u ON c.idusuario = u.idusuario INNER JOIN usuario us ON v.idusuario=us.idusuario INNER JOIN tipopag tp ON v.idtipopag= tp.idtipopag INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN tipodoc td ON dv.idtipodoc=td.idtipodoc WHERE v.estado=$estado AND (date_format(v.fecha, '%Y-%m-%d') BETWEEN '$iniped' AND '$finped') $wu";
            $cp=mysqli_query($cone,$c);
            if (mysqli_num_rows($cp)>0) {
?>
                <tr>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">N°</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">TIENDA</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">CAJERO</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">DESPACHADOR</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">FECHA</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">CLIENTE</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">DOCUMENTO</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">TIPODOC</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">T.PAGO</font></td>
                  <td bgcolor= "#777777"><font color="#ffffff" size="2">MONTO CANCELADO S/</font></td>
                  <!--<td bgcolor= "#777777"><font color="#ffffff" size="2">DESCUENTO S/</font></td>-->
                  <!--<td bgcolor= "#777777"><font color="#ffffff" size="2">ESTADO</font></td>-->
                </tr>
                <?php
                while($rcp=mysqli_fetch_assoc($cp)){
                    $idped=$rcp['idventa'];
                    $cdv=mysqli_query($cone,"SELECT dv.*, p.nombre, p.precioven FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$idped;");
                      if(mysqli_num_rows($cdv)>0){
                          $n=0;
                          $st=0;
                          while($rdv=mysqli_fetch_assoc($cdv)){
                            $n++;
                            $st=$st+$rdv['subtotal'];
                          }
                          //$de=$st*$rcp['descuento'];
                ?>
                <tr>
                  <td><font color="#000000"><?php echo $rcp['idventa'];?></font></td>
                  <td><font color="#000000"><?php echo $rcp['tienda']; ?></font></td>
                  <td><font color="#000000"><?php echo $rcp['cajero']; ?></font></td>
                  <td><font color="#000000"><?php echo $rcp['despachador']; ?></font></td>
                  <td><font color="#000000"><?php echo date('d/m/Y H:i', strtotime($rcp['fecha']))?></td>
                  <td><font color="#000000"><?php echo $rcp['nombre'];?></td>
                  <td><font color="#000000"><?php echo substr($rcp['tipodoc'],0,1).$rcp['seriecom']."-".$rcp['numdoc'];?></td>
                  <td><font color="#000000"><?php echo $rcp['tipodoc']; ?></td>
                  <td><font color="#000000"><?php echo $rcp['tipopag']; ?></font></td>
                  <td><font color="#000000"><?php echo n_22decimal($st);?></font></td>
                  <!--<td><font color="#000000"><?php //echo n_22decimal($de);?></font></td>-->
                  <!--<td><font color="#000000"><?php //echo $rcp['estado']; ?></font></td>-->
                </tr>
<?php
                      }
                }
?>
          </table>
<?php
                }else{
?>                 <tr>
                    <td colspan="20">NO EXISTEN VENTAS QUE MOSTRAR</td>
                  </tr>
<?php
                }
}else{
		echo mensajeda("Error: Debe seleccionar al menos un valor en cada campo");
	}
  mysqli_close($cone);
?>
