<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CLI').'class.clientes.inc.php';

	$error = '';
	if (empty($_REQUEST['Id'])){
		$error = 'Error al acceder a la pagina.';
	}
	elseif (empty($_REQUEST['confirmado'])){
		$error = 'Debe confirmar la eliminacion del cliente.';
	}
	if (!empty ($error)){
		$oSmarty->assign ('stTITLE', 'Borrar un cliente');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oCliente = new clsClientes();
	foreach ($IDs as $id){
		if (!$oCliente->findId($id)){
			$oSmarty->assign ('stTITLE', 'Borrar un cliente');
			$oSmarty->assign ('stMESSAGE', $oCliente->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oCliente->Borrar()){
			$oSmarty->assign ('stTITLE', 'Borrar un cliente');
			$oSmarty->assign ('stMESSAGE', $oCliente->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('CLI').'cli.listar.php');
?>