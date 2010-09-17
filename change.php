<?php
	require_once 'cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	$stLANGUAGE = !empty($_GET['language'])?$_GET['language']:'';
	$_SESSION['_front_idioma'] = $stLANGUAGE;

	redireccionar('index.php');
?>