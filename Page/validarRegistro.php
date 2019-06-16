<?php

   function validarLetras($pass){
      
   	$permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
   	for ($i=0; $i<strlen($pass); $i++){ 
         if (strpos($permitidos, substr($pass,$i,1))===false){ 
            return false; 
         } 
   	}
   	return true;
   }


   function validaEmail($email){

       if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE){
         return false;
   	}
   	else{
         return true;
      }
   }


   function validarContrasenia($clave){

   	if(strlen($clave) < 4){
         return false;
      }else return true;
      
   }


   function validarTarjeta($tarjeta){

      if(strlen($tarjeta) == 16){
         return true;
      }else return false;
      
   }

   function validarNSeguridad($numero){

      if(strlen($numero) == 3){
         return true;
      }else return false;
      
   }

?>