<?php

class ShowAnnouncement{
	
	private $Query;
	
	public $table,$Rows,$id;
	
	public function __construct(){
		
		global $eaf,$lang;
		
		$this->table = tablenamestart("announcements");
		
		if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) and is_numeric($eaf->_REQUEST['id'])){
		
			$this->id = intval(abs($eaf->_REQUEST['id']));	
		}
		
		$this->Query = $eaf->db->query("select * from `$this->table` where `id` = $this->id");
		
		$this->Rows  = $eaf->db->_object($this->Query);			
	}
	
	public function _exists(){
		
		global $eaf,$lang;
		
		if($eaf->db->dbnum($this->Query) == 0){
			
			header("location: index.php");	
		}
	
	}
	
	public function AddGuest(){
		
		global $eaf,$lang;
		
		$Vnum = $this->Rows->views;
		
		print $Vnum;
	
	}
}
?>