<?php
	require_once getLocal('COMMONS').'func.html.inc.php';
	noCache();

	if (!isset($_SESSION['_clienteId'])){redireccionar(getWeb('CLIENTE').'index.php');}
?>