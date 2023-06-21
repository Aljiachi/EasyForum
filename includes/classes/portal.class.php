<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class eafPortal{

	private $Where , $OrderBy , $TableStart , $Table;
	
	public $RightBlocks,$LeftBlocks,$CenterBlocks; 
	
	public function __construct(){
				
		$this->OrderBy    = GetProtalOrderBy();
		
		$this->TableStart = "phpforyou_";
		
		$this->Table 	  = "pblocks";
		
	}	
	
	public function GetRightBLocks(){
		
		global $eaf,$lang;
		
		$this->Where = "1";
		
		return $eaf->db->query("select * from " . $this->TableStart . $this->Table . " where block_where = $this->Where order by block_id $this->OrderBy"); 	
	}
	
	public function GetLeftBLocks(){
		
		global $eaf,$lang;
		
		$this->Where = "2";
		
		return $eaf->db->query("select * from " . $this->TableStart . $this->Table . " where block_where = $this->Where order by block_id $this->OrderBy"); 	
	}
	
	public function GetCenterBLocks(){
		
		global $eaf,$lang;
		
		$this->Where = "3";
		
		return $eaf->db->query("select * from " . $this->TableStart . $this->Table . " where block_where = $this->Where order by block_id $this->OrderBy"); 	
	}
	
	public function View(){
		
		global $eaf,$lang;
		
		$eaf->_print($eaf->template->display("portal"));
	}
	
}
       
?>