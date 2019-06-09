<?php
class Authentication {	

	function login(){
		if(session_status() == PHP_SESSION_NONE){//Compruebe si la sesión comenzó
			session_start();
		}
	}

	function logout(){		
		session_unset();
		session_destroy();
		header('Location:home.php');
	}
	
	
	function logueado(){//verifica si esta logueado
		if(!isset($_SESSION['id'])){//Si no tiene la sesion iniciada
			$error = "ERROR!. Usted no a iniciado sesión.";
			throw new Exception($error);	
		}
	}


	function siLogueado(){//Si ya tiene la sesion iniciada
		if(session_status() == PHP_SESSION_NONE){//Compruebe si la sesión comenzó
			session_start();
		}
		if (isset($_SESSION["id"])) { 
			return true;	
		}else return false;
	}


	public function autenticar($user, $pass, $link){		
		if ((!$user=="")AND(!$pass=="")) {
			$str = "SELECT * FROM usuario WHERE email='".$user."' AND '".$pass."' = contrasenia";		
			$result = mysqli_query($link,$str);
			$numrows=mysqli_num_rows($result);
			if($numrows!=0){
				$row=mysqli_fetch_array($result);
				$_SESSION['id']=$row['id'];
				echo'<script>alert("¡Bienvenido a Home Switch Home!")</script>';
				echo'<script>window.location.href="index.php";</script>';
			}
			else{
				$error = 'ERROR!. Los datos ingresados no estan registrados en el sistema, por favor verifiqué que ingreso bien sus datos.';
				throw new Exception($error);	
			}
		}
		else{
			throw new Exception('<script>alert("¡Error al ingresar a su cuenta!")</script>');
			header('Location:login.php');
		}			
	}
}
?>