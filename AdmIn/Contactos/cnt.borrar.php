<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CNT').'class.contactos.inc.php';

	$error = '';
	if (empty($_REQUEST['Id']))
		$error = 'Error al acceder a la página.';
	elseif (empty($_REQUEST['confirmado']))
		$error = 'Debe confirmar la eliminación del contacto.';

	if (! empty ($error)){
		$oSmarty->assign ('stTITLE'  , 'Borrar un contacto');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oContacto = new clsContactos();
	foreach ($IDs as $id){
		if (!$oContacto->findId($id)){
			$oSmarty->assign ('stTITLE'  , 'Borrar un contacto');
			$oSmarty->assign ('stMESSAGE', $oContacto->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oContacto->Borrar()){
			$oSmarty->assign ('stTITLE'  , 'Borrar un contacto');
			$oSmarty->assign ('stMESSAGE', $oContacto->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('CNT').'cnt.listar.php');
?>