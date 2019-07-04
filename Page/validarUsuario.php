<?php  
	require_once('DB.php');
	$conexion = conectar();

	$id = $_GET['id'];

	mysqli_query($conexion, "UPDATE usuario SET suscripto = 'si', actualizar = 'no' WHERE id = $id");
	header("Location:".$_SERVER['HTTP_REFERER']);
?>