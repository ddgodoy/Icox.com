<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('USU').'class.usuarios.inc.php';

	$oUsuario = new clsUsuarios();

	$stID = 0;
	$stEMPRESA = '';
	$stNOMBRE = '';
	$stAPELLIDO = '';
	$stUBICACION = '';
	$stDIRECCION = '';
	$stTELEFONO = '';
	$stCELULAR = '';
	$stEMAIL = '';
	$stEMAIL_REP = '';
	$stHABILITADO = '';
	$stERROR = '';

	if ($_POST) {
		$stID = $_POST['id'];
		$stEMPRESA = $_POST['empresa'];
		$stNOMBRE = $_POST['nombre'];
		$stAPELLIDO = $_POST['apellido'];
		$stUBICACION = $_POST['ubicacion'];
		$stDIRECCION = $_POST['direccion'];
		$stTELEFONO = $_POST['telefono'];
		$stCELULAR = $_POST['celular'];
		$stHABILITADO = isset($_POST['habilitado']) ? 1 : 0;
		$stEMAIL = trim($_POST['email']);
		$stEMAIL_REP = trim($_POST['email_rep']);
		$stCLAVE = trim($_POST['clave']);
		$stCLAVE_REP = trim($_POST['clave_rep']);

		$oUsuario->clearErrores();

		if ($oUsuario->findId($stID)){
			$updClave = false;

			$oUsuario->setEmpresa($stEMPRESA);
			$oUsuario->setNombre($stNOMBRE);
			$oUsuario->setApellido($stAPELLIDO);
			$oUsuario->setUbicacion($stUBICACION);
			$oUsuario->setDireccion($stDIRECCION);
			$oUsuario->setTelefono($stTELEFONO);
			$oUsuario->setCelular($stCELULAR);
			$oUsuario->setEmail($stEMAIL);
			$oUsuario->setActualizado();
			$oUsuario->setHabilitado($stHABILITADO);

			if (!empty($stCLAVE)) {
				$updClave = true;

				$oUsuario->setClave($stCLAVE);
				$oUsuario->checkEmailRep($stEMAIL_REP);
				$oUsuario->checkClaveRep($stCLAVE_REP);
			}
			if (!$oUsuario->hasErrores() && $oUsuario->Modificar()){
				$oUsuario->updateClave($updClave);

				if (isset($_POST['btn_accion_mail'])) {
					$oUsuario->sendInfoToUser($stCLAVE, getLocal('COMMONS'));
				}
				redireccionar(getWeb('USU').'listar.php');
			}
		}
		$stHABILITADO = isset($_POST['habilitado']) ? 'CHECKED' : '';
		$stERROR = $oUsuario->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oUsuario->clearErrores();

		if (!$oUsuario->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Modificar usuario');
			$oSmarty->assign ('stMESSAGE', $oUsuario->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stEMPRESA = $oUsuario->editEmpresa();
		$stNOMBRE = $oUsuario->editNombre();
		$stAPELLIDO = $oUsuario->editApellido();
		$stUBICACION = $oUsuario->editUbicacion();
		$stDIRECCION = $oUsuario->editDireccion();
		$stTELEFONO = $oUsuario->editTelefono();
		$stCELULAR = $oUsuario->editCelular();
		$stEMAIL = $oUsuario->editEmail();
		$stEMAIL_REP = $oUsuario->editEmail();
		$stHABILITADO = $oUsuario->getHabilitado()==1 ? 'CHECKED' : '';
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar usuario');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta p�gina directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stEMPRESA', $stEMPRESA);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stAPELLIDO', $stAPELLIDO);
	$oSmarty->assign('stUBICACION', $stUBICACION);
	$oSmarty->assign('stDIRECCION', $stDIRECCION);
	$oSmarty->assign('stTELEFONO', $stTELEFONO);
	$oSmarty->assign('stCELULAR', $stCELULAR);
	$oSmarty->assign('stEMAIL', $stEMAIL);
	$oSmarty->assign('stEMAIL_REP', $stEMAIL_REP);
	$oSmarty->assign('stHABILITADO', $stHABILITADO);
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar usuario');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');

	$oSmarty->display('usu.registrar.tpl.html');
?>