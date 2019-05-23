<?php
    Include("DB.php");
    $conexion = conectar();
    $idRes = $_POST['id_residencia'];
    $montoMinimo = $_POST['monto_inicial'];
    $fechaInicio = $_POST['inicia'];
    $fechaPeriodo = $_POST['periodo'];

    //En caso de que alguna query a la base de datos falle
    function errQuery(){
        echo('<script> alert("ERROR!. La consulta falló"); 
                window.location = "subasta.php?id='.$idRes.'";
            </script>');
    }

    //Errores 
    function errorQuery($mensaje){
    echo('<script> alert("ERROR!. '.$mensaje.'); 
            window.location = "subasta.php?id='.$idRes.'";
        </script>');
    }

    $diferenciaDias = ($fechaPeriodo - $fechaInicio) / 86400;
    if( $fechaInicio > date('Y-m-d') ){  
        //Caclculo la diferencia en meses
        if( $diferenciaDias > 3){
            if( ceil($diferenciaDias / 30,417)  < 6 ){
                //Inserto nueva subasta
                if(mysqli_query($conexion, "INSERT INTO subasta s VALUE $idRes, $montoMinimo, $fechaPeriodo, $fechaInicio, 0")){
                    //Actualizo la residencia que ahora pasa a estar en subasta
                    if(mysqli_query($conexion, "UPDATE  residencia SET en_subasta = 'si' WHERE id = $idRes")){
                        //Borro el periodo libre
                        if(mysqli_query($conexion, "DELETE FROM periodo WHERE id_residencia= $idRes AND fecha = $fechaPeriodo")){  
    ?>                    
                            <script> alert("La subasta se creó correctamente"); 
                                    window.location = "crudResidencia.php";
                            </script>
<?php 
                        } else{
                            errQuery();
                        }
                    } else{
                        errQuery();
                    }
                } else {
                    errQuery();
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