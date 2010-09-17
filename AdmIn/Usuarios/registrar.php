<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('USU').'class.usuarios.inc.php';

	$oUsuario = new clsUsuarios();

	$stEMPRESA = '';
	$stNOMBRE = '';
	$stAPELLIDO = '';
	$stUBICACION = '';
	$stDIRECCION = '';
	$stTELEFONO = '';
	$stCELULAR = '';
	$stEMAIL = '';
	$stEMAIL_REP = '';
	$stHABILITADO = 'CHECKED';
	$stERROR = '';
	
	if ($_POST) {
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

		$oUsuario->setEmpresa($stEMPRESA);
		$oUsuario->setNombre($stNOMBRE);
		$oUsuario->setApellido($stAPELLIDO);
		$oUsuario->setUbicacion($stUBICACION);
		$oUsuario->setDireccion($stDIRECCION);
		$oUsuario->setTelefono($stTELEFONO);
		$oUsuario->setCelular($stCELULAR);
		$oUsuario->setEmail($stEMAIL);
		$oUsuario->setClave($stCLAVE);
		$oUsuario->setCreado();
		$oUsuario->setActualizado();
		$oUsuario->setHabilitado($stHABILITADO);
		$oUsuario->checkEmailRep($stEMAIL_REP);
		$oUsuario->checkClaveRep($stCLAVE_REP);

		if (!$oUsuario->hasErrores() && $oUsuario->Registrar()) {
			if (isset($_POST['btn_accion_mail'])) {
				$oUsuario->sendInfoToUser($stCLAVE, getLocal('COMMONS'));
			}
			redireccionar(getWeb('USU').'listar.php');
		}
		$stHABILITADO = isset($_POST['habilitado']) ? 'CHECKED' : '';
		$stERROR = $oUsuario->getErrores();
	}
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
	$oSmarty->assign('stTITLE' , 'Nuevo usuario');
	$oSmarty->assign('stBTN_ACTION', 'Nuevo');

	$oSmarty->display('usu.registrar.tpl.html');
?>