<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('PRO').'class.proyectos.inc.php';

	$error = '';
	if (empty($_REQUEST['Id']))
		$error = 'Error al acceder a la página.';
	elseif (empty($_REQUEST['confirmado']))
		$error = 'Debe confirmar la eliminación del proyecto.';

	if (!empty ($error)){
		$oSmarty->assign ('stTITLE'  , 'Borrar un proyecto');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oProyecto = new clsProyectos();
	foreach ($IDs as $id){
		if (!$oProyecto->findId($id)){
			$oSmarty->assign ('stTITLE'  , 'Borrar un proyecto');
			$oSmarty->assign ('stMESSAGE', $oProyecto->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oProyecto->Borrar(getLocal('FPR'))){
			$oSmarty->assign ('stTITLE'  , 'Borrar un proyecto');
			$oSmarty->assign ('stMESSAGE', $oProyecto->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('PRO').'pro.listar.php');
?>