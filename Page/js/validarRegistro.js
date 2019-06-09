function validarRegistro(){

	var nombre = document.getElementById("inputNombre").value;
	var apellido = document.getElementById("inputApellido").value;
	var email = document.getElementById("inputEmail").value;
	var contrasenia = document.getElementById("inputPassword").value;
	var reContrasenia = document.getElementById("inputRePassword2").value;	

	var verificar = true;

	//Validacion del nombre
	if(!soloLetras(nombre)){
		alert('[ERROR] El nombre debe ser escrito solo con letras.');
		verificar = false;
	}

	//Validacion del apellido
	else if (!soloLetras(apellido)){
		alert("[ERROR] El Apellido debe ser escrito solo con letras.");
		return false;
	}

	//Validacion del email
	else if (!validarEmail(email)){
		alert("[ERROR] El email ingresado no es valido.");
		verificar = false;
	}

	//Validacion de la contraseña
	else if(contrasenia.length<4){
			alert('[ERROR] La contraseña debe tener por lo menos 4 caracteres.');
			return false;
	}

	//Valido que las claves coincidan 
	else if (!(contrasenia==reContrasenia)){
			alert('[ERROR] Las claves no coinciden.');
			verificar = false;
	}

	return verificar;

	//-------------------------------------------------------------
}


		



function soloLetras(cadenaAhora){
	var filter6=/^[A-Za-z\_\-\.\s\xF1\xD1]+$/;

	if (filter6.test(cadenaAhora)){
		return true;
	}
	else{
		return false;
	}	
}


function validarEmail(clave){
	var nCaracter = 0;
	var t3 = "@";
	var cla=clave.length;
	for (i=0;i<clave.length;i++) {
		if ( t3.indexOf(clave.charAt(i)) != -1 ) 
			nCaracter++;
	}
	if ( nCaracter==0 ) 
	{
		return false;	
	}
	else return true;
}







