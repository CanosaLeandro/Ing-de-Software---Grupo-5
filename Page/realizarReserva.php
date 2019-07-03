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
$semana=$_POST['semana'];//id del periodo

$verificar=true;

//verifico que el usuario tenga la semana de la subasta libre
$queryPeriodo="SELECT * FROM periodo WHERE id = $semana";
$resutPeriodo=mysqli_query($conexion,$queryPeriodo);
$arrayPeriodo=mysqli_fetch_assoc($resutPeriodo);
//obtengo la semana y el año de la semana subastada para comparar luego 
$semanaPeriodo=$arrayPeriodo['semana'];
$anioPeriodo=$arrayPeriodo['anio'];
//obtengo todas las reservas del usuario
$queryReservas="SELECT * FROM reserva WHERE id_usuario=$idUsuario";
$resutReservas=mysqli_query($conexion,$queryReservas);
while ($row=mysqli_fetch_assoc($resutReservas)) {
    $idPeriodoReserva=$row['semana'];
    $queryPeriodoReserva="SELECT * FROM periodo WHERE id = $idPeriodoReserva";
    $resutPeriodoReserva=mysqli_query($conexion,$queryPeriodoReserva);
    $arrayPeriodoReserva=mysqli_fetch_assoc($resutPeriodoReserva);
    $semanaPeriodoReserva=$arrayPeriodoReserva['semana'];
    $anioPeriodoReserva=$arrayPeriodoReserva['anio'];
    //verifico si es la misma semana y el misma año
    if (($semanaPeriodo==$semanaPeriodoReserva)&&($anioPeriodo==$anioPeriodoReserva)) {
       echo '<script>alert("¡ERROR, usted ya tiene una reserva para esa semana!, intente con otra.");
			window.location="reservar.php?id='.$idResidencia.'";</script>';
        $verificar=false;
    }

}

if($verificar){
	//asocio la reserca con el usuario
	$query="INSERT INTO reserva (id,id_residencia,id_usuario,semana) VALUES (null,$idResidencia,$idUsuario,$semana)";
	if(mysqli_query($conexion,$query)){

		//averiguo cuantos creditos tiene y descuento uno
		$sqlCreditos=mysqli_query($conexion,"SELECT creditos FROM usuario WHERE id = $idUsuario");
		$result=mysqli_fetch_assoc($sqlCreditos);
		$creditos=$result['creditos'];
		$creditos--;

		//se descuentan los creditos del usuario
		$sqlDescontarCreditos="UPDATE usuario SET creditos=$creditos WHERE id = $idUsuario";
		mysqli_query($conexion,$sqlDescontarCreditos);

		$anio=date("Y");
		//deshabilito la semana de la tabla periodo 
		$sqlDeleteSemana="UPDATE periodo SET activa='no' WHERE id=$semana";
		mysqli_query($conexion,$sqlDeleteSemana);

		echo  '<script>alert("La reserva se completo exitosamente.");
		window.location="index.php";</script>';
	}
}
 ?>