<!DOCTYPE html>
<html lang="es">
<?php
include("DB.php");
include("links.php");
$conexion = conectar();

/*aca valida si inicio sesion--------------------------------------------*/
require_once('Authentication.php');
$authentication = new Authentication();	
$authentication->login();						
try{				
	$authentication->logueadoAdmin();
}catch(Exception $ex){
	$error = $ex->getMessage();
	echo "<script>alert('$error');</script>";
	echo "<script>window.location = 'loginAdmin.php';</script>";
}
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
$id=$_GET['id'];
$enviado=NULL;
		
if(isset($_POST['btn'])){
	$enviado=true;	
	$id=$_POST['idFoto'];
}
?>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="crudResidencia.php">
	    <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
	    Home Switch Home
	  </a>
	  <a class="navbar-brand" href="crudUsuarios.php">Usuarios</a>
	  <div style="margin-left: 450px;" class="d-flex align-items-end">
	  	<div class="ml-5 p-2">
	  		<a href="logoutAdmin.php" type="button" class="btn btn-danger">Cerrar sesión</a> 
	  	</div>
	  </div>  
      
	</nav>

	<div class="container">
		<div class="table-wrapper">
			
			<div class="table-title">
				<nav class="navbar navbar-light bg-light">
					<a class="navbar-brand" href="home.php">
						<img style="margin-top: -10px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
				   	 Home Switch Home
					</a>
				</nav>
				<div class="row">
					<div class="col-sm-6">
						<h2>Administración de <b>Residencias</b></h2>
					</div>
				</div>
			</div>


			<div class="">
				<form action="" enctype="multipart/form-data" method="POST">
					<div class="modal-header">
						<h4 class="modal-title">Agregar Portada a la Residencia</h4>
					</div>
					<br>
					<div class="form-group">
						<label for="inputFoto">Imagen de portada</label>
						<input type="hidden" name="idFoto" value="<?php echo $id;?>">
						<input type="file" name="foto" id="foto" class="form-control" placeholder="" value="" required oninvalid="setCustomValidity('El campo Imagen de portada es obligatorio.')"
                 oninput="setCustomValidity('')">
					</div>
	
					<div class="modal-footer">
						<input type="button" class="btn btn-default" value="Cancelar">
						<input type="submit" name= "btn" class="btn btn-success" value="Agregar">
					</div>
				</form>
			</div>
		</div>
	</div>


	<?php 
	if ($enviado) {

		if(!empty($_FILES['foto']['name'])) {//verifica que la foto este definida
			$archivo = $_FILES['foto']['tmp_name'];
			$tamanio = $_FILES['foto']['size'];
			$fp = fopen($archivo, "r");//abre el fichero. Con "r" es para solo lectura
			$contenido = fread($fp, $tamanio);//fread: Lectura de un fichero en modo binario seguro, lee el archivo abierto con fopen hasta $tamanio
			$contenido = addslashes($contenido);//Devuelve un string con barras invertidas delante de los caracteres que necesitan ser escapados. 
			fclose($fp);//Cierra un puntero a un archivo abierto


			if(mysqli_query($conexion,"UPDATE residencia 
										SET foto = '$contenido' WHERE id = $id")){
					echo '<script> alert("La operación se completo correctamente. La nueva residencia fue agregada al sistema.");
					window.location = "crudResidencia.php";</script>';
			}else{ echo '<script> alert("No se pudo agregar el registo al sistema.");</script>';
				} 
				

		}else{ echo '<script>alert("ERROR!. El campo Portada es obligatorio.");
					</script>';
			}	
	}

	 ?>
</body>
</html>