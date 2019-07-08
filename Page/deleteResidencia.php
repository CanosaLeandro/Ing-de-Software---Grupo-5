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

		$tieneOperacionesFuturas = 0;
		$querySemana = "SELECT * FROM semana WHERE id_residencia = $id AND disponible = 'no' ORDER BY anio , num_semana DESC LIMIT 1"; 
		//busco la ultima semana (en tiempo) reservada 
		$sqlSemana = mysqli_query($conexion,$querySemana);
		$registroSemana = mysqli_fetch_assoc($sqlSemana);
		$hoy = date('Y-m-d');
		$anioDB = $registroSemana['anio'];
		$week = $registroSemana['num_semana'];
		//strtotime("{$anioDB}W{$week} solo funciona con $week de dos digitos
        //los int empiezan en 1,2 por lo que hay que agregarle un 0 al inico                         
        if ($week<10){
            $week= str_pad($week, 2, '0', STR_PAD_LEFT);
        }
		$fechaSemana= date("Y-m-d", strtotime("{$anioDB}W{$week}"));
		if($fechaSemana>=$hoy){
			//compruebo si la fecha de la semana es mayor a la actual
			$tieneOperacionesFuturas = 1;
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
			//si no tiene operaciones futuras se eliminan sus semanas
			if(mysqli_query($conexion,"DELETE FROM semana WHERE id_residencia =$id")){
				//y se elimina fisicamente
				if(mysqli_query($conexion,"DELETE FROM residencia WHERE id = $id")){
					echo '<script>alert("La residencia fue eliminada correctamente.");
					window.location = "crudResidencia.php";</script>';
				}else{ echo '<script>alert("La residencia no pudo eliminarse, intentelo en otro momento.");
					window.location = "crudResidencia.php";</script>';
				}
			}else{
				echo '<script>alert("Las semanas no pudieron eliminarse.");
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