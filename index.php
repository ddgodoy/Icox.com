<?php
	require_once 'cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	$_SESSION['_front_idioma'] = !empty($_SESSION['_front_idioma'])?$_SESSION['_front_idioma']:isset($_GET['es'])?'_es':'';

	redireccionar('company.php');
?>