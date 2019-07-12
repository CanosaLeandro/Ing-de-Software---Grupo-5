<?php
   
	function calcularCreditos($idUsuario,$anio){
        Include_once("DB.php");
        $conexion = conectar();
		$queryCreditos = "SELECT * FROM creditos WHERE id_usuario = $idUsuario AND anio = $anio";
        $sqlCreditos=mysqli_query($conexion,$queryCreditos);
        $resultadoCreditos=mysqli_fetch_assoc($sqlCreditos);
        $creditos = $resultadoCreditos['creditos'];
        return $creditos;
	}
?>