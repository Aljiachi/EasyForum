<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------




class EditPost{
	
	public $tid,$pid;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->tid = intval(abs($eaf->_REQUEST['tid']));	

		$this->pid = intval(abs($eaf->_REQUEST['pid']));	

	}
	
	public function _Theard(){
	
		global $eaf,$lang;
		
		return $eaf->db->query("SELECT * FROM " . tablenamestart("topics") . " WHERE tid=$this->tid");
		
	}
	
	public function _Post(){
	
		global $eaf,$lang;
		
		return $eaf->db->query("SELECT * FROM " . tablenamestart("posts") . " WHERE pid=$this->pid");
		
	}
	
	public function _Object($Query){
		
		global $eaf,$lang;
		
		return $eaf->db->_object($Query);	
	}
	
	public function _Rows(){
			
			global $eaf,$lang;
			
			$eaf->Userlogged = $_SESSION['username'];
			
			if($this->tid){
				 
				 $rows = $this->_Object($this->_Theard());
				 
				 $eaf->PostTitle      = $rows->title;
				   
				 $eaf->PostUser       = $rows->username;
				 
				 $eaf->PostUser_id    = $rows->u_id;

				 $eaf->PostIcon       = $rows->icon_id;
				 
				 $eaf->PostText       = str_replace("*=q=*","'",$rows->text);
				 
				 	if(UserGroup(GetUserid(),"edit_topic") !== 1){
						
						$EditUserG = 0;
						
					}
					
					if($eaf->PostUser !== $eaf->Userlogged){

						$EditUserLog = 0;
															
					}
					
					if(UserGroup(GetUserid(),"edit_topic") == 1){
					
						$EditUserG = 1;
							
					}
					
					if($eaf->PostUser == $eaf->Userlogged){
						
						$EditUserLog = 1;
					}
					
								 				 
			}else{
			
				 $rows = $this->_Object($this->_Post());	
				 
				 $eaf->PostTitle      = $rows->ptitle;
				   
				 $eaf->PostUser       = $rows->pusername;
				 
				 $eaf->PostUser_id    = $rows->u_id;
				 
				 $eaf->PostIcon       = $rows->icon;
				 
				 $eaf->PostText       = str_replace("*=q=*","'",$rows->ptext);
				 
				 	if(UserGroup(GetUserid(),"edit_post") !== 1){
						
						$EditUserG = 0;
						
					}
					
					if($eaf->PostUser !== $eaf->Userlogged){

						$EditUserLog = 0;
															
					}
					
					if(UserGroup(GetUserid(),"edit_post") == 1){
					
						$EditUserG = 1;
							
					}
					
					if($eaf->PostUser == $eaf->Userlogged){
						
						$EditUserLog = 1;
					}

			}
					if($EditUserG !== 1 or $EditUserLog !== 1){
					
						$SelfEdit = 0;	
					
					}else{

						$SelfEdit = 1;	

					}
			
			 	   if(UserGroup(GetUserid(),"mod_edit") !== 1 || UserGroup(GetUserid(),"is_admin") !== 1){
						
						$EditModDo = 0;
						
					}
					
					if(UserGroup(GetUserid(),"mod_edit") == 1 || UserGroup(GetUserid(),"is_admin") == 1){
						
						$EditModDo = 1;
					
					}
					
					if(getModerFile("edit") == 1){
						
						$SuperModer = 1;	
					
					}else{
						
						$SuperModer = 0;
					}
																				
					if($SelfEdit !== 1 && $EditModDo !== 1 and $SuperModer !== 1){
						
							$eaf->_Redmsg($eaf->_ForrText());	
						
						return false;
					}
					
					
					print $eaf->template->display('editpost');
	

	
	}
}
?>
