<!DOCTYPE html>
<html lang="es">
<?php
    Include("DB.php");
	$conexion = conectar();		

	$id = $_GET['id'];
	$sqlEdit = "SELECT * FROM residencia WHERE id = $id";
	$resultEdit = mysqli_query($conexion,$sqlEdit);
	$fila = mysqli_fetch_assoc($resultEdit);

?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración de residencias</title>
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
		<form action="editResidencia.php" enctype="multipart/form-data" method="POST">
			<div class="modal-header">						
				<h4 class="modal-title">Editar Residencia</h4>
			</div>
			<div class="modal-body">					
				<div class="form-group">
					<label>Nombre</label>
					<input type="hidden" name="nombreAnt" value="<?php echo $fila['nombre'];?>">
					<input type="text" name="nombre" value="<?php echo $fila['nombre'];?>" placeholder="" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Foto</label>
					<img style="margin-left: 20px; margin-bottom: 5px; height: 70px; width: 70px;" class="foto" src="foto.php?id=<?php echo $id;?>"/>
					<input type="file" name="foto" class="form-control">
				</div>
				<div class="form-group">
					<label>Capacidad</label>
					<input type="hidden" name="capacidadAnt" value="<?php echo $fila['capacidad'];?>">
					<input type="number" name="capacidad" value="<?php echo utf8_encode(utf8_decode($fila['capacidad']));?>" class="form-control" required>
				</div>			
				<div class="form-group">
					<label>Ubicación</label>
					<input type="hidden" name="ubicacionAnt" value="<?php echo $fila['ubicacion'];?>">
					<input type="text" name="ubicacion" value="<?php echo utf8_encode(utf8_decode($fila['ubicacion']));?>" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Descripción</label>
					<input type="hidden" name="descripcionAnt" value="<?php echo $fila['descrip'];?>">
					<textarea class="form-control" name="descripcion" value="<?php echo $fila['descrip'];?>" placeholder="<?php echo utf8_encode(utf8_decode($fila['descrip']));?>" required><?php echo $fila['descrip'];?></textarea>
				</div>			
			</div>
			<div class="modal-footer">
				<input type="hidden" name="id" value="<?php echo $id ;?>">
				<a href="crudResidencia.php"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"></a>
				<input type="submit" class="btn btn-info" value="Guardar">
			</div>
		</form>
	</div>
</body>
</html> 