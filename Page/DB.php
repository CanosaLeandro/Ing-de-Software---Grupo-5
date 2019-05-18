<?php
	function conectar(){
	//localhost, usuario, contraseña, bd
		$conexion = mysqli_connect("localhost","root","","ingsoft") or die("Error".mysqli_error($conexion));
		return $conexion;
	}
?>