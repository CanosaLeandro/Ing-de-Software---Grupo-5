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
$idResidencia=$_GET['idResi'];
$semana=$_GET['idSemana'];//id del periodo
$idHotsale=$_GET['idHotsale'];

$verificar=true;

//verifico que el usuario tenga la semana libre
$queryPeriodo="SELECT * FROM semana WHERE id = $semana";
$resutPeriodo=mysqli_query($conexion,$queryPeriodo);
$arrayPeriodo=mysqli_fetch_assoc($resutPeriodo);
//obtengo la semana y el año de la semana para comparar luego 
$semanaPeriodo=$arrayPeriodo['num_semana'];
$anioPeriodo=$arrayPeriodo['anio'];
//obtengo todas las reservas del usuario
$queryReservas="SELECT * FROM reserva WHERE id_usuario=$idUsuario";
$resultReservas=mysqli_query($conexion,$queryReservas);
while ($row=mysqli_fetch_assoc($resultReservas)) {
    $idPeriodoReserva=$row['id_semana'];
    $queryPeriodoReserva="SELECT * FROM semana WHERE id = $idPeriodoReserva";
    $resutPeriodoReserva=mysqli_query($conexion,$queryPeriodoReserva);
    $arrayPeriodoReserva=mysqli_fetch_assoc($resutPeriodoReserva);
    $semanaPeriodoReserva=$arrayPeriodoReserva['num_semana'];
    $anioPeriodoReserva=$arrayPeriodoReserva['anio'];
    //verifico si es la misma semana y el misma año
    if (($semanaPeriodo==$semanaPeriodoReserva)&&($anioPeriodo==$anioPeriodoReserva)) {
       echo "<script>alert('No fue posible su compra del hotsale ya que usted no tiene la semana a comprar disponible.');
			window.location='residenciaHotsale.php?idResi=$idResidencia&idHotsale=$idHotsale&idSemana=$semana';</script>";
        $verificar=false;
    }
}
//ahora verifico todos los hotsale comprados del usuario
$queryHotsaleComprados="SELECT * FROM hotsalecomprados WHERE id_usuario=$idUsuario";
$resultHotsaleComprados=mysqli_query($conexion,$queryHotsaleComprados);
while ($row=mysqli_fetch_assoc($resultHotsaleComprados)) {//itera por cada hotsale
    $id_hotsale=$row['id_hotsale'];
    $queryHotsaleComprado="SELECT * FROM semana WHERE id = $id_hotsale";
    $resultHotsaleComprado=mysqli_query($conexion,$queryHotsaleComprado);
    $arrayHotsale=mysqli_fetch_assoc($resultHotsaleComprado);
    //de cada hotsale, se obtiene la semana
    $idPeriodoReserva=$arrayHotsale['id_semana'];
    $queryPeriodoReserva="SELECT * FROM semana WHERE id = $idPeriodoReserva";
    $resutPeriodoReserva=mysqli_query($conexion,$queryPeriodoReserva);
    $arrayPeriodoReserva=mysqli_fetch_assoc($resutPeriodoReserva);
    $semanaPeriodoReserva=$arrayPeriodoReserva['num_semana'];
    $anioPeriodoReserva=$arrayPeriodoReserva['anio'];
    //verifico si es la misma semana y el misma año
    if (($semanaPeriodo==$semanaPeriodoReserva)&&($anioPeriodo==$anioPeriodoReserva)) {
       echo "<script>alert('No fue posible su compra del hotsale ya que usted no tiene la semana a comprar disponible.');
            window.location='residenciaHotsale.php?idResi=$idResidencia&idHotsale=$idHotsale&idSemana=$semana';</script>";
        $verificar=false;
    }
}


if($verificar){//si tiene la semana disponible
	//asocio al hotsale con el usuario
    $query="INSERT INTO hotsalecomprados (id,id_usuario,id_hotsale) VALUES (null,$idUsuario,$idHotsale)";
    if(mysqli_query($conexion,$query)){
	    //deshabilito el hotsale, para que no pueda volver a comprarse
	    $sqlDeshabilitarHotsale="UPDATE hotsale SET activo='no' WHERE id=$idHotsale";
	    if(mysqli_query($conexion,$sqlDeshabilitarHotsale)){
			    echo  "<script>alert('Compra exitosa.');
			    window.location='hotsales.php';</script>";
        }else{
            echo "<script>alert('Error al generar la compra.');
            window.location='residenciaHotsale.php?idResi=$idResidencia&idHotsale=$idHotsale&idSemana=$semana';</script>";
        }
    }else{
        echo "<script>alert('Error al generar la compra.');
		window.location='residenciaHotsale.php?idResi=$idResidencia&idHotsale=$idHotsale&idSemana=$semana';</script>";
    }
}
 ?>