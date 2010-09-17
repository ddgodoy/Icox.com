<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsIndustrias{
		var $Id  = 0;
		var $Nombre = '';
		var $Errores = array();
		var $DB;

		function clsIndustrias(){
			$this->clearIndustrias();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearIndustrias(){
			$this->Id  = 0;
			$this->Nombre = '';
			$this->Errores = array();
		}
		function Validar(){
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if ($this->DB->Query("SELECT indId FROM industrias WHERE indNombre = '$this->Nombre';")){
				$this->Errores['Modificar'] = "La industria que quiere registrar ya existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO industrias (indNombre) VALUES ('$this->Nombre');";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'La industria no puede ser registrada.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			return TRUE;
		}
		function Modificar(){
			if (!$this->DB->Query("SELECT indId FROM industrias WHERE indId = $this->Id;")){
				$this->Errores['Modificar'] = "La industria que quiere modificar no existe.";
			}
			if ($this->DB->Query("SELECT indId FROM industrias WHERE indNombre = '$this->Nombre' AND indId <> $this->Id;")){
				$this->Errores['Modificar'] = "La industria que quiere modificar ya se encuentra registrada.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE industrias SET indNombre = '$this->Nombre' WHERE indId = $this->Id;";
			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "La industria no puede ser modificada."; return FALSE;
			}
			return TRUE;
		}
		function Borrar(){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar La industria.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM industrias WHERE indId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al eliminar La industria.'; return FALSE;
			}
			$this->DB->Command("DELETE FROM proyectos_industrias WHERE industria = $this->Id;");

			return TRUE;
		}
		function findId($valor){
			$this->clearIndustrias();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'El Id debe ser mayor a cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM industrias WHERE indId = $this->Id;");
			if (!$result){
				$this->Errores['Id'] = 'La industria no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['indId'];
			$this->Nombre = $datos['indNombre'];

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
	}
?>