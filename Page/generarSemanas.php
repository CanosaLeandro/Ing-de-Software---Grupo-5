<?php 
set_time_limit(300);
include("DB.php");
$conexion = conectar();
$anio=$_POST['anio'];
$verificar=true;

//selecciona los anio que hay en la tabla periodo
$aniosVigentesQuery="SELECT DISTINCT anio FROM periodo";
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
	while ($idResidencia=mysqli_fetch_assoc($residencias)) {
		$id = $idResidencia['id'];
		for ($i = 1; $i <= 52; $i++) { #genero las 52 semanas anuales
			mysqli_query($conexion, "INSERT INTO periodo SET id_residencia = $id , semana = $i,activa='si',anio=$anio");
		}
	}
	echo '<script>alert("Se habilitaron las semanas del año '.$anio.' correctamente.");
			window.location = "crudResidencia.php";</script>';
}

?>