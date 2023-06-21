<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------





class SendPm{
	
	private $Query,$Rows,$uid;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->uid   = intval(abs($eaf->_REQUEST['uid']));
		
		$this->Query = $eaf->db->query("SELECT * FROM members WHERE uid = $this->uid");
		
		$this->Rows  = $eaf->db->_object($this->Query);
	
	}
	
	public function _exists(){
		
		global $eaf,$lang;
		
		if(UserGroup(GetUserid(),"send_pm")  != 1){
			
				header("location: ?action=error&do=8");	

				$eaf->_close();
				
		}
	}
	
	public function _Form(){
		
		global $eaf,$lang;
		
		$eaf->To_Username	=	$this->Rows->username;
		
		$eaf->To_Id		  =	$this->Rows->uid;
		
	    print $eaf->template->display('sendpm');

	}
		
}
?>