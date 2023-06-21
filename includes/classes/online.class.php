<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------




class eafOnline{
	
	private $ip,$is_time,$timeout,$tablename;
	
	private function Where(){

	global $eaf,$lang;

	switch($eaf->_REQUEST['action']){
	
	case "": $link = ForumName(); break;

	case "showtheard": 

		$sql_theard = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=".$eaf->_REQUEST['tid']);
	
		$rows_theard = $eaf->db->dbrows($sql_theard);

		$link = $lang["online_showtheard"] . ' : '.'<a href="?action=showtheard&tid='.$rows_theard['tid'].'">'.$rows_theard['title'].'</a>';
	
	break;

	case "sections": 
	
		$sfid = $eaf->security->sint($eaf->_REQUEST['fid']);

		$sql_sections = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE fid=$sfid");

		$rows_section = $eaf->db->dbrows($sql_sections);

		$link = $lang["online_forum"] . ' :  <a href="page=forum&id='.$rows_section['fid'].'">' . $rows_section['name']. '</a>';

	break;

	case "newtheard": $link = $link["online_newtheard"]; break;

	case "edit_post": $link = $lang["online_editpost"]; break;

	case "add_post": $link = $lang["online_newpost"]; break;

	case "register": $link = $lang["online_signup"]; break;

	case "uusercp": $link = $lang["online_usercp"]; break;

	case "login": $link = $lang["online_login"]; break;

	case "members": $link = $lang["online_members"]; break;

	case "search": $link = $lang["online_search"]; break;

	case "search_do": $link = $lang["online_searchres"]; break;

	case "contact": $link = $lang["online_contact"]; break;

	case "download": $link = $lang["online_download"]; break;

	case "online": $link = $lang["online_online"]; break;

	case "getpage": 
	$id = intval(abs($eaf->_REQUEST['id']));
	
	$Getpage = $eaf->db->_object($eaf->db->query("select page_name,page_id from " . tablenamestart("pages") . " where page_id = $id"));
	
	$link = $lang["online_online"] . " : <a href=\"$Getpage->page_id\">$Getpage->page_name</a>"; 
	
	break;

	case "announcement": 
		
	$id = intval(abs($eaf->_REQUEST['id']));
	
	$Getannouncement = $eaf->db->_object($eaf->db->query("select id,title from " . tablenamestart("announcements") . " where id = $id"));
	
	$link = $lang["online_announcement"] . ' : ' . $Getannouncement->title ; break;

	case "portal": $link = $lang["online_portal"]; break;

	case "profile": 

		$sql = $eaf->db->query("SELECT * FROM members WHERE uid=".$eaf->_REQUEST['uid']);

		$row = $eaf->db->dbrows($sql);

		$link = $lang["online_profile"] . $row['username']; break;
		
	default : $link = ForumName();

	}
	
	return $link;

	}
	public function OnLine(){

		global $eaf,$lang;

		$this->tablename = tablenamestart('online');

		$this->is_time = time(); 

		$this->timeout = $this->is_time - 200; 

		$this->ip = getip(); 
		
		$this->fid = intval(abs($eaf->_REQUEST['fid']));
		
		$this->tid = intval(abs($eaf->_REQUEST['tid']));

		if(empty($this->fid)) $this->fid = 0;

		if(empty($this->tid)) $this->tid = 0;

		$GetSetting = FunctionsSqlRows();
		
		if(isset($_SESSION['username']))
	
		{
			$user_on_name = UserName();
		
		}else{
		
			$user_on_name = $lang["guest"];
	
		}

		if(empty($GetSetting["timetype"])){
		
			$lastMoveTime = "h:i A";
				
		}else{

			$lastMoveTime = $GetSetting["timetype"];

		}
		
		$query_delete_ip 	  = $eaf->db->query("DELETE FROM $this->tablename WHERE ip='".$this->ip."'");

		$query_delete_timeout = $eaf->db->query("DELETE FROM $this->tablename WHERE time < '".$this->timeout."'");

		$query_delete_name    = $eaf->db->query("DELETE FROM $this->tablename WHERE name = '".$user_on_name."' and uid!=0");

	
		if(UserId() == 0){
			
			$query_insert_vistor  = $eaf->db->query("INSERT INTO $this->tablename VALUES ('','".$this->ip."','".$this->is_time."','".$user_on_name."','".GetUserid()."','".$this->Where()."','".date($lastMoveTime)."','".$this->fid."','". $this->tid ."')");	

		}else{
		
			$GetUserInfo = $eaf->db->_object($eaf->db->query("select option_online from members where uid = " . UserId()));
			
			if($GetUserInfo->option_online == 1){
				
				$user_on_name = $lang["guest"];
			
				$query_insert_vistor  = $eaf->db->query("INSERT INTO $this->tablename VALUES ('','".$this->ip."','".$this->is_time."','".$user_on_name."','0','".$this->Where()."','".date($lastMoveTime)."','".$this->fid."','". $this->tid ."')");	

			}else{
			
			$query_insert_vistor  = $eaf->db->query("INSERT INTO $this->tablename VALUES ('','".$this->ip."','".$this->is_time."','".$user_on_name."','".GetUserid()."','".$this->Where()."','".date($lastMoveTime)."','".$this->fid."','". $this->tid ."')");	
	
			}
		}
	}

	public function OnlineGuest(){

		global $eaf,$lang;

		$query = $eaf->db->query("SELECT * FROM $this->tablename WHERE uid=0");

		return $eaf->db->dbnum($query);

	}

	public function OnlineUsers(){

		global $eaf,$lang;

	$query = $eaf->db->query("SELECT * FROM $this->tablename WHERE uid!=0");

	return $eaf->db->dbnum($query);	

	}

	public function OnlineAll(){

		global $eaf,$lang;
		
		$query   = $eaf->db->query("SELECT * FROM $this->tablename");

		return  $eaf->db->dbnum($query);

	}

	public function UsersOnline(){

		global $eaf,$lang;

		return $eaf->db->query("SELECT * FROM $this->tablename WHERE uid!=0");
		
	}
# end class 
}
?>