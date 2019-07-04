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
		<title>Eliminar Residencia</title>
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
		
		$tieneOperacionesFuturas= false;
		$queryReservas = "SELECT * FROM reserva WHERE id_residencia = $id "; 
		$resultReserva = mysqli_query($conexion,$queryReservas);
		$rowReserva = mysqli_num_rows($resultReserva);
		####################################################################
		//consular si son operaciones futuras (pueden ser viejas)//
		####################################################################

		if($rowReserva > 0){
			$tieneOperacionesFuturas = true;
		}
		
		$querySubastas = "SELECT * FROM subasta WHERE id_residencia = $id";
		$resultSubastas = mysqli_query($conexion,$querySubastas);
		$rowSubastas = mysqli_num_rows($resultSubastas);

		####################################################################
		//consular si son operaciones futuras (pueden ser viejas)//
		####################################################################

		if($rowSubastas > 0){
			$tieneOperacionesFuturas = true;			
		}
		
		$queryHotsale = "SELECT * FROM hotsale WHERE id_residencia = $id";
		$resultHotsale = mysqli_query($conexion,$queryHotsale);
		$rowHotsale = mysqli_num_rows($resultHotsale);
		
		####################################################################
		//consular si son operaciones futuras (pueden ser viejas)//
		####################################################################

		if($rowHotsale > 0){
			$tieneOperacionesFuturas = true;
		}

		if($tieneOperacionesFuturas) {
			//si tiene operaciones futuras se da hace una baja logica
			if(mysqli_query($conexion,"UPDATE residencia SET activo = 'no' WHERE id = $id")){
				echo '<script>alert("La propiedad fue dada de baja correctamente.");
							window.location = "crudResidencia.php";</script>';
			}
			else{ echo '<script>alert("La propiedad no pudo darse de baja, intentelo en otro momento.");
				window.location = "crudResidencia.php";</script>';
			}
		}else{
			//si no tiene operaciones futuras se elimina fisicamente
			if(mysqli_query($conexion,"DELETE FROM residencia WHERE id = $id")){
				echo '<script>alert("La residencia fue eliminada correctamente.");
				window.location = "crudResidencia.php";</script>';
			}else{ echo '<script>alert("La residencia no pudo eliminarse, intentelo en otro momento.");
				window.location = "crudResidencia.php";</script>';
			}
		}
	}
	?>

		<div class="container">
			<div id="deleteEmployeeModal" class="modal-dialog">
				<div class="modal-content">
					<form action="deleteResidencia.php" method="post">
						<div class="modal-header">						
							<h4 class="modal-title">Dar de baja a la Residencia</h4>
						</div>
						<div class="modal-body">					
							<p>¿Estás seguro de que deseas dar de baja esta propiedad?</p>
							
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