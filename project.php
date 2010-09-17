<?php
	require_once 'cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('PRO').'class.proyectos.inc.php';

	$stID = !empty($_GET['Id'])?$_GET['Id']:redireccionar('index.php');

	$oProyecto = new clsProyectos();
	$oProyecto->clearErrores();

	if (!$oProyecto->findId($stID)){
		redireccionar('index.php');
	}
	$stNOMBRE    = $oProyecto->getNombre();
	$stREFERENCIA= $oProyecto->getReferencia();
	$stCLIENTE   = $oProyecto->getCliente();
	$stOBJETIVO  = $oProyecto->getObjetivo();
	$stSITUACION = $oProyecto->getSituacion();
	$stPROPUESTA = $oProyecto->getPropuesta();
	$stRESULTADOS= $oProyecto->getResultados();
	$stIMAGEN    = $oProyecto->getImagen()?getWeb('FPR').$oProyecto->Imagen:'';

	/*------------------------------------------------------------------------------*/
	$oMyDB = new clsMyDB();
	$arFotos = array();
	$rsFotos = $oMyDB->Query("SELECT imgId, imgImagen FROM proyectos_imagenes WHERE imgProyecto = $stID ORDER BY imgCarga;");

	if ($rsFotos){
		$rutaFotos = getWeb('FPR');
		while ($fila = mysql_fetch_assoc($rsFotos)) {
			$Id = $fila['imgId'];
			$arFotos[$Id] = $rutaFotos.$fila['imgImagen'];
		}
		$oSmarty->assign('stFOTOS', $arFotos);
		$oSmarty->assign('stSET_CSS_GALERIA', true);
	}
	/*------------------------------------------------------------------------------*/

	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stNOMBRE'    , $stNOMBRE);
	$oSmarty->assign('stREFERENCIA', $stREFERENCIA);
	$oSmarty->assign('stCLIENTE'   , $stCLIENTE);
	$oSmarty->assign('stOBJETIVO'  , $stOBJETIVO);
	$oSmarty->assign('stSITUACION' , $stSITUACION);
	$oSmarty->assign('stPROPUESTA' , $stPROPUESTA);
	$oSmarty->assign('stRESULTADOS', $stRESULTADOS);
	$oSmarty->assign('stIMAGEN'    , $stIMAGEN);

	$oSmarty->display('tpl.project'.$_SESSION['_front_idioma'].'.html');
?>