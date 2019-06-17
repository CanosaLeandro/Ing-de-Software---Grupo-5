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
$enviado=NULL;
$nombre= NULL;
$capacidad= NULL;
$ubicacion= NULL;
$direccion= NULL;
$descripcion= NULL;

		
if(isset($_POST['btn'])){
	$enviado=true;
	$nombre= $_POST['nombre'];
	$capacidad= $_POST['capacidad'];
	$ubicacion= $_POST['ubicacion'];
	$direccion= $_POST['direccion'];
	$descripcion= $_POST['descripcion'];	
}
?>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="crudResidencia.php">
	    <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
	    Home Switch Home
	  </a>
	  <a class="navbar-brand" href="crudUsuarios.php">Usuarios</a>
      
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
					<div class="col-sm-6">
						<h2>Administración de <b>Residencias</b></h2>
					</div>
				</div>
			</div>


			<div class="">
				<form action="" enctype="multipart/form-data" method="POST">
					<div class="modal-header">
						<h4 class="modal-title">Agregar Residencia</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="inputNombre"> Nombre</label>
							<input type="text" name="nombre" class="form-control" placeholder="" required pattern="[A-Za-z ]+" value="<?php echo $nombre;?>" oninvalid="setCustomValidity('El campo Nombre es obligatorio y debe escribirse solo con letras.')"
                     oninput="setCustomValidity('')">
						</div>
						<div class="form-group">
							<label for="inputCapacidad">Capacidad</label>
							<input type="number" name="capacidad" class="form-control" placeholder="" required value="<?php echo $capacidad;?>" oninvalid="setCustomValidity('Completé este campo, por favor.')"
                     oninput="setCustomValidity('')">
						</div>
						<div class="form-group">
							<label for="inputUbicacion"> Ubicación</label>
							<input type="text" name="ubicacion" class="form-control" placeholder="" required value="<?php echo $ubicacion;?>">
						</div>
						<div class="form-group">
							<label for="inputDireccion"> Dirección</label>
							<input type="text" name="direccion" class="form-control" placeholder="" required value="<?php echo $direccion;?>">
						</div>
						<div class="form-group">
							<label for="inputDescripcion"> Descripción</label>
							<textarea class="form-control" name="descripcion" placeholder="" value="<?php echo $descripcion;?>"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" value="Cancelar">
						<input type="submit" name= "btn" class="btn btn-success" value="Siguiente">
					</div>
				</form>
			</div>
		</div>
	</div>


	<?php 
	if ($enviado) {
	 	if (($nombre != null) AND ($capacidad != null) AND ($ubicacion != null) AND ($direccion != null)) {

				//valido que no haya un nombre repetido en la BD 
				$query = "SELECT * FROM residencia WHERE nombre = '$nombre'";
				$resultado = mysqli_query($conexion, $query);
				$rows = mysqli_num_rows($resultado);
				if ($rows == 0) {

					if( mysqli_query($conexion,"INSERT INTO residencia 
												SET nombre = '$nombre', activo = 'si', capacidad = $capacidad, ubicacion = '$ubicacion', direccion = '$direccion', en_subasta = 'no', en_hotsale = 'no', descrip = '$descripcion'")){
							$id = mysqli_insert_id($conexion);
							for ($i = 1; $i <= 52; $i++) { #genero las 52 semanas anuales
								
								mysqli_query($conexion, "INSERT INTO periodo SET id_residencia = $id , semana = $i");
								
							}
							echo '<script>window.location = "seleccionarFoto.php?id='.$id.'";</script>';
					}else{ echo '<script> alert("No se pudo agregar el registo al sistema.");
									window.location = "addModalResidencia.php";</script>';
						} 
					
				}else { echo '<script>alert("ERROR!. La residencia ya existe y no puede volver a insertarte en el sistema.");</script>';
					}
		}
		else {echo '<script>alert("Complete todos los campos solicitados e intentelo nuevamente.");</script>';
			}	
	} ?>
</body>
</html>