<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('IND').'class.industrias.inc.php';

	$error = '';
	if (empty($_REQUEST['Id'])){
		$error = 'Error al acceder a la página.';
	}
	elseif (empty($_REQUEST['confirmado'])){
		$error = 'Debe confirmar la eliminación de la industria.';
	}
	if (!empty ($error)){
		$oSmarty->assign ('stTITLE', 'Borrar una industria');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oIndustria = new clsIndustrias();
	foreach ($IDs as $id){
		if (!$oIndustria->findId($id)){
			$oSmarty->assign ('stTITLE', 'Borrar una industria');
			$oSmarty->assign ('stMESSAGE', $oIndustria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oIndustria->Borrar()){
			$oSmarty->assign ('stTITLE', 'Borrar una industria');
			$oSmarty->assign ('stMESSAGE', $oIndustria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('IND').'ind.listar.php');
?>