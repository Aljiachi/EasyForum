<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------




class eafFriends{
	
	private $id,$table,$start_table;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->id = intval(abs($eaf->_REQUEST['id']));
		
		$this->table = "friends";
		
		$this->start_table = "phpforyou_";
			
	}
	
	public function addFriend(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_REQUEST['action']) && $eaf->_REQUEST['action'] == "addfriend"){
			
		if(isset($_SESSION['username']) && Userid() != 0){
			
			$frined_id = Userid();
			
			$date      = arabic_data();
						
			$Query     = $eaf->db->query("select * from " . $this->start_table . $this->table . " WHERE friend_id = '$frined_id' AND friend_uid = '$this->id'");
			
			$Access    = $eaf->db->query("select * from members where uid=$this->id");
			
			$Rows      = $eaf->db->_object($Access);
			
		   	$userNAme  = UserName();
			
			if($eaf->db->dbnum($Access) == 0){
				
				echo $lang["addfrined_nouser"];
				
				$eaf->_close();
			}
			
			if($eaf->db->dbnum($Query) != 0){
				
				echo $lang["addfriend_exists"];
				
				$eaf->_close();
			
			}else{
				
				$INSert = $eaf->db->query("insert into " . $this->start_table . $this->table . " values ('','$this->id','no','$userNAme','$frined_id','$date')") or die(mysql_error());	
			
				if($INSert){
				
					echo $lang["addfriend_ok"];
					
					$eaf->_close();
						
				}
				
			}
			
			
		}else{
			
			echo $lang["alert_loginaccess"];	
			
			$eaf->_close();

		}
		
		}

	}
	
	public function QueryFriendsActived(){
	
		global $eaf,$lang;
		
		if(isset($_SESSION['username']) && Userid() != 0){
		
			$query = $eaf->db->query("SELECT * FROM " . $this->start_table . $this->table . " WHERE friend_uid=" . UserId() . " AND friend_active='yes'");	
	
		}
		
		return $query;
		
		}
		
	public function QueryFriendsUnActived(){
	
		global $eaf,$lang;
		
		if(isset($_SESSION['username']) && Userid() != 0){
		
			$query = $eaf->db->query("SELECT * FROM " . $this->start_table . $this->table . " WHERE friend_uid=" . UserId() . " AND friend_active='no'");	
	
		}
		
		return $query;
		
		}
	public function ShowFriends(){
	
		global $eaf,$lang;
				
		print $eaf->template->display('usercp_friends');	
	}
	
	public function DeleteFriend(){
	
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));
		
		if(isset($eaf->_REQUEST['action']) and $eaf->_REQUEST['action'] == "user_friends"){
				
		if(isset($eaf->_REQUEST['do']) and $eaf->_REQUEST['do'] == "delete"){
		
		$query = $eaf->db->query("select * from " . $this->start_table . $this->table . " where id=$id");
		
		$rows  = $eaf->db->_object($query);
		
		if($rows->friend_uid !== UserId()){
		
			$eaf->_Redmsg($lang["alert_cant_doit"]);
			
			$eaf->_print($eaf->_Refresh(GoBack()));
				
			$eaf->_close();
		}
		
		$delete = $eaf->db->query("DELETE FROM " . $this->start_table . $this->table . " WHERE id=$id");
		
		if($delete){
			
			$eaf->_Greenmsg($lang["deletefriend_ok"]);
			
			$eaf->_print($eaf->_Refresh(GoBack()));
			
			$eaf->_close();
			
		}
		
		} # end do Get
		
		} # end action Get
	}
	
	public function AcceptFriend(){
	
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));
		
		if(isset($eaf->_REQUEST['action']) and $eaf->_REQUEST['action'] == "user_friends"){
				
		if(isset($eaf->_REQUEST['do']) and $eaf->_REQUEST['do'] == "accept"){
		
		$query = $eaf->db->query("select * from " . $this->start_table . $this->table . " where id=$id");
		
		$rows  = $eaf->db->_object($query);
		
		if($rows->friend_uid !== UserId()){
		
			$eaf->_Redmsg($lang["alert_cant_doit"]);
			
			$eaf->_print($eaf->_Refresh(GoBack()));
				
			$eaf->_close();
		}
		
		$update = $eaf->db->query("UPDATE  " . $this->start_table . $this->table . " SET friend_active='yes' WHERE id=$id");
		
		if($update){
			
			$eaf->_Greenmsg($lang["activefriend_ok"]);
			
			$eaf->_print($eaf->_Refresh(GoBack()));
			
			$eaf->_close();
			
		}
		
		} # end do Get
		
		} # end action Get
	}
}
?>