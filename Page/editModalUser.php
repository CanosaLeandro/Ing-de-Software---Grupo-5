<!DOCTYPE html>
<html lang="es">
<?php
    Include("DB.php"); $conexion = conectar(); 
	/*aca valida si inicio sesion--------------------------------------------*/
	require_once('Authentication.php');
	$authentication = new Authentication();	
	$authentication->login();						
	try{				
		$authentication->logueado();
	}catch(Exception $ex){
		$error = $ex->getMessage();
		echo "<script>alert('$error');</script>";
		echo "<script>window.location = 'home.php';</script>";
	}		

	/*----------------------------------------------------------------------------*/
	$id = $_SESSION['id'];	
	$sqlEdit = "SELECT * FROM usuario WHERE id = $id";
	$resultEdit = mysqli_query($conexion,$sqlEdit);
	$fila = mysqli_fetch_assoc($resultEdit);

?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modificación de cuenta</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style_crudResidencia.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php 

		$enviado = false;
		$contrasenia = null;
		$nuevaContrasenia = null;
		$reContrasenia = null;

		$apellidoAnt = $fila['apellido'];
		$nombreAnt = $fila['nombre'];
		$emailAnt = $fila['email'];
		$contraseniaAnt = $fila['contrasenia'];
		$tarjetaAnt = $fila['tarjeta_credito'];
		$seguridadAnt = $fila['numero_seguridad'];



		if (isset($_POST['btn'])) {
			$enviado=true;
		} ?>

<nav style="background-image: url('images/hero_1.jpg'); height: 70px; border-bottom: solid 1px black; " class="navbar navbar-expand-lg navbar-light bg-light">
	 <div class="col-2">
              	<a class="navbar-brand" href="index.php">
				    <img style="margin-top: -30px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
				  </a>
              </div>
</nav>



<div class="container">
	<div class="">
		<h4 class="m-3"><b>Modificar información</b></h4>
	</div>
	<div class="row">
		<div class="container-fluid d-flex justify-content-center">
			
			<form class="ml-5" name="frm" method="post" action="">
				  <div class="form-group row">
				    <label for="inputApellido" class="col-sm-5 col-form-label ml-2">Apellido</label>
				    <div class="col-sm-8">
				    	<input type="hidden" name="apellidoAnt" value="<?php echo $fila['apellido'];?>">
				        <input type="text" class="form-control" name="apellido" id="inputApellido" placeholder="Escribá aquí su apellido" value="<?php echo $fila['apellido'];?>" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputNombre" class="col-sm-5 col-form-label ml-2">Nombre</label>
				    <div class="col-sm-8">
				      <input type="hidden" name="nombreAnt" value="<?php echo $fila['nombre'];?>">
				      <input type="text" class="form-control" name="nombre" id="inputNombre" placeholder="Escribá aquí su nombre" value="<?php echo $fila['nombre'];?>" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail" class="col-sm-5 col-form-label ml-2">Email</label>
				    <div class="col-sm-8">
				    	<input type="hidden" name="emailAnt" value="<?php echo $fila['email'];?>">
				        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="" value="<?php echo $fila['email'];?>" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword" class="col-sm-5 col-form-label ml-2">Contraseña</label>
				    <div class="col-sm-8">
				        <input type="password" class="form-control" name="contrasenia" id="inputPassword" placeholder="" aria-describedby="passwordHelpBlock" required pattern=".{4,}"
                     oninvalid="setCustomValidity('La contraseña es obligatoria y debe tener como mínimo 4 caracteres.')"
                     oninput="setCustomValidity('')">
				        <small id="passwordHelpBlock" class="form-text text-muted">
						  Ingrese su aquí su contraseña.
						</small>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="inputPassword4" class="col-sm-5 col-form-label ml-2">Nueva contraseña <i>(Opcional)</i></label>
				    <div class="col-sm-8">
				      <input type="password" class="form-control" name="nuevaContrasenia" id="inputPassword3" placeholder="" pattern=".{4,}"
                     oninvalid="setCustomValidity('La contraseña es obligatoria y debe tener como mínimo 4 caracteres.')"
                     oninput="setCustomValidity('')" onkeyup="habilita()">
				    </div>
				  </div>


				  <div class="form-group row">
				    <label for="inputPassword4" class="col-sm-5 col-form-label ml-2">Confirmar nueva contraseña</label>
				    <div class="col-sm-8">
				      <input type="password" class="form-control" name="reContrasenia" id="inputPassword2" placeholder="" pattern=".{4,}"
                     oninvalid="setCustomValidity('Escriba la nueva contraseña.')"
                     oninput="setCustomValidity('')" disabled="true">
				    </div>
				  </div>	  

					

				  <div class="form-group row" style="display: inline-block;">
					    <div class="col-sm-12">
					    	<label for="inputTarjeta" class="col-form-label">Tarjeta de credito</label>
					    	<input type="hidden" name="tarjetaAnt" value="<?php echo $fila['tarjeta_credito'];?>">
					        <input type="number" id="inputTarjeta" name="tarjeta" class="form-control" placeholder="" required value="<?php echo $fila['tarjeta_credito'];?>">
					    </div>
				  </div>

				  <div class="form-group row" style="display: inline-block;">
					    <div class="col-sm-9">
				    	   	<label for="inputSeguro" class="col-form-label">N° de seguridad</label>
				    	   	<input type="hidden" name="seguridadAnt" value="<?php echo $fila['numero_seguridad'];?>">
				    	    <input style="width: 100px;" id="inputSeguro" name="seguro" type="number" class="form-control" placeholder="" value="<?php echo $fila['numero_seguridad'];?>" required>
				    	</div>		    
				  </div>	 
				  <br>
				  
				  <div class="modal-footer">
						<input type="hidden" name="id" value="<?php echo $id ;?>">
						<a href="index.php"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"></a>
						<input type="submit" name="btn" class="btn btn-info" value="Guardar">
					</div>
				</form>
		</div>
	</div>
</div>

<?php 

if($enviado){


	include("validarRegistro.php");
	$verificar = true;
	$cambio = false;
	$nuevaContrasenia=null;

	$apellido = $_POST['apellido'];

	$nombre = $_POST['nombre'];

	$email = $_POST['email'];

	$contrasenia = $_POST['contrasenia'];
	if (!empty($_POST['nuevaContrasenia'])) {
		$nuevaContrasenia = $_POST['nuevaContrasenia'];
	}
	if (!empty($_POST['reContrasenia'])) {
		$reContrasenia = $_POST['reContrasenia'];
	}
	


	if ($contraseniaAnt == $contrasenia) {//si la contraseña es correcta
		

			if ($nuevaContrasenia !==null) {//si cambio la contraseña
				

				if(!validarContrasenia($nuevaContrasenia)){
					echo "<script>alert('ERROR!. La nueva contraseña debe tener como minimo 4 caracteres.')</script>";
					$verificar = false;
					
				}
				else if($nuevaContrasenia!==$reContrasenia){	
					echo "<script>alert('ERROR!. La nueva contraseña no coincide con la confirmación de la contraseña.')</script>";
					$verificar = false;
					
				}	
				if ($verificar) {
					$cambio = true;
				}
			}

			
			$tarjeta = $_POST['tarjeta'];
			
			$seguridad = $_POST['seguro'];

			if(!validarLetras($apellido)){//si puso algun numero o simbolo en apellido
				echo "<script>alert('ERROR!. El apellido debe contener solo letras.')</script>";
				$verificar = false;
			}
			else if(!validarLetras($nombre)){//si puso algun numero o simbolo en nombre
				echo "<script>alert('ERROR!. El nombre debe contener solo letras.')</script>";
				$verificar = false;
			}
			else if(!validaEmail($email)){
				echo "<script>alert('ERROR!. El email ingresado no es valido.')</script>";
				$verificar = false;
			}

			else if(!validarContrasenia($contrasenia)){
				echo "<script>alert('ERROR!. La contraseña debe tener como minimo 4 caracteres.')</script>";
				$verificar = false;
			}
			
			else if(!validarTarjeta($tarjeta)){	
				echo "<script>alert('ERROR!. El número de tarjeta debe tener 16 digitos.')</script>";
				$verificar = false;
			}	
			else if(!validarNSeguridad($seguridad)){	
				echo "<script>alert('ERROR!. El número de seguridad debe tener 3 digitos.')</script>";
				$verificar = false;
			}	


			if (($emailAnt != $email)&&($verificar)) {//si cambio el nombre

					$query = "SELECT COUNT(*) AS total FROM usuario WHERE email = '$email'";
					$cant = mysqli_query($conexion,$query);
					$re = mysqli_fetch_assoc($cant);
					if ($re['total'] == 0) {//no esta repetido el email

						if ($cambio) {//si cambio la contraseña
						
							if (mysqli_query($conexion,"UPDATE usuario 
														SET apellido = '$apellido', nombre = '$nombre', email = '$email', contrasenia = '$nuevaContrasenia', tarjeta_credito = $tarjeta, numero_seguridad = $seguridad 
														WHERE id = $id")){ 
								echo '<script> alert("Los datos fueron modificados exitosamente.");
										window.location = "index.php";</script>
								';
							}else{ echo '<script> alert("No se pudieron modificar los datos.");
										window.location = "editModalUser.php?id='.$id.'";</script>';
							} 
						}else{//si no cambio la contraseña

							if (mysqli_query($conexion,"UPDATE usuario 
														SET apellido = '$apellido', nombre = '$nombre', email = '$email', contrasenia ='$contrasenia', tarjeta_credito = $tarjeta, numero_seguridad = $seguridad 
														WHERE id = $id")){ 
								echo '<script> alert("Los datos fueron modificados exitosamente.");
										window.location = "index.php";</script>
								';
							}else{ echo '<script> alert("No se pudieron modificar los datos.");
										window.location = "editModalUser.php?id='.$id.'";</script>';
							} 
						}
						
					}else{echo '<script>alert("Error!. El email ingresado ya existe en el sistema, intente con otro.");
				    		window.location = "editModalUser.php?id='.$id.'";</script>';}
				
			}elseif (($email == $emailAnt)&&($verificar)) {

				if ($cambio) {//si cambio la contraseña
					
					if (mysqli_query($conexion,"UPDATE usuario 
													SET apellido ='$apellido', nombre ='$nombre', email='$email', contrasenia ='$nuevaContrasenia', tarjeta_credito = $tarjeta, numero_seguridad = $seguridad 
													WHERE id = $id")){ 
							echo '<script> alert("Los datos fueron modificados exitosamente.");
									window.location = "index.php";</script>
							';
					}else{ echo '<script> alert("No se pudieron modificar los datos.");
								window.location = "editModalUser.php?id='.$id.'";</script>';
					} 
				}else{//si no cambio la contraseña

					if (mysqli_query($conexion,"UPDATE usuario 
													SET apellido = '$apellido', nombre = '$nombre', email ='$email',
													contrasenia='$contrasenia', tarjeta_credito = $tarjeta, numero_seguridad = $seguridad 
													WHERE id = $id")){ 
							echo '<script> alert("Los datos fueron modificados exitosamente.");
									window.location = "index.php";</script>
							';
					}else{ echo '<script> alert("No se pudieron modificar los datos.");
								window.location = "editModalUser.php?id='.$id.'";</script>';
					} 
				}
			} 
	}else {
	echo '<script>alert("ERROR!. La contraseña ingresada es incorrecta.");
				    		window.location = "editModalUser.php?id='.$id.'";</script>';}

}	
?>			
		
</body>
<script>
function habilita(){
    var estadoActual = document.frm.reContrasenia;
    var estadoNuevaContrasenia = document.frm.nuevaContrasenia;
    estadoActual.disabled =false;
    estadoActual.required =true;

    if (estadoNuevaContrasenia.value ==""){
    	estadoActual.disabled =true;
    }
}
</script>

</html> 