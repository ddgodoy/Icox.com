<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsCategorias{
		var $Id  = 0;
		var $Nombre = '';
		var $Orden  = 0;
		var $Errores= array();
		var $DB;

		function clsCategorias(){
			$this->clearCategorias();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearCategorias(){
			$this->Id  = 0;
			$this->Nombre = '';
			$this->Orden  = 0;
			$this->Errores= array();
		}
		function Validar(){
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if ($this->DB->Query("SELECT catId FROM categorias WHERE catNombre = '$this->Nombre';")){
				$this->Errores['Modificar'] = "La categoría que quiere registrar ya existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO categorias (catNombre, catOrden) VALUES ('$this->Nombre', $this->Orden);";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'La categoría no puede ser registrada.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			$this->checkOrden();

			return TRUE;
		}
		function Modificar(){
			if (!$this->DB->Query("SELECT catId FROM categorias WHERE catId = $this->Id;")){
				$this->Errores['Modificar'] = "La categoría que quiere modificar no existe.";
			}
			if ($this->DB->Query("SELECT catId FROM categorias WHERE catNombre = '$this->Nombre' AND catId <> $this->Id;")){
				$this->Errores['Modificar'] = "La categoría que quiere modificar ya se encuentra registrada.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE categorias SET catNombre = '$this->Nombre', catOrden = $this->Orden WHERE catId = $this->Id;";
			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "La categoría no puede ser modificada."; return FALSE;
			}
			$this->checkOrden();

			return TRUE;
		}
		function Borrar(){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar la categoría.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM categorias WHERE catId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al eliminar la categoría.'; return FALSE;
			}
			/*------------------------------------------------------------------------------------------*/
			$ord = 0;
			$res = $this->DB->Query("SELECT * FROM categorias ORDER BY catOrden;");
			while ($res && $dat = mysql_fetch_assoc($res)){
				$ord++; $sId = $dat['catId'];
				$this->DB->Command("UPDATE categorias SET catOrden = $ord WHERE catId = $sId;");
			}
			$this->DB->Command("DELETE FROM proyectos_categorias WHERE categoria = $this->Id;");
			$this->DB->Command("DELETE FROM proyectos_subcategorias WHERE categoria = $this->Id;");
			$this->DB->Command("UPDATE subcategorias SET subCategoria = 0 WHERE subCategoria = $this->Id;");
			/*------------------------------------------------------------------------------------------*/
			return TRUE;
		}
		function findId($valor){
			$this->clearCategorias();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'El Id debe ser mayor a cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM categorias WHERE catId = $this->Id;");
			if (!$result){
				$this->Errores['Id'] = 'La categoría no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['catId'];
			$this->Nombre = $datos['catNombre'];
			$this->Orden  = $datos['catOrden'];

			return TRUE;
		}
		function clearErrores(){$this->Errores = array();}
		function hasErrores(){if (empty($this->Errores)){return FALSE;} else {return TRUE;}}
		function getErrores(){
			$error = '';
			foreach($this->Errores as $descripcion){$error .= $descripcion.'<br>';}
			return $error;
		}
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
		function setOrden($valor){
			$this->Orden = (integer) $valor;
			if ($this->Orden == 0){
				$this->Errores['Orden'] = 'Indique un orden.';
			}
		}
		function getOrden(){return $this->Orden;}
//----------------------------------------------------------
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Debe ingresar el id.';}
		}
		function getId(){return $this->Id;}
//----------------------------------------------------------
		function checkOrden(){
			$res1 = $this->DB->Query("SELECT COUNT(catId) as cuantos FROM categorias WHERE catOrden = $this->Orden;");
			$dat1 = mysql_fetch_assoc($res1);

			if ($dat1['cuantos'] > 1){
				$ordn = 0;
				$res2 = $this->DB->Query("SELECT catId, catOrden FROM categorias WHERE catId <> $this->Id ORDER BY catOrden;");
				while ($res2 && $dat2 = mysql_fetch_assoc($res2)){
					$ordn++; $sId = $dat2['catId']; $sOr = $dat2['catOrden'];

					if ($sOr == $this->Orden){$ordn++;}
					$this->DB->Command("UPDATE categorias SET catOrden = $ordn WHERE catId = $sId;");
		}}}
//----------------------------------------------------------
	}
?>