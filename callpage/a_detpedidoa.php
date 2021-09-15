<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
  if(isset($_POST['idped']) && !empty($_POST['idped'])){
    $idped=iseguro($cone,$_POST['idped']);
    //$idca=iseguro($cone,$_POST['idca']);
    $cv=mysqli_query($cone,"SELECT v.estado, v.fecha, p.nombre, p.descuento, p.tipodocumento, p.numerodoc, td.tipodoc, LPAD(dv.numero, 8,'0') AS numdoc, l.seriecom FROM venta v INNER JOIN persona p ON v.cliente=p.idpersona INNER JOIN local l ON v.idlocal=l.idlocal INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN tipodoc td ON dv.idtipodoc=td.idtipodoc WHERE v.idventa=$idped;");
    if($rv=mysqli_fetch_assoc($cv)){
      $estado=$rv['estado'];
      if ($estado==2) {
        $est="";
      }else {
        $est="ANULADA";
      }
?>
    <table class="table table-hover table-bordered">
      <tr>
        <th>CLIENTE</th>
        <td colspan="3"><?php echo $rv['nombre']; ?></td>
      </tr>
      <tr>
        <th><?php echo tipodocumento($rv['tipodocumento']); ?></th>
        <td><?php echo $rv['numerodoc']; ?></td>
        <th>FECHA</th>
        <td><?php echo ftnormal($rv['fecha']); ?></td>
      </tr>
      <tr>
        <th> <?php echo $rv['tipodoc']." ".$est;?></th>
        <td colspan="3"><?php echo substr($rv['tipodoc'],0,1).$rv['seriecom']."-".$rv['numdoc'];?></td>
      </tr>
    </table>

<?php
      $cdv=mysqli_query($cone,"SELECT dv.*, p.nombre FROM detventa dv INNER JOIN producto p ON dv.idproducto=p.idproducto WHERE dv.idventa=$idped;");
      if(mysqli_num_rows($cdv)>0){
?>
    <table class="table table-hover table-bordered">
      <thead>
      <tr>
        <th>#</th>
        <th>PRODUCTO</th>
        <th>CANT.</th>
        <th>PU</th>
        <th>TOTAL</th>
      </tr>
      </thead>
<?php
        $n=0;
        $st=0;
        while($rdv=mysqli_fetch_assoc($cdv)){
          $n++;
          $st=$st+$rdv['subtotal'];
?>
      <tr>
        <td><?php echo $n; ?></td>
        <td><?php echo $rdv['nombre']; ?></td>
        <td><?php echo $rdv['cantidad']; ?></td>
        <td><?php echo "S/ ".$rdv['preunitario']; ?></td>
        <td><?php echo "S/ ".$rdv['subtotal']; ?></td>
      </tr>
<?php
        }
        $de=n_22decimal($st*$rv['descuento']);
?>
      <tr>
        <th colspan="4">TOTAL</th>
        <th><?php echo "S/ ". n_22decimal($st); ?></th>
      </tr>
      <tr>
        <th colspan="4">DESCUENTO (<?php echo ($rv['descuento']*100); ?> %)</th>
        <th><?php echo "S/ ". $de; ?></th>
      </tr>
      <tr>
        <th colspan="4">T. TOTAL</th>
        <th><?php echo "S/ ". n_22decimal($st-$de); ?><input type="hidden" name="ttot" value="<?php echo ($st-$de) ?>"></th>
      </tr>
    </table>
<?php
      }
      mysqli_free_result($cdv);

    }else{
      echo mensajeda("Datos incorrectos");
    }
    mysqli_free_result($cv);
  }else{
    echo mensajeda("Faltan datos");
  }
?>
