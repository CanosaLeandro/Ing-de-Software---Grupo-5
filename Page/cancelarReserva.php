<?php 
Include("DB.php"); 
$conexion = conectar();
Include("calcularCreditos.php"); 

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
$semana=$_POST['semana'];//esto es el id de la semana
$querySemana="SELECT * FROM semana WHERE id =$semana";
$sqlSemana=mysqli_query($conexion,$querySemana);
$resultSemana=mysqli_fetch_assoc($sqlSemana);
$semanaDB= $resultSemana['num_semana'];
$anioDB=$resultSemana['anio'];

//verifico si faltan mas de 8 semanas para la semana de reserva
date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();
@$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 

$dia   = substr($fecha_actual,8,2);
$mes = substr($fecha_actual,5,2);
$anio = substr($fecha_actual,0,4);
if($anio != $anioDB){
	if(($anioDB - $anio)==1){
		$semanaDB = $semanaDB + 52 ;
	}
}
//$semana es la semana actual
$semanaActual = date('W',  mktime(0,0,0,$mes,$dia,$anio));
$verificar=($semanaDB - $semanaActual);

$query="DELETE FROM reserva WHERE id_residencia=$idResidencia AND id_usuario=$idUsuario AND id_semana=$semana";
if(mysqli_query($conexion,$query)){

	//al eliminar se devolverán automaticamente el credito (cuando se necesitan, se calculan)
	
	//activo la semana en la tabla semana
	$sqlAltaSemana="UPDATE semana SET disponible='si' WHERE id=$semana";
	
	if (mysqli_query($conexion,$sqlAltaSemana)) {//si es exitosa

		if($verificar>8){//si quedan menos de 8 semanas para la semana reservada
			$creditos = calcularCreditos($idUsuario,$anioDB);
			$creditos++;
			$actualizarCreditos = "UPDATE creditos SET creditos = $creditos WHERE id_usuario = $idUsuario AND anio = $anioDB";
			if(mysqli_query($conexion,$actualizarCreditos)){
				echo  '<script>alert("La reserva fue cancelada exitosamente.");
				window.location="listaReservas.php";</script>';
			}else{
				echo  '<script>alert("Error al actualizar los créditos.");
				window.location="listaReservas.php";</script>';
			}
		}else{
			echo  '<script>alert("La reserva fue cancelada exitosamente pero no se le reintegrará el crédito consumido en la reserva por hacer la cancelación sin una antelación de al menos 8 semanas para la semana reservada.");
			window.location="listaReservas.php";</script>';
		}
	}else{
		echo  '<script>alert("Error al actualizar la semana.");
			window.location="listaReservas.php";</script>';
	}
}else{
	echo  '<script>alert("Error al Eliminar la reserva, intentelo mas tarde.");
			window.location="listaReservas.php";</script>';
}

 ?>