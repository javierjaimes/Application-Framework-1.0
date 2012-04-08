<?php
class AppConf{
	var $app;
	var $appdir;
	var $db;
	
	function __construct(){
		require(dirname(__FILE__) . "/config.php");
		
		$db_file = BD;
		$pathfile = dirname(__FILE__) . "/app/db" . "/$db_file.php";
		
		if(BD == 'mysql'){
			require_once($pathfile);
			$this->db = new Mysql(BD_HOST, BD_USUARIO, BD_CLAVE, BD_NOMBRE);
			$this->db->connect();
		}
		
		$this->select = "SELECT * FROM " . PREFIX . "opciones ORDER BY opciones_id";
		
		$this->db->query($this->select);		
		if($this->db->getNumsRows() > 0){
			while($opcion = $this->db->getRecordSet()){
				$this->app[$opcion['opciones_nombre']] = $opcion['opciones_valor'];
			}
			
			
			//stylesheet
			$this->app['app_dir'] = $this->app['sitepath'] . "/app";
			$this->app['theme_dir'] = $this->app['sitepath'] . "/theme";
			$this->app['theme_url'] = $this->app['siteurl'] . "/theme";
			$this->app['stylesheet'] = $this->app['theme_url'] ."/style.css";
			
			//$this->load($this->app['app_dir']);
			
			if($this->load($this->app['app_dir'])){
				sort($this->appdir);
				//print_r($this->appdir);
				//exit();
				foreach($this->appdir as $archivo){
					require_once($archivo);	
				}
			}
		}else{
			header("location: ./install.php");
		}
	}
	
	function load($appdir, $appsubdir = ''){
		$dir = opendir($appdir);
		
		while(false !== ($archivo = readdir($dir))){
			
			if($archivo != "." && $archivo != ".."){
				if(is_dir($this->app['app_dir'] . "/" . $archivo)){
					$this->load($this->app['app_dir'] . "/" . $archivo, $archivo);	
				}else{
					if($appsubdir){
						//echo "<br />" . $this->app['app_dir'] . "/" .$appsubdir. "/" . $archivo;
						$this->appdir[] = $this->app['app_dir'] . "/" .$appsubdir. "/" . $archivo;
						//require_once($this->app['app_dir'] . "/" .$appsubdir . "/" . $archivo);
					}else{
						//echo "<br />" . $this->app['app_dir'] . "/" . $archivo;
						$this->appdir[] = $this->app['app_dir'] . "/" . $archivo;
						//require_once($this->app['app_dir'] . "/" . $archivo);	
						
					}
				}
				
			}
			/*if($archivo != "." && $archivo != ".."){
				if(is_dir($this->app['app_dir'] . "/" . $archivo)){				
					if($this->app['app_dir'] . "/" . $archivo != "." && $this->dir . "/" . $archivo != ".."){						
						$this->load($this->app['app_dir'] . "/" . $archivo, $archivo);
					}				
				}else{
					echo $this->app['app_dir']. "/" . $archivo;
					if(empty($appsubdir)){
						echo $this->app['app_dir'] . "/" . $archivo;
						$this->appdir[] = $this->app['app_dir'] . "/" . $archivo;
						
						require_once($this->app['app_dir'] . "/" . $archivo);
					}else{
						$this->appdir[$appsubdir][] = $this->app['app_dir'] . "/" . $archivo;
						require_once($this->app['app_dir'] . "/$appsubdir/" . $archivo);
					}
					
					//echo $this->dir . "/" . $archivo . "<br />";
				}
			}*/
		}
		
		closedir($dir);	
		return true;
	}
	
	
	
}
?>