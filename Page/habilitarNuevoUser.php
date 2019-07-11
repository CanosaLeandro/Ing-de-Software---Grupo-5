<?php
include("DB.php");
include("links.php");
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
/*---------------------------------------------------------------------------*/
$idUser=$_GET['id'];
//habilito al nuevo usuario
$query="UPDATE usuario SET valido='si' WHERE id=$idUser";
if(mysqli_query($conexion,$query)){
	echo "<script>alert('El nuevo usuario fue habilitado correctamente.');</script>";
	echo "<script>window.location = 'habilitarUsuarios.php';</script>";
}
?>