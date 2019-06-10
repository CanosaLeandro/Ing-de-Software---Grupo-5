<!DOCTYPE html>
<html lang="es">
	<?php
		Include("DB.php");
		$conexion = conectar();				
	?>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Administración de residencias</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style_crudResidencia.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<?php  
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	if (isset($_POST['activo'])) {
		$id = $_POST['id'];
		if(mysqli_query($conexion,"UPDATE residencia SET activo = 'si' WHERE id = $id")){
			echo '<script>alert("La propiedad fue dada de alta correctamente.");
					window.location = "crudResidencia.php";</script>';
		}
		else{ echo '<script>alert("La propiedad no pudo darse de alta, intentelo en otro momento.");
			window.location = "crudResidencia.php";</script>';
		}
	}
	?>
		<!-- <div id="deleteEmployeeModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content"> -->
		<div class="container">
			<div id="altaEmployeeModal" class="modal-dialog">
				<div class="modal-content">
					<form action="altaResidencia.php" method="post">
						<div class="modal-header">						
							<h4 class="modal-title">Dar de alta a la Residencia</h4>
						</div>
						<div class="modal-body">					
							<p>¿Estás seguro de que deseas dar de alta esta propiedad?</p>
							
						</div>
						<div class="modal-footer">
							<input type="hidden" name="id" value="<?php echo $id ;?>">
							<input type="submit" name="activo" class="btn btn-danger" value="Si">
							<a href="crudResidencia.php"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"></a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>