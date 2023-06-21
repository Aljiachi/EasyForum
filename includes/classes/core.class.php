<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Core{

	public function _Refresh($link){
			
			return '<meta http-equiv="refresh" content="2;URL='.$link.'" />';
			
			}
			
	public function _print($text){
			
			return print $text;
	
	}
	
	public function _ForrText(){
		
		global $lang;
		
		return $lang["stop"];	
	}
	
	public function _Redmsg($msg){
		
		global $eaf,$lang;
		
		$eaf->Alert = "<div class='red'>$msg</div>";
		
		print $eaf->template->display('alert');
	}
	
	public function _Greenmsg($msg){
		
		global $eaf,$lang;
		
		$eaf->Alert = "<div class='green'>$msg</div>";
		
		print $eaf->template->display('alert');
	
	}
	public function _close(){
	
		return exit;
	
	}
	
	public function _explode($delimiter,$string){

		return explode($delimiter,$string);	
	
	}
	public function _implode($glue,$array){
	
		return implode($glue,$array);	
	
	}
	
	public function _loadxml($file){

		return simplexml_load_file($file);	

	}

}
	$eaf = new Core;
	
	$eaf->_GET 	 = &$_GET;
	
	$eaf->_POST	= &$_POST;

	$eaf->_REQUEST = &$_REQUEST;

	$eaf->_SERVER  = &$_SERVER;
	
?>
