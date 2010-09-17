<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsImagenes {
		var $Id = 0;
		var $Proyecto= 0;
		var $Imagen  = '';
		var $Carga   = '';
		var $Errores = array();
		var $DB;

		function clsImagenes(){
			$this->clearImagenes();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){
				$this->Errores = $this->DB->Errores;
			}
		}
		function clearImagenes(){
			$this->Id = 0;
			$this->Proyecto= 0;
			$this->Imagen  = '';
			$this->Carga   = '';
			$this->Errores = array();
		}
		function Validar(){if (empty($this->Errores)){return TRUE;} else {return FALSE;}}
		function Registrar(){
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO proyectos_imagenes (imgProyecto, imgImagen, imgCarga) ".
						 "VALUES ($this->Proyecto, '$this->Imagen', '$this->Carga');";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'La imagen no puede ser registrada.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			return TRUE;
		}
		function Modificar(){
			if (!$this->DB->Query("SELECT imgId FROM proyectos_imagenes WHERE imgId = $this->Id;")){
				$this->Errores['Modificar'] = "La imagen que quiere modificar no existe."; return FALSE;
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE proyectos_imagenes SET imgProyecto = $this->Proyecto, imgImagen = '$this->Imagen' WHERE imgId = $this->Id;";
			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "La imagen no puede ser modificada."; return FALSE;
			}
			return TRUE;
		}
		function Borrar($ruta){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar la imagen.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM proyectos_imagenes WHERE imgId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al eliminar la imagen.'; return FALSE;
			}
			@unlink($ruta.$this->Imagen);
			@unlink($ruta.'c'.$this->Imagen);

			return TRUE;
		}
		function findId($valor){
			$this->Id = (integer) $valor;
			
			if ($this->Id <= 0){
				$this->Errores['Id'] = 'Error interno.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM proyectos_imagenes WHERE imgId = $this->Id;");
			if (!$result){
				$this->Errores['Id'] = "La imagen no existe."; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['imgId'];
			$this->Proyecto= $datos['imgProyecto'];
			$this->Imagen  = $datos['imgImagen'];
			$this->Carga   = $datos['imgCarga'];

			return TRUE;
		}
//----------------------------------------------------------
		function clearErrores(){$this->Errores = array();}
		function hasErrores(){if (empty($this->Errores)){return FALSE;} else {return TRUE;}}
		function getErrores(){
			$error = '';
			foreach($this->Errores as $descripcion){$error .= $descripcion.'<br>';}
			return $error;
		}
//----------------------------------------------------------
		function getTitulo($codigo){
			$nombre = 'este proyecto';
			$result = $this->DB->Query("SELECT proNombre as Nombre FROM proyectos WHERE proId = $codigo;");
			if ($result){
				$datos = mysql_fetch_assoc($result);
				$nombre= $this->DB->forShow($datos['Nombre']);
			}
			return $nombre;
		}
//----------------------------------------------------------
		function setImagen($valor, $uploaddir, $img_anterior = ''){
			if ($valor['size'] == 0){
				$this->Errores['Imagen'] = "Debe ingresar la imagen.";
			}
			elseif (!($valor['type']=="image/jpeg" || $valor['type']=="image/pjpeg" || $valor['type']=="image/gif")){
				$this->Errores['Imagen'] = "La imagen debe ser JPG ó GIF.";
			} else {
				$ext = strtolower(strrchr($valor['name'], '.'));
				$uploadfile = time().$ext;
				$upload_tmb = 'c'.$uploadfile;

				if (move_uploaded_file($valor['tmp_name'], $uploaddir.$uploadfile)){
					if ($img_anterior){
						@unlink($uploaddir.$img_anterior);
						@unlink($uploaddir.'c'.$img_anterior);
					}
					if (!chmod($uploaddir.$uploadfile, 0755)) {
						$this->Errores['Imagen'] = "No fue posible cambiar los permisos de la imagen.";
					} else {
						$this->Imagen = $uploadfile;

						$this->DB->redimensionar($uploadfile,$uploadfile,$uploaddir,$ext,440,330);
						$this->DB->redimensionar($uploadfile,$upload_tmb,$uploaddir,$ext,180,135);
					}
				} else {
					$this->Errores['Imagen'] = "La imagen no puede ser cargada.";
		}}}
		function getImagen(){return $this->Imagen;}
//----------------------------------------------------------
		function setProyecto($valor){$this->Proyecto = (integer) $valor;}
		function getProyecto(){return $this->Proyecto;}
//----------------------------------------------------------
		function setCarga($valor){$this->Carga = $valor;}
		function getCarga(){return $this->Carga;}
//----------------------------------------------------------
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Error interno.';}
		}
		function getId(){return $this->Id;}
//----------------------------------------------------------
	}
?>