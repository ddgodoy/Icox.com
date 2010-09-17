<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsSubcategorias{
		var $Id  = 0;
		var $Nombre = '';
		var $Categoria = 0;
		var $Errores = array();
		var $DB;

		function clsSubcategorias(){
			$this->clearSubcategorias();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearSubcategorias(){
			$this->Id  = 0;
			$this->Nombre = '';
			$this->Categoria = 0;
			$this->Errores= array();
		}
		function Validar(){
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO subcategorias (subNombre, subCategoria) VALUES ('$this->Nombre', $this->Categoria);";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'La subcategoria no puede ser registrada.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			return TRUE;
		}
		function Modificar(){
			if (!$this->DB->Query("SELECT subId FROM subcategorias WHERE subId = $this->Id;")){
				$this->Errores['Modificar'] = "La subcategoria que quiere modificar no existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE subcategorias SET subNombre = '$this->Nombre', subCategoria = $this->Categoria WHERE subId = $this->Id;";
			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "La subcategoria no puede ser modificada."; return FALSE;
			}
			return TRUE;
		}
		function Borrar(){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar la subcategoria.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM subcategorias WHERE subId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al eliminar la subcategoria.'; return FALSE;
			}
			$this->DB->Command("DELETE FROM proyectos_subcategorias WHERE subcategoria = $this->Id;");
			return TRUE;
		}
		function findId($valor){
			$this->clearSubcategorias();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'El Id debe ser mayor a cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM subcategorias WHERE subId = $this->Id;");
			if (!$result){
				$this->Errores['Id'] = 'La subcategoria no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['subId'];
			$this->Nombre = $datos['subNombre'];
			$this->Categoria = $datos['subCategoria'];

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
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Debe ingresar el id.';}
		}
		function getId(){return $this->Id;}
//----------------------------------------------------------
		function setCategoria($valor){
			$this->Categoria = (integer) $valor;
			if (empty($this->Categoria)){$this->Errores['Categoria'] = 'Debe seleccionar una categoria.';}
		}
		function getCategoria(){return $this->Categoria;}
	}
?>