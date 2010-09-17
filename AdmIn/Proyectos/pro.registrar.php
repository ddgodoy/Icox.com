<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('PRO').'class.proyectos.inc.php';
	require_once getLocal('PRO').'pro.cargas.php';
//--------------------------------------------------------------------
	$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
	$stAUXID = empty($_REQUEST['codigo'])?time():$_REQUEST['codigo'];
//--------------------------------------------------------------------
	$stNOMBRE    = '';
	$stREFERENCIA= '';
	$stCLIENTE   = '';
	$stOBJETIVO  = '';
	$stSITUACION = '';
	$stPROPUESTA = '';
	$stRESULTADOS= '';
	$stIMAGEN    = '';
	$stERROR     = '';

	$stOBJETIVO_EN  = '';
	$stSITUACION_EN = '';
	$stPROPUESTA_EN = '';
	$stRESULTADOS_EN= '';
	
	$stINDUSTRIA = llenarSelectMultiple($aInd, $selInd);
	$stCATEGORIA = llenarSelectMultiple($aCat, $selCat);
	$stSUBCATEGORIA = llenarSelectMultiple($aSub, $selSub);

	if (isset($_POST['btn_accion'])){
		$_POST['industria'] = isset($_POST['industria'])?$_POST['industria']:array();
		$_POST['categoria'] = isset($_POST['categoria'])?$_POST['categoria']:array();
		$_POST['subcategoria'] = isset($_POST['subcategoria'])?$_POST['subcategoria']:array();
		
		$arrInd = is_array($_POST['industria'])?$_POST['industria']:array($_POST['industria']);
		$arrCat = is_array($_POST['categoria'])?$_POST['categoria']:array($_POST['categoria']);
		$arrSub = is_array($_POST['subcategoria'])?$_POST['subcategoria']:array($_POST['subcategoria']);

		$stORDEN     = $_POST['orden'];
		$stNOMBRE    = $_POST['nombre'];
		$stREFERENCIA= $_POST['referencia'];
		$stCLIENTE   = $_POST['cliente'];
		$stOBJETIVO  = $_POST['objetivo'];
		$stSITUACION = $_POST['situacion'];
		$stPROPUESTA = $_POST['propuesta'];
		$stRESULTADOS= $_POST['resultados'];
		$stIMAGEN    = $_FILES['imagen'];

		$stOBJETIVO_EN  = $_POST['objetivo_en'];
		$stSITUACION_EN = $_POST['situacion_en'];
		$stPROPUESTA_EN = $_POST['propuesta_en'];
		$stRESULTADOS_EN= $_POST['resultados_en'];

		$oProyecto = new clsProyectos();
		$oProyecto->clearErrores();

		$oProyecto->setOrden     ($stORDEN);
		$oProyecto->setNombre    ($stNOMBRE);
		$oProyecto->setReferencia($stREFERENCIA);
		$oProyecto->setCliente   ($stCLIENTE);
		$oProyecto->setObjetivo  ($stOBJETIVO);
		$oProyecto->setSituacion ($stSITUACION);
		$oProyecto->setPropuesta ($stPROPUESTA);
		$oProyecto->setResultados($stRESULTADOS);
		
		$oProyecto->setObjetivo_en  ($stOBJETIVO_EN);
		$oProyecto->setSituacion_en ($stSITUACION_EN);
		$oProyecto->setPropuesta_en ($stPROPUESTA_EN);
		$oProyecto->setResultados_en($stRESULTADOS_EN);

		if (!empty($stIMAGEN['tmp_name'])){$oProyecto->setImagen($stIMAGEN,getLocal('FPR'));}

		if (!$oProyecto->hasErrores() && $oProyecto->Registrar()){
			$oProyecto->setIndustria   ($arrInd);
			$oProyecto->setCategoria   ($arrCat);
			$oProyecto->setSubcategoria($arrSub);
			$oProyecto->actualizarDatos($stAUXID);

			redireccionar(getWeb('PRO').'pro.listar.php?page='.$page);
		}
		$stINDUSTRIA = llenarSelectMultiple($aInd, $selInd);
		$stCATEGORIA = llenarSelectMultiple($aCat, $selCat);
		$stSUBCATEGORIA = llenarSelectMultiple($aSub, $selSub);

		$stIMAGEN = '';
		$stERROR = $oProyecto->getErrores();
	}
	$oSmarty->assign('stAUXID'     , $stAUXID);
	$oSmarty->assign('stERROR'     , $stERROR);
	$oSmarty->assign('stORDEN'     , $stORDEN);
	$oSmarty->assign('stNOMBRE'    , $stNOMBRE);
	$oSmarty->assign('stREFERENCIA', $stREFERENCIA);
	$oSmarty->assign('stCLIENTE'   , $stCLIENTE);
	$oSmarty->assign('stOBJETIVO'  , $stOBJETIVO);
	$oSmarty->assign('stSITUACION' , $stSITUACION);
	$oSmarty->assign('stPROPUESTA' , $stPROPUESTA);
	$oSmarty->assign('stRESULTADOS', $stRESULTADOS);
	$oSmarty->assign('stIMAGEN'    , $stIMAGEN);

	$oSmarty->assign('stOBJETIVO_EN'  , $stOBJETIVO_EN);
	$oSmarty->assign('stSITUACION_EN' , $stSITUACION_EN);
	$oSmarty->assign('stPROPUESTA_EN' , $stPROPUESTA_EN);
	$oSmarty->assign('stRESULTADOS_EN', $stRESULTADOS_EN);

	$oSmarty->assign('stINDUSTRIA' , $stINDUSTRIA);
	$oSmarty->assign('stCATEGORIA' , $stCATEGORIA);
	$oSmarty->assign('stSUBCATEGORIA' , $stSUBCATEGORIA);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nuevo proyecto');
	$oSmarty->assign('stBTN_ACTION', 'Nuevo');
//--------------------------------------------------------------------
	$oSmarty->assign('stPAGE', $page);
//--------------------------------------------------------------------
	$oSmarty->display('pro.registrar.tpl.html');
?>