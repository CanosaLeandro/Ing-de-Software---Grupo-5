<?php
    Include("DB.php");
    $conexion = conectar();
    $idRes = $_POST['id_residencia'];
    $montoMinimo = $_POST['monto_inicial'];
    $fechaInicio = strtotime($_POST['inicia']);
    $mysqlFechaInicio = date('Y-m-d H:i:s',$fechaInicio);
    $fechaPeriodo = strtotime($_POST['periodo']);
    $mysqlFechaPeriodo = date('Y-m-d H:i:s',$fechaPeriodo);
    //En caso de que alguna query a la base de datos falle
    function errQuery(){
        global $idRes;
        echo('<script> alert("ERROR!. La consulta falló"); 
               
            </script>');
    }

    //Errores 
    function errorQuery($mensaje){
        global $idRes;
        echo('<script> alert("ERROR!. '.$mensaje.'"); 
              
            </script>');
    }

    //Sin errores
    function success(){
        global $idRes;
        echo ('<script> alert("La subasta se creó correctamente"); 
                    window.location = "crudResidencia.php";
                </script>');
    }

    $diferenciaDias = ceil(($fechaPeriodo - $fechaInicio) / 86400);
    if( $fechaInicio > date('Y-m-d') ){  
        //Caclculo la diferencia en meses
        if( $diferenciaDias > 3){
            if( ceil($diferenciaDias / 30.417)  < 6 ){
                //Inserto nueva subasta
                if(mysqli_query($conexion, "INSERT INTO subasta VALUES (, $idRes, $montoMinimo, $mysqlFechaPeriodo, $mysqlFechaInicio, 0/*Puja ganadora que por defecto es 0*/)")){
                    //Actualizo la residencia que ahora pasa a estar en subasta
                    if(mysqli_query($conexion, "UPDATE  residencia SET en_subasta = 'si' WHERE id = $idRes")){
                        //Borro el periodo libre
                        if(mysqli_query($conexion, "DELETE FROM periodo WHERE id_residencia= $idRes AND fecha = $mysqlFechaPeriodo")){              
                            success();
                        } else{
                            errorQuery('Falla al eliminar un periodo libre');
                        }
                    } else{
                        errorQuery('Falla en actualizar residencia');
                    }
                } else {
                    errorQuery('Falla al agregar una subasta');
                }
            } else{
                errorQuery('La semana a subastar es demasiado lejana del inicio de la subasta');
            }
        } else{
            errorQuery('La subasta no puede concretarse en la semana que se esta subastando');
        }
    } else{
        errorQuery('La fecha de inicio de subasta es anterior a la fecha actual');
    }
?>