<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('ADM').'class.administrador.inc.php';

	$error = '';
	if (empty($_REQUEST['Id']))
		$error = 'Error al acceder a la página.';
	elseif (empty($_REQUEST['confirmado']))
		$error = 'Debe confirmar la eliminación del administrador.';

	if (!empty ($error)){
		$oSmarty->assign('stTITLE'  , 'Borrar administrador');
		$oSmarty->assign('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oAdministrador = new clsAdministrador();
	foreach ($IDs as $id){	
		if (!$oAdministrador->findId($id)){
			$oSmarty->assign ('stTITLE'  , 'Borrar administrador');
			$oSmarty->assign ('stMESSAGE', $oAdministrador->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if ($oAdministrador->Login != SUPER_ADMIN){
			if (!$oAdministrador->Borrar()){
				$oSmarty->assign ('stTITLE'  , 'Borrar administrador');
				$oSmarty->assign ('stMESSAGE', $oAdministrador->getErrores());
				$oSmarty->display('information.tpl.html');
				exit();
			}
		}
	}
	redireccionar(getWeb('ADM').'adm.listar.php');
?>