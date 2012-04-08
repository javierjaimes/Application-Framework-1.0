<?php
class MySql{
	var $host;
	var $user;
	var $password;
	var $db;
	var $link;
	var $recordset;
	
	
	function __construct($host, $user, $password, $db = ""){
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->db = $db;		
	}
	
	function connect($db = ""){
		if(!empty($db)){
			$this->db = $db;
		}
		$this->link = mysql_connect($this->host,$this->user,$this->password) or die(mysql_error());
		if($this->link){
			mysql_select_db($this->db,$this->link);	
			//echo "me conecte y tengo la bd";
		}else{
			return false;	
		}
	}
	
	function query($sql,$object = null){
		if(is_null($object)){
			$this->recordset = mysql_query($sql, $this->link);	
		}else{
			$this->$object = mysql_query($sql, $this->link);			
		}		
		if(!$this->recordset){
			return false;	
		}else{
			return true;	
		}		
	}
	function unsetRecordset($object){
		unset($this->$object);
	}
	
	function getRecordset($recordset = null){
		if(is_null($recordset)){
			return mysql_fetch_array($this->recordset);
		}else{
			return mysql_fetch_array($this->$recordset);		
		}
	}
	
	function getNumsRows(){
		return mysql_num_rows($this->recordset);
	}
}
?>