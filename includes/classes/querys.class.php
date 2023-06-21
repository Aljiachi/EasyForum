<?php

#--eaf

class eafQuers{

	public function TotalPosts(){

		global $eaf,$lang;

		$fid  = intval(abs($eaf->_REQUEST['fid']));

		$query_posts = $eaf->db->dbselect(tablenamestart('posts')," f_id = ".$fid,"","");

		$total_posts = $eaf->db->dbnum($query_posts);

		$update_totalposts = $eaf->db->query("UPDATE "  . tablenamestart('sections') . " SET total_replays='$total_posts' WHERE fid=$fid") or die(mysql_error());	

	}
	
	public function Errors(){

	global $eaf,$lang;

	if($eaf->_REQUEST['action'] == "error"){

	switch($eaf->_REQUEST['do']){

	case 1: 
	
		$eaf->_Redmsg($lang["alert_empty"]);

		echo '<meta http-equiv="refresh" content="1;URL=index.php?action=search" />';

	exit;

	break;	

	case 2: 

	$eaf->_Redmsg($lang["alert_empty"]);

		echo '<meta http-equiv="refresh" content="1;URL=index.php?action=search" />';

	exit;

	break;	

	case 3:			
		
		$eaf->_Redmsg($lang["alert_cant_doit"]);

		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';

		exit;
		
		break;

	case 4: 
	
		$eaf->_Redmsg($lang["alert_cant_doit"]);
		
		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';
		
		exit;
		
		break;

	case 5:		
	
		$eaf->_Redmsg($lang["alert_user_notexists"]);
		
		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';
		
		exit;
		
		break;

	case 6:		
	
		$eaf->_Redmsg($lang["alert_cant_doit"]);
		
		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';
		
		exit;
		
		break;

	case 7:		
	
		$eaf->_Redmsg($lang["alert_cant_doit"]);
			
		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';
		
		exit;
		
		break;

	case 8:		
	
		$eaf->_Redmsg($lang["alert_cant_doit"]);
		
		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';
		
		exit;
		
		break;

		}

		}	

	}

	public function Act(){

	global $eaf,$lang;

	$pid = intval(abs($eaf->_REQUEST['pid']));
	
	$tid = intval(abs($eaf->_REQUEST['tid']));

	switch($eaf->_REQUEST['act']){

	case "delete_post":  $eaf->sql->DeletePost($pid);    exit;  break;

	case "delete_topic": $eaf->sql->DeleteTopic($tid);   exit;  break;

	case "search_user":  $eaf->users->UserFinde(); exit; break;

	case "delete_attach":$eaf->sql->DeleteAttachment($eaf->_REQUEST['id']); exit;break;
	
	}	
	
	}

	public function ThisPage(){

	global $eaf,$lang;

	switch($eaf->_REQUEST['action']){

	case "sections": define('THIS_PAGE','sections'); break;	

	case "showtheard": define('THIS_PAGE','showtheard'); break;	

	case "newtheard": define('THIS_PAGE','newtheard'); break;	

	case "add_post": define('THIS_PAGE','addpost');break;	

	case "edit_post": define('THIS_PAGE','editpost'); break;	

	case "cpanel": define('THIS_PAGE','userpanel'); break;	

	case "login": define('THIS_PAGE','login'); break;	

	case "logout": define('THIS_PAGE','logout'); break;	

	case "members": define('THIS_PAGE','members'); break;	

	case "blog": define('THIS_PAGE','blog'); break;	

	case "sendpm":define('THIS_PAGE','sendpm'); break;	

	case "showpm":define('THIS_PAGE','showpm'); break;	

	case "user_pm":define('THIS_PAGE','user_pm'); break;	

	case "search":define('THIS_PAGE','search'); break;	

	case "attachments":define('THIS_PAGE','attachments'); break;	

	case "search_do":define('THIS_PAGE','search_do'); break;	

	case "":define('THIS_PAGE','index');break;
 
 	}

	return true;	

	}

	public function Sections(){

		global $eaf,$lang;

		$fid = intval(abs($eaf->_REQUEST['fid']));

		return $eaf->db->dbselect(tablenamestart('sections'),"fid=".$fid,"","");	

	}

	public function Icons(){

		global $eaf,$lang;

		return $eaf->db->dbselect(tablenamestart('icons'),"","","");	
	
	}

	public function Smiles(){

		global $eaf,$lang;

		return $eaf->db->dbselect(tablenamestart('smiles'),"","","");	

	}



	public function UploadAttachment(){

		global $eaf,$lang;
	
		if(isset($eaf->_REQUEST['action']) && $eaf->_REQUEST['action'] == "attach_upload"){
	
			if(GetAttachmentsDo() == 1){
		
				$eaf->sql->AttachmentUpload();
		
				print $eaf->template->display("upload_attachment");
		
				exit;
		
			}else{
		
				echo '<div style="text-align:center;color:red;">رفع المرفقات مغلقة حالياً</div>';	
			
			}
	
		}	

	}
	
	public function MoveTemplate(){
	
		global $eaf,$lang;
	
		$eaf->query = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE sort!='0' ");	

		print $eaf->template->display('post_move');
	
	}

# END CLASS 
}
$eaf->SDB = new eafQuers()
?>