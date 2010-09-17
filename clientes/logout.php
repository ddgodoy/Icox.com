<?php
	include_once '../cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	if (isset($_SESSION['_clienteId'])){$_SESSION = array();}

	session_destroy();
	redireccionar(getWeb('CLIENTE').'sesion.php');
?>