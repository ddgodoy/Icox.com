<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('IMG').'class.imagenes.inc.php';

	$oImagenes = new clsImagenes();
	
	if (!empty($_REQUEST['codigo'])){
		$stCODIGO = $_REQUEST['codigo'];
	} else {
		$oSmarty->assign ('stTITLE'  , 'Galería de imágenes');
		$oSmarty->assign ('stMESSAGE', 'No puede ingresar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$error = '';
	if (empty($_REQUEST['Id']))
		$error = 'Error al acceder a la página.';
	elseif (empty($_REQUEST['confirmado']))
		$error = 'Debe confirmar la eliminación de la imagen.';
	
	if (!empty($error)){
		$oSmarty->assign ('stMESSAGE', $error);
		$oSmarty->assign ('stTITLE'  , 'Borrar una imagen');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$IDs = is_array($_REQUEST['Id'])?$_REQUEST['Id']:array($_REQUEST['Id']);

	foreach ($IDs as $id){
		if (!$oImagenes->findId($id)){
			$oSmarty->assign ('stTITLE'  , 'Borrar una imagen');
			$oSmarty->assign ('stMESSAGE', $oImagenes->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		if (!$oImagenes->Borrar(getLocal('FPR'))){
			$oSmarty->assign ('stTITLE'  , 'Borrar una imagen');
			$oSmarty->assign ('stMESSAGE', $oImagenes->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
	}
	redireccionar(getWeb('IMG')."img.listar.php?codigo=$stCODIGO");
?>