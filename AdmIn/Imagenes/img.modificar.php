<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('IMG').'class.imagenes.inc.php';

	$oImagenes = new clsImagenes();

	if (!empty($_REQUEST['codigo'])){
		$stCODIGO = $_REQUEST['codigo'];
		$stTITULO = $oImagenes->getTitulo($stCODIGO);
	} else {
		$oSmarty->assign ('stTITLE'  , 'Galería de imágenes');
		$oSmarty->assign ('stMESSAGE', 'No puede ingresar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$stID = 0;
	$stIMAGEN = '';
	$stERROR = '';

	if (isset($_POST['btn_accion'])){
		$stID = $_POST['id'];
		$stIMAGEN = $_FILES['imagen'];

		$oImagenes->clearErrores();
		if ($oImagenes->findId($stID)){
			$oImagenes->setProyecto($stCODIGO);

			if (!empty($stIMAGEN['tmp_name'])){
				$oImagenes->setImagen($stIMAGEN, getLocal('FPR'), $oImagenes->Imagen);
			}
			if (!$oImagenes->hasErrores() && $oImagenes->Modificar()){
				redireccionar(getWeb('IMG')."img.listar.php?codigo=$stCODIGO");
			}
		}
		$stIMAGEN = getWeb('FPR').$oImagenes->Imagen;
		$stERROR = $oImagenes->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oImagenes->clearErrores();
		if (!$oImagenes->findId($stID)){
			$oSmarty->assign ('stTITLE'  , 'Modificar imagen');
			$oSmarty->assign ('stMESSAGE', $oImagenes->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stIMAGEN = getWeb('FPR').$oImagenes->Imagen;
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar imagen');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stCODIGO', $stCODIGO);
	$oSmarty->assign('stIMAGEN', $stIMAGEN);
	$oSmarty->assign('stTITULO', $stTITULO);
	
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar galería');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');
	
	$oSmarty->display('img.registrar.tpl.html');
?>