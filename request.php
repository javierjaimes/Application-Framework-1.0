<?php
require_once('app.php');
$app = new App();
$request = new AppRequest();

//parametros
$metodo = $_GET['get'];
$params = $_GET['params'];
 
if(method_exists($request,$metodo)){
	if(isset($params)){
		$request->$metodo($params);
	}else{
		$request->$metodo();	
	}
}else{
	echo "no existe!";	
}
?>