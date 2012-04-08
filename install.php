<?php
	//echo $url = "http://" . $_SERVER['HTTP_HOST'] ;
	//echo " " .$path = $_SERVER['DOCUMENT_ROOT']  ;
	$install = $_GET['step'];
	if(isset($install)){
		require('config.php');
		$link = mysql_connect(BD_HOST, BD_USUARIO, BD_CLAVE) or die("error conectando");
		if($link){
			mysql_select_db(BD_NOMBRE, $link) or die("error seleccionando la base de datos");
		}
		
		
		if($install == 1){
			
			$sitio = $_POST['sitio'];
			$email = $_POST['email']; 
			
			$url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			$path = $_SERVER['DOCUMENT_ROOT']  . dirname($_SERVER['PHP_SELF']);
			
			
				
			$sql = "CREATE TABLE IF NOT EXISTS ".PREFIX."opciones (
				opciones_id int(11) NOT NULL auto_increment,
				opciones_nombre varchar(100) NOT NULL,
				opciones_valor varchar(100) NOT NULL,
				PRIMARY KEY  (opciones_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
			$ejecutar = mysql_query($sql, $link);
			if($ejecutar){				
				$sql = "INSERT INTO ".PREFIX."opciones (opciones_id, opciones_nombre, opciones_valor) VALUES(NULL, 'sitename', '$sitio'),(NULL, 'siteurl', '$url'),(NULL, 'sitepath', '$path'),(NULL, 'app_email', '$email');";				
				$ejecutar = mysql_query($sql, $link);
				if($ejecutar){
					header("location: ./install.php?step=2");
				}
			}
		}elseif($install == 2){
			$sql = "CREATE TABLE IF NOT EXISTS `".PREFIX."usuarios` (
			  `usuarios_id` int(11) NOT NULL auto_increment,
			  `usuarios_login` varchar(100) NOT NULL,
			  `usuarios_clave` varchar(100) NOT NULL,
			  PRIMARY KEY  (`usuarios_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			$ejecutar = mysql_query($sql);
			if($ejecutar){
				$sql = "CREATE TABLE IF NOT EXISTS `".PREFIX."usuariosmetadata` (
				  `usuariosmetadata_id` int(11) NOT NULL auto_increment,
				  `usuariosmetadata_nombre` varchar(200) NOT NULL,
				  `usuariosmetadata_cedula` int(11) NOT NULL,
				  `usuariosmetadata_telefono` text NOT NULL,
				  `usuariosmetadata_direccion` text NOT NULL,
				  `usuariosmetadata_email` varchar(200) NOT NULL,
				  `usuarios_id` int(11) NOT NULL,
				  PRIMARY KEY  (`usuariosmetadata_id`),
				  KEY `usuarios_id` (`usuarios_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";		
				$ejecutar = mysql_query($sql);		
			}
		}elseif($install == 3){
			$usuario = $_POST['usuario'];
			$clave = $_POST['clave'];
			$nombre = $_POST['nombre'];
			$email = $_POST['email'];
			
			//$alfanumerico = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			//$clave = substr(substr($alfanumerico, rand(1, strlen($alfanumerico))), 0, 6);
			
			$sql = "INSERT INTO ".PREFIX."usuarios (usuarios_id, usuarios_login, usuarios_clave) VALUES(NULL, '$usuario', MD5('$clave'))";	
			$ejecutar = mysql_query($sql);
			if($ejecutar){
				$sql = "SELECT MAX(usuarios_id) AS id FROM ".PREFIX."usuarios";
				if($ejecutar = mysql_query($sql)){
					$usuario_id = mysql_fetch_array($ejecutar);
					$sql = "INSERT INTO `".PREFIX."usuariosmetadata` VALUES(NULL, '$nombre', '0', '', '', '$email', {$usuario_id['id']});";
					if($ejecutar = mysql_query($sql)){						
					} 
				}				
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Install App...</title>
</head>

<body>
	<div id="pagina">
    	<?php if(!isset($install)): ?>
    	
    	<h1>Installar App...</h1>
        <form action="<?= $_SERVER['PHP_SELF']; ?>?step=1" method="post">
        	<label for="sitio">Sitio:</label>
            <input type="text" name="sitio" />
            <label for="email">Email:</label>
        	<input type="text" name="email" />
            <input type="submit" value="siguiente" />
        </form>
        <?php elseif(isset($install) && $install == 2): ?>
        <form action="<?= $_SERVER['PHP_SELF']; ?>?step=3" method="post">
        	<label for="usuario">Usuario</label>
        	<input type="text" name="usuario" />
        	<label for="clave">Clave</label>
        	<input type="password" name="clave" />
        	<label for="nombre">Nombre</label>
        	<input type="text" name="nombre" />        	
        	<label for="nombre">Email</label>
        	<input type="text" name="email" />
        	<input type="submit" value="siguiente" />        	
        </form>
        
        <?php elseif(isset($install) && $install == 3): ?>
        <h1>Installacion perfecta...</h1>
        <p>aqui tienes tus datos de acceso:</p>
        <p><strong>usuario:</strong><?php echo $usuario ?></p>
        <p><strong>clave:</strong> <?= $clave ?></p>
        <?php endif ?>
    </div>
</body>
</html>
