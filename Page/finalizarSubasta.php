<?php
    Include("calcularCreditos.php");
    Include("DB.php");
    $conexion = conectar();
    
    $idSubasta=$_GET['id'];

    //busco la informacion de la subasta
    $querySubasta = "SELECT * FROM subasta WHERE id = $idSubasta";
    $sqlSubasta = mysqli_query($conexion, $querySubasta);
    $resultadoSubasta = mysqli_fetch_assoc($sqlSubasta);
    $montoMinimo = $resultadoSubasta['monto_minimo'];
    $idSemana = $resultadoSubasta['id_semana'];
    $idResidencia= $resultadoSubasta['id_residencia'];
    //busco la informacion de la semana
    $querySemana = "SELECT * FROM semana WHERE id = $idSemana";
    $sqlSemana = mysqli_query($conexion,$querySemana);
    $reslutadoSemana = mysqli_fetch_assoc($sqlSemana);
    $numSemana = $reslutadoSemana['num_semana'];
    $anio = $reslutadoSemana['anio'];
    //busco las pujas
    $queryPujas = "SELECT * FROM puja WHERE id_subasta = $idSubasta ORDER BY monto DESC";
    $sqlPujas = mysqli_query($conexion,$queryPujas);

    while($registroPujas = mysqli_fetch_assoc($sqlPujas)){
        $idUsuario = $registroPujas['id_usuario'];
        $monto = $registroPujas['monto'];

        if($monto>= $montoMinimo){//compruebo que el monto sea mayor al minimo        
            //busco la informacion del usuario
            $queryUsuario = "SELECT * FROM usuario WHERE id = $idUsuario";
            $sqlUsuario = mysqli_query($conexion, $queryUsuario);
            $resultadoUsuario = mysqli_fetch_assoc($sqlUsuario);
            $emailUsuario = $resultadoUsuario['email'];
            $creditos = calcularCreditos($idUsuario,$anio); 
            if($creditos>0){//compruebo que el usuario tenga créditos
                //obtengo todas las reservas del usuario
                $verificar=true;
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
                    if (($numSemana==$semanaPeriodoReserva)&&($anio==$anioPeriodoReserva)) {
                    echo "<script>alert('No fue posible su compra del hotsale ya que usted no tiene la semana a comprar disponible.');
                            window.location='residenciaHotsale.php?idResi=$idResidencia&idHotsale=$idHotsale&idSemana=$semana';</script>";
                        $verificar=false;
                    }
                }
                if ($verificar){
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
                        if (($numSemana==$semanaPeriodoReserva)&&($anio==$anioPeriodoReserva)) {
                        echo "<script>alert('No fue posible su compra del hotsale ya que usted no tiene la semana a comprar disponible.');
                                window.location='residenciaHotsale.php?idResi=$idResidencia&idHotsale=$idHotsale&idSemana=$semana';</script>";
                            $verificar=false;
                        }
                    }
                }                
                if($verificar){//compruebo que tenga la semana disponible
                    //entonces es el ganador
                    try{
                        mysqli_query($conexion,"MYSQLI_TRANS_START_READ_WRITE");
		                mysqli_autocommit($conexion,FALSE);
                        //Agrego la reserva
                        $sqlAddReserva="INSERT INTO reserva (id,id_residencia,id_usuario,id_semana) VALUES (null,$idResidencia,$idUsuario,$idSemana)";
                        $queryAddReserva=$conexion->prepare($sqlAddReserva);
				        $queryAddReserva->execute();
                        //deshabilito la semana de la tabla semana 
                        $queryUpdateSemana="UPDATE semana SET disponible='no' , en_subasta='no' WHERE id=$idSemana";
                        $sqlUpdateSemana=$conexion->prepare($queryUpdateSemana);
                        $sqlUpdateSemana->execute();
                        //actualizo los créditos del usuario
                        $creditos--;
                        $queryUpdateCreditos = "UPDATE creditos SET creditos = $creditos WHERE id_usuario = $idUsuario AND anio = $anio";
                        $sqlUpdateCreditos = $conexion->prepare($queryUpdateCreditos);
                        $sqlUpdateCreditos->execute();
                        //borro todas las pujas
                        $queryDeletePujas="DELETE FROM puja WHERE id_subasta=$idSubasta";
                        $sqlDeletePujas = $conexion->prepare($queryDeletePujas);
                        $sqlDeletePujas->execute();
                        //borro la subasta
                        $queryDeleteSubasta = "DELETE FROM subasta WHERE id = $idSubasta ";
                        $sqlDeleteSubasta = $conexion->prepare($queryDeleteSubasta);
                        $sqlDeleteSubasta->execute();
                        $conexion->commit();
                        echo  '<script>alert("El Ganador es el usuario '.$emailUsuario.'.");
                            window.location="finalizarSubastas.php";</script>'; 
	                } catch (Exception $e){
		                $conexion->rollback();
                        echo  '<script>alert("Error al finalizar la subasta. Intente mas tarde");
                        window.location="finalizarSubastas.php";</script>';     
                    }
                }else{
                    $idPuja= $registroPujas['id'];
                    if(!mysqli_query($conexion,"DELETE FROM puja WHERE id= $idPuja")){
                        echo  '<script>alert("Error, No se pudo eliminar la puja '.$idPuja.'.");
                        window.location="finalizarSubastas.php";</script>';
                    }
                }
            }else{
                $idPuja= $registroPujas['id'];
                if(!mysqli_query($conexion,"DELETE FROM puja WHERE id= $idPuja")){
                    echo  '<script>alert("Error, No se pudo eliminar la puja '.$idPuja.'.");
                    window.location="finalizarSubastas.php";</script>';
                }
            }
        }else{
            $idPuja= $registroPujas['id'];
            if(!mysqli_query($conexion,"DELETE FROM puja WHERE id= $idPuja")){
                echo  '<script>alert("Error, No se pudo eliminar la puja '.$idPuja.'.");
                window.location="finalizarSubastas.php"; </script>';
            }
        }
    }
    try{
        mysqli_query($conexion,"MYSQLI_TRANS_START_READ_WRITE");
        mysqli_autocommit($conexion,FALSE);
        //borro la subasta
        $queryDeleteSubasta = "DELETE FROM subasta WHERE id = $idSubasta ";
        $sqlDeleteSubasta = $conexion->prepare($queryDeleteSubasta);
        $sqlDeleteSubasta->execute();
        $conexion->commit();
    } catch (Exception $e){
        $conexion->rollback();
        echo  '<script>alert("Error al finalizar la subasta. Intente mas tarde");
        window.location="finalizarSubastas.php";</script>';     
    }
    echo  '<script>alert("No hubo ganador de la subasta");
    window.location="finalizarSubastas.php";</script>'; 
