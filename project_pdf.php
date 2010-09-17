<?php
	require_once 'cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('PRO').'class.proyectos.inc.php';

	$stID = !empty($_GET['Id'])?$_GET['Id']:redireccionar('index.php');
	$stQT = !empty($_GET['q'])?$_GET['q']:'l';
	$stQT = $stQT=='l' ? 'low' : 'high';

	$oProyecto = new clsProyectos();
	$oProyecto->clearErrores();

	$stERROR    = 'Internal error';
	$lNOMBRE    = 'Name :';
	$lREFERENCIA= 'Reference :';
	$lCLIENTE   = 'Client :';
	$lOBJETIVO  = 'Objective :';
	$lSITUACION = 'Situation :';
	$lPROPUESTA = 'Proposal :';
	$lRESULTADOS= 'Results :';

	if ($_SESSION['_front_idioma'] == '_es'){
		$stERROR = 'Error interno';
		$lNOMBRE    = 'Nombre :';
		$lREFERENCIA= 'Referencia :';
		$lCLIENTE   = 'Cliente :';
		$lOBJETIVO  = 'Objetivo :';
		$lSITUACION = 'Situación :';
		$lPROPUESTA = 'Propuesta :';
		$lRESULTADOS= 'Resultados :';
	}
	if (!$oProyecto->findId($stID)){die($stERROR);}
/*---------------------------------------------------------------------------*/	
	$stRUTA = getLocal('FPR');
	$stLOGO = $oProyecto->Imagen?$stRUTA.$oProyecto->Imagen:'';

	$oMyDB = new clsMyDB();
	$arFotos = array();
	$rsFotos = $oMyDB->Query("SELECT imgImagen FROM proyectos_imagenes WHERE imgProyecto = $stID ORDER BY imgCarga LIMIT 3;");
	if ($rsFotos){while ($fila = mysql_fetch_assoc($rsFotos)) {$arFotos[] = $stRUTA.'c'.$fila['imgImagen'];}}
/*---------------------------------------------------------------------------*/
	function check_texto($texto){
		$cantMx = 47; $xTexto = ''; $auxTex = 0; $cantLn = 1;
		$aTexto = explode(" ", str_replace("\n"," ",$texto));

		for ($i=0; $i<count($aTexto); $i++){
			$auxTex += strlen($aTexto[$i]);
			if ($auxTex >= $cantMx){
				$aTexto[$i] = $aTexto[$i]."\n"; $auxTex = 0; $cantLn++;
			} else {
				$aTexto[$i] = $aTexto[$i]." ";
			}
			$xTexto .= $aTexto[$i];
		}
		return array($xTexto, $cantLn);
	}
/*---------------------------------------------------------------------------*/	
	$arReferencia= $oProyecto->Referencia? check_texto($oProyecto->Referencia):array();
	$arCliente   = $oProyecto->Cliente   ? check_texto($oProyecto->Cliente)   :array();
	$arObjetivo  = $oProyecto->Objetivo  ? check_texto($oProyecto->Objetivo)  :array();
	$arSituacion = $oProyecto->Situacion ? check_texto($oProyecto->Situacion) :array();
	$arPropuesta = $oProyecto->Propuesta ? check_texto($oProyecto->Propuesta) :array();
	$arResultados= $oProyecto->Resultados? check_texto($oProyecto->Resultados):array();
/*---------------------------------------------------------------------------*/
	$posY = 50;
	$rutaPdfI = getLocal('PDFI');
	require_once $rutaPdfI.'fpdi.php';

	$pdf =& new FPDI(); 
	$pagecount = $pdf->setSourceFile($rutaPdfI.$stQT.$_SESSION['_front_idioma'].'.pdf');
	$tplidx = $pdf->importPage(1);

	$pdf->addPage();
	$pdf->useTemplate($tplidx);
	$pdf->SetDisplayMode('real');
	/**/
	$yImg = 40;
	if ($stLOGO){$pdf->Image($stLOGO,156,$yImg,50);} else {$yImg = -5;}
	foreach ($arFotos as $fot){$yImg += 45; $pdf->Image($fot,156,$yImg,50);}
	/**/
/*---------------------------------------------------------------------------*/
	$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
	$pdf->SetFont('Arial','B',11);
	$pdf->Text(54, $posY, $oProyecto->Nombre);
	$pdf->Line(54, $posY + 2, 150, $posY + 2);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
	$pdf->Text(15, $posY, $lNOMBRE);
	$pdf->Line(0, $posY + 2, 52, $posY + 2);
/*---------------------------------------------------------------------------*/
	if (count($arReferencia) > 0){
		$posY += 8;
		$pdf->SetXY(54, $posY);
		$posY = (4 * $arReferencia[1]) + $posY;
	
		$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
		$pdf->SetFont('Arial','BI',9);
		$pdf->MultiCell(150, 4, $arReferencia[0]);
		$pdf->Line(54, $posY + 2, 150, $posY + 2);
	
		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
		$pdf->Text(15, $posY, $lREFERENCIA);
		$pdf->Line(0, $posY + 2, 52, $posY + 2);
	}
/*---------------------------------------------------------------------------*/
	if (count($arCliente) > 0){
		$posY += 3;
		$pdf->SetXY(54, $posY);
		$posY = (4 * $arCliente[1]) + $posY;
		$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(150, 4, $arCliente[0]);
		$pdf->Line(54,$posY + 2,150,$posY + 2);
	
		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
		$pdf->Text(15, $posY, $lCLIENTE);
		$pdf->Line(0,$posY + 2,52,$posY + 2);
	}
/*---------------------------------------------------------------------------*/
	if (count($arObjetivo) > 0){
		$posY += 3;
		$pdf->SetXY(54, $posY);
		$posY = (4 * $arObjetivo[1]) + $posY;
		
		if ($posY > 270){
			$posY = 50;
			$pdf->AddPage();
			$pdf->useTemplate($tplidx);
			$pdf->SetXY(54, $posY);
			$posY = (4 * $arObjetivo[1]) + $posY;
		}
		$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(150, 4, $arObjetivo[0]);
		$pdf->Line(54, $posY + 2, 150, $posY + 2);
	
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
		$pdf->Text(15, $posY, $lOBJETIVO);
		$pdf->Line(0, $posY + 2, 52, $posY + 2);
	}
/*---------------------------------------------------------------------------*/
	if (count($arSituacion) > 0){
		$posY += 3;
		$pdf->SetXY(54, $posY);
		$posY = (4 * $arSituacion[1]) + $posY;
		
		if ($posY > 270){
			$posY = 50;
			$pdf->AddPage();
			$pdf->useTemplate($tplidx);
			$pdf->SetXY(54, $posY);
			$posY = (4 * $arSituacion[1]) + $posY;
		}
		$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(150, 4, $arSituacion[0]);
		$pdf->Line(54, $posY + 2, 150, $posY + 2);
	
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
		$pdf->Text(15, $posY, $lSITUACION);
		$pdf->Line(0, $posY + 2, 52, $posY + 2);	
	}
/*---------------------------------------------------------------------------*/
	if (count($arPropuesta) > 0){
		$posY += 3;
		$pdf->SetXY(54, $posY);
		$posY = (4 * $arPropuesta[1]) + $posY;
		
		if ($posY > 270){
			$posY = 50;
			$pdf->AddPage();
			$pdf->useTemplate($tplidx);
			$pdf->SetXY(54, $posY);
			$posY = (4 * $arPropuesta[1]) + $posY;
		}
		$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(150, 4, $arPropuesta[0]);
		$pdf->Line(54, $posY + 2, 150, $posY + 2);
	
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
		$pdf->Text(15, $posY, $lPROPUESTA);
		$pdf->Line(0, $posY + 2, 52, $posY + 2);	
	}
/*---------------------------------------------------------------------------*/
	if (count($arResultados) > 0){
		$posY += 3;
		$pdf->SetXY(54, $posY);
		$posY = (4 * $arResultados[1]) + $posY;
	
		if ($posY > 270){
			$posY = 50;
			$pdf->AddPage();
			$pdf->useTemplate($tplidx);
			$pdf->SetXY(54, $posY);
			$posY = (4 * $arResultados[1]) + $posY;
		}
		$pdf->SetTextColor(124); $pdf->SetDrawColor(210);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(150, 4, $arResultados[0]);
		$pdf->Line(54, $posY + 2, 150, $posY + 2);
	
		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(255); $pdf->SetDrawColor(255);
		$pdf->Text(15, $posY, $lRESULTADOS);
		$pdf->Line(0, $posY + 2, 52, $posY + 2);	
	}
/*---------------------------------------------------------------------------*/
	$pdf->Output('project_brochure.pdf', 'I'); 
?>