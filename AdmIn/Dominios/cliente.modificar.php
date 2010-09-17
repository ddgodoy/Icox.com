<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('CLIENTE').'menu.inc.php';
	require_once getLocal('DMI').'class.dominios.inc.php';

	$oDominio = new clsDominios();

	$stID = 0;
	$stDOMINIO = '';
	$stDNS_PRIMARIO = '';
	$stDNS_SECUNDARIO = '';
	$stIP_PRIMARIO = '';
	$stIP_SECUNDARIO = '';
	$stREG_PAIS = '';
	$stREG_PROVINCIA = '';
	$stREG_CIUDAD = '';
	$stREG_CODIGO_POSTAL = '';
	$stREG_DIRECCION = '';
	$stREG_TELEFONO = '';
	$stREG_EMAIL = '';
	$stREG_NOMBRE = '';
	$stREG_APELLIDO = '';
	$stREG_EMPRESA = '';
	$stADM_PAIS = '';
	$stADM_PROVINCIA = '';
	$stADM_CIUDAD = '';
	$stADM_CODIGO_POSTAL = '';
	$stADM_DIRECCION = '';
	$stADM_TELEFONO = '';
	$stADM_EMAIL = '';
	$stADM_NOMBRE = '';
	$stADM_APELLIDO = '';
	$stADM_EMPRESA = '';
	$stTEC_PAIS = '';
	$stTEC_PROVINCIA = '';
	$stTEC_CIUDAD = '';
	$stTEC_CODIGO_POSTAL = '';
	$stTEC_DIRECCION = '';
	$stTEC_TELEFONO = '';
	$stTEC_EMAIL = '';
	$stTEC_NOMBRE = '';
	$stTEC_APELLIDO = '';
	$stTEC_EMPRESA = '';
	$stCREADO = '';
	$stACTUALIZADO = '';
	$stDNS_ALTERNATIVOS = array();
	$stIP_ALTERNATIVOS = array();
	$stERROR = '';

	if (isset($_POST['btn_accion'])){
		$stID = $_POST['id'];
		$stDOMINIO = $_POST['dominio'];
		$stDNS_PRIMARIO = $_POST['dns_primario'];
		$stDNS_SECUNDARIO = $_POST['dns_secundario'];
		$stIP_PRIMARIO = $_POST['ip_primario'];
		$stIP_SECUNDARIO = $_POST['ip_secundario'];
		$stREG_PAIS = $_POST['reg_pais'];
		$stREG_PROVINCIA = $_POST['reg_provincia'];
		$stREG_CIUDAD = $_POST['reg_ciudad'];
		$stREG_CODIGO_POSTAL = $_POST['reg_codigo_postal'];
		$stREG_DIRECCION = $_POST['reg_direccion'];
		$stREG_TELEFONO = $_POST['reg_telefono'];
		$stREG_EMAIL = $_POST['reg_email'];
		$stREG_NOMBRE = $_POST['reg_nombre'];
		$stREG_APELLIDO = $_POST['reg_apellido'];
		$stREG_EMPRESA = $_POST['reg_empresa'];
		$stADM_PAIS = $_POST['adm_pais'];
		$stADM_PROVINCIA = $_POST['adm_provincia'];
		$stADM_CIUDAD = $_POST['adm_ciudad'];
		$stADM_CODIGO_POSTAL = $_POST['adm_codigo_postal'];
		$stADM_DIRECCION = $_POST['adm_direccion'];
		$stADM_TELEFONO = $_POST['adm_telefono'];
		$stADM_EMAIL = $_POST['adm_email'];
		$stADM_NOMBRE = $_POST['adm_nombre'];
		$stADM_APELLIDO = $_POST['adm_apellido'];
		$stADM_EMPRESA = $_POST['adm_empresa'];
		$stTEC_PAIS = $_POST['tec_pais'];
		$stTEC_PROVINCIA = $_POST['tec_provincia'];
		$stTEC_CIUDAD = $_POST['tec_ciudad'];
		$stTEC_CODIGO_POSTAL = $_POST['tec_codigo_postal'];
		$stTEC_DIRECCION = $_POST['tec_direccion'];
		$stTEC_TELEFONO = $_POST['tec_telefono'];
		$stTEC_EMAIL = $_POST['tec_email'];
		$stTEC_NOMBRE = $_POST['tec_nombre'];
		$stTEC_APELLIDO = $_POST['tec_apellido'];
		$stTEC_EMPRESA = $_POST['tec_empresa'];
		$stDNS_ALTERNATIVOS = isset($_POST['dns_alternativos']) ? $_POST['dns_alternativos'] : array();
		$stIP_ALTERNATIVOS = isset($_POST['ip_alternativos']) ? $_POST['ip_alternativos'] : array();

		$oDominio->clearErrores();

		if ($oDominio->findId($stID)){
			$oDominio->setDominio($stDOMINIO);
			$oDominio->setDnsPrimario($stDNS_PRIMARIO);
			$oDominio->setDnsSecundario($stDNS_SECUNDARIO);
			$oDominio->setIpPrimario($stIP_PRIMARIO);
			$oDominio->setIpSecundario($stIP_SECUNDARIO);
			$oDominio->setRegPais($stREG_PAIS);
			$oDominio->setRegProvincia($stREG_PROVINCIA);
			$oDominio->setRegCiudad($stREG_CIUDAD);
			$oDominio->setRegCodigoPostal($stREG_CODIGO_POSTAL);
			$oDominio->setRegDireccion($stREG_DIRECCION);
			$oDominio->setRegTelefono($stREG_TELEFONO);
			$oDominio->setRegEmail($stREG_EMAIL);
			$oDominio->setRegNombre($stREG_NOMBRE);
			$oDominio->setRegApellido($stREG_APELLIDO);
			$oDominio->setRegEmpresa($stREG_EMPRESA);
			$oDominio->setAdmPais($stADM_PAIS);
			$oDominio->setAdmProvincia($stADM_PROVINCIA);
			$oDominio->setAdmCiudad($stADM_CIUDAD);
			$oDominio->setAdmCodigoPostal($stADM_CODIGO_POSTAL);
			$oDominio->setAdmDireccion($stADM_DIRECCION);
			$oDominio->setAdmTelefono($stADM_TELEFONO);
			$oDominio->setAdmEmail($stADM_EMAIL);
			$oDominio->setAdmNombre($stADM_NOMBRE);
			$oDominio->setAdmApellido($stADM_APELLIDO);
			$oDominio->setAdmEmpresa($stADM_EMPRESA);
			$oDominio->setTecPais($stTEC_PAIS);
			$oDominio->setTecProvincia($stTEC_PROVINCIA);
			$oDominio->setTecCiudad($stTEC_CIUDAD);
			$oDominio->setTecCodigoPostal($stTEC_CODIGO_POSTAL);
			$oDominio->setTecDireccion($stTEC_DIRECCION);
			$oDominio->setTecTelefono($stTEC_TELEFONO);
			$oDominio->setTecEmail($stTEC_EMAIL);
			$oDominio->setTecNombre($stTEC_NOMBRE);
			$oDominio->setTecApellido($stTEC_APELLIDO);
			$oDominio->setTecEmpresa($stTEC_EMPRESA);
			$oDominio->setActualizado();

			if (!$oDominio->hasErrores() && $oDominio->Modificar()){
				$oDominio->setDnsAlternativos($stDNS_ALTERNATIVOS, $stIP_ALTERNATIVOS);

				if ($oDominio->clienteHizoCambios()) {
					$oDominio->sendMailToAdmin($oDominio->getDominio(), getLocal('COMMONS'));
				}
				unset($_SESSION['_clientePreserve']);

				redireccionar(getWeb('DMI').'cliente.listar.php');
			}
		}
		$stERROR = $oDominio->getErrores();
		$stCREADO = $oDominio->getCreado();
		$stACTUALIZADO = $oDominio->getActualizado();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oDominio->clearErrores();

		if (!$oDominio->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Modificar dominio');
			$oSmarty->assign ('stMESSAGE', $oDominio->getErrores());
			$oSmarty->display('cliente.information.tpl.html');
			exit();
		}
		$auxAlternativos = $oDominio->getDnsAlternativos();

		$oDominio->preserveValuesInSession($auxAlternativos['dns'], $auxAlternativos['ip']);

		$stDOMINIO = $oDominio->editDominio();
		$stDNS_PRIMARIO = $oDominio->editDnsPrimario();
		$stDNS_SECUNDARIO = $oDominio->editDnsSecundario();
		$stIP_PRIMARIO = $oDominio->editIpPrimario();
		$stIP_SECUNDARIO = $oDominio->editIpSecundario();
		$stREG_PAIS = $oDominio->editRegPais();
		$stREG_PROVINCIA = $oDominio->editRegProvincia();
		$stREG_CIUDAD = $oDominio->editRegCiudad();
		$stREG_CODIGO_POSTAL = $oDominio->editRegCodigoPostal();
		$stREG_DIRECCION = $oDominio->editRegDireccion();
		$stREG_TELEFONO = $oDominio->editRegTelefono();
		$stREG_EMAIL = $oDominio->editRegEmail();
		$stREG_NOMBRE = $oDominio->editRegNombre();
		$stREG_APELLIDO = $oDominio->editRegApellido();
		$stREG_EMPRESA = $oDominio->editRegEmpresa();
		$stADM_PAIS = $oDominio->editAdmPais();
		$stADM_PROVINCIA = $oDominio->editAdmProvincia();
		$stADM_CIUDAD = $oDominio->editAdmCiudad();
		$stADM_CODIGO_POSTAL = $oDominio->editAdmCodigoPostal();
		$stADM_DIRECCION = $oDominio->editAdmDireccion();
		$stADM_TELEFONO = $oDominio->editAdmTelefono();
		$stADM_EMAIL = $oDominio->editAdmEmail();
		$stADM_NOMBRE = $oDominio->editAdmNombre();
		$stADM_APELLIDO = $oDominio->editAdmApellido();
		$stADM_EMPRESA = $oDominio->editAdmEmpresa();
		$stTEC_PAIS = $oDominio->editTecPais();
		$stTEC_PROVINCIA = $oDominio->editTecProvincia();
		$stTEC_CIUDAD = $oDominio->editTecCiudad();
		$stTEC_CODIGO_POSTAL = $oDominio->editTecCodigoPostal();
		$stTEC_DIRECCION = $oDominio->editTecDireccion();
		$stTEC_TELEFONO = $oDominio->editTecTelefono();
		$stTEC_EMAIL = $oDominio->editTecEmail();
		$stTEC_NOMBRE = $oDominio->editTecNombre();
		$stTEC_APELLIDO = $oDominio->editTecApellido();
		$stTEC_EMPRESA = $oDominio->editTecEmpresa();
		$stCREADO = $oDominio->getCreado();
		$stACTUALIZADO = $oDominio->getActualizado();
		$stDNS_ALTERNATIVOS = $auxAlternativos['dns'];
		$stIP_ALTERNATIVOS = $auxAlternativos['ip'];
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar dominio');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta pagina directamente');
		$oSmarty->display('cliente.information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stDOMINIO', $stDOMINIO);
	$oSmarty->assign('stDNS_PRIMARIO', $stDNS_PRIMARIO);
	$oSmarty->assign('stDNS_SECUNDARIO', $stDNS_SECUNDARIO);
	$oSmarty->assign('stIP_PRIMARIO', $stIP_PRIMARIO);
	$oSmarty->assign('stIP_SECUNDARIO', $stIP_SECUNDARIO);
	$oSmarty->assign('stREG_PAIS', $stREG_PAIS);
	$oSmarty->assign('stREG_PROVINCIA', $stREG_PROVINCIA);
	$oSmarty->assign('stREG_CIUDAD', $stREG_CIUDAD);
	$oSmarty->assign('stREG_CODIGO_POSTAL', $stREG_CODIGO_POSTAL);
	$oSmarty->assign('stREG_DIRECCION', $stREG_DIRECCION);
	$oSmarty->assign('stREG_TELEFONO', $stREG_TELEFONO);
	$oSmarty->assign('stREG_EMAIL', $stREG_EMAIL);
	$oSmarty->assign('stREG_NOMBRE', $stREG_NOMBRE);
	$oSmarty->assign('stREG_APELLIDO', $stREG_APELLIDO);
	$oSmarty->assign('stREG_EMPRESA', $stREG_EMPRESA);
	$oSmarty->assign('stADM_PAIS', $stADM_PAIS);
	$oSmarty->assign('stADM_PROVINCIA', $stADM_PROVINCIA);
	$oSmarty->assign('stADM_CIUDAD', $stADM_CIUDAD);
	$oSmarty->assign('stADM_CODIGO_POSTAL', $stADM_CODIGO_POSTAL);
	$oSmarty->assign('stADM_DIRECCION', $stADM_DIRECCION);
	$oSmarty->assign('stADM_TELEFONO', $stADM_TELEFONO);
	$oSmarty->assign('stADM_EMAIL', $stADM_EMAIL);
	$oSmarty->assign('stADM_NOMBRE', $stADM_NOMBRE);
	$oSmarty->assign('stADM_APELLIDO', $stADM_APELLIDO);
	$oSmarty->assign('stADM_EMPRESA', $stADM_EMPRESA);
	$oSmarty->assign('stTEC_PAIS', $stTEC_PAIS);
	$oSmarty->assign('stTEC_PROVINCIA', $stTEC_PROVINCIA);
	$oSmarty->assign('stTEC_CIUDAD', $stTEC_CIUDAD);
	$oSmarty->assign('stTEC_CODIGO_POSTAL', $stTEC_CODIGO_POSTAL);
	$oSmarty->assign('stTEC_DIRECCION', $stTEC_DIRECCION);
	$oSmarty->assign('stTEC_TELEFONO', $stTEC_TELEFONO);
	$oSmarty->assign('stTEC_EMAIL', $stTEC_EMAIL);
	$oSmarty->assign('stTEC_NOMBRE', $stTEC_NOMBRE);
	$oSmarty->assign('stTEC_APELLIDO', $stTEC_APELLIDO);
	$oSmarty->assign('stTEC_EMPRESA', $stTEC_EMPRESA);
	$oSmarty->assign('stCREADO', $stCREADO);
	$oSmarty->assign('stACTUALIZADO', $stACTUALIZADO);
	$oSmarty->assign('stDNS_ALTERNATIVOS', $stDNS_ALTERNATIVOS);
	$oSmarty->assign('stIP_ALTERNATIVOS', $stIP_ALTERNATIVOS);
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar dominio');

	$oSmarty->display('cliente.modificar.tpl.html');
?>