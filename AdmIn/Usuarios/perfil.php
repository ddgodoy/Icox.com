<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('CLIENTE').'menu.inc.php';
	require_once getLocal('USU').'class.usuarios.inc.php';

	$oUsuario = new clsUsuarios();

	$stID = $_SESSION['_clienteId'];
	$stEMPRESA = '';
	$stNOMBRE = '';
	$stAPELLIDO = '';
	$stUBICACION = '';
	$stDIRECCION = '';
	$stTELEFONO = '';
	$stCELULAR = '';
	$stEMAIL = '';
	$stEMAIL_REP = '';
	$stERROR = '';

	if ($_POST) {
		$stEMPRESA = $_POST['empresa'];
		$stNOMBRE = $_POST['nombre'];
		$stAPELLIDO = $_POST['apellido'];
		$stUBICACION = $_POST['ubicacion'];
		$stDIRECCION = $_POST['direccion'];
		$stTELEFONO = $_POST['telefono'];
		$stCELULAR = $_POST['celular'];
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

			if (!empty($stCLAVE)) {
				$updClave = true;

				$oUsuario->setClave($stCLAVE);
				$oUsuario->checkEmailRep($stEMAIL_REP);
				$oUsuario->checkClaveRep($stCLAVE_REP);
			}
			if (!$oUsuario->hasErrores() && $oUsuario->Modificar()){
				$oUsuario->updateClave($updClave);
				
				$_SESSION['_clienteNombre'] = $oUsuario->apellido.', '.$oUsuario->nombre;

				redireccionar(getWeb('CLIENTE').'contenido.php');
			}
		}
		$stERROR = $oUsuario->getErrores();
	} else {		
		$oUsuario->clearErrores();

		if (!$oUsuario->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Perfil de usuario');
			$oSmarty->assign ('stMESSAGE', $oUsuario->getErrores());
			$oSmarty->display('cliente.information.tpl.html');
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
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Mis datos');

	$oSmarty->display('cliente.perfil.tpl.html');
?>