<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CAT').'class.categorias.inc.php';

	$error = '';
	if (empty($_REQUEST['Id'])){
		$error = 'Error al acceder a la página.';
	}
	elseif (empty($_REQUEST['confirmado'])){
		$error = 'Debe confirmar la eliminación de la categoría.';
	}
	if (!empty ($error)){
		$oSmarty->assign ('stTITLE', 'Borrar una categoría');
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	$oCategoria = new clsCategorias();
	foreach ($IDs as $id){
		if (!$oCategoria->findId($id)){
			$oSmarty->assign ('stTITLE', 'Borrar una categoría');
			$oSmarty->assign ('stMESSAGE', $oCategoria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oCategoria->Borrar()){
			$oSmarty->assign ('stTITLE', 'Borrar una categoría');
			$oSmarty->assign ('stMESSAGE', $oCategoria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('CAT').'cat.listar.php');
?>