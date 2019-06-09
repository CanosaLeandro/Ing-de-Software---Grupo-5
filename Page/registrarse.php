<!DOCTYPE html>
<html lang="es">
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

		if(isset($_POST['btn'])){
			include("validarRegistro.php");
			
			$nombre=$_POST['inputNombre']; 
			$apellido=$_POST['inputApellido'];
			$email=$_POST['inputEmail'];
			$contrasenia=$_POST['inputPassword'];
			$reContrasenia=$_POST['inputPassword2'];
			$tarjeta=$_POST['inputTarjeta'];

			if(!validarLetras($apellido)){
				header('Location: registrarse.php'); 
			}
			else if(!validarLetras($nombre)){
				header('Location: registrarse.php'); 
			}
			else if(!validaEmail($email)){
				header('Location: registrarse.php'); 
			}
			else if(!validarContrasenia($contraseña)){
				header('Location: registrarse.php'); 
			}
			else if($contrasenia!=$reContrasenia){	
				header('Location: registrarse.php'); 
			}	
			

			$verificar=mysqli_query($conexion,"SELECT email FROM usuario WHERE email='".$email."'"); 
			//Pregunta si hay algun email
			if(mysqli_num_rows($verificar)!=0){
				echo  "<script>alert('¡El email ingresado ya existe en el sistema!, intente con otro.');
					window.location = 'registrarse.php';</script>";
			}
			else{
				//Si no esta ese email en la BDD, lo agrega
				$query="INSERT INTO usuario (id,email,apellido,nombre,contrasenia,suscripto,tarjeta_credito) VALUES (null,'$email','$apellido','$nombre','$contrasenia','no','$tarjeta')"; 	
				mysqli_query($conexion,$query);
				echo "<script>alert('Su cuenta fue creada correctamente!.');
					window.location = 'login.php';</script>";
			}//termina de insertar en la bdd a el nuevo usuario
	    }///termina aca lo que hace cuando aprietan el boton de registrar 
	?>   
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">
    <img src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    Home Switch Home
  </a>
	<a href="login.php"><button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Iniciar Sesión</button></a>
</nav>
<div class="container-fluid">
	<div class="">
				<h4 class="m-3">Registro</h4>
			</div>
	<div class="row">
		<div class="col-4"></div>
		<div class="d-flex justify-content-center">
			<form name="frm" method="post" action="" onsubmit="return validarRegistro();">
				  <div class="form-group row">
				    <label for="inputApellido" class="col-sm-5 col-form-label ml-2">Apellido</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="inputApellido" id="inputApellido" placeholder="Escribá aquí su apellido" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputNombre" class="col-sm-5 col-form-label ml-2">Nombre</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="inputNombre" id="inputNombre" placeholder="Escribá aquí su nombre" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputEmail" class="col-sm-5 col-form-label ml-2">Email</label>
				    <div class="col-sm-10">
				      <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword" class="col-sm-5 col-form-label ml-2">Contraseña</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="" aria-describedby="passwordHelpBlock" required>
				      <small id="passwordHelpBlock" class="form-text text-muted">
						  Su contraseña debe contener un mínimo de 4 caracteres.
						</small>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword4" class="col-sm-5 col-form-label ml-2">Confirmar contraseña</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="inputPassword2" id="inputPassword2" placeholder="" required>
				    </div>
				  </div>	  
				  <div class="form-group row">
				    <label for="inputTarjeta" class="col-sm-5 col-form-label ml-2">Tarjeta de credito</label>
				    <div class="col-sm-8">
				      <input type="number" class="form-control" name="tarjeta" id="inputTarjeta" placeholder="Ingrese el número de la tarjeta aquí" required>
				    </div>
				    <label for="inputTarjeta" class="col-sm-5 col-form-label ml-2">Númweo de seguridad</label>
				    <div class="col-sm-4">
				      <input type="number" class="form-control" name="tarjeta" id="inputTarjeta" placeholder="" required>
				    </div>
				  </div>	 
				  <div class="form-group row">
				    <div class="col-sm-10">
				      <button type="submit" name="btn" class="btn btn-primary">Crear Cuenta</button>
				    </div>
				  </div>
				</form>
		<div/>
		</div>
	</div>


</div>
</body>	
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/validarRegistro.js"></script> 
</html>