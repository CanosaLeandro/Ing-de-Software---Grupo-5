function validarLogin(){
	
	var nombre = document.getElementById("userLogin").value;
	var contrasenia = document.getElementById("passLogin").value;
	var verificar = true;

	if (nombre=="") {
		verificar = false;
	}
	if(contrasenia==""){
		verificar = false;
	}
    if(verificar){
		document.frm.action='validarLogin.php?user='+nombre+'&pass='+contrasenia;
		document.frm.submit();
    }else{ alert("Complete ambos campos por favor.");
    		window.location.href='login.php';
    }
}




		






