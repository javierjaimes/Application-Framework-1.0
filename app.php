<?php
require_once(dirname(__FILE__) . "/appconf.php");
class App extends AppConf{
	
	var $params = array();
	
	var $script;
	var $date;
	
	var $sql;
	
	var $session = false;
	
	function __construct(){	
		parent::__construct();
		
		if($this->hasSession()){
			$this->session = $_SESSION;
		}
	}	
	
	function getStyleSheet(){
		$this->urlStyle = $this->app['siteurl'] . "/theme/style.css";
		return $this->urlStyle;		
	}		
	function getHeader($includes = null, $dependencias = null){
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
		include($this->app['sitepath'] . "/theme/header.php");
	}	
	function getFooter(){
		include($this->app['sitepath'] . "/theme/footer.php");
	}
	function getSideBar(){
		include($this->app['sitepath'] . "/theme/sidebar.php");	
	}
	function getScript($script = null){
		//print_r($this->scripts);
		if(is_null($this->scripts)){
			if(is_null($script)){				
				print $files .= "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/jquery-1.3.2.min.js\"></script>\r";
				return true;
			}else{				
				$scripts = explode(",",$script);
				foreach($scripts as $script){
					$this->scripts[] = $script;
				}
			}
		}
		
		foreach($this->scripts as $file){			
			if($file == "jquery"){		
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/jquery-1.3.2.min.js\"></script>\r";
			}elseif($file == "ui"){
				print "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $this->app['siteurl']."/includes/js/ui/css/smoothness/jquery-ui-1.7.1.css\" />\r";
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/ui/jquery-ui-1.7.1.min.js\"></script>\r";
			}elseif($file == "lightbox"){
				print "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $this->app['siteurl']."/includes/js/lightbox/css/jquery.lightbox-0.5.css\" />\r";
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/lightbox/jquery.lightbox-0.5.min.js\"></script>\r";
			}elseif($file == "validate"){						
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/validate/jquery.validate.min.js\"></script>\r";
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/validate/localization/messages_es.js\"></script>\r";
			}elseif($file == "swfupload"){
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/swfupload/swfupload.js\"></script>\r";
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/swfupload/plugins/swfupload.queue.js\"></script>\r";
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/swfupload/plugins/swfupload.speed.js\"></script>\r";
			}elseif($file == "tinymce"){						
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/tinymce/tiny_mce.js\"></script>\r";
			}elseif($file == "tmpopup"){						
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/tinymce/tiny_mce_popup.js\"></script>\r";
			}elseif($file == "jeditable"){						
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/jquery.jeditable.mini.js\"></script>\r";
			}elseif($file == "scrollable"){						
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/tools.scrollable-1.1.2.min.js\"></script>\r";
			}elseif(ereg("php",$file,$regs)){
				include($this->app['sitepath']."/includes/extras/".basename($file));
			}else{				
				print "<script type=\"text/javascript\" src=\"" . $this->app['siteurl'] . "/includes/js/" . $file . ".js\"></script>\r";
			}			
		}
		unset($this->scripts);
		//echo $this->scripts . "SOY VACIA";
	}
	function include_template($template){
		include($this->app['sitepath'] . "/theme/" . $template . ".php");
	}
	function getDate($format){
		if($format == "Mysql"){
			$this->date = "NOW()";	
		}elseif($format == "m"){
			$format = date($format);
			switch ($format){
				case 1:
					$this->date = "Enero";
					break;
				case 2:
					$this->date = "Febrero";
					break;
				case 3:
					$this->date = "Marzo";
					break;
				case 4:
					$this->date = "Abril";
					break;
				case 5:
					$this->date = "Mayo";
					break;
				case 6:
					$this->date = "Junio";
					break;
				case 7:
					$this->date = "Julio";
					break;
				case 8:
					$this->date = "Agosto";
					break;
				case 9:
					$this->date = "Septiembre";
					break;
				case 10:
					$this->date = "Octubre";
					break;
				case 11:
					$this->date = "Noviembre";
					break;
				case 12:
					$this->date = "Diciembre";
					break;
			}
		}else{
			$this->date = date($format);
		}
		return $this->date;
	}
	
	function getLogin($usuario, $clave, $url){
		//echo $redirect;
		
		$usuario = mysql_real_escape_string($usuario);
		$clave = mysql_real_escape_string($clave);
		$this->select = "SELECT u.*, um.* FROM " . PREFIX . "usuarios AS u, ".PREFIX."usuariosmetadata AS um WHERE u.usuarios_login = '$usuario' AND usuarios_clave = MD5('" . $clave . "') AND um.usuarios_id = u.usuarios_id";		
		
		//echo $this->select;
		
		if($this->db->query($this->select)){
			
			if($this->db->getNumsRows() > 0){
				
				$usuario = $this->db->getRecordset();
				$usuarios = new Usuarios();
				if(!$this->hasSession()) {
					session_start();	

					foreach($usuarios->getUsuarios($usuario['usuarios_id']) as $i => $valor){
						$_SESSION[$i] = $valor;
					}				
					$this->session = $_SESSION;
					header("location: $url");
				}				
			}else{
				header('location: inicio?login_error=1');	
			}
		}
	}
	
	function getSession(){
		return $this->session;
	}
	
	function hasSession(){		
		if(!isset($_SESSION)){
			session_start();
			if(isset($_SESSION['id'])){				
				return true;;
			}else{				
				return false;
			}
		}else{			
			return false;
		}
	}
	
	function logOut($url){
		setcookie("hacer_cita","",-1);
		session_unset();
		session_destroy();		
		header("location: $url");
	}
		
	function getLanguages($language = ""){		
		if(!$language){
			//echo "no hay lenguaje";
			$languages = preg_replace('/(;q=\d+.\d+)/i', '', getenv('HTTP_ACCEPT_LANGUAGE'));
			$languages = explode(",", $languages);
			$lang_default = array_shift($languages);
			foreach($this->languages as $language){
				if(preg_match("/$language/",$lang_default)){
									
					$variables = file($this->app['sitepath']."/lang/".$language.".txt");
					
					foreach($variables as $variable){
						$variable = explode("=",$variable);
						if(preg_match("/,/",$variable[1])){
							$this->var[$variable[0]] = explode(",",$variable[1]);
						}else{
							$this->var[$variable[0]] = $variable[1];
						}
					}
					
					return $language;
					break;
				}			
			}
		}else{			
			$variables = file($this->app['sitepath']."/lang/".$language.".txt");
			
			foreach($variables as $variable){
				$variable = explode("=",$variable);
				if(preg_match("/,/",$variable[1])){
					$this->var[$variable[0]] = explode(",",$variable[1]);
				}else{
					$this->var[$variable[0]] = $variable[1];
				}
			}
			return $language;
		}
		
		
	}
	
	function main(){		
		// LANGUAGE
		//$this->language = $this->getLanguages($this->params[0]);
		
		//usa htacces
		$url = $_GET['vars'];
		if(!$url){
			$file = $this->app['theme_dir'] . "/index.php";			
		}else{
			$url = preg_replace('/\/$/', '', $url);	
			$vars = explode('/', $url);			
			foreach($vars as $key => $var){
				$this->params[$key] = preg_replace('/[^a-zA-Z0-9-_]/', '', $var);
			}
			
			$file = $this->app['theme_dir'] . "/" . $this->params[0] . ".php";									
		}
		
		//usa variables GET
		/*foreach ($_GET as $var){
			$this->params[] = $var;
		}
		if($this->params[1]){			
			$file = $this->app['theme_dir'] . "/" . $this->params[1] . ".php";
		}else{
			$file = $this->app['theme_dir'] . "/index.php";
		}*/
		
		if(file_exists($file)){
			include($file);
		}else{
			include($this->app['theme_dir'] . "/404.php");	
		}
	}
}

?>