<?php
    Include("DB.php");
    $conexion = conectar();
    $idRes = $_POST['id_residencia'];
    $montoMinimo = $_POST['monto_inicial'];
    $fechaInicio = strtotime($_POST['inicia']);
    $mysqlFechaInicio = date('Y-m-d H:i:s',$fechaInicio);
    $fechaPeriodo = strtotime($_POST['periodo']);
    $año= $_POST['año'];
    $mysqlFechaPeriodo = date('Y-m-d H:i:s',$fechaPeriodo);
    //En caso de que alguna query a la base de datos falle
    function errQuery(){
        global $idRes;
        echo('<script> alert("ERROR!. La consulta falló"); 
               window.location(subastarPropiedad.php?id='.$idRes.');
            </script>');
    }

    //Errores 
    function errorQuery($mensaje){
        global $idRes;
        echo('<script> alert("ERROR!. '.$mensaje.'"); 
                window.location(subastarPropiedad.php?id='.$idRes.');
            </script>');
    }
     // Formulate the Difference between two dates 
    
     $diff = abs($fechaPeriodo - $fechaInicio);  
    
     // To get the year divide the resultant date into 
     // total seconds in a year (365*60*60*24) 
     $years = floor($diff / (365*60*60*24));  
   
   
     // To get the month, subtract it with years and 
     // divide the resultant date into 
     // total seconds in a month (30*60*60*24)   
     $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
     $diferenciaDias = floor(($diff - $years * 365*60*60*24 - $months *30*60*60*24)/ (60*60*24));

    //Sin errores
    function success(){
        global $idRes;
        echo ('<script> alert("La subasta se creó correctamente"); 
                    window.location = "crudResidencia.php";
                </script>');
    }


    if( $fechaInicio > date('Y-m-d') ){  
        //Caclculo la diferencia en meses
        if( $diferenciaDias > 3){
            if( ceil($diferenciaDias / 30.417)  < 6 ){
                //Inserto nueva subasta
                if(mysqli_query($conexion, "INSERT INTO subasta 
                                            SET id_residencia=$idRes, monto_inicial = $montoMinimo, periodo = $mysqlFechaPeriodo, inicia = $mysqlFechaInicio, puja_ganadora = 0")){
                    //Actualizo la residencia que ahora pasa a estar en subasta
                    if(mysqli_query($conexion, "UPDATE  residencia SET en_subasta = 'si' WHERE id = $idRes")){
                        //Borro el periodo libre
                        if(mysqli_query($conexion, "UPDATE periodo SET en_subasta = 'si' WHERE id_residencia= $idRes AND semana = $mysqlFechaPeriodo AND anio = $año ")){              
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