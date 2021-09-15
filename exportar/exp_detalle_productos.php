<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$localv=iseguro($cone,$_GET['lo']);
$iniven=fmysql(iseguro($cone,$_GET['fi']));
$finven=fmysql(iseguro($cone,$_GET['ff']));
if(isset($localv) && !empty($localv) && isset($iniven) && !empty($iniven) && isset($finven) && !empty($finven)){
  $fecha = @date("d-m-Y");
    //Inicio de la instancia para la exportación en Excel
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=productos_vendidos_del_$iniven-al-$finven.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
      <table border=1>
        <tr>
          <th colspan="7"><font face="arial" color="#FF5C26" size="3">DETALLE DE PRODUCTOS VENDIDOS</font></th>
        </tr>
        <tr>
          <td colspan="7"></td>
        </tr>
<?php
          $cprod=mysqli_query($cone,"SELECT p.idproducto, um.abreviatura, p.nombre FROM producto p INNER JOIN unimedida um ON p.idunimedida=um.idunimedida where p.estado=1");
          if (mysqli_num_rows($cprod)>0) {
?>
            <tr>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">PRODUCTO VENDIDO</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">LOCAL DE VENTA</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">FECHA DE VENTA</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">DOCUMENTO</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">CLIENTE</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">UNID.MEDIDA</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">CANTIDAD</font></td>
            </tr>
<?php
              if ($localv=="t") {
                $wl="";
              }else {
                $wl= "AND l.idlocal=$localv";
              }
                while($rcprod=mysqli_fetch_assoc($cprod)){

                  $prod=$rcprod['idproducto'];
                  $c="SELECT dv.*, v.fecha, l.nombre as localv, l.seriecom, pe.nombre as clientev, LPAD(dve.numero, 8,'0') AS numdoc, td.tipodoc FROM venta v INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN detventa dv ON v.idventa=dv.idventa INNER JOIN producto p ON dv.idproducto=p.idproducto INNER JOIN persona pe ON pe.idpersona=v.cliente INNER JOIN docventa dve ON v.idventa=dve.idventa INNER JOIN tipodoc td ON dve.idtipodoc=td.idtipodoc WHERE v.estado=2 AND (date_format(v.fecha, '%Y-%m-%d') BETWEEN '$iniven' AND '$finven') AND p.idproducto=$prod $wl";
                    //echo $c;
                  $cv=mysqli_query($cone,$c);

                  if (mysqli_num_rows($cv)>0){
                    $cant=0;
                    $n=0;
                    while($rcv=mysqli_fetch_assoc($cv)){
                      $cant=$cant+$rcv['cantidad'];
                      $n++;
                      ?>
                      <tr>
                        <td><font color="#000000"><?php echo $rcprod['nombre'];?></font></td>
                        <td><font color="#000000"><?php echo $rcv['localv']; ?></font></td>
                        <td><font color="#000000"><?php echo date('d/m/Y H:i', strtotime($rcv['fecha']))?></font></td>
                        <td><font color="#000000"><?php echo substr($rcv['tipodoc'],0,1).$rcv['seriecom']."-".$rcv['numdoc'];?></td>
                        <td><font color="#000000"><?php echo $rcv['clientev']; ?></font></td>
                        <td><font color="#000000"><?php echo $rcprod['abreviatura']; ?></font></td>
                        <td><font color="#000000"><?php echo $rcv['cantidad']; ?></font></td>
                      </tr>
                      <?php
                    }
              }
        }
    ?>
          </table>

    <?php
    }else{
?>    <tr>
        <td colspan="20">NO EXISTEN PRODUCTOS QUE MOSTRAR</td>
      </tr>
<?php
    }
}
  mysqli_close($cone);
?>
