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
    //header('Content-type: application/vnd.ms-excel');
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=productos_vendidos_del_$iniven-al-$finven.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
      <table border=1>
        <tr>
          <th colspan="3"><font face="arial" color="#FF5C26" size="3">REPORTE DE PRODUCTOS VENDIDOS</font></th>
        </tr>
        <tr>
          <td colspan="3"></td>
        </tr>
<?php
          $cprod=mysqli_query($cone,"SELECT p.idproducto, um.abreviatura, p.nombre FROM producto p INNER JOIN unimedida um ON p.idunimedida=um.idunimedida where p.estado=1");
          if (mysqli_num_rows($cprod)>0) {
?>
            <tr>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">PRODUCTO</font></td>
              <td bgcolor= "#777777"><font color="#ffffff" size="2">UNIDAD DE MEDIDA</font></td>
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
                  $c="SELECT dv.* FROM venta v INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN detventa dv ON v.idventa=dv.idventa INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE v.estado=2 AND (date_format(v.fecha, '%Y-%m-%d') BETWEEN '$iniven' AND '$finven') AND p.idproducto=$prod $wl";

                  $cv=mysqli_query($cone,$c);

                  if (mysqli_num_rows($cv)>0){
                    $cant=0;
                    while($rcv=mysqli_fetch_assoc($cv)){
                      $cant=$cant+$rcv['cantidad'];
                        }
                        ?>
                        <tr>
                          <td><font color="#000000"><?php echo $rcprod['nombre'];?></font></td>
                          <td><font color="#000000"><?php echo $rcprod['abreviatura']; ?></font></td>
                          <td><font color="#000000"><?php echo $cant; ?></font></td>
                        </tr>
    <?php
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
