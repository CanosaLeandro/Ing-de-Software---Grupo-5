<?php
    Include("DB.php");
    $conexion = conectar();
    $idRes = $_POST['id_residencia'];
    $montoMinimo = $_POST['monto_inicial'];
    $fechaInicio = strtotime($_POST['inicia']);
    $hora=$_POST['hora'];
    $mysqlFechaInicio = date('Y-m-d',$fechaInicio);
   
    $fecha=$_POST['periodo'];//contiene la semana y el anio concatenados
    
    $horaDB= $mysqlFechaInicio." ".$hora.":00";

    $semana = substr($fecha, 0,1);
    $anio = substr($fecha, 1, 6);

    $queryIdPeriodo="SELECT * FROM periodo WHERE id_residencia=$idRes AND semana=$semana AND anio=$anio";
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
                             (id,id_residencia,monto_inicial,semana,inicia, puja_ganadora) VALUES(NULL,$idRes,$montoMinimo,$idPeriodo,'$horaDB',0)")){

     //Deshabilito la semana que se puso en subasta
     if(mysqli_query($conexion, "UPDATE periodo SET activa = 'no' WHERE id=$idPeriodo")){              
         success();
     } else{
         errorQuery('Falla al eliminar un periodo libre');
     }
 } else {
     errorQuery(' al crear la subasta.');
 }
             
?>