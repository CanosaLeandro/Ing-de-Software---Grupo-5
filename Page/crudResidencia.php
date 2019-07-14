<!DOCTYPE html>
<html lang="es">
<?php
include("DB.php");
include("links.php");
$conexion = conectar();

/*aca valida si inicio sesion--------------------------------------------*/
require_once('Authentication.php');
$authentication = new Authentication();	
$authentication->login();						
try{				
	$authentication->logueadoAdmin();
}catch(Exception $ex){
	$error = $ex->getMessage();
	echo "<script>alert('$error');</script>";
	echo "<script>window.location = 'loginAdmin.php';</script>";
}
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración de residencias</title>
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

$query = "SELECT * FROM residencia ORDER BY activo LIMIT $empieza, $por_pagina";
$resultado = mysqli_query($conexion, $query);




?>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="crudResidencia.php">
	    <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
	    Home Switch Home
	  </a>
	  <a class="navbar-brand" href="crudUsuarios.php">Usuarios</a>
	  <div style="margin-left: 50%;" class="d-flex align-items-end">
	  	<div class="ml-5 p-2">
	  		<a href="logoutAdmin.php" type="button" class="btn btn-danger btn-sm">Cerrar sesión</a> 
	  	</div>
	  </div>     
	</nav>

	<div class="container">
		<div class="table-wrapper">
			
			<div class="table-title">
				<nav class="navbar navbar-light bg-light">
					<a class="navbar-brand" href="home.php">
						<img style="margin-top: -10px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
				   	 Home Switch Home
					</a>
				</nav>
				<div class="row">
					<div class="col-sm-4">
						<h2>Administración de <b>Residencias</b></h2>
					</div>
					<div class="col-sm-8">
						<a href="crearHotsale.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Crear Hotsale</span></a>
						<a href="habilitarSemanas.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Habilitar semanas</span></a>
						<a href="addModalResidencia.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Agregar Nueva Residencia</span></a>
					</div>
					<div class="col-sm-12">
						<a href="cancelarSubastas.php" class="btn btn-danger"><i class="material-icons">remove_circle</i> <span>Cancelar Subasta</span></a>
					</div>
<<<<<<< HEAD
=======

>>>>>>> 8c1af30513afc7eece69fa3c9d1bdba2f5dc8327
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Activo</th>
						<th>Portada</th>
						<th>Capacidad</th>
						<th>Ubicación</th>
						<th>Dirección</th>
						<th>Descripción</th>
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
							<td><?php echo utf8_encode(utf8_decode($fila['nombre'])); ?></td>
							<td><?php echo utf8_encode(utf8_decode($fila['activo'])); ?></td>
							<td><img class="foto" src="foto.php?id=<?php echo $id; ?>" /></td>
							<td><?php echo $fila['capacidad']; ?></td>
							<td><?php echo utf8_encode(utf8_decode($fila['ubicacion'])); ?></td>
							<td><?php echo utf8_encode(utf8_decode($fila['direccion'])); ?></td>
							<td><?php echo utf8_encode(utf8_decode($fila['descrip'])); ?></td>
							<td>
							<?php 
							if ($fila['activo']== 'si' ){?>
								<a href="editModalResidencia.php?id=<?php echo $id; ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
								<a href="deleteResidencia.php?id=<?php echo $id; ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
								<br>
								<a href="subastarPropiedad.php?id=<?php echo $id;?>">
									<button type="button" onclick="location.href=subastarPropiedad.php?id=<?php echo $id;?>"; class="btn btn-primary btn-sm" >Subastar</button>
								</a>
								<!--
								<?php 
								
								
									if($fila['en_hotsale']== 'no'){ 
									?>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#<?php echo $calendario?>" aria-expanded="false" aria-controls="<?php echo $calendario?>">Hotsale</button>
										<div class="collapse multi-collapse" id="<?php echo $calendario?>">
											<div class="card card-body">
												<input type="date" id="fecha_hotsale<?php echo $id; ?>" >
											</div>
										</div>-->
									<?php }
							} else{ ?>
								<a href="altaResidencia.php?id=<?php echo $id;?>">
									<button type="button" onclick="location.href=altaResidencia.php?id=<?php echo $id;?>"; class="btn btn-primary btn-sm" >Dar de Alta</button>
								</a><?php 
							} ?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<?php
			$qry = "SELECT * FROM residencia ORDER BY nombre ASC";

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
						$dif =  (($total_registros)-((($pagina-1)*$por_pagina)+1) );
						?>
						<div class="hint-text">
							<?php if ($dif > 1) {
								?>Mostrando del registro<b> <?php echo (($pagina-1)*$por_pagina)+1 ?></b> al <b><?php if (($por_pagina*$pagina)>$total_registros){echo $total_registros; } else {echo $por_pagina*$pagina; }?></b>, de <b><?php echo $total_registros; ?></b> registros
							<?php } else { ?> Mostrando <b> ultimo</b> registro <?php }?> </div>
						<nav aria-label="Page navigation example">
							<ul class="pagination">

								<?php
								//link a la primera pagina

								for ($i = 1; $i < $total_paginas; $i++) {
									echo "<li class='page-item'>
										<a href='crudResidencia.php?pagina=" . $i . "' class='page-link'>" . $i . "</a>
									  </li>";
								}


								//link a la ultima pagina
								echo "<li class='page-item'><a href='crudResidencia.php?pagina=$total_paginas' class='page-link'>" . 'Ultimos registros' . "</a></li>";
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