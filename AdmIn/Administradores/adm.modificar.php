<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('ADM').'class.administrador.inc.php';

	$stBAN = 0;
	$stRUT = 'adm.listar.php';
	if (isset($_REQUEST['ban']) && $_REQUEST['ban'] == 1){
		$stBAN = 1; $stRUT = getWeb('ADMIN').'contenido.php';
	}
	$stID = 0;
	$stNOMBRE  = '';
	$stAPELLIDO= '';
	$stENABLED = '';
	$stEMAIL   = '';
	$oldpassword = '';
	$newpassword = '';
	$confirmacion= '';
	$stERROR = '';	

	if (isset($_POST['btn_action'])){
		$stID = $_POST['id'];
		$stNOMBRE  = $_POST['nombre'];
		$stAPELLIDO= $_POST['apellido'];
		$stEMAIL   = $_POST['email'];
		$stENABLED = isset($_POST['enabled'])?'S':'N';
		$oldpassword = !empty($_POST['oldpassword'])?$_POST['oldpassword']:'';
		$newpassword = !empty($_POST['newpassword'])?$_POST['newpassword']:'';
		$confirmacion= !empty($_POST['confirma'])?$_POST['confirma']:'';

		$oAdmin = new clsAdministrador();
		$oAdmin->clearErrores();
		
		if ($oAdmin->findId($stID)){
			$xSetRoot = $oAdmin->getRoot() == 1 ? 1 : 0;

			$oAdmin->setNombre  ($stNOMBRE);
			$oAdmin->setApellido($stAPELLIDO);
			$oAdmin->setEmail   ($stEMAIL);
			$oAdmin->setRoot    ($xSetRoot);

			if (($_SESSION['_admLogin'] == SUPER_ADMIN) && ($_SESSION['_admId'] != $stID)){
				$oAdmin->setEnabled($stENABLED);
			}
			if ($newpassword!='' && $confirmacion!=''){
				if ($_SESSION['_admId'] == $stID){
					$oAdmin->changePassword($oldpassword, $newpassword, $confirmacion);
				} else {
					$oAdmin->changePasswordDirect($newpassword, $confirmacion);
				}
			}
			if (!$oAdmin->hasErrores() && $oAdmin->Modificar()){
				if ($stBAN == 1){redireccionar(getWeb('ADMIN').'contenido.php');}
				redireccionar(getWeb('ADM').'adm.listar.php');
			}
		}
		$stENABLED = isset($_POST['enabled'])?'CHECKED':'';
		$stERROR = $oAdmin->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oAdmin = new clsAdministrador();
		$oAdmin->clearErrores();
		
		if (!$oAdmin->findId($stID)){
			$oSmarty->assign ('stTITLE'  , 'Modificar administrador');
			$oSmarty->assign ('stMESSAGE', $oAdmin->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stNOMBRE  = $oAdmin->editNombre();
		$stAPELLIDO= $oAdmin->editApellido();
		$stEMAIL   = $oAdmin->editEmail();
		$stENABLED = ($oAdmin->Enabled=='S')?'CHECKED':'';
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar administrador');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta p�gina directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$stSHOW_PASSWORD= $_SESSION['_admId']==$stID?TRUE:FALSE;
	$stSHOW_ENABLED = ($_SESSION['_admLogin']==SUPER_ADMIN && $_SESSION['_admId']!=$stID)?TRUE:FALSE;

	$oSmarty->assign('stID' , $stID);
	$oSmarty->assign('stBAN', $stBAN);
	$oSmarty->assign('stRUT', $stRUT);
	$oSmarty->assign('stERROR'   , $stERROR);
	$oSmarty->assign('stNOMBRE'  , $stNOMBRE);
	$oSmarty->assign('stAPELLIDO', $stAPELLIDO);
	$oSmarty->assign('stENABLED' , $stENABLED);
	$oSmarty->assign('stEMAIL'   , $stEMAIL);

	$oSmarty->assign('stSHOW_PASSWORD', $stSHOW_PASSWORD);
	$oSmarty->assign('stSHOW_ENABLED' , $stSHOW_ENABLED);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar Administrador');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');

	$oSmarty->display('adm.modificar.tpl.html');
?>