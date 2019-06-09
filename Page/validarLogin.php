<?php
    Include("DB.php");
	$conexion = conectar();	
	$user=$_GET['user'];
	$pass=$_GET['pass'];
	require_once('Authentication.php');
	$authentication = new Authentication();
	$authentication -> login();
	$authentication -> siLogueado();
	try{				
		$authentication->autenticar($user, $pass, $conexion);
	}catch(Exception $ex){
		$error = $ex->getMessage();
		echo "<script>alert('$error');</script>";
		echo "<script>window.location = 'login.php?';</script>";
		/*echo "<script>window.location = 'error.php?error=$error';</script>";*/
	}	
?>