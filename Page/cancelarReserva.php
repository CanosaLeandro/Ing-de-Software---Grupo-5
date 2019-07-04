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
$semana=$_POST['id_semana'];//esto es el id de la semana
$querySemana="SELECT * FROM semana WHERE id =$semana";
$resultSemana=mysqli_query($conexion,$querySemana);
$semanaDB= mysqli_fetch_assoc($resultSemana)['num_semana'];

$conAntelacion=true;

//verifico si faltan mas de 8 semanas para la semana de reserva
date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();
@$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 

$dia   = substr($fecha_actual,8,2);
$mes = substr($fecha_actual,5,2);
$anio = substr($fecha_actual,0,4);
//$semana es la semana actual
$semanaActual = date('W',  mktime(0,0,0,$mes,$dia,$anio));
$verificar=($semanaDB - $semanaActual);
if($verificar<=8){//si quedan menos de 8 semanas para la semana reservada
	echo '<script>alert("La reserva fue cancelada exitosamente pero no se le reintegrará el credito consumido en la reserva por hacer la cancelación sin una antelación de al menos 8 semanas para la semana reservada.");</script>';
	$conAntelacion=false;
}

//elimino la reserca del usuario
$query="DELETE FROM reserva WHERE id_residencia=$idResidencia AND id_usuario=$idUsuario AND id_semana=$semana";
if(mysqli_query($conexion,$query)){

	if ($conAntelacion) {//si cancelo con antelacion
		
		############################################
		//averiguo cuantos creditos tiene y sumo uno
		############################################
		
	}
	//activo la semana en la tabla semana
	$sqlAltaSemana="UPDATE semana SET disponible='si' WHERE id=$semana";
	mysqli_query($conexion,$sqlAltaSemana);

	if ($conAntelacion) {//si cancelo con antelacion
		echo  '<script>alert("La cancelación de la reserva se completo con exito.");
		window.location="listaReservas.php";</script>';
	}else {
		echo  '<script>window.location="listaReservas.php";</script>';
	}
}

 ?>