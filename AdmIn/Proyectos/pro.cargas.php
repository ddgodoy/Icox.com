<?php
	$oMyDB = new clsMyDB();

	$rLast = $oMyDB->Query("SELECT MAX(proOrden) as ultimo FROM proyectos;");
	if ($rLast){
		$dLast = mysql_fetch_assoc($rLast);
		$stORDEN = $dLast['ultimo'] + 1;
	} else {
		$stORDEN = 0;
	}
	/*------------------------------------------------------------------------------------------------*/
	$selInd = 0;
	$rInd = $oMyDB->Query("SELECT * FROM industrias ORDER BY indNombre;");
	if ($rInd){
		while ($fInd = mysql_fetch_assoc($rInd)){
			if ($selInd == 0){$selInd = $fInd['indId'];}
			$aInd[$fInd['indId']] = $oMyDB->forShow($fInd['indNombre']);
		}
	} else {$aInd = array(0 => '--');}
	/*------------------------------------------------------------------------------------------------*/
	$selCat = 0;
	$rCat = $oMyDB->Query("SELECT * FROM categorias ORDER BY catOrden;");
	if ($rCat){
		while ($fCat = mysql_fetch_assoc($rCat)){
			if ($selCat == 0){$selCat = $fCat['catId'];}
			$aCat[$fCat['catId']] = $oMyDB->forShow($fCat['catNombre']);
		}
	} else {$aCat = array(0 => '--');}
	/*------------------------------------------------------------------------------------------------*/
	$selSub = '0_0';
	$rSub = $oMyDB->Query("SELECT * FROM subcategorias ORDER BY subNombre;");
	if ($rSub){
		while ($fSub = mysql_fetch_assoc($rSub)){
			$xIdSub = $fSub['subId'].'_'.$fSub['subCategoria'];
			if ($selSub == 0){$selSub = $xIdSub;}
			$aSub[$xIdSub] = $oMyDB->forShow($fSub['subNombre']);
		}
	} else {$aSub = array('0_0' => '--');}
?>