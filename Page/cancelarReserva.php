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

//verifico si faltan mas de 8 semanas para la semana de reserva
date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();
@$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 

$dia   = substr($fecha_actual,8,2);
$mes = substr($fecha_actual,5,2);
$anio = substr($fecha_actual,0,4);
//$semana es la semana actual
$semanaActual = date('W',  mktime(0,0,0,$mes,$dia,$anio));
$verificar=($semana - $semanaActual);
if($verificar<=8){//si quedan menos de 8 semanas para la semana reservada
	echo '<script>alert("¡ERROR, no fue posible cancelar la reserva. Para hacer una cancelación es necesario realizarla con una antelación de al menos 8 semanas para la semana reservada.");
	window.location="residenciaReservada.php?id='.$idResidencia.'";</script>';
}
else{
	//elimino la reserca del usuario
	$query="DELETE FROM reserva WHERE id_residencia=$idResidencia AND id_usuario=$idUsuario AND semana=$semana";
	if(mysqli_query($conexion,$query)){

		//averiguo cuantos creditos tiene y sumo uno
		$sqlCreditos=mysqli_query($conexion,"SELECT creditos FROM usuario WHERE id = $idUsuario");
		$result=mysqli_fetch_assoc($sqlCreditos);
		$creditos=$result['creditos'];
		if ($creditos<2) {
			$creditos++;
		}
		
		//se aumenta los creditos del usuario
		$sqlAumentarCreditos="UPDATE usuario SET creditos=$creditos WHERE id = $idUsuario";
		mysqli_query($conexion,$sqlAumentarCreditos);

		//inserto la semana en la tabla periodo
		$sqlAltaSemana="UPDATE periodo SET activa='si' WHERE id_residencia='$idResidencia' AND semana='$semana'";
		mysqli_query($conexion,$sqlAltaSemana);

		echo  '<script>alert("La cancelación de la reserva se completo con exito.");
		window.location="index.php";</script>';
	}
}
 ?>