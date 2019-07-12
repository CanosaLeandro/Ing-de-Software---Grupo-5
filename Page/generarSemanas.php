<?php 
set_time_limit(300);
include("DB.php");
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

$anio=$_POST['anio'];
$verificar=true;

//selecciona los anio que hay en la tabla periodo
$aniosVigentesQuery="SELECT DISTINCT anio FROM semana";
$aniosVigentes=mysqli_query($conexion,$aniosVigentesQuery);//para comparar año por año

//chequeo que el año ingresado no exista en la tabla periodo
while ($registroAnioVigente=mysqli_fetch_assoc($aniosVigentes)) {
	if ($anio == $registroAnioVigente['anio']) {
		echo "<script>alert('ERROR, las semanas de ese año ya fueron habilitadas. Intente con otro año.');
		window.location='habilitarSemanas.php';</script>";
		$verificar=false;
	}
}

if($verificar) {
	//si para el while, se generan las semanas
	
	$idResidenciaQuery="SELECT id FROM residencia ORDER BY id";

	$residencias=mysqli_query($conexion,$idResidenciaQuery);

	//se generan las semanas para cada residencia
	try {
		mysqli_query($conexion,"MYSQLI_TRANS_START_READ_WRITE");
		mysqli_autocommit($conexion,FALSE);
		while ($idResidencia=mysqli_fetch_assoc($residencias)) {
			$id = $idResidencia['id'];
			for ($i = 1; $i <= 52; $i++) { #genero las 52 semanas anuales
				$sql="INSERT INTO semana SET id_residencia = $id , num_semana = $i, disponible='si', anio=$anio, en_subasta='no', en_hotsale='no'";
				$query=$conexion->prepare($sql);
				$query->execute();
			}
		}
		$conexion->commit();
	} catch (Exception $e){
		$conexion->rollback();
		echo '<script>alert("ERROR al generar las semanas del año: '.$anio.'");
			window.location = "crudResidencia.php";</script>';
	}
	echo '<script>alert("Se habilitaron las semanas del año '.$anio.' correctamente.");
			window.location = "crudResidencia.php";</script>';
}
?>