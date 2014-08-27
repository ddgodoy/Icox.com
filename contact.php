<?php
	require_once 'cOmmOns/config.inc.php';

	$stNOMBRE   = '';
	$stEMAIL    = '';
	$stTELEFONO = '';
	$stPAIS     = '';
	$stCIUDAD   = '';
	$stDIRECCION= '';
	$stCONSULTA = '';
	$stMENSAJE  = '';
	$stERROR    = '';

	if (isset($_POST['btn_ejecutar'])){
		$stNOMBRE   = $_POST['nombre'];
		$stEMAIL    = $_POST['email'];
		$stTELEFONO = $_POST['telefono'];
		$stPAIS     = $_POST['pais'];
		$stCIUDAD   = $_POST['ciudad'];
		$stDIRECCION= $_POST['direccion'];
		$stCONSULTA = $_POST['consulta'];

		if ($stNOMBRE=='' || $stEMAIL=='' || $stTELEFONO=='' || $stCONSULTA==''){
			$stERROR = 'Complete the fields required';
			if ($_SESSION['_front_idioma'] == '_es'){
				$stERROR = 'Complete los campos requeridos';
			}
		} else {
			require_once getLocal('COMMONS').'func.mail.php';

			$ok = true;
			if (!has_no_newlines($stNOMBRE))   {$ok = false;}
			if (!has_no_newlines($stEMAIL))    {$ok = false;}
			if (!has_no_newlines($stTELEFONO)) {$ok = false;}
			if (!has_no_newlines($stPAIS))     {$ok = false;}
			if (!has_no_newlines($stCIUDAD))   {$ok = false;}
			if (!has_no_newlines($stDIRECCION)){$ok = false;}
			if (!has_no_emailheaders($stCONSULTA)){$ok = false;}
			
			if ($ok){
				$texto = 'Icox Consulting - Datos Contacto'."\n"."\n".
						 'Nombre: '   .$stNOMBRE."\n".
						 'Email: '    .$stEMAIL."\n".
						 'Telefono: ' .$stTELEFONO."\n".
						 'Pais: '     .$stPAIS."\n".
						 'Ciudad: '   .$stCIUDAD."\n".
						 'Direccion: '.$stDIRECCION."\n".
						 'Consulta: ' .$stCONSULTA;
				$stCONSULTA_HTML = nl2br($stCONSULTA);
				$html = "<html>
						<head>
						<title>Icox Consulting - Datos Contacto</title>
						<style type='text/css'>
							body{background-color: #E8ECF0;}
							td {font-family: arial;font-size: 11px;}
						</style>
						</head>
						<body>
							<table>
								<tr><td colspan='2'><h1>Icox Consulting - Datos Contacto</h1></td></tr>
								<tr><td><strong>Nombre:</strong>&nbsp;</td><td>$stNOMBRE</td></tr>
								<tr><td><strong>Email:</strong>&nbsp;</td><td>$stEMAIL</td></tr>
								<tr><td><strong>Telefono:</strong>&nbsp;</td><td>$stTELEFONO</td></tr>
								<tr><td><strong>Pais:</strong>&nbsp;</td><td>$stPAIS</td></tr>
								<tr><td><strong>Ciudad:</strong>&nbsp;</td><td>$stCIUDAD</td></tr>
								<tr><td><strong>Direccion:</strong>&nbsp;</td><td>$stDIRECCION</td></tr>
								<tr><td colspan='2'><strong>Consulta:</strong>&nbsp;</td></tr>
								<tr><td colspan='2'>$stCONSULTA_HTML</td></tr>
							</table>
						</body>
						</html>";
				if (@send_mail("info@icox.com", $stEMAIL, 'CONTACTO DESDE LA WEB ICOX.COM', $html, $texto)){
					$stMENSAJE  = 'Sent successfully. Soon we will communicate with you. Thanks';
					if ($_SESSION['_front_idioma'] == '_es'){
						$stMENSAJE  = 'Envio exitoso. Nos comunicaremos con Ud a la brevedad. Gracias';
					}
					/**/
					require_once getLocal('CNT').'class.contactos.inc.php';
	
					$oContacto = new clsContactos();
					$oContacto->clearErrores();
	
					$oContacto->setFecha    (date('Y-m-d'));
					$oContacto->setNombre   ($stNOMBRE);
					$oContacto->setEmail    ($stEMAIL);
					$oContacto->setTelefono ($stTELEFONO);
					$oContacto->setPais     ($stPAIS);
					$oContacto->setCiudad   ($stCIUDAD);
					$oContacto->setDireccion($stDIRECCION);
					$oContacto->setConsulta ($stCONSULTA);
					
					if (!$oContacto->hasErrores()){
						@$oContacto->Registrar();
					}
					/**/
					$stNOMBRE   = '';
					$stEMAIL    = '';
					$stTELEFONO = '';
					$stPAIS     = '';
					$stCIUDAD   = '';
					$stDIRECCION= '';
					$stCONSULTA = '';
					$stERROR    = '';
				} else {
					$stERROR = 'Internal error. Please, try later';
					if ($_SESSION['_front_idioma'] == '_es'){
						$stERROR = 'Error interno. Por favor, intente nuevamente';
					}
				}
			} else {
				$stERROR = 'Invalid contents';
				if ($_SESSION['_front_idioma'] == '_es'){
					$stERROR = 'Contenidos no validos';
				}
	}}}
	$stACCION_ONLOAD = 'onload="oImg_3.start();"';

	$oSmarty->assign('stNOMBRE'   , $stNOMBRE);
	$oSmarty->assign('stEMAIL'    , $stEMAIL);
	$oSmarty->assign('stTELEFONO' , $stTELEFONO);
	$oSmarty->assign('stPAIS'     , $stPAIS);
	$oSmarty->assign('stCIUDAD'   , $stCIUDAD);
	$oSmarty->assign('stDIRECCION', $stDIRECCION);
	$oSmarty->assign('stCONSULTA' , $stCONSULTA);
	$oSmarty->assign('stMENSAJE'  , $stMENSAJE);
	$oSmarty->assign('stERROR'    , $stERROR);
	$oSmarty->assign('stACCION_ONLOAD', $stACCION_ONLOAD);

	$oSmarty->display('tpl.contact'.$_SESSION['_front_idioma'].'.html');
?>