<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class eafRating{

	private $table,$uid,$time,$ip,$tid;
	
	public function start(){
		
		global $eaf,$lang;
	
		$this->table = tablenamestart("trating");	
		
		$this->uid   = UserId();
		
		$this->time  = time();
		
		$this->ip    = getip();
		
		$this->tid   = intval(abs(trim($eaf->_REQUEST['tid'])));
	}
	
  private function add(){
	  
	  global $eaf,$lang;
	
	if(UserGroup(GetUserid(),"theards_rating") == 0){
	
		print $lang["cant_rating"];	
	
		return false;
	}
	
	if($this->uid !== 0){
		
		$Find = $eaf->db->query("select id from $this->table where tid = $this->tid and uid = $this->uid");
	
	}else{
		
		$Find = $eaf->db->query("select id from $this->table where tid = $this->tid and ip = $this->ip");

	}
	
	if($eaf->db->dbnum($Find) !== 0){
	
		print $lang["cant_rating"];	
	
		return false;
	}
	
	$Insert = $eaf->db->query("insert into $this->table values ('','$this->tid','$this->uid','$this->time','$this->ip')");
	
	if($Insert){
	
		print $lang["rating_ok"];	
	
	}else{
		
		print $lang["rating_error"];	
	
	}
  }
  
  public function run(){
	  
	  global $eaf,$lang;
	  
	  $this->start();
	  
	  $action = strip_tags(trim($eaf->_REQUEST['action']));
	  
	  if($action == "rating"){
	
		$this->add();
		
		exit;
			  
	  }
  }
}

?>