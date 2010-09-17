<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('SUB').'class.subcategorias.inc.php';

	$error = '';
	if (empty($_REQUEST['Id'])){
		$error = 'Error al acceder a la página.';
	}
	elseif (empty($_REQUEST['confirmado'])){
		$error = 'Debe confirmar la eliminación de la subcategoria.';
	}
	if (!empty ($error)){
		$oSmarty->assign ('stTITLE', 'Borrar una subcategoria');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oSubcategoria = new clsSubcategorias();
	foreach ($IDs as $id){
		if (!$oSubcategoria->findId($id)){
			$oSmarty->assign ('stTITLE', 'Borrar una subcategoria');
			$oSmarty->assign ('stMESSAGE', $oSubcategoria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oSubcategoria->Borrar()){
			$oSmarty->assign ('stTITLE', 'Borrar una subcategoria');
			$oSmarty->assign ('stMESSAGE', $oSubcategoria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('SUB').'sub.listar.php');
?>