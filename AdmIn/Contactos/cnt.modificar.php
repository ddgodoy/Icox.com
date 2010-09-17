<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CNT').'class.contactos.inc.php';

	$stID = $_GET['Id'];

	$oContacto = new clsContactos();
	$oContacto->clearErrores();

	if (!$oContacto->findId($stID)){
		$oSmarty->assign ('stTITLE'  , 'Contacto');
		$oSmarty->assign ('stMESSAGE', $oContacto->getErrores());
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$stFECHA    = $oContacto->getFecha();
	$stNOMBRE   = $oContacto->getNombre();
	$stEMAIL    = $oContacto->getEmail();
	$stTELEFONO = $oContacto->getTelefono();
	$stPAIS     = $oContacto->getPais();
	$stCIUDAD   = $oContacto->getCiudad();
	$stDIRECCION= $oContacto->getDireccion();
	$stCONSULTA = $oContacto->getConsulta();
	
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stFECHA'    , $stFECHA);
	$oSmarty->assign('stNOMBRE'   , $stNOMBRE);
	$oSmarty->assign('stEMAIL'    , $stEMAIL);
	$oSmarty->assign('stTELEFONO' , $stTELEFONO);
	$oSmarty->assign('stPAIS'     , $stPAIS);
	$oSmarty->assign('stCIUDAD'   , $stCIUDAD);
	$oSmarty->assign('stDIRECCION', $stDIRECCION);
	$oSmarty->assign('stCONSULTA' , $stCONSULTA);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Contacto');
	$oSmarty->assign('stBTN_ACTION', 'Detalle');
	
	$oSmarty->display('cnt.registrar.tpl.html');
?>