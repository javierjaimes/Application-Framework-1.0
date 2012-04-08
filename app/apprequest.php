<?php
class AppRequest extends AppClient{
	function __construct(){
		
	}
	
	function getCategorias($linea){
		$this->objeto = new Catalogo();
		if($categorias = $this->objeto->getCategorias($linea)){
		foreach($categorias as $categoria){
			print $categoria['id'] . "-" . $categoria['nombre'] . ",";	
		}
		}else{
			print "false";
		}
	}
	
	function getCiudades($estado){
		$this->objeto = new Catalogo();
		if($ciudades = $this->objeto->getCiudades($estado)){
		foreach($ciudades as $ciudad){
			print $ciudad['id'] . "-" . $ciudad['nombre'] . ",";	
		}
		}else{
			print "false";
		}
	}
}
?>