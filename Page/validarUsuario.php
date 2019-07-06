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

	mysqli_query($conexion, "UPDATE usuario SET suscripto = 'si', actualizar = 'no' WHERE id = $id");
	header("Location:".$_SERVER['HTTP_REFERER']);
?>