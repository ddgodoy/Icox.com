<?php
	require_once getLocal('COMMONS').'func.html.inc.php';
	noCache();

	if (!isset($_SESSION['_admId'])){redireccionar(getWeb('ADMIN').'index.php');}
?>