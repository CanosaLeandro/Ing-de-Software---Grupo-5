<?php
    Include("DB.php");
    $conexion = conectar();
    $idSubasta = $_GET['id'];
    
    //consulta por la semana de la subasta
    $querySemana = "SELECT * FROM subasta WHERE id = $idSubasta";
    $sqlSemana = mysqli_query($conexion, $querySemana);
    $result = mysqli_fetch_assoc($sqlSemana);
    $semana = $result['id_semana'];
    $cantidadSubastas = mysqli_num_rows($sqlSemana);
    

    try {
		mysqli_query($conexion,"MYSQLI_TRANS_START_READ_WRITE");
		mysqli_autocommit($conexion,FALSE);
		$sqlPujas="DELETE FROM puja WHERE id_subasta = $idSubasta";
		$queryPujas=$conexion->prepare($sqlPujas);
        $queryPujas->execute();
        $sqlActualizarSemana="UPDATE semana SET disponible = 'si' , en_subasta = 'no' WHERE id = $semana";
		$queryActualizarSemana=$conexion->prepare($sqlActualizarSemana);
		$queryActualizarSemana->execute();
        if( $cantidadSubastas== 1){
            $sqlActualizarResidencia="UPDATE residencia SET en_subasta='no' WHERE id = $idSubasta";
		    $queryActualizarResidencia=$conexion->prepare($sqlActualizarResidencia);
            $queryActualizarResidencia->execute();
        }
        $sqlEliminarSubasta="DELETE FROM subasta WHERE id = $idSubasta";
		$queryEliminarSubasta=$conexion->prepare($sqlEliminarSubasta);
        $queryEliminarSubasta->execute();

		$conexion->commit();
	} catch (Exception $e){
		$conexion->rollback();
		echo '<script>alert("Error al cancelar la subasta, intente mas tarde");
			window.location = "cancelarSubastas.php";</script>';
	}
	echo '<script>alert("La subasta fue cancelada.");
			window.location = "cancelarSubastas.php";</script>';
?>  
