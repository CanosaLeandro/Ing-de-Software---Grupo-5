<!DOCTYPE html>
<html lang="es">
	<?php
		Include("DB.php");
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
		<title>Eliminar Usuario</title>
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
	if (isset($_POST['aceptar'])) {
		$id = $_POST['id'];
		
		$query = "SELECT * FROM puja WHERE id_usuario = $id";
		$resultado = mysqli_query($conexion,$query);
		$pujas = mysqli_num_rows($resultado);
		
		if($pujas != 0){
			if(!mysqli_query($conexion,"DELETE FROM puja WHERE id_usuario= $id")){
				echo '<script>alert("las pujas no pudieron eliminarse, intentelo en otro momento.");
				window.location = "index.php";</script>';
			}
		}
		
		$query = "SELECT * FROM reserva WHERE id_usuario = $id";
		$result = mysqli_query($conexion,$query);
		while($reserva = mysqli_fetch_assoc($result)){
			$idSemana = $reserva['id_semana'];
			if(!mysqli_query($conexion,"UPDATE semana SET disponible = 'si' WHERE id= $idSemana")){
				echo '<script>alert("La semanas no pudieron actualizarse, intentelo en otro momento.");
				window.location = "index.php";</script>';
			}
			if(!mysqli_query($conexion,"DELETE FROM reserva WHERE id_usuario= $id")){
				echo '<script>alert("Las reservas no pudieron eliminarse, intentelo en otro momento.");
				window.location = "index.php";</script>';
			}
		}
		$queryHotsale = "SELECT * FROM hotsalecomprados WHERE id_usuario = $id";
		$resultadoHotsale = mysqli_query($conexion,$queryHotsale);
		while($hotsale = mysqli_fetch_assoc($resultadoHotsale)){
			$idSemana = $hotsale['id_semana'];
			if(!mysqli_query($conexion,"UPDATE semana SET disponible = 'si' WHERE id= $idSemana")){
				echo '<script>alert("La semanas no pudieron actualizarse, intentelo en otro momento.");
				window.location = "index.php";</script>';
			}
			if(!mysqli_query($conexion,"UPDATE semana SET disponible = 'si' WHERE id= $idSemana")){
				echo '<script>alert("La semanas no pudieron actualizarse, intentelo en otro momento.");
				window.location = "index.php";</script>';
			}
		
		if($hotsales != 0){
			if(!mysqli_query($conexion,"DELETE FROM hotsalecomprados WHERE id_usuario= $id")){
				echo '<script>alert("Las reservas no pudieron eliminarse, intentelo en otro momento.");
				window.location = "index.php";</script>';
			}
		}
		//log out
		require_once('Authentication.php');
		$authentication = new Authentication();	
		$authentication->login();	
		$authentication->logout();
		if(mysqli_query($conexion,"DELETE FROM usuario WHERE id = $id")){
			echo '<script>alert("El usuario fue eliminado correctamente.");
			window.location = "home.php";</script>';
		}else{ echo '<script>alert("El usuario no pudo eliminarse, intentelo en otro momento.");
			window.location = "index.php";</script>';
		}	
		
	}
	?>
		<!-- <div id="deleteEmployeeModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content"> -->
		<div class="container">
			<div id="deleteEmployeeModal" class="modal-dialog">
				<div class="modal-content">
					<form action="deleteUser.php" method="post">
						<div class="modal-header">						
							<h4 class="modal-title">Eliminar Usuario</h4>
						</div>
						<div class="modal-body">					
							<p>¿Estás seguro de que deseas eliminar tu usuario?</p>
                            <p>Una vez realizada la eliminación no se podrá volver atrás</p>
							
						</div>
						<div class="modal-footer">
							<input type="hidden" name="id" value="<?php echo $id ;?>">
							<input type="submit" name="aceptar" class="btn btn-danger" value="Si">
							<a href="index.php"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"></a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>