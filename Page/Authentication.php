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

	function logoutAdmin(){		
		session_unset();
		session_destroy();
		header('Location:loginAdmin.php');
	}
	
	
	function logueado(){//verifica si esta logueado
		if(!isset($_SESSION['id'])){//Si no tiene la sesion iniciada
			$error = "ERROR!. Usted no a iniciado sesión.";
			throw new Exception($error);	
		}
	}

	function logueadoAdmin(){//verifica si esta logueado
		if(!isset($_SESSION['idAdmin'])){//Si no tiene la sesion iniciada
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

	function siLogueadoAdmin(){//Si ya tiene la sesion iniciada
		if(session_status() == PHP_SESSION_NONE){//Compruebe si la sesión comenzó
			session_start();
		}
		if (isset($_SESSION["idAdmin"])) { 
			return true;	
		}else return false;
	}

	public function autenticarAdmin($user, $pass, $link){		
		if ((!$user=="")AND(!$pass=="")) {

			$str = "SELECT * FROM administrador WHERE usuario= '$user'";
			$result = mysqli_query($link,$str);
			$numrows=mysqli_num_rows($result);
			if($numrows!=0){

				$str = "SELECT * FROM administrador WHERE usuario='".$user."' AND '".$pass."' = contrasenia";		
				$result = mysqli_query($link,$str);
				$numrows=mysqli_num_rows($result);
				if($numrows!=0){
					$row=mysqli_fetch_array($result);
					$_SESSION['idAdmin']=$row['id'];
					echo'<script>alert("¡Bienvenido a la administración de Home Switch Home!")</script>';
					echo'<script>window.location.href="crudResidencia.php";</script>';
				}
				else{
					$error = 'ERROR!. Contraseña incorrecta, por favor verifiqué que ingreso bien la contraseña.';
					throw new Exception($error);	
				}
			}else{
				echo'<script>alert("ERROR!. El correo electronico '.$user.', no existe en el sistema, por favor verifiqué que ingreso bien sus datos.")</script>';
				echo'<script>window.location.href="loginAdmin.php";</script>';
			}

			
		}
		else{
			throw new Exception('<script>alert("¡Error al ingresar a su cuenta!")</script>');
			header('Location:loginAdmin.php');
		}			
	}


	public function autenticar($user, $pass, $link, $cookie){		
		if ((!$user=="")AND(!$pass=="")) {

			$str = "SELECT * FROM usuario WHERE email= '$user'";
			$result = mysqli_query($link,$str);
			$numrows=mysqli_num_rows($result);
			if($numrows!=0){
				//verifico que el usuario tenga la cuenta habilitado
				$queryHabilitado="SELECT * FROM usuario WHERE email='".$user."' AND '".$pass."' = contrasenia";
				$resultadoHabilitado = mysqli_query($link,$queryHabilitado);
				$registro=mysqli_fetch_array($resultadoHabilitado);
				$valido=$registro['valido'];
				if ($valido=='si') {//si esta habilitado
				
					$str = "SELECT * FROM usuario WHERE email='".$user."' AND '".$pass."' = contrasenia";		
					$result = mysqli_query($link,$str);
					$numrows=mysqli_num_rows($result);
					if($numrows!=0){
						$row=mysqli_fetch_array($result);
						$_SESSION['id']=$row['id'];
						if ($cookie) {
							//se crea la cookie
							setcookie("recordarUser", $user, time() + (60 * 60 * 24 * 7)); 
							setcookie("recordarPass", $pass, time() + (60 * 60 * 24 * 7));
						}
						echo'<script>alert("¡Bienvenido a Home Switch Home!")</script>';
						echo'<script>window.location.href="index.php";</script>';
					}
					else{
						$error = 'ERROR!. Contraseña incorrecta, por favor verifiqué que ingreso bien la contraseña.';
						throw new Exception($error);	
					}
				}else{echo'<script>alert("Error, usted aún no tiene habilitada su cuenta. Intente en otro momento.")</script>';
						echo'<script>window.location.href="home.php";</script>';}
			}else{
				echo'<script>alert("ERROR!. El correo electronico '.$user.', no existe en el sistema, por favor verifiqué que ingreso bien sus datos.")</script>';
				echo'<script>window.location.href="login.php";</script>';
			}

			
		}
		else{
			throw new Exception('<script>alert("¡Error al ingresar a su cuenta!")</script>');
			header('Location:login.php');
		}			
	}
}
?>