<?php
	require_once getLocal('CLIENTE').'sesion_cliente.inc.php';

	$contenido[] = array('Desc'=>'Mis datos', 'Link'=>getWeb('USU').'perfil.php');
	$contenido[] = array('Desc'=>'Dominios', 'Link'=>getWeb('DMI').'cliente.listar.php');

	$oSmarty->assign('stCLIENTE_ID' , $_SESSION['_clienteId']);
	$oSmarty->assign('stCONTENIDO', $contenido);
?>