<?php
class Upload extends AppClient{
	
	function __construct(){
		parent::__construct();
	}
	
	function upload($file,$dir){
		$tamaño = $file['size'];
		$tipo = $file['type'];
		$nombre = $file['name'];
		
		if(move_uploaded_file($file['tmp_name'],$dir."/".$nombre)){
			return true;
		}else{
			echo "error subiendo el archivo...";	
		}
	}
	
	function uploadAndResize($file, $dir, $tamaño = 65){
		if($this->upload($file, $dir)){		
			if($this->resizeImagen($dir."/".$file['name'])){
				return true;
			}else{
				echo "Error creando el thumbnail...";
			}
		}else{
			echo "error subiendo la imagen...";	
		};
	}
	
	function resizeImagen($file, $tamaño = 128){		
		$file = pathinfo($file);
		$dirfile = $file['dirname'];		
		$basename = $file['basename'];
		$pathfile = $dirfile."/". $basename; 
		
		
		//echo  $pathfile .  "SI MUNDO";
		list($ancho, $alto, $tipo) = getimagesize($pathfile);
		

		$thancho = $tamaño;
		$thalto = $alto * $tamaño / $ancho;
		$th = imagecreatetruecolor($thancho,$thalto);
		
		if($tipo == 1){
			$thimagen = imagecreatefromgif($pathfile);
			imagecopyresampled($th,$thimagen,0,0,0,0,$thancho,$thalto,$ancho,$alto);
			imagegif($th,$dirfile."/".$tamaño."_".$basename);
			return true;
		}elseif($tipo == 2){
			$thimagen = imagecreatefromjpeg($pathfile);
			imagecopyresampled($th,$thimagen,0,0,0,0,$thancho,$thalto,$ancho,$alto);
			imagejpeg($th,$dirfile."/".$tamaño."_".$basename);
			return true;
		}elseif($tipo == 3){
			$thimagen = imagecreatefrompng($pathfile);	
			imagecopyresampled($th,$thimagen,0,0,0,0,$thancho,$thalto,$ancho,$alto);
			imagepng($th,$dirfile."/".$tamaño."_".$basename);
			return true;
		}
	}
}
?>