<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('PRO').'class.proyectos.inc.php';
	require_once getLocal('PRO').'pro.cargas.php';
/*----------------------------------------------------------------*/
	$page = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
/*----------------------------------------------------------------*/
	$stID = 0;
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
	
	$stINDUSTRIA = '';
	$stCATEGORIA = '';
	$stSUBCATEGORIA = '';

	if (isset($_POST['btn_accion'])){
		$_POST['industria'] = isset($_POST['industria'])?$_POST['industria']:array();
		$_POST['categoria'] = isset($_POST['categoria'])?$_POST['categoria']:array();
		$_POST['subcategoria'] = isset($_POST['subcategoria'])?$_POST['subcategoria']:array();

		$arrInd = is_array($_POST['industria'])?$_POST['industria']:array($_POST['industria']);
		$arrCat = is_array($_POST['categoria'])?$_POST['categoria']:array($_POST['categoria']);
		$arrSub = is_array($_POST['subcategoria'])?$_POST['subcategoria']:array($_POST['subcategoria']);

		$stID = $_POST['id'];
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

		if ($oProyecto->findId($stID)){
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
			
			if (isset($_POST['quitar_imagen'])){@unlink(getLocal('FPR').$oProyecto->Imagen); $oProyecto->Imagen = '';}
			if (!empty($stIMAGEN['tmp_name'])){$oProyecto->setImagen($stIMAGEN, getLocal('FPR'), $oProyecto->Imagen);}

			if (!$oProyecto->hasErrores() && $oProyecto->Modificar()){
				$oProyecto->delTablasMovimiento();
				$oProyecto->setIndustria   ($arrInd);
				$oProyecto->setCategoria   ($arrCat);
				$oProyecto->setSubcategoria($arrSub);

				redireccionar(getWeb('PRO').'pro.listar.php?page='.$page);
			}
		}
		$stINDUSTRIA = llenarSelectMultiple($aInd, $oProyecto->getIndustrias());
		$stCATEGORIA = llenarSelectMultiple($aCat, $oProyecto->getCategorias());
		$stSUBCATEGORIA = llenarSelectMultiple($aSub, $oProyecto->getSubcategorias());

		$stIMAGEN = $oProyecto->getImagen()?getWeb('FPR').$oProyecto->Imagen:'';
		$stERROR = $oProyecto->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oProyecto = new clsProyectos();
		$oProyecto->clearErrores();

		if (!$oProyecto->findId($stID)){
			$oSmarty->assign ('stTITLE'  , 'Modificar un proyecto');
			$oSmarty->assign ('stMESSAGE', $oProyecto->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stORDEN     = $oProyecto->getOrden();
		$stNOMBRE    = $oProyecto->editNombre();
		$stREFERENCIA= $oProyecto->editReferencia();
		$stCLIENTE   = $oProyecto->editCliente();
		$stOBJETIVO  = $oProyecto->editObjetivo();
		$stSITUACION = $oProyecto->editSituacion();
		$stPROPUESTA = $oProyecto->editPropuesta();
		$stRESULTADOS= $oProyecto->editResultados();
		$stIMAGEN    = $oProyecto->getImagen()?getWeb('FPR').$oProyecto->Imagen:'';
		
		$stOBJETIVO_EN  = $oProyecto->editObjetivo_en();
		$stSITUACION_EN = $oProyecto->editSituacion_en();
		$stPROPUESTA_EN = $oProyecto->editPropuesta_en();
		$stRESULTADOS_EN= $oProyecto->editResultados_en();
		
		$stINDUSTRIA = llenarSelectMultiple($aInd, $oProyecto->getIndustrias());
		$stCATEGORIA = llenarSelectMultiple($aCat, $oProyecto->getCategorias());
		$stSUBCATEGORIA = llenarSelectMultiple($aSub, $oProyecto->getSubcategorias());
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar un proyecto');
		$oSmarty->assign ('stMESSAGE', 'No puede ingresar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stAUXID'     , $stID);
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
	$oSmarty->assign('stTITLE' , 'Modificar proyecto');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');
/*----------------------------------------------------------------*/
	$oSmarty->assign('stPAGE', $page);
/*----------------------------------------------------------------*/
	$oSmarty->display('pro.registrar.tpl.html');
?>