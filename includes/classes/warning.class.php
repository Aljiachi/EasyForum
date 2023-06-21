<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Warning{

	private $Userid , $Table , $Label , $TheardId , $PostId;
	
	public function __construct(){
		
		global $eaf,$lang;
		
		$this->Userid   = $eaf->security->HashId($eaf->_REQUEST['id']);
		
		$this->TheardId = $eaf->security->HashId($eaf->_REQUEST['tid']);

		$this->PostId   = $eaf->security->HashId($eaf->_REQUEST['pid']);
			
		$this->Table    = "warnings";
		
		$this->Label    = "phpforyou_";
	}
		
		
	public function _Access(){
		
		global $eaf,$lang;
		
		$Username = UserName();
				
		$Password = PassWord();
		
		$By       = UserId();
		
		$UserID   = $eaf->security->HashId($this->Userid,false);
		
		$tid      = $eaf->security->HashId($this->TheardId,false);

		$pid      = $eaf->security->HashId($this->PostId,false);
			
		if(!$Username or !$Password or empty($Username)){
			
			$eaf->_print($eaf->_RedMsg($lang["alert_loginaccess"]));
						
			$eaf->_close();				
		}
		
		if($By == $UserID){
			
			$eaf->_print($eaf->_RedMsg($lang["warning_yourself"]));
						
			$eaf->_close();
			
		}

		$Find = $eaf->db->query("select * from members where uid = $UserID");
		
		if($eaf->db->dbnum($Find) == false){
			
			$eaf->_print($eaf->_RedMsg($lang["alert_user_notexists"]));
						
			$eaf->_close();
			
			}
		
			if(isset($eaf->_REQUEST['tid']) && !empty($eaf->_REQUEST['tid'])){
			
				$TheardFind = $eaf->db->query("select * from " . tablenamestart("topics") . " where tid = $tid");
		
				if($eaf->db->dbnum($TheardFind) == false){
				
					$eaf->_print($eaf->_RedMsg($lang["alert_theard_notexists"]));
						
					$eaf->_close();
			
					}
			
			}else{
				
				$PostFind = $eaf->db->query("select * from " . tablenamestart("posts") . " where pid = $pid");
		
				if($eaf->db->dbnum($PostFind) == false){
			
					$eaf->_print($eaf->_RedMsg($lang["alert_post_notexists"]));
						
					$eaf->_close();
			
				}
				
			}
		
	}
	
	public function AddWarning(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['addwarning'])):
	
		$By     = UserId();
		
		$Date   = arabic_data();
		
		$Time   = time();
		
		$UserID = $eaf->security->HashId($this->Userid,false);
		
		$tid      = $eaf->security->HashId($this->TheardId,false);

		$pid      = $eaf->security->HashId($this->PostId,false);
		
		$Way	  = $eaf->security->CleanHtml($eaf->_POST['way']);
		
		if(empty($Way)){
			
			$eaf->_print($eaf->_RedMsg($lang["alert_empty"]));
			
			return false;
		}
		
		$query = $eaf->db->query("insert into " . $this->Label . $this->Table . " values ('','$UserID','$By','$Way','$Date','$Time','$tid','$pid')");
		
		if($query){
			
			$eaf->_print($eaf->_GreenMsg($lang["alert_added"]));
			
			$eaf->_close();	
		
		}else{

			$eaf->_print($eaf->_RedMsg($lang["alert_adderror"]));
			
			$eaf->_close();
			
		}
		
		endif;
			
	}
	
}
?>