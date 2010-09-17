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
		$oSmarty->display('information_pop.tpl.html');
		exit();
	}
	$stBANDERA = false;
	$stIMAGEN = '';
	$stERROR = '';

	if (isset($_POST['btn_accion'])){
		$stIMAGEN = $_FILES['imagen'];

		$oImagenes->clearErrores();

		$oImagenes->setCarga   (date('Y-m-d H:i:s'));
		$oImagenes->setProyecto($stCODIGO);
		$oImagenes->setImagen  ($stIMAGEN, getLocal('FPR'));

		if (!$oImagenes->hasErrores() && $oImagenes->Registrar()){
			$stBANDERA = true;
		} else {
			$stIMAGEN = '';
			$stERROR = $oImagenes->getErrores();
		}
	}
	$oSmarty->assign('stERROR'  , $stERROR);
	$oSmarty->assign('stCODIGO' , $stCODIGO);
	$oSmarty->assign('stIMAGEN' , $stIMAGEN);
	$oSmarty->assign('stTITULO' , $stTITULO);
	$oSmarty->assign('stBANDERA', $stBANDERA);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nueva imagen');
	$oSmarty->assign('stBTN_ACTION', 'Nueva');

	$oSmarty->display('img.registrar_pop.tpl.html');
?>