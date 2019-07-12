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
	//selecciona los anio que hay en la tabla semana
	$aniosVigentesQuery="SELECT DISTINCT anio FROM semana";
	$aniosVigentes=mysqli_query($conexion,$aniosVigentesQuery);//para comparar año por año

	//genero para cada año, los creditos para el nuevo usuario
	while ($registroAnioVigente=mysqli_fetch_assoc($aniosVigentes)) {
		$anio=$registroAnioVigente['anio'];
		mysqli_query($conexion,"INSERT INTO creditos (id,id_usuario,anio,creditos) VALUES (NULL,$idUser,$anio,2)");
	}
	
	echo "<script>alert('El nuevo usuario fue habilitado correctamente.');</script>";
	echo "<script>window.location = 'habilitarUsuarios.php';</script>";
}
?>