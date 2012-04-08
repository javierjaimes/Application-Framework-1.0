<?php
require_once('appadmin.php');
$appadmin = new AppAdmin();

if(!empty($_SESSION['id'])){
	session_unset();
	session_destroy();
}
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
if(isset($usuario) && isset($clave)){
	$appadmin->getLogin($usuario,$clave);	
}else{
	$appadmin->main();	
}

?>
