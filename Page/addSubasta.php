<?php
    Include("DB.php");
    $conexion = conectar();
    $idRes = $_POST['id_residencia'];
    $montoMinimo = $_POST['monto_minimo'];
    $fechaInicio = strtotime($_POST['inicia']);
    $hora=$_POST['hora'];
    $mysqlFechaInicio = date('Y-m-d',$fechaInicio);
   
    $fecha=$_POST['periodo'];//contiene la semana y el anio concatenados
    
    $horaDB= $mysqlFechaInicio." ".$hora.":00";

    $semana = substr($fecha, 0,2);
    $anio = substr($fecha, 2, 4);
    
    $queryIdPeriodo="SELECT id FROM semana WHERE id_residencia=$idRes AND num_semana= $semana AND anio=$anio ";
    $resultadoIdPerido=mysqli_query($conexion,$queryIdPeriodo);
    $arrayIdPeriodo=mysqli_fetch_assoc($resultadoIdPerido);
    $idPeriodo=$arrayIdPeriodo['id'];


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
     

    //Sin errores
    function success(){
        global $idRes;
        echo ('<script> alert("La subasta se creó correctamente"); 
                    window.location = "crudResidencia.php";
                </script>');
    }
    
 //Inserto nueva subasta
 if(mysqli_query($conexion, "INSERT INTO subasta 
                             (id_residencia,monto_minimo,id_semana,inicia, puja_ganadora) VALUES($idRes,$montoMinimo,$idPeriodo,'$horaDB',0)")){

     //Deshabilito la semana que se puso en subasta
     if(mysqli_query($conexion, "UPDATE semana SET disponible = 'no' WHERE id=$idPeriodo")){              
         success();
     } else{
         errorQuery('Erro al actualizar la semana a reservada');
     }
 } else {
     errorQuery(' al crear la subasta.');
 }
             
?>