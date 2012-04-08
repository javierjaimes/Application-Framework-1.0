<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $this->app['sitename'] ?></title>
<link rel="stylesheet" type="text/css" href="<?= $this->getStyleSheet() ?>" />
<?php $this->getScript($this->scripts) ?>
</head>

<body>
	<div id="pagina">
    	<div id="inicio">
        	<div id="titulo"><h1><a href="<?= $this->app['panelurl'] ?>"><?= $this->app['sitename'] ?></a></h1></div>
        </div>
        <div id="contenido">
        	<div id="menu">
            	<?php if(!empty($_SESSION['id'])): ?>
            	<ul>
                	<li><a href="?url=home" class="activo">Hoy</a></li>
                    <li><a href="?url=noticias">Noticias</a></li>
                    <li><a href="?url=sermones">Sermones</a></li>
                    <li><a href="?url=calendario">Calendario</a></li>
                    <li><a href="?url=galeria">Galerias</a></li>                                                
                </ul>
                <?php else: ?>
                <ul>
                	<li><a href="<?= $this->app['panelurl'] ?>?url=olvido_clave" class="activo">olvido su clave?</a></li>
                	<li><a href="<?= $this->app['siteurl'] ?>">&laquo; regresar a <?= $this->app['sitename'] ?></a></li>
                </ul>
                <?php endif ?>
            </div>
            <div id="documento">
				<?php if(!empty($_SESSION['id'])): ?>
                <div id="aplicacion">
                    <p><a href="?url=settings">configurar</a> | <a href="?url=logout">cerrar sesion</a></p>
                </div>
                <? endif ?>