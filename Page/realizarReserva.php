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
$semana=$_POST['semana'];//id del periodo


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
			window.location="reservar.php?id='.$idResidencia.'";</script>';
        $verificar=false;
    }

}


if($verificar){
    $creditos = calcularCreditos($idUsuario,$anioPeriodo);
    if($creditos >= 1){

    	//asocio la reserca con el usuario
	    $query="INSERT INTO reserva (id,id_residencia,id_usuario,id_semana) VALUES (null,$idResidencia,$idUsuario,$semana)";
	    if(mysqli_query($conexion,$query)){
		    //deshabilito la semana de la tabla periodo 
		    $sqlDeleteSemana="UPDATE semana SET disponible='no' WHERE id=$semana";
		    if(mysqli_query($conexion,$sqlDeleteSemana)){
                $creditos--;
			    $actualizarCreditos = "UPDATE creditos SET creditos = $creditos WHERE id_usuario = $idUsuario AND anio = $anioPeriodo";
			    if(mysqli_query($conexion,$actualizarCreditos)){
				    echo  '<script>alert("La reserva se completo exitosamente.");
				    window.location="listaReservas.php";</script>';
			    }else{
				    echo  '<script>alert("Error al actualizar los créditos.");
				    window.location="listaReservas.php";</script>';
			    } 
            }
        }else{
            echo  '<script>alert("Error al generar la reserva.");
			window.location="listaReservas.php";</script>';
        }
    }
}
 ?>