<!DOCTYPE html>
<html style="background-image: url('images/imagenRegistro.jpg');" lang="es">
<head>
	<title>Registro</title>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 

   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 

    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<?php
		require_once("DB.php");
		$conexion = conectar();

		$enviado = false;
		$nombre=NULL; 
		$apellido=NULL;
		$email=NULL;
		$tarjeta=NULL;
		$seguro=NULL;

		if (isset($_POST['btn'])) {
			$enviado=true;
			$nombre=$_POST['inputNombre']; 
			$apellido=$_POST['inputApellido'];
			$email=$_POST['inputEmail'];
			$contrasenia=$_POST['inputPassword'];
			$reContrasenia=$_POST['inputPassword2'];
			$tarjeta=$_POST['inputTarjeta'];
			$seguro=$_POST['inputSeguro'];
		}

		
	?>   
<body style="background-image: url('images/imagenRegistro.jpg');">
<nav style="background-image: url('images/imagenRegistro.jpg');" class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="home.php">
    <img src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    Home Switch Home
  </a>
	<a href="login.php"><button style="color: white; text-shadow: 1px 1px black" class="btn btn-outline-primary my-2 my-sm-0" type="submit">Iniciar Sesión</button></a>
</nav>
<div style="background-image: url('images/imagenRegistro.jpg');" class="container-fluid">
	<div class="">
				<h4 class="m-3">Registro</h4>
			</div>
	<div class="row">
		<div class="col-3"></div>
		<div class="d-flex justify-content-center">
			
			<form class="ml-5" name="frm" method="post" action="">
				  <div class="form-group row">
				    <label for="inputApellido" class="col-sm-5 col-form-label ml-2">Apellido</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="inputApellido" id="inputApellido" placeholder="Escribá aquí su apellido" value="<?php echo $apellido;?>" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputNombre" class="col-sm-5 col-form-label ml-2">Nombre</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" name="inputNombre" id="inputNombre" placeholder="Escribá aquí su nombre" value="<?php echo $nombre;?>" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail" class="col-sm-5 col-form-label ml-2">Email</label>
				    <div class="col-sm-8">
				      <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="" value="<?php echo $email;?>" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword" class="col-sm-5 col-form-label ml-2">Contraseña</label>
				    <div class="col-sm-8">
				      <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="" aria-describedby="passwordHelpBlock" required pattern=".{4,}"
                     oninvalid="setCustomValidity('La contraseña es obligatoria y debe tener como mínimo 4 caracteres')"
                     oninput="setCustomValidity('')">
				      <small id="passwordHelpBlock" class="form-text text-muted">
						  Su contraseña debe contener un mínimo de 4 caracteres.
						</small>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label style="color: white; text-shadow: 1px 1px black" for="inputPassword4" class="col-sm-5 col-form-label ml-2">Confirmar contraseña</label>
				    <div class="col-sm-8">
				      <input type="password" class="form-control" name="inputPassword2" id="inputPassword2" placeholder="" required pattern=".{4,}"
                     oninvalid="setCustomValidity('La contraseña es obligatoria y debe tener como mínimo 4 caracteres')"
                     oninput="setCustomValidity('')">
				    </div>
				  </div>	  

					

				  <div class="form-group row" style="display: inline-block;">
					    <div class="col-sm-12">
					    	<label for="inputTarjeta" style="color: white; text-shadow: 1px 1px black" class="col-form-label">Tarjeta de credito</label>
					        <input type="number" id="inputTarjeta" name="inputTarjeta" class="form-control" placeholder="" required value="<?php echo $tarjeta;?>">
					    </div>
				  </div>
				  <div class="form-group row" style="display: inline-block;">
					    <div class="col-sm-9">
				    	   	<label for="inputSeguro" style="color: white; text-shadow: 1px 1px black" class="col-form-label">N° de seguridad</label>
				    	    <input style="width: 100px;" id="inputSeguro" name="inputSeguro" type="number" class="form-control" placeholder="" value="<?php echo $seguro;?>" required>
				    	</div>		    
				  </div>	 
				  <br>
				  <div class="form-group row">
				    <div class="col-sm-10">
				      <button type="submit" name="btn" class="btn btn-primary">Crear Cuenta</button>
				    </div>
				  </div>
				</form>
		</div>
		</div>
	</div>


</div>

<?php  

		if($enviado){
			
			include("validarRegistro.php");
			$verificar = true;

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
			else if($contrasenia!=$reContrasenia){	
				echo "<script>alert('ERROR!. Las contraseñas no coinciden.')</script>";
				$verificar = false;
			}	
			else if(!validarTarjeta($tarjeta)){	
				echo "<script>alert('ERROR!. El número de tarjeta debe tener 16 digitos.')</script>";
				$verificar = false;
			}	
			else if(!validarNSeguridad($seguro)){	
				echo "<script>alert('ERROR!. El número de seguridad debe tener 3 digitos.')</script>";
				$verificar = false;
			}	
			
			if ($verificar) {
			
				$verificar=mysqli_query($conexion,"SELECT email FROM usuario WHERE email='".$email."'"); 
				//Pregunta si hay algun email
				if(mysqli_num_rows($verificar)!=0){
					echo  "<script>alert('¡El email ingresado ya existe en el sistema!, intente con otro.');</script>";
				}
				else{
					//Si no esta ese email en la BDD, lo agrega
					//se inserta el nuevo registro pero el usuario aun no tiene validada su cuenta
					$query="INSERT INTO usuario (id,email,apellido,nombre,contrasenia,suscripto,tarjeta_credito,numero_seguridad,actualizar,valido) VALUES (null,'$email','$apellido','$nombre','$contrasenia','no',$tarjeta,$seguro,'no','no')";
					mysqli_query($conexion,$query);
					echo "<script>alert('Sus datos fueron registrados correctamente. Cuando el equipo de Home Switch Home valide sus datos, podra usar su cuenta.');
						window.location = 'home.php';</script>";
				}//termina de insertar en la bdd a el nuevo usuario
			}
	    }///termina aca lo que hace cuando aprietan el boton de registrar 
?>
</body>	
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>