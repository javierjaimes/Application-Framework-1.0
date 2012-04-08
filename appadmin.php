<?php
require_once(dirname(__FILE__) . "/appconf.php");

class AppAdmin extends AppConf{
	var $scripts;
	var $urlSite;	
	
	var $session = false;
	
	function __construct(){
		parent::__construct();
		$this->app['panelurl'] = $this->app['siteurl'] . "/panel";
		$this->app['theme_url_panel']  = $this->app['sitepath'] . "/panel";
		
		session_start();		
		//print_r($usuarios->getUsuarios(1));
		if(!empty($_SESSION['id'])){			
			$this->session = $_SESSION;
		}
	}
	function getStyleSheet(){
		$this->urlStyle = $this->app['panelurl'] . "/css/style.css";
		return $this->urlStyle;
	}
	function getHeader($includes = "", $dependencias = ""){
		if($includes){
			if($dependencias){
				$dependencias = explode(",",$dependencias);
				foreach($dependencias as $dependencia){
					$this->scripts[] = $dependencia;
				}
			}
			$includes = explode(",",$includes);
			foreach($includes as $include){
				$this->scripts[] = $include;
			}
		}
		include($this->app['sitepath'] . "/panel/header.php");
	}
	
	function getScript($script){
		//print_r($script);
		if(empty($script)){			
			print '<script type="text/javascript" src="' . $this->app['siteurl'] . '/includes/js/jquery-1.3.2.min.js"></script>';				
		}else{		
			//$scripts = explode(',',$script);
			//print "<script type=\"text/javascript\" src=\"". $this->app['siteurl'] . "/includes/js/jquery-1.2.6.min.js\"></script>\r";
			foreach($script as $file){
				
					if(ereg("jquery",$file,$regs)){
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/jquery-1.3.2.min.js\"></script>\r";
					}elseif($file == "ui"){
						print "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $this->app['siteurl']."/includes/js/ui/css/smoothness/jquery-ui-1.7.custom.css\" />\r";
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/ui/jquery-ui-1.7.1.min.js\"></script>\r";
						
					}elseif(ereg("tinymce",$file,$regs)){
						//echo $file;
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/tinymce/tiny_mce.js\"></script>\r";
					}elseif(ereg("tmpopup",$file,$regs)){
						//echo $file;
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/tinymce/tiny_mce_popup.js\"></script>\r";
					}elseif(ereg("swfupload",$file,$regs)){
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/swfupload/swfupload.js\"></script>\r";
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/swfupload/plugins/swfupload.queue.js\"></script>\r";
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/swfupload/plugins/swfupload.speed.js\"></script>\r";
					}elseif(ereg("thickbox",$file,$regs)){
						print "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $this->app['siteurl']."/includes/js/thickbox/thickbox.css\" />\r";
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/thickbox/thickbox-compressed.js\"></script>\r";
					}elseif(ereg("php",$file,$regs)){
						include($this->app['theme_url_panel']."/includes/".basename($file));
					}else{
						print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl']. "/includes/js/" . $file . ".js\"></script>\r";
					}
			}	
		}
	}
	
	function getFooter(){
		include($this->app['sitepath'] . "/panel/footer.php");	
	}
	function include_template($template){
		include($this->app['sitepath'] . "/panel/" . $template . ".php");	
	}
	
	function getLogin($usuario, $clave){
		$usuario = mysql_real_escape_string($usuario);
		$clave = mysql_real_escape_string($clave);
		
		$this->select = "SELECT * FROM " . PREFIX . "usuarios WHERE usuarios_login = '" . $usuario . "' AND usuarios_clave = MD5('" . $clave . "')";
		//echo $this->select;
		if($this->db->query($this->select)){
			if($this->db->getNumsRows() > 0){
				
				$usuario = $this->db->getRecordset();	
				//print_r($usuario);
				$usuarios = new Usuarios();
				foreach($usuarios->getUsuarios($usuario['usuarios_id']) as $i => $valor){
					$_SESSION[$i] = $valor;
				}
				$this->session = $_SESSION;
				
				header('location: ./panel/?url=home');	
			}else{
				header('location: login.php?error=1');
			}
		}else{
			echo $this->select . " error";	
		}
	}
	function logOut(){
		session_unset();
		session_destroy();
		header("location: ../login.php");
	}
	function main(){
		if($this->session or isset($_POST['PHPSESSID'])){	
			$url = $_GET['url'];			
			if(!$url){			
				include($this->app['theme_url_panel'] . "/login.php");
			}else{
				include($this->app['theme_url_panel'] . "/" . $url . ".php");
			}
		}else{				
			include($this->app['theme_url_panel'] . "/login.php");
		}
	}
}
?>