<?php
	include_once '../cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	if (isset($_SESSION['_admId'])){redireccionar(getWeb('ADMIN').'contenido.php');}
	$_SESSION['_admNombre'] = 'No hay un usuario registrado todavia.';

	$stERROR = '';
	$stLOGIN = '';

	if (isset($_POST['btnLogin'])){
		$stLOGIN = $_POST['login'];
		$stPASSW = $_POST['password'];

		require_once getLocal('ADM').'class.administrador.inc.php';

		$oAdmin = new clsAdministrador();
		$oAdmin->clearErrores();
		
		$oAdmin->doLogin($stLOGIN,$stPASSW);

		if (!$oAdmin->hasErrores()){
			$_SESSION['_admId']    = $oAdmin->Id;
			$_SESSION['_admRoot']  = $oAdmin->Root;
			$_SESSION['_admLogin'] = $oAdmin->Login;
			$_SESSION['_admNombre']= $oAdmin->Apellido.', '.$oAdmin->Nombre;

			redireccionar(getWeb('ADMIN').'contenido.php');
		}
		$stERROR = $oAdmin->getErrores();
	}
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stLOGIN' , $stLOGIN);
	$oSmarty->assign('stERROR' , $stERROR);

	$oSmarty->display('adm.login.tpl.html');
?>