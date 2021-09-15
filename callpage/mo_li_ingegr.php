<?php
session_start();
if(isset($_POST['idm']) && !empty($_POST['idm']) && isset($_POST['ma']) && !empty($_POST['ma'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$idm=iseguro($cone, $_POST['idm']);
	$ma=explode("/",iseguro($cone,$_POST['ma']));
	$no=iseguro($cone, $_SESSION['nousu']);
	$id=iseguro($cone, $_SESSION['idusu']);
	if(is_numeric($ma[0]) && is_numeric($ma[1])){
		$anio=$ma[1];
		$mes=$ma[0];
		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
			$cu=mysqli_query($cone,"SELECT m.idmovimiento, m.codigo, m.fecregistro, m.glosa, m.estado, sd.descripcion AS subdiario, a.descripcion AS actividad  FROM movimiento m INNER JOIN subdiario sd ON m.idsubdiario=sd.idsubdiario INNER JOIN actividad a ON m.idactividad=a.idactividad WHERE m.anio='$anio' AND m.mes='$mes' ORDER BY m.idmovimiento DESC;");
?>
				<div class="row">
					<div class="col-md-8">
						<span class="titulo"><i class="fa fa-calendar-o text-gray"></i> <?php echo strtoupper(nmes($mes)); ?> - <?php echo $anio; ?></span>
						<input type="hidden" id="mean" value="<?php echo $mes."/".$anio; ?>">
					</div>
					<div class="col-md-4 text-right">
						<?php if(vaccesom($cone,$id,$idm,1)){ ?>
						<button type="button" class="btn bg-aqua" id="b_a_ingegr"><i class="fa fa-plus"></i> Agregar</button>
						<?php } ?>
					</div>
				</div>
				<hr>
<?php
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_ingegr">
					<thead>
						<tr>
							<th>CÓDIGO</th>
							<th>SUB DIARIO</th>
							<th>ACTIVIDAD</th>
							<th>F REG.</th>
							<th>GLOSA</th>
							<th>ESTADO</th>
							<th>ACCIÓN</th>
						</tr>
					</thead>
					<tbody>
<?php
				$n=0;
				while($ru=mysqli_fetch_assoc($cu)){
					$n++;
?>
						<tr>
							<td><?php echo codmovimiento($cone,$ru['idmovimiento']); ?></td>
							<td><?php echo $ru['subdiario']; ?></td>
							<td><?php echo $ru['actividad']; ?></td>
							<td><?php echo fnormal($ru['fecregistro']); ?></td>
							<td><?php echo $ru['glosa']; ?></td>				
							<td><?php echo estado($ru['estado']); ?></td>
							<td>
								<div class="btn-group btn-group-xs">
								  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Editar" onclick="mo_f_ingegr(<?php echo $idm.",'edi',".$ru['idmovimiento']; ?>)"><i class="fa fa-pencil"></i></button>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="<?php echo $ru['estado']==1 ? "Desactivar" : "Activar"; ?>" onclick="mo_f_ingegr(<?php echo $idm.",'est',".$ru['idmovimiento']; ?>)"><i class="fa fa-toggle-on"></i></button>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="mo_f_ingegr(<?php echo $idm.",'eli',".$ru['idmovimiento']; ?>)"><i class="fa fa-trash"></i></button>
								  <?php } ?>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Detalle" onclick="mo_l_detingegr(<?php echo $idm.",".$ru['idmovimiento']; ?>)"><i class="fa fa-chevron-circle-right"></i></button>
								</div>
							</td>
						</tr>
<?php
				}
?>
					</tbody>
				</table>
<?php
			}else{
				echo mensajeda("No se encontró datos");
			}
			mysqli_free_result($cu);
?>
<script>
$("#dt_ingegr").DataTable({
  dom: 'Bfrtip',
  buttons: [
    {
        extend: 'excel',
        text: '<i class="fa fa-file-excel-o"></i>',
        titleAttr: 'Excel'
    },
    {
        extend: 'pdf',
        text: '<i class="fa fa-file-pdf-o"></i>',
        titleAttr: 'PDF'
    },
    {
        extend: 'print',
        text: '<i class="fa fa-print"></i>',
        titleAttr: 'Imprimir'
    }
  ]
});
$('[data-toggle="tooltip"]').tooltip();
$("#b_a_ingegr").click(function(){
  $('#m_ingegr').modal('show');
  $(".tm_ingegr").html('<i class="fa fa-plus text-green"></i> Agregar Ingreso Egreso');
  $(".modal-dialog").addClass("modal-lg");
  var mean=$("#mean").val();
  $.ajax({
    method: "POST",
    url: base+"callpage/mo_f_ingegr.php",
    data: {idm: idm, acc: 'add', mean: mean},
    dataType: 'html',
    beforeSend: function(){
      $("#f_ingegr").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
      $("#bg_ingegr").hide();
    },
    success: function(d){
      $("#f_ingegr").html(d);
      $("#bg_ingegr").show();
    }
  });
});
function mo_l_detingegr(idm,idmov){
  $.ajax({
    method: "POST",
    url: base+"callpage/mo_li_detingegr.php",
    data: {idm: idm, idmov: idmov},
    dataType: 'html',
    beforeSend: function(){
      $("#t_ingegr").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success: function(d){
      $("#t_ingegr").slideDown("slow");
      $("#t_ingegr").html(d);
    }
  });
}
</script>
<?php
		}
	}
	mysqli_close($cone);
}
?>