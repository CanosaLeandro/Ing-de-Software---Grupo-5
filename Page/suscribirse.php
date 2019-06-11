<?php  
	session_start();
	require_once('DB.php');
	$conexion = conectar();
	require_once('Authentication.php');
	$authentication = new Authentication();	
	$authentication->login();						
	try{				
		$authentication->logueado();
	}catch(Exception $ex){
		$error = $ex->getMessage();
		echo "<script>alert('$error');</script>";
		echo "<script>window.location = 'home.php';</script>";
	}	

	$id = $_SESSION['id'];

	mysqli_query($conexion, "UPDATE usuario SET actualizar = 'si' WHERE id = $id");
	header("Location:".$_SERVER['HTTP_REFERER']);
?>