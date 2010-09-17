<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsProyectos{
		var $Id = 0;
		var $Orden     = 0;
		var $Nombre    = '';
		var $Referencia= '';
		var $Cliente   = '';
		var $Objetivo  = '';
		var $Situacion = '';
		var $Propuesta = '';
		var $Resultados= '';
		var $Imagen    = '';

		var $Objetivo_en  = '';
		var $Situacion_en = '';
		var $Propuesta_en = '';
		var $Resultados_en= '';

		var $Errores   = array();
		var $DB;

		function clsProyectos(){
			$this->clearProyectos();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearProyectos(){
			$this->Id = 0;
			$this->Orden     = 0;
			$this->Nombre    = '';
			$this->Referencia= '';
			$this->Cliente   = '';
			$this->Objetivo  = '';
			$this->Situacion = '';
			$this->Propuesta = '';
			$this->Resultados= '';
			
			$this->Objetivo_en  = '';
			$this->Situacion_en = '';
			$this->Propuesta_en = '';
			$this->Resultados_en= '';
			
			$this->Imagen    = '';
			$this->Errores   = array();
		}
		function Validar(){
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO proyectos (proOrden, proNombre, proReferencia, proCliente, proObjetivo, ".
						 "proSituacion, proPropuesta, proResultados, proImagen, proObjetivo_en, proSituacion_en, ".
						 "proPropuesta_en, proResultados_en) VALUES ($this->Orden, '$this->Nombre', '$this->Referencia', ".
						 "'$this->Cliente', '$this->Objetivo', '$this->Situacion', '$this->Propuesta', '$this->Resultados".
						 "', '$this->Imagen', '$this->Objetivo_en', '$this->Situacion_en', '$this->Propuesta_en', '$this->Resultados_en');";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'El proyecto no puede ser registrado.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			$this->checkOrden();

			return TRUE;
		}		
		function Modificar(){
			$result = $this->DB->Query("SELECT proId FROM proyectos WHERE proId = $this->Id;");
			if (!$result){
				$this->Errores['Modificar'] = "El proyecto no existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE proyectos SET proOrden = $this->Orden, proNombre = '$this->Nombre', ".
							"proReferencia = '$this->Referencia', proCliente = '$this->Cliente', ".
							"proObjetivo = '$this->Objetivo', proSituacion = '$this->Situacion', ".
							"proPropuesta = '$this->Propuesta', proResultados = '$this->Resultados', ".
							"proImagen = '$this->Imagen', proObjetivo_en = '$this->Objetivo_en', ".
							"proSituacion_en = '$this->Situacion_en', proPropuesta_en = '$this->Propuesta_en', ".
							"proResultados_en = '$this->Resultados_en' WHERE proId = $this->Id;";
			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "El proyecto no puede ser modificado."; return FALSE;
			}
			$this->checkOrden();

			return TRUE;
		}
		function Borrar($ruta){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al tratar de eliminar el proyecto.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM proyectos WHERE proId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al tratar de eliminar el proyecto.'; return FALSE;
			}
			@unlink($ruta.$this->Imagen);

			$rImages = $this->DB->Query("SELECT imgImagen FROM proyectos_imagenes WHERE imgProyecto = $this->Id;");
			while ($rImages && $fila = mysql_fetch_assoc($rImages)){
				@unlink($ruta.$fila['imgImagen']);
				@unlink($ruta.'c_'.$fila['imgImagen']);
			}
			$this->DB->Command("DELETE FROM proyectos_imagenes WHERE imgProyecto = $this->Id;");
			/*-------------------------------------------------------------------------------------------*/
			$ord = 0;
			$res = $this->DB->Query("SELECT * FROM proyectos ORDER BY proOrden;");
			while ($res && $dat = mysql_fetch_assoc($res)){
				$ord++; $sId = $dat['proId'];
				$this->DB->Command("UPDATE proyectos SET proOrden = $ord WHERE proId = $sId;");
			}
			/*-------------------------------------------------------------------------------------------*/
			$this->DB->Command("DELETE FROM proyectos_industrias WHERE proyecto = $this->Id;");
			$this->DB->Command("DELETE FROM proyectos_categorias WHERE proyecto = $this->Id;");
			$this->DB->Command("DELETE FROM proyectos_subcategorias WHERE proyecto = $this->Id;");
			/*-------------------------------------------------------------------------------------------*/
			return TRUE;
		}
		function findId($valor){
			$this->clearProyectos();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'Error interno.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM proyectos WHERE proId = $this->Id;");
			if (!$result){
				$this->Errores['Id'] = 'El proyecto no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['proId'];
			$this->Orden     = $datos['proOrden'];
			$this->Nombre    = $datos['proNombre'];
			$this->Referencia= $datos['proReferencia'];
			$this->Cliente   = $datos['proCliente'];
			$this->Objetivo  = $datos['proObjetivo'];
			$this->Situacion = $datos['proSituacion'];
			$this->Propuesta = $datos['proPropuesta'];
			$this->Resultados= $datos['proResultados'];
			$this->Imagen    = $datos['proImagen'];

			$this->Objetivo_en  = $datos['proObjetivo_en'];
			$this->Situacion_en = $datos['proSituacion_en'];
			$this->Propuesta_en = $datos['proPropuesta_en'];
			$this->Resultados_en= $datos['proResultados_en'];

			return TRUE;
		}
		function actualizarDatos($valor){
			$this->DB->Command("UPDATE proyectos_imagenes SET imgProyecto = $this->Id WHERE imgProyecto = $valor;");
		}
//----------------------------------------------------------
		function clearErrores(){$this->Errores = array();}
		function hasErrores(){
			if (empty($this->Errores)){return FALSE;} else {return TRUE;}
		}
		function getErrores(){
			$error = '';
			foreach($this->Errores as $descripcion){$error .= $descripcion.'<br>';}
			return $error;
		}
//----------------------------------------------------------
		function setOrden($valor){
			$this->Orden = (integer) $valor;
			if ($this->Orden == 0){
				$this->Errores['Orden'] = 'Indique un orden.';
			}
		}
		function getOrden(){return $this->Orden;}
//----------------------------------------------------------
		function setNombre($valor){
			$this->Nombre = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['Nombre'] = 'Complete el nombre.';
			}
		}
		function getNombre(){return $this->DB->forShow($this->Nombre);}
		function editNombre(){return $this->DB->forEdit($this->Nombre);}
//----------------------------------------------------------
		function setReferencia($valor){$this->Referencia = $this->DB->forSave($valor);}
		function getReferencia(){return $this->DB->forShow($this->Referencia);}
		function editReferencia(){return $this->DB->forEdit($this->Referencia);}
//----------------------------------------------------------
		function setCliente($valor){$this->Cliente = $this->DB->forSave($valor);}
		function getCliente(){return $this->DB->forShow($this->Cliente);}
		function editCliente(){return $this->DB->forEdit($this->Cliente);}
//----------------------------------------------------------
		function setObjetivo($valor){$this->Objetivo = $this->DB->forSave($valor);}
		function getObjetivo(){return $this->DB->forShow($this->Objetivo);}
		function editObjetivo(){return $this->DB->forEdit($this->Objetivo);}
//----------------------------------------------------------
		function setSituacion($valor){$this->Situacion = $this->DB->forSave($valor);}
		function getSituacion(){return $this->DB->forShow($this->Situacion);}
		function editSituacion(){return $this->DB->forEdit($this->Situacion);}
//----------------------------------------------------------
		function setPropuesta($valor){$this->Propuesta = $this->DB->forSave($valor);}
		function getPropuesta(){return $this->DB->forShow($this->Propuesta);}
		function editPropuesta(){return $this->DB->forEdit($this->Propuesta);}
//----------------------------------------------------------
		function setResultados($valor){$this->Resultados = $this->DB->forSave($valor);}
		function getResultados(){return $this->DB->forShow($this->Resultados);}
		function editResultados(){return $this->DB->forEdit($this->Resultados);}
//----------------------------------------------------------
		function setObjetivo_en($valor){$this->Objetivo_en = $this->DB->forSave($valor);}
		function getObjetivo_en(){return $this->DB->forShow($this->Objetivo_en);}
		function editObjetivo_en(){return $this->DB->forEdit($this->Objetivo_en);}
//----------------------------------------------------------
		function setSituacion_en($valor){$this->Situacion_en = $this->DB->forSave($valor);}
		function getSituacion_en(){return $this->DB->forShow($this->Situacion_en);}
		function editSituacion_en(){return $this->DB->forEdit($this->Situacion_en);}
//----------------------------------------------------------
		function setPropuesta_en($valor){$this->Propuesta_en = $this->DB->forSave($valor);}
		function getPropuesta_en(){return $this->DB->forShow($this->Propuesta_en);}
		function editPropuesta_en(){return $this->DB->forEdit($this->Propuesta_en);}
//----------------------------------------------------------
		function setResultados_en($valor){$this->Resultados_en = $this->DB->forSave($valor);}
		function getResultados_en(){return $this->DB->forShow($this->Resultados_en);}
		function editResultados_en(){return $this->DB->forEdit($this->Resultados_en);}
//----------------------------------------------------------
		function setImagen($valor, $uploaddir, $img_anterior = ''){
			if ($valor['size'] == 0){
				$this->Errores['Imagen'] = "Debe ingresar la imagen.";
			}
			elseif (!($valor['type']=="image/jpeg" || $valor['type']=="image/pjpeg" || $valor['type']=="image/gif")){
				$this->Errores['Imagen'] = "La imagen debe ser JPG ó GIF.";
			} else {
				$ext = strtolower(strrchr($valor['name'], '.'));
				$uploadfile = 'p_'.time().$ext;

				if (move_uploaded_file($valor['tmp_name'], $uploaddir.$uploadfile)){
					if ($img_anterior){
						@unlink($uploaddir.$img_anterior);
					}
					if (!chmod($uploaddir.$uploadfile, 0755)) {
						$this->Errores['Imagen'] = "No fue posible cambiar los permisos de la imagen.";
					} else {
						$this->Imagen = $uploadfile;
						$this->DB->redimensionar($uploadfile,$uploadfile,$uploaddir,$ext,160,120);
					}
				} else {
					$this->Errores['Imagen'] = "La imagen no puede ser cargada.";
		}}}
		function getImagen(){return $this->Imagen;}
//----------------------------------------------------------
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Error interno.';}
		}
		function getId(){return $this->Id;}
//----------------------------------------------------------
		function checkOrden(){
			$res1 = $this->DB->Query("SELECT COUNT(proId) as cuantos FROM proyectos WHERE proOrden = $this->Orden;");
			$dat1 = mysql_fetch_assoc($res1);

			if ($dat1['cuantos'] > 1){
				$ordn = 0;
				$res2 = $this->DB->Query("SELECT proId, proOrden FROM proyectos WHERE proId <> $this->Id ORDER BY proOrden;");
				while ($res2 && $dat2 = mysql_fetch_assoc($res2)){
					$ordn++; $sId = $dat2['proId']; $sOr = $dat2['proOrden'];

					if ($sOr == $this->Orden){$ordn++;}
					$this->DB->Command("UPDATE proyectos SET proOrden = $ordn WHERE proId = $sId;");
		}}}
//----------------------------------------------------------
		function setIndustria($industrias){
			foreach ($industrias as $ind){
				if ($ind != 0){
					$this->DB->Command("INSERT INTO proyectos_industrias (proyecto, industria) VALUES ($this->Id, $ind);");
		}}}
		function setCategoria($categorias){
			foreach ($categorias as $cat){
				if ($cat != 0){
					$this->DB->Command("INSERT INTO proyectos_categorias (proyecto, categoria) VALUES ($this->Id, $cat);");
		}}}
		function setSubcategoria($subcategorias){
			foreach ($subcategorias as $sub){
				if ($sub != '0_0'){
					$aSub = explode('_', $sub);
					$xCat = $aSub[1]; $xSub = $aSub[0];

					$this->DB->Command("INSERT INTO proyectos_subcategorias (proyecto, categoria, subcategoria) VALUES ($this->Id, $xCat, $xSub);");
		}}}
//----------------------------------------------------------
		function delTablasMovimiento(){
			$this->DB->Command("DELETE FROM proyectos_industrias WHERE proyecto = $this->Id;");
			$this->DB->Command("DELETE FROM proyectos_categorias WHERE proyecto = $this->Id;");
			$this->DB->Command("DELETE FROM proyectos_subcategorias WHERE proyecto = $this->Id;");
		}
//----------------------------------------------------------
		function getIndustrias(){
			$aInd = array();
			$rInf = $this->DB->Query("SELECT industria FROM proyectos_industrias WHERE proyecto = $this->Id;");
			while ($rInf && $fInd = mysql_fetch_assoc($rInf)){
				$aInd[] = $fInd['industria'];
			}
			return $aInd;
		}
		function getCategorias(){
			$aCat = array();
			$rCat = $this->DB->Query("SELECT categoria FROM proyectos_categorias WHERE proyecto = $this->Id;");
			while ($rCat && $fCat = mysql_fetch_assoc($rCat)){
				$aCat[] = $fCat['categoria'];
			}
			return $aCat;
		}
		function getSubcategorias(){
			$aSub = array();
			$rSub = $this->DB->Query("SELECT * FROM proyectos_subcategorias WHERE proyecto = $this->Id;");
			while ($rSub && $fSub = mysql_fetch_assoc($rSub)){
				$aSub[] = $fSub['subcategoria'].'_'.$fSub['categoria'];
			}
			return $aSub;
		}
//----------------------------------------------------------
	}
?>