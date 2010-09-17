<?php
	include_once '../cOmmOns/config.inc.php';
	require_once getLocal('CLIENTE').'menu.inc.php';
	
	$oSmarty->assign('stNOMBRE_CLIENTE', $_SESSION['_clienteNombre']);

	$oSmarty->display('cliente.contenido.tpl.html');
?>