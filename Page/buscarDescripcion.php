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
	<?php
          
    //cantidad de registros por pagina
    $por_pagina = 5;

    //si se presiono algun indice de la paginacion
    if(isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
        $descripcion= $_GET['descripcion'];
    }else{
        $pagina = 1;
    }

    if(isset($_GET['buscar'])){
        $descripcion =  $_GET['descripcion'];
    }elseif (!isset($_GET['pagina'])) {//si no busca y no cambia de pagina
        $descripcion ='';
    }
    //la pagina inicia en 0 y se multiplica por $por_pagina

    $empieza = ($pagina - 1) * $por_pagina;

    $query = "SELECT * FROM residencia WHERE descrip LIKE '%$descripcion%' AND activo = 'si' LIMIT $empieza, $por_pagina";
    $resultado = mysqli_query($conexion, $query);
    
?>
<body>
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
                    <div class="col-sm-4">
                        <h2>Buscar por <b>Descripción</b></h2>
                    </div>

                    <!-- buscador por rangos de fechas -->
                    <div class="col-sm-4">
                        <form action="buscarDescripcion.php" method="GET">
                            <div class="form-group">
                              <label for="disabledSelect">Descripcion</label>
                              <input type="text" id="disabledSelect" class="form-control" name="descripcion" value="<?php echo $descripcion;?>" placeholder="" required>
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>                    
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
                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['id'];$j++;
                    ?>
                    <tr>
                        <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                        <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                        <td><?php echo $fila['capacidad'];?></td>
                        <td><?php echo utf8_encode(utf8_decode($fila['ubicacion']));?></td>
                        <td><?php echo utf8_encode(utf8_decode($fila['descrip']));?></td>
                        <td>
                            <a href='residencia.php?id=<?php echo $id;?>'><button type="button " class="btn btn-info"><span>Ver Residencia</span></button></a>
                        </td>
                    </tr> 
                    <?php };?>
                </tbody>
            </table>
            <?php
                $qry="SELECT * FROM residencia WHERE descrip LIKE '%$descripcion%' AND activo = 'si'";
    
                $result = mysqli_query($conexion, $qry);
                //contar el total de registros
                $total_registros = mysqli_num_rows($result);
            ?>
            <div class="clearfix">
				<?php
				if (isset($total_registros)) {

					if ($total_registros > 5) {

						//usando ceil para dividir el total de registros entre $por_pagina
						//ceil redondea un numero para abajo
						$total_paginas = ceil($total_registros / $por_pagina);

						?>
						<div class="hint-text">Mostrando del registro<b> <?php echo (($pagina-1)*$por_pagina)+1 ?></b> al <b><?php if (($por_pagina*$pagina)>$total_registros){echo $total_registros; } else {echo $por_pagina*$pagina; }?></b>, de <b><?php echo $total_registros; ?></b> registros</div>
						<nav aria-label="Page navigation example">
							<ul class="pagination">

								<?php
								//link a la primera pagina

								for ($i = 1; $i < $total_paginas; $i++) {
									echo "<li class='page-item'>
										<a href='buscarDescripcion.php?pagina=" . $i . "&descripcion=".$descripcion."' class='page-link'>" . $i . "</a>
									  </li>";
								}


								//link a la ultima pagina
								echo "<li class='page-item'><a href='buscarDescripcion.php?pagina=".$total_paginas."&descripcion=".$descripcion."' class='page-link'>" . 'Ultimos registros' . "</a></li>";
							}
						}
						?>

					</ul>
				</nav>
			</div>
        </div>
    </div>
</body>
</html>         