<?php
session_start();
if(isset($_POST['idm']) && !empty($_POST['idm'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$idm=iseguro($cone, $_POST['idm']);
	$no=iseguro($cone, $_SESSION['nousu']);
	$id=iseguro($cone, $_SESSION['idusu']);
	$lo=iseguro($cone, $_SESSION['local']);

		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
?>
				<div class="row">
					<div class="col-md-8">
						<span class="titulo"><i class="fa fa-cubes text-muted"></i> Productos</span>
					</div>
					<div class="col-md-4 text-right">
						<?php if(vaccesom($cone,$id,$idm,1)){ ?>
						<button class="btn bg-orange" onclick="ma_f_mante(<?php echo $idm.", 'addpro', 0"; ?>);"><i class="fa fa-plus"></i> Nuevo</button>
						<?php } ?>
					</div>
				</div>
				<hr>
<?php
			$cu=mysqli_query($cone,"SELECT p.idproducto, p.nombre, p.precioven, p.preciovenesp, p.preciovenadp, p.estado, um.abreviatura, c.categoria FROM producto p INNER JOIN unimedida um ON p.idunimedida=um.idunimedida INNER JOIN categoria c ON p.idcategoria=c.idcategoria ORDER BY p.idproducto DESC;");
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_productos">
					<thead>
						<tr>
							<th>#</th>
							<th>CATEGORÍA</th>
							<th>PRODUCTO</th>
							<th>UNI. MEDIDA</th>
							<th>PRECIO NORMAL</th>
							<th>PRECIO ESPEC.</th>
							<th>PRECIO ALIANZAS</th>
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
							<td><?php echo $ru['categoria']; ?></td>
							<td><a href="javascript:void(0)" onclick="ma_f_mante(<?php echo $idm.",'infopro',".$ru['idproducto']; ?>)"><?php echo $ru['nombre']; ?></a></td>
							<td><?php echo $ru['abreviatura']; ?></td>
							<td><?php echo $ru['precioven']; ?></td>
							<td><?php echo $ru['preciovenesp']; ?></td>
							<td><?php echo $ru['preciovenadp']; ?></td>			
							<td><?php echo estado($ru['estado']); ?></td>
							<?php if(vaccesom($cone,$id,$idm,1)){ ?>
							<td>
								<div class="btn-group btn-group-xs">
								  
								  <button type="button" class="btn btn-default" title="<?php echo $ru['estado']==1 ? "Desactivar" : "Activar" ?>" onclick="ma_f_mante(<?php echo $idm.",'estpro',".$ru['idproducto']; ?>)"><i class="fa fa-toggle-on"></i></button>
								  <button type="button" class="btn btn-default" title="Editar" onclick="ma_f_mante(<?php echo $idm.",'edipro',".$ru['idproducto']; ?>)"><i class="fa fa-pencil"></i></button>
								  
								</div>
							</td>
							<?php } ?>
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
$("#dt_productos").DataTable();
</script>
<?php
		}

	mysqli_close($cone);
}
?>