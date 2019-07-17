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
//obtengo todas las reservas y hotsales del usuario
$queryReservas="SELECT id_semana FROM reserva WHERE id_usuario=$idUsuario
UNION DISTINCT
SELECT id_semana FROM hotsalecomprados INNER JOIN hotsale ON hotsalecomprados.id_hotsale = hotsale.id 
WHERE  id_usuario=$idUsuario";
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
       echo '<script>alert("Error, usted ya tiene una reserva para esa semana, intente con otra.");
			window.location="hotsales.php";</script>';
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