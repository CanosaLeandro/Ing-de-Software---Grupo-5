<?php
    Include("DB.php");
	$conexion = conectar();	
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$cookie = false;
	if(isset($_POST['recordar']) && !empty($_POST['recordar'])){
		$cookie = true;
	}
	require_once('Authentication.php');
	$authentication = new Authentication();
	$authentication -> login();
	$authentication -> siLogueado();
	try{				
		$authentication->autenticar($user, $pass, $conexion, $cookie);
	}catch(Exception $ex){
		$error = $ex->getMessage();
		echo "<script>alert('$error');</script>";
		echo "<script>window.location = 'login.php?';</script>";
		/*echo "<script>window.location = 'error.php?error=$error';</script>";*/
	}	
?>