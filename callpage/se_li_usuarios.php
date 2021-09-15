<?php
session_start();
if(isset($_POST['idm']) && !empty($_POST['idm'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$idm=iseguro($cone, $_POST['idm']);
	$no=iseguro($cone, $_SESSION['nousu']);
	$id=iseguro($cone, $_SESSION['idusu']);
	if(vlogin($cone, $no, $id)){
		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
			$cu=mysqli_query($cone,"SELECT u.idusuario, u.nombre, u.estado, CONCAT(p.apepaterno, ' ', p.apematerno, ', ', p.nombres) as nom  FROM usuario u INNER JOIN miembro m ON u.idmiembro=m.idmiembro INNER JOIN persona p ON m.idpersona=p.idpersona ORDER BY u.idusuario DESC;");
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_usuarios">
					<thead>
						<tr>
							<th>#</th>
							<th>NOMBRE</th>
							<th>USUARIO</th>
							<th>ESTADO</th>
							<?php if(vaccesom($cone,$id,$idm,1)){ ?>
							<th>ACCIÓN</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
<?php
				$n=0;
				while($ru=mysqli_fetch_assoc($cu)){
					$n++;
?>
						<tr>
							<td><?php echo $n; ?></td>
							<td><?php echo $ru['nom']; ?></td>
							<td><?php echo $ru['nombre']; ?></td>
							<td><?php echo $ru['estado']==1 ? "<div class='label label-success'>Activo</div>" : "<div class='label label-danger'>Inactivo</div>"; ?></td>
							<?php if(vaccesom($cone,$id,$idm,1)){ ?>
							<td>
								<div class="btn-group btn-group-xs">
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Editar" onclick="se_feditar(<?php echo $idm.",'edit',".$ru['idusuario']; ?>)"><i class="fa fa-pencil"></i></button>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Permisos" onclick="se_feditar(<?php echo $idm.",'perm',".$ru['idusuario']; ?>)"><i class="fa fa-key"></i></button>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cambiar Contraseña" onclick="se_feditar(<?php echo $idm.",'cont',".$ru['idusuario']; ?>)"><i class="fa fa-lock"></i></button>
								</div>
							</td>
							<?php } ?>
						</tr>
<?php
				}
?>
					</tbody>
				</table>
			      <script>
	                $("#dt_usuarios").DataTable({
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
	              </script>
<?php
			}else{
				echo mensajeda("No se encontró datos");
			}
			mysqli_free_result($cu);
		}
	}
	mysqli_close($cone);
}
?>