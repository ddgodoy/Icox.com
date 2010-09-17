<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('DMI').'class.dominios.inc.php';

	$error = '';
	if (empty($_REQUEST['Id'])){
		$error = 'Error al acceder a la pagina.';
	}
	elseif (empty($_REQUEST['confirmado'])){
		$error = 'Debe confirmar la eliminacion del dominio.';
	}
	if (!empty ($error)){
		$oSmarty->assign ('stTITLE', 'Borrar un dominio');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oDominio = new clsDominios();

	foreach ($IDs as $id){
		if (!$oDominio->findId($id)){
			$oSmarty->assign ('stTITLE', 'Borrar un dominio');
			$oSmarty->assign ('stMESSAGE', $oDominio->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oDominio->Borrar()){
			$oSmarty->assign ('stTITLE', 'Borrar un dominio');
			$oSmarty->assign ('stMESSAGE', $oDominio->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('DMI').'listar.php');
?>