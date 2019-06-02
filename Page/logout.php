<?php
	require_once('Authentication.php');
	$authentication = new Authentication();	
	$authentication->login();						
	$authentication->logout();
?>