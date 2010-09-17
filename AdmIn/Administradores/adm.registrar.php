<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('ADM').'class.administrador.inc.php';

	$stLOGIN   = '';
	$stNOMBRE  = '';
	$stAPELLIDO= '';
	$stEMAIL   = '';
	$stENABLED = 'CHECKED';
	$stFECNAC  = '01/01/1980';
	$stERROR   = '';

	if (isset($_POST['btn_accion'])){
		$stNOMBRE  = $_POST['nombre'];
		$stAPELLIDO= $_POST['apellido'];
		$stLOGIN   = $_POST['login'];
		$stEMAIL   = $_POST['email'];
		$stFECNAC  = $_POST['fecnac'];
		$stENABLED = isset($_POST['enabled'])?'S':'N';

		$password  = $_POST['password'];
		$confirma  = $_POST['confirma'];

		$oAdmin = new clsAdministrador();
		$oAdmin->clearErrores();

		$oAdmin->setNombre  ($stNOMBRE);
		$oAdmin->setApellido($stAPELLIDO);
		$oAdmin->setLogin   ($stLOGIN);
		$oAdmin->setEnabled ($stENABLED);
		$oAdmin->setFecnac  ($stFECNAC);
		$oAdmin->setEmail   ($stEMAIL);
		$oAdmin->setRoot    (0);

		$oAdmin->setPassword($password);
		$oAdmin->setConfirma($confirma);

		if (!$oAdmin->hasErrores() && $oAdmin->Registrar()){
			redireccionar(getWeb('ADM').'adm.listar.php');
		}
		$stERROR = $oAdmin->getErrores();
		$stENABLED = isset($_POST['enabled'])?'CHECKED':'';
	}
	$oSmarty->assign('stERROR'   , $stERROR);
	$oSmarty->assign('stNOMBRE'  , $stNOMBRE);
	$oSmarty->assign('stAPELLIDO', $stAPELLIDO);
	$oSmarty->assign('stLOGIN'   , $stLOGIN);
	$oSmarty->assign('stEMAIL'   , $stEMAIL);
	$oSmarty->assign('stFECNAC'  , $stFECNAC);
	$oSmarty->assign('stENABLED' , $stENABLED);

	$oSmarty->assign('stBTN_ACTION', 'Nuevo');
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nuevo administrador');

	$oSmarty->display('adm.registrar.tpl.html');
?>