<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('SUB').'class.subcategorias.inc.php';
	
	$oMyDB = new clsMyDB();
	/*----------------------------------------------------------------------*/
	$aCat = array('-- seleccionar --');
	$rCat = $oMyDB->Query("SELECT * FROM categorias ORDER BY catOrden;");
	while ($rCat && $fCat = mysql_fetch_assoc($rCat)){
		$aCat[$fCat['catId']] = $oMyDB->forShow($fCat['catNombre']);
	}
	/*----------------------------------------------------------------------*/
	$stID = 0;
	$stNOMBRE = '';
	$stCATEGORIA = '';
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stID = $_POST['id'];
		$stCATEGORIA  = $_POST['categoria'];
		$stNOMBRE = $_POST['nombre'];

		$oSubcategoria = new clsSubcategorias();
		$oSubcategoria->clearErrores();

		if ($oSubcategoria->findId($stID)){
			$oSubcategoria->setCategoria($stCATEGORIA);
			$oSubcategoria->setNombre($stNOMBRE);

			if (!$oSubcategoria->hasErrores() && $oSubcategoria->Modificar()){
				redireccionar(getWeb('SUB').'sub.listar.php');
			}
		}
		$stCATEGORIA = llenarSelect($aCat, $oSubcategoria->Categoria);
		$stERROR = $oSubcategoria->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oSubcategoria = new clsSubcategorias();
		$oSubcategoria->clearErrores();

		if (!$oSubcategoria->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Modificar subcategoría');
			$oSmarty->assign ('stMESSAGE', $oSubcategoria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stCATEGORIA = llenarSelect($aCat, $oSubcategoria->Categoria);
		$stNOMBRE = $oSubcategoria->editNombre();
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar subcategoría');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stCATEGORIA', $stCATEGORIA);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar subcategoría');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');

	$oSmarty->display('sub.registrar.tpl.html');
?>