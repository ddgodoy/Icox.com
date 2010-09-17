<?php
	include_once '../cOmmOns/config.inc.php';
	require_once getLocal('ADM').'class.administrador.inc.php';
	require_once getLocal('CAPTCHA').'class.captcha.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	$stERROR = '';
	$stEMAIL = '';
	$stFECHA = '01/01/1980';

	if (isset($_POST['btn_action'])){
		$stEMAIL = $_POST['email'];
		$stFECHA = $_POST['fecha'];
		$stVERIF = $_POST['verificar'];

		$oCaptcha = new clsCaptcha();
		$oCaptcha->setDirectorio(getLocal('CAPTCHA').'image_data');
		
		if($oCaptcha->check($stVERIF)){
			$oAdministrador = new clsAdministrador();
			$oAdministrador->clearErrores();

			$oAdministrador->checkIdentidad($stEMAIL,$stFECHA,getLocal('COMMONS'));
			if (!$oAdministrador->hasErrores()){
				$oSmarty->assign ('stTITLE', 'Clave enviada');
				$oSmarty->assign ('stLINKS', array(array('desc'=>'Login','link'=>'index.php')));
				$oSmarty->assign ('stMESSAGE', 'La nueva clave fue enviada con exito.');
				$oSmarty->display('information.tpl.html');
				exit();
			} else {
				$stERROR = $oAdministrador->getErrores();
			}
		} else {
  			$stERROR = 'El codigo ingresado no es valido.';
  		}
	}
	$oSmarty->assign('stERROR', $stERROR);
	$oSmarty->assign('stEMAIL', $stEMAIL);
	$oSmarty->assign('stFECHA', $stFECHA);

	$oSmarty->display('adm.recordar.tpl.html');
?>