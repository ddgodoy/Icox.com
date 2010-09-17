<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('IND').'class.industrias.inc.php';

	$stID = 0;
	$stNOMBRE = '';
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stID = $_POST['id'];
		$stNOMBRE = $_POST['nombre'];

		$oIndustria = new clsIndustrias();
		$oIndustria->clearErrores();

		if ($oIndustria->findId($stID)){
			$oIndustria->setNombre($stNOMBRE);

			if (!$oIndustria->hasErrores() && $oIndustria->Modificar()){
				redireccionar(getWeb('IND').'ind.listar.php');
			}
		}
		$stERROR = $oIndustria->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oIndustria = new clsIndustrias();
		$oIndustria->clearErrores();

		if (!$oIndustria->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Modificar industria');
			$oSmarty->assign ('stMESSAGE', $oIndustria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stNOMBRE = $oIndustria->editNombre();
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar industria');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar industria');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');

	$oSmarty->display('ind.registrar.tpl.html');
?>