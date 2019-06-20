<!DOCTYPE html>
<html lang="es">
<?php
include("DB.php");
include("links.php");
$conexion = conectar();
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración de Usuarios</title>
	<link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style_crudResidencia.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php


//cantidad de registros por pagina
$por_pagina = 5;

//si se presiono algun indice de la paginacion
if (isset($_GET['pagina'])) {
	$pagina = $_GET['pagina'];
} else {
	$pagina = 1;
}

//la pagina inicia en 0 y se multiplica por $por_pagina

$empieza = ($pagina - 1) * $por_pagina;

$query = "SELECT * FROM usuario ORDER BY email LIMIT $empieza, $por_pagina";
$resultado = mysqli_query($conexion, $query);
?>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="crudUsuarios.php">
	    <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
	    Home Switch Home
	  </a>
	  <a class="navbar-brand" href="crudResidencia.php">Residencias</a>
      
	</nav>
	<div class="container">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Administración de <b>Usuarios</b></h2>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Apellido</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Suscripto</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$j = 0;
					while ($fila = mysqli_fetch_assoc($resultado)) {
						$id = $fila['id']; 
						$j++;
						?>
						<tr>
							<td><?php echo utf8_encode(utf8_decode($fila['apellido'])); ?></td>
							<td><?php echo utf8_encode(utf8_decode($fila['nombre'])); ?></td>
							<td><?php echo utf8_encode(utf8_decode($fila['email'])); ?></td>
							<td><?php echo $fila['suscripto'];?></td>
							<td>
								<a href="deleteUser.php?id=<?php echo $id; ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
								<?php 
								if (($fila['suscripto'] == 'no') and ($fila['actualizar'] == 'si')){?>
									<a href="validarUsuario.php?id=<?php echo $id;?>">
										<button type="button" class="btn btn-primary btn-sm" >Dar de alta la suscripción</button>
									</a>
								<?php } ?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<?php
			$qry = "SELECT * FROM usuario";

			$result = mysqli_query($conexion, $qry);
			//contar el total de registros
			$total_registros = mysqli_num_rows($result);
			?>
			<div class="clearfix">
				<?php
				if (isset($total_registros)) {

					if ($total_registros > 5) {

						//usando ceil para dividir el total de registros entre $por_pagina
						//ceil redondea un numero para abajo
						$total_paginas = ceil($total_registros / $por_pagina);

						?>
						<div class="hint-text">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros; ?></b> registros</div>
						<nav aria-label="Page navigation example">
							<ul class="pagination">

								<?php
								//link a la primera pagina

								for ($i = 1; $i < $total_paginas; $i++) {
									echo "<li class='page-item'>
										<a href='crudUsuarios.php?pagina=" . $i . "' class='page-link'>" . $i . "</a>
									  </li>";
								}


								//link a la ultima pagina
								echo "<li class='page-item'><a href='crudUsuarios.php?pagina=$total_paginas' class='page-link'>" . 'Ultimos registros' . "</a></li>";
							}
						}
						?>

					</ul>
				</nav>
			</div>
		</div>
	</div>


</body>

</html>