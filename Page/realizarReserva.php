<?php 
Include("DB.php"); 
$conexion = conectar(); 

/*aca valida si inicio sesion--------------------------------------------*/
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
$idUsuario=$_SESSION['id'];
$idResidencia=$_POST['idResidencia'];
$semana=$_POST['semana'];

//verifico si el usuario tiene la semana disponible
$verificar=mysqli_query($conexion,"SELECT semana FROM reserva WHERE id_usuario=$idUsuario AND semana=$semana"); 
if(mysqli_num_rows($verificar)!=0){
	echo '<script>alert("¡ERROR, usted ya tiene una reserva para esa semana!, intente con otra.");
	window.location="reservar.php?id='.$idResidencia.'";</script>';
}
else{
	//asocio la reserca con el usuario
	$query="INSERT INTO reserva (id,id_residencia,id_usuario,semana) VALUES (null,$idResidencia,$idUsuario,$semana)";
	if(mysqli_query($conexion,$query)){

		//averiguo cuantos creditos tiene y descuento uno
		$sqlCreditos=mysqli_query($conexion,"SELECT credito FROM usuario WHERE id = $idUsuario");
		$creditos=mysqli_num_rows($sqlCreditos);
		$creditos--;

		//se descuentan los creditos del usuario
		$sqlDescontarCreditos="UPDATE usuario SET creditos=$creditos WHERE id = $idUsuario";
		mysqli_query($conexion,$sqlDescontarCreditos);

		//elimino la semana que se reservo de la tabla periodo 
		$sqlDeleteSemana="DELETE FROM periodo WHERE id_residencia=$idResidencia AND semana=$semana";
		mysqli_query($conexion,$sqlDeleteSemana);


		echo  '<script>alert("La reserva se completo exitosamente.");
		window.location="index.php";</script>';
	}
}
 ?>