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
if (isset($_POST['eliminar'])) {
	$id = $_POST['id'];
	if(mysqli_query($conexion,"DELETE FROM residencia WHERE id = $id")){
		echo '<script>alert("La propiedad fue eliminada del sistema.");
	    			window.location = "crudResidencia.php";</script>';
	}
	else{ echo '<script>alert("La propiedad no pudo eliminarse, intentelo en otro momento.");
	    window.location = "crudResidencia.php";</script>';
	}
}
?>
	<!-- <div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content"> -->
	<div class="container">
		<div id="deleteEmployeeModal" class="modal-dialog">
			<div class="modal-content">
				<form action="deleteResidencia.php" method="post">
					<div class="modal-header">						
						<h4 class="modal-title">Eliminar Residencia</h4>
					</div>
					<div class="modal-body">					
						<p>¿Estás seguro de que deseas eliminar este registro?</p>
						<p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id" value="<?php echo $id ;?>">
						<a href="crudResidencia.php"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"></a>
						<input type="submit" name="eliminar" class="btn btn-danger" value="Eliminar">
					</div>
				</form>
	</div></div>	</div>		
			<!-- </div>
			</div>
				</div> -->
</body>
</html>