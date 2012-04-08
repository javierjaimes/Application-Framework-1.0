<?php
require_once('app.php');
$app = new App();

if(!$app->getSession()){
	if(isset($_POST['submit'])){		
		$app->getLogin($_POST['usuario'], $_POST['clave'],$_SERVER['HTTP_REFERER']);
	}
}else{
	if(ereg("logout", $_GET['vars'], $regs)){
		$app->logOut($_SERVER['HTTP_REFERER']);
	}
}
$app->main();
?>