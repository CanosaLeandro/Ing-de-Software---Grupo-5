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
	<title>Administración de Subastas</title>
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


//obtengo todas las subastas donde hayan pasado mas de 3 días
$inicia = date("Y-m-d h:i:s");
$hora = substr($inicia,11, 8);
$fechaInicia = substr($inicia,0, 10);
$fechaMinima = date('Y-m-d',strtotime($fechaInicia."-3 day"));
$fechaMinima = "$fechaMinima $hora";
$query = "SELECT * FROM subasta WHERE inicia < '$fechaMinima' ORDER BY inicia LIMIT $empieza, $por_pagina";
$resultado = mysqli_query($conexion, $query);
?>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="crudResidencia.php">
	    <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
	    Home Switch Home
	  </a>
	  <a class="navbar-brand" href="crudUsuarios.php">Usuarios</a>
	  <div style="margin-left: 800px;" class="d-flex align-items-end">
	  	<div class="ml-5 p-2">
	  		<a href="logoutAdmin.php" type="button" class="btn btn-danger">Cerrar sesión</a> 
	  	</div>
	  </div>  
      
	</nav>
	<div class="container">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Administración de <b>Subastas</b></h2>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Residencia</th>
						<th>Foto</th>
                        <th>Finalizó</th>
                        <th>Fecha de la semana</th>
						<th>Acción</th>
                    </tr>
				</thead>
				<tbody>
					<?php
					$j = 0;
					while ($fila = mysqli_fetch_assoc($resultado)) {
                        $id = $fila['id'];
                        $id_residencia = $fila['id_residencia'];
                        $id_semana= $fila['id_semana'];
                        //Día de inicio
                        $iniciaHora= $fila['inicia'];
                        $inicia= substr($iniciaHora,0,10);
                        $date = date_create($inicia);
                        $inicioDate = date_format( $date,'d/m/Y');
                        $finDate =  date('d/m/Y',strtotime($inicioDate."+3 day"));
                        //informacion de la residencia
                        $sqlResidencia = mysqli_query($conexion,"SELECT * FROM residencia WHERE id = $id_residencia");
                        $resultadoResidencia = mysqli_fetch_assoc($sqlResidencia);
                        $nombreResidencia= $resultadoResidencia['nombre'];
                        //informacion de la semana
                        $sqlSemana= mysqli_query($conexion,"SELECT * FROM semana WHERE id = $id_semana"); 
                        $resultadoSemana= mysqli_fetch_assoc($sqlSemana);
                        $num_semana = ($resultadoSemana['num_semana']+1);
                        //si la semana es menor a 10 le agrego un 0 adelante EJ 2 -> 02
                        if ($num_semana<10){
                            $num_semana= str_pad($num_semana, 2, '0', STR_PAD_LEFT);
                        }
                        $anio_semana = $resultadoSemana['anio'];
                        $fechaLunes= date('Y-m-d',strtotime("{$anio_semana}W{$num_semana}"));
                        $fecha = date("d/m/Y",strtotime($fechaLunes."- 1 day"));
                        $j++;
						?>
						<tr>
							<td><?php echo utf8_encode(utf8_decode($nombreResidencia)); ?></td>
							<td><img class="foto" src="foto.php?id=<?php echo $id_residencia; ?>" /></td>
                            <td><?php echo utf8_encode(utf8_decode($finDate)); ?></td>
							<td><?php echo utf8_encode(utf8_decode($fecha)); ?></td>
							<td>
								<a style="color: white;" role="button" href="finalizarSubasta.php?id=<?php echo $id; ?>" class="btn btn-primary btn-block">Finalizar Subasta</a>
							</td>
						</tr>
					<?php
					}
					if ($j==0) {
						echo "<tr><td style='color:red;' colspan='6'>No hay subastas.</td></tr>";
					}
					?>
				</tbody>
			</table>
			<?php
			$qry = "SELECT * FROM subasta ";

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
										<a href='finalizarSubastas.php?pagina=" . $i . "' class='page-link'>" . $i . "</a>
									  </li>";
								}


								//link a la ultima pagina
								echo "<li class='page-item'><a href='finalizarSubastas.php?pagina=$total_paginas' class='page-link'>" . 'Ultimos registros' . "</a></li>";
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