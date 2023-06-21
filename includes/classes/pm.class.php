<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------





class GetPm{
	
	private $pmid,$query,$rows;
	
	public function __construct(){
		
		global $eaf,$lang;
		
		$this->pmid    = intval(abs($eaf->_REQUEST['pmid']));
	
		$this->query   = $eaf->db->query("SELECT * FROM " . tablenamestart("pm") . " WHERE sid=$this->pmid ");
		
		$this->rows    = $eaf->db->dbrows($this->query);
	}
	
	public function _exists(){
	
		global $eaf,$lang;
		
		if($eaf->db->dbnum($this->query) == 0){
			
			header("location: ?action=error&do=8");
			
			$eaf->_close();
		}
	}
	
	public function _IsForMe(){
	
		global $eaf,$lang;
	
		if($this->rows['s_uid'] !== UserId()){
		
			header("location: ?action=error&do=3");
		
			$eaf->_close();		
		}
	
	}
	
	public function _IsReaded(){
	
		global $eaf,$lang;
		
		return $eaf->db->query("UPDATE " . tablenamestart('pm') . " SET sact='1' WHERE sid=$this->pmid");
			
	}
	
	public function _Rows(){
		
		return array(
					"id" => $this->rows['sid'],
					"title" => strip_tags($this->rows['stitle']) ,
					"date" => $this->rows['sdata'],
					"sender_id" => $this->rows['sfrom'],
					"visted" => $this->rows['sact'],
					"text" => GetBbCode($this->rows['smsg']),
					"to_id" => $this->rows['s_uid'],
					"sender_name" => $this->rows['s_fname']
					);	
	}
}

?>