<!DOCTYPE html>
<html lang="es">
<?php
include("DB.php");
include("links.php");
$conexion = conectar();
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración de residencias</title>
	<link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style_crudResidencia.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
</head>
<body>
	<?php
    $hoy = date('Y-m-d');
    $inicioMin = date("Y-m-d",strtotime($hoy."+ 6 months"));
    $inicioMax = date("Y-m-d",strtotime($hoy."+ 12 months"));
    //cantidad de registros por pagina
    $por_pagina = 5;

    //si se presiono algun indice de la paginacion
    if(isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
    }else{
        $pagina = 1;
    }

    if(isset($_POST['buscarInicio'])){
        $fin = True;
        $fechaInicio = $_POST['inicio'];
    }else{ 
        $fin = False;
    }
    ?>  
    <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <nav class="navbar navbar-light bg-light">
					    <a class="navbar-brand" href="index.php">
						    <img src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block" alt="">
				   	        Home Switch Home
					    </a>
				    </nav>
                    <div class="row">
                        <div class="col-sm-7">
                            <h2>Buscar por <b>Semanas libres</b></h2>
                        </div>
                        <?php 
                        if(!$fin) { ?>
                            <div class="col-sm-5">
                                <form action="buscarSemanas.php" method="POST">
                                    <div class="form-group">
                                        <label for="disabledTextInput">Inicio del rango de busqueda</label>
                                        <input id="fechaInicio" type="date" name="inicio" min="<?php echo $inicioMin; ?>" max= "<?php echo $inicioMax; ?>" value= "" required>
                                        <button type="submit" name="buscarInicio" class="btn btn-primary">Siguiente</button>
                                    </div>
                                </form>
                            </div>
                        
                        <?php 
                        }else{?>

                            <div class="col-sm-5">  
                                <form action="buscarSemanas.php?" method="POST" name= "buscarFin">
                                    <div class="form-group">
                                        <label for="disabledTextInput">Fin del rango de busqueda</label>
                                        <?php 
                                            $dosMeses= date("Y-m-d",strtotime($fechaInicio."+ 2 months"));
                                            if( $dosMeses <= $inicioMax){
                                                $max = $dosMeses;
                                            }else{
                                                $max= $inicioMax;
                                            }
                                    
                                        ?>
                                        <input id="fechaFin" type="date" name="fin" min="<?php echo $fechaInicio; ?>" max= "<?php echo $max; ?>" value= "" required>
                                        <input type="hidden" name="inicio" value="<?php echo $fechaInicio; ?>">
                                        <button type="submit" name="buscarFin" class="btn btn-primary">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        <?php 
                        }?>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Portada</th>
                            <th>Capacidad</th>
                            <th>Ubicación</th>
                            <th>Descripción</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(isset($_POST['buscarFin'])){
                            $fechaFin= $_POST['fin'];
                            $fechaInicio= $_POST['inicio'];
                            $date = new DateTime($fechaInicio);
                            $weekInicio = $date->format("W");
                            $anio = $date->format("Y");
                            $date = new DateTime($fechaFin);
                            $weekFin = $date->format("W");
                            $anioFin = $date->format("Y");
                            ###########################
                            #al sacar la semana de inicio
                            #y de fin, si el fin es el año siguiente
                            #la semana va a ser menor..
                            ###########################
                            if($anio != $anioFin){
                                if(($anioFin - $anio)==1){
                                    $weekInicioAnio= 1;
                                    $weekFinAnio = 52;
                                    $querySemana = "SELECT DISTINCT id_residencia FROM semana 
                                    WHERE disponible = 'si' AND anio = $anio AND num_semana
                                    BETWEEN $weekInicio AND $weekFinAnio 
                                    OR anio= $anioFin AND num_semana BETWEEN $weekInicioAnio AND $weekFin 
                                    ORDER BY anio , num_semana DESC"; 
                                }
                            }else{
                                $querySemana = "SELECT DISTINCT id_residencia FROM semana 
                                WHERE disponible = 'si' AND anio = $anio AND num_semana 
                                BETWEEN $weekInicio AND $weekFin 
                                ORDER BY anio , num_semana DESC"; 
                            }
             
                            $sqlSemana = mysqli_query($conexion,$querySemana); 
                              
                            $j=0;
                            while ($registroSemana = mysqli_fetch_assoc($sqlSemana)){
                                $idResidencia = $registroSemana['id_residencia'];
                                $queryResidencia = "SELECT * FROM residencia WHERE id = $idResidencia ORDER BY nombre DESC"; 

                                $sqlResidencia = mysqli_query($conexion,$queryResidencia);
                                $resultResidencia = mysqli_fetch_assoc($sqlResidencia);
                                $id = $resultResidencia['id'];
                                $j++;
                                echo "
                                <tr>
                                    <td>".$resultResidencia['nombre']."</td>
                                    <td><img class='foto' src='foto.php?id= $id'/></td>
                                    <td>".$resultResidencia['capacidad']."</td>
                                    <td> ".utf8_encode(utf8_decode($resultResidencia['ubicacion']))."</td>
                                    <td> ".utf8_encode(utf8_decode($resultResidencia['descrip']))."</td><td>
                                        <a href='residencia.php?id=$idResidencia'><button type='button' class='btn btn-info'><span>Ver residencia</span></button></a>
                                    </td>
                                </tr>";
                            }
                        }?>
                    </tbody>
                </table>
            </div>
        </div>  
</body>
</html>         