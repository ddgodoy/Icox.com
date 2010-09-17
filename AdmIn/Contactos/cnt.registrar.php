<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CNT').'class.contactos.inc.php';

	$stFECHA    = date('d/m/Y');
	$stNOMBRE   = '';
	$stEMAIL    = '';
	$stTELEFONO = '';
	$stPAIS     = '';
	$stCIUDAD   = '';
	$stDIRECCION= '';
	$stCONSULTA = '';
	$stERROR    = '';

	if (isset($_POST['btn_accion'])){
		$stFECHA    = $_POST['fecha'];
		$stNOMBRE   = $_POST['nombre'];
		$stEMAIL    = $_POST['email'];
		$stTELEFONO = $_POST['telefono'];
		$stPAIS     = $_POST['pais'];
		$stCIUDAD   = $_POST['ciudad'];
		$stDIRECCION= $_POST['direccion'];
		$stCONSULTA = $_POST['consulta'];

		$oContacto = new clsContactos();
		$oContacto->clearErrores();

		$oContacto->setFecha    ($stFECHA);
		$oContacto->setNombre   ($stNOMBRE);
		$oContacto->setEmail    ($stEMAIL);
		$oContacto->setTelefono ($stTELEFONO);
		$oContacto->setPais     ($stPAIS);
		$oContacto->setCiudad   ($stCIUDAD);
		$oContacto->setDireccion($stDIRECCION);
		$oContacto->setConsulta ($stCONSULTA);

		if (!$oContacto->hasErrores() && $oContacto->Registrar()){
			redireccionar(getWeb('CNT').'cnt.listar.php');
		}
		$stERROR = $oContacto->getErrores();
	}
	$oSmarty->assign('stERROR'    , $stERROR);
	$oSmarty->assign('stFECHA'    , $stFECHA);
	$oSmarty->assign('stNOMBRE'   , $stNOMBRE);
	$oSmarty->assign('stEMAIL'    , $stEMAIL);
	$oSmarty->assign('stTELEFONO' , $stTELEFONO);
	$oSmarty->assign('stPAIS'     , $stPAIS);
	$oSmarty->assign('stCIUDAD'   , $stCIUDAD);
	$oSmarty->assign('stDIRECCION', $stDIRECCION);
	$oSmarty->assign('stCONSULTA' , $stCONSULTA);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nuevo contacto');
	$oSmarty->assign('stBTN_ACTION', 'Nuevo');

	$oSmarty->display('cnt.registrar.tpl.html');
?>