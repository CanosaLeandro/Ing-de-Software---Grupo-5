<!DOCTYPE html>
<html lang="es">
<?php
    Include("DB.php");
    $conexion = conectar();   
	
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busqueda por Descripcion</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_crudResidencia.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
	<body>
            
            <div class="container">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Buscar por <b> Descripcion</b></b></h2>
                            </div>


                            <!-- buscador por rangos de fechas -->
                            <div class="col-sm-4">
								<form>
                                    <div class="form-group">
										<label for="disabledSelect">Descripcion</label>
										<input type="text" id="disabledSelect" class="form-control" name="descripcion" value="" placeholder="">
                                    </div>
                                    <button type="submit" name="buscarDescripcion" class="btn btn-primary">Buscar</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>

<?php 

        //Esta parte es el buscador
        if(isset($_GET['buscarDescripcion'])){
				$descrip = $_GET['descripcion'];
                $sqlEdit = "SELECT * FROM residencia WHERE descrip LIKE '%$descrip%'";
				$resultado = mysqli_query($conexion,$sqlEdit);
			?>	
                    

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
                                $j=0;
                                while($fila = mysqli_fetch_assoc($resultado)){
                                    $id = $fila['id'];$j++;
                            ?>
                            <tr>
                                <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                                <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                                <td><?php echo $fila['capacidad'];?></td>
                                <td><?php echo utf8_encode(utf8_decode($fila['ubicacion']));?></td>
                                <td><?php echo utf8_encode($fila['descrip']);?></td>
                                <td>
                                    <a href="residencia.php?id= <?php echo $id; ?>"><button type="button" class="btn btn-info"><span>Ver Residencia</span></button></a>
                                </td>
                            </tr> 
                            <?php };?>
                        </tbody>
                    </table>
        <?php } 
		?>
	
	</body>
</html>
