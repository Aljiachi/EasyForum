<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------




class Addpost{

	private $tid,$topic_id,$pid;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->tid 	    = intval(abs($eaf->_REQUEST['tid']));
		
		$this->topic_id   = intval(abs($eaf->_REQUEST['topic_id']));

		$this->pid  		= intval(abs($eaf->_REQUEST['pid']));

	}
	
	private function _Query(){
		
		global $eaf,$lang;
		
		if($this->tid){
			
			return $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=$this->tid");
		
		}else{
		
			return $eaf->db->query("SELECT * FROM " . tablenamestart('posts') . "  WHERE pid=$this->pid");
			
		}
	}
	
	public function Quote(){
		
		global $eaf,$lang;
		
		if($eaf->_REQUEST['do'] == "quote"){
			
			return true;
			
		}else{
			
			return false;
		
		}
	
	}
	
	public function _Form(){
		
		global $eaf,$lang;
		
		$Query = $this->_Query();			

		$Rows  = @$eaf->db->dbrows($Query);

		if($this->tid){	
				
		$eaf->TitlePost 	= 	$Rows['title'];
		
		$eaf->QuoteBy      = 	$Rows['username'];
		
		$eaf->QuoteText    =	$Rows['text'];
		
		}else{
		
		$eaf->TitlePost 	= 	$Rows['ptitle'];
		
		$eaf->QuoteBy      = 	$Rows['pusername'];
		
		$eaf->QuoteText    =	$Rows['ptext'];
			
		}
		
		$eaf->TheardId	 =	$this->topic_id;
				
		print $eaf->template->display('newpost');			
	}
}
?>
