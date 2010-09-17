<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('IND').'class.industrias.inc.php';

	$stNOMBRE = '';
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stNOMBRE = $_POST['nombre'];

		$oIndustria = new clsIndustrias();
		$oIndustria->clearErrores();
		$oIndustria->setNombre($stNOMBRE);

		if (!$oIndustria->hasErrores() && $oIndustria->Registrar()){
			redireccionar(getWeb('IND').'ind.listar.php');
		}
		$stERROR = $oIndustria->getErrores();
	}
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nueva industria');
	$oSmarty->assign('stBTN_ACTION', 'Nueva');

	$oSmarty->display('ind.registrar.tpl.html');
?>