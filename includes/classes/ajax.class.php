<?php

class eafAjax{
	
	public function Replay(){
		
	global $eaf,$lang;
	
	if($eaf->_REQUEST['action'] == "addpost" && $eaf->_REQUEST['do'] == "ajax"){	
	
	if(isset($eaf->_POST['addfastpost'])){

	$post_title = strip_tags($eaf->_POST['post_title']);

	$fid = $eaf->security->sint($eaf->_POST['post_fid']);

	$tid = $eaf->security->sint($eaf->_POST['post_tid']);
	
	$u_add_id = $eaf->security->sint(Userid());

	$user_add_name = $eaf->security->svar(UserName());
	
	$data = arabic_data();

	if(GetHtmlPost() == 1){

		$content = $eaf->BbCode->BbCodeToHtml($eaf->_POST['post_text']);

	}else{

		$content = $eaf->security->_HtmlReplace($eaf->_POST['post_text']);

	}

	$post_icon = strip_tags($eaf->_POST['post_icon']);

	if(empty($post_icon)){

	$post_icon = GetPostIcon();

	}


		$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=".$tid);

		$rows = mysql_fetch_assoc($sql);

		if($rows['close'] == 0){

			$_SESSION['save_last_post'] = $content;

			$SqlInsertPost = $eaf->db->query("INSERT INTO " . tablenamestart('posts') . " (t_id,f_id,u_id,ptitle,pdata,pusername,ptext,picon) VALUES (

	'$tid',

	'$fid',

	'".UserId()."',

	'$post_title',

	'$data',

	'$user_add_name',

	'$content',

	'$post_icon'

	)") or die(mysql_error());

	$time = time();

	$update = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET wtime='$time' WHERE tid=$tid");

	$insert_id= mysql_insert_id();

	if($SqlInsertPost){
		
		return true;
		
	}else{
		
		return false;
				
			}

	}else{
		
		return false;
}
}
	}
	
	}
	
	public function VistorMsg(){
		
		global $eaf,$lang;

		if($eaf->_REQUEST['action'] == "addvistormsg" && $eaf->_REQUEST['do'] == "ajax"){	
	
		if(isset($eaf->_POST['addvmsg']) and $eaf->_POST['addvmsg'] == "addnew"){
		
			$by = GetUserid();
			
			$uid= intval(abs($eaf->_POST['uid']));
			
			$text= strip_tags($eaf->_POST['msg']);	
			
			$ip  = getip();
			
			$time = time();
			
			$data = arabic_data();
			
			$Query = $eaf->db->query("insert into " . tablenamestart("vistorsmsgs") . " values ('','$uid','$by','$data','$text','$ip','$time')");
		}	
		
		}
	}
	
	public function Editguestmsg(){
	
	global $eaf,$lang;

		if($eaf->_REQUEST['action'] == "editvistormsg" && $eaf->_REQUEST['do'] == "ajax"){	
	
		if(isset($eaf->_POST['msg_post']) and $eaf->_POST['msg_post'] == "edit_vmsg"){
					
			$id= intval(abs($eaf->_POST['msg_id']));
			
			$text= strip_tags($eaf->_POST['msg_text']);	
											
			$Query = $eaf->db->query("update " . tablenamestart("vistorsmsgs") . " set msg_text='$text' where msg_id = $id");
		}	
		
		}
		
	}
	
	public function Deleteguestmsg(){
	
		global $eaf,$lang;
		
		if($eaf->_REQUEST['action'] == "deletevistormsg" && $eaf->_REQUEST['do'] == "ajax"){	
		
			$id = intval(abs($eaf->_REQUEST['id']));
			
			$uid = UserId();
									
			$Find = $eaf->db->query("select msg_id , msg_by from " . tablenamestart("vistorsmsgs") . " where msg_id = $id");
			
			$Rows = $eaf->db->_object($Find);	
	
			if($eaf->db->dbnum($Find) == 0){
			
				return false;
		
			}
					
			$Delete = $eaf->db->query("delete from " . tablenamestart("vistorsmsgs") . " where msg_id = '$id' and msg_u_id = '$uid'");
			
			exit;
		}
	}
	
	public function GetUser(){
		
		global $eaf;
		
		if($eaf->_REQUEST['action'] == "getname" && $eaf->_REQUEST['do'] == "ajax"){
		
			$p = strip_tags(trim($eaf->_REQUEST['p']));
			
			$n = strip_tags(trim($eaf->_REQUEST['n']));	
			
			if(!empty($p) && !empty($n) ) {
			
			$Query = $eaf->db->query("select username from members where `username` LIKE '%$p%' or `username` = '$p' limit 10");
			
			if($eaf->db->dbnum($Query) > 0){
				
				while($Rows = $eaf->db->_object($Query)){
				
					print "<div onclick=\"InputInsert('$n','$Rows->username');\" class=\"SMenu\">" . $Rows->username . "</div>";
				
				}
				
			}
			
			}
			
			exit;
	
		}
	}
	
	}
?>