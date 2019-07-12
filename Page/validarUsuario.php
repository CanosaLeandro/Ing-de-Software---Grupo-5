<?php  
	require_once('DB.php');
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

	$id = $_GET['id'];

	if(mysqli_query($conexion, "UPDATE usuario SET suscripto = 'si', actualizar = 'no' WHERE id = $id")){
		$aniosVigentesQuery="SELECT DISTINCT anio FROM semana";
		$aniosVigentes=mysqli_query($conexion,$aniosVigentesQuery);//para comparar año por año
		$anioActual= date('Y');
		//genero para cada año, sus semanas
		try {
			mysqli_query($conexion,"MYSQLI_TRANS_START_READ_WRITE");
			mysqli_autocommit($conexion,FALSE);
			echo '<script>alert("TRY");</script>';
			while ($registroAnioVigente=mysqli_fetch_assoc($aniosVigentes)) {
				$anio=$registroAnioVigente['anio'];
				echo '<script>alert("'.$anio.'");</script>';
				if($anio >= $anioActual){
					echo '<script>alert("insertar");</script>';
					$sql="INSERT INTO creditos SET id_usuario = $id , anio = $anio , creditos = 2 ";
					$query=$conexion->prepare($sql);
					$query->execute();
				}
			}
			$conexion->commit();
		} catch (Exception $e){
			$conexion->rollback();
			echo '<script>alert("ERROR al generar los creditos del año: '.$anio.'");
				window.location = "habilitarUsuarios.php";</script>';
		}
		echo "<script>alert('El nuevo usuario fue habilitado correctamente.');</script>";
		echo "<script>window.location = 'habilitarUsuarios.php';</script>";		
	}else{
		echo '<script>alert("ERROR al actualizar el usuario");
			window.location = "habilitarUsuarios.php";</script>';
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
?>