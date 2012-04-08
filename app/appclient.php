<?php
class AppClient extends AppConf{		
	var $objeto;
	var $result;
	
	var $meses = array(
		"01" => "Ene",
		"02" => "Feb",
		"03" => "Mar",
		"04" => "Abr",
		"05" => "May",
		"06" => "Jun",
		"07" => "Jul",
		"08" => "Ago",
		"09" => "Sep",
		"10" => "Oct",
		"11" => "Nov",
		"12" => "Dic"
	);	

	function __construct(){
		parent::__construct();
	}	
	
	function getFormatFecha($fecha){
		$fecha  = explode("-",$fecha);
		return $fecha[2] . " " . $this->meses[$fecha[1]];		
	}
	
	function getUniqueCode($tamaño = 6){
		$codigo = md5(uniqid(rand(),true));
		if($tamaño != ""){
			return substr($codigo,0,$tamaño);
		}else{
			return $codigo;
		}
	}
	
	function rename($string){		
		$patron[0] = "/ /";
		$patron[1] = "/ñ/";
		$patron[2] = "/Ñ/";
		$patron[3] = "/[.]/";
		$patron[4] = "/@/";
		$patron[5] = "/á/";
		$patron[6] = "/é/";
		$patron[7] = "/í/";
		$patron[8] = "/ó/";
		$patron[9] = "/ú/";
		$patron[10] = "/'/";
		
		$reemplazo[0] = "";
		$reemplazo[1] = "n";
		$reemplazo[2] = "n";
		$reemplazo[3] = "";
		$reemplazo[4] = "";
		$reemplazo[5] = "a";
		$reemplazo[6] = "e";
		$reemplazo[7] = "i";
		$reemplazo[8] = "o";
		$reemplazo[9] = "u";
		$reemplazo[10] = "";
				
		return strtolower(preg_replace($patron,$reemplazo,$string));	
	}
	
	
	function tiniUrl($string, $modo = ""){
		if(!$modo){
			//return "hola mundo";
			$string = preg_replace("/\.$/","",$string);		
			$caracteres = array(" ");
			return strtolower(str_replace($caracteres,"_",$string));
			//return strtolower(str_replace(' ', '_', $string));		
		}else{
			//return strtolower(str_replace('_', ' ', $string));
			return str_replace("_", " ", preg_replace('/html$/', '', $string));
		}
	}
	
	
}
?>