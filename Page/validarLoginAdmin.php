<?php
    Include("DB.php");
	$conexion = conectar();	
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	require_once('Authentication.php');
	$authentication = new Authentication();
	$authentication -> login();
	$authentication -> siLogueadoAdmin();
	try{				
		$authentication->autenticarAdmin($user, $pass, $conexion);
	}catch(Exception $ex){
		$error = $ex->getMessage();
		echo "<script>alert('$error');</script>";
		echo "<script>window.location = 'loginAdmin.php?';</script>";
		/*echo "<script>window.location = 'error.php?error=$error';</script>";*/
	}	
?>