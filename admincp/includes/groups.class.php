<?php

# * Easy Forum
# * Version is 2
# * Date : 2011
# * Email: php4u@hotmail.com
# * offical website : http://www.g-scripts.com
# * Programming rights reserved
# * The program is free and forall
# * Programming By : Php4u 
# * Powered By 	   : G-scripts
# * To Download Plugins, Hooks , Styles , Updates ... Visiting Our Website	
class Groups_Control_System
{
	
	private $start_tabel="phpforyou_";
	
	private $table="groups";
	
	private $id;
	
	public function __construct(){
	
	global $eaf,$lang;
	
	$this->id = $eaf->security->sint($eaf->_REQUEST['id']);	
	
	}
	
	public  function FormAdd(){
		
	global $lang;
	
	return '
		<form method="post" name="addform">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td class="head" colspan="2">'.$lang["groups_add"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_title"].'</td>
		<td><input type="text" name="title" /></td>
		</tr>
		<tr>
		<td>'.$lang["groups_style"].'</td>
		<td><textarea name="style" style="direction:ltr;"><span style="color:#ccc">{name}</span></textarea></td>
		</tr>
		<tr>
		<td>'.$lang["groups_name"].'</td>
		<td><input type="text" name="name" /></td>
		</tr>
		<tr>
		<td>'.$lang["groups_out"].'</td>
		<td>
		<select name="out">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_script"].'</td>
		<td>
		<select name="script">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewForums"].'</td>
		<td>
		<select name="view_forums">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewTopics"].'</td>
		<td>
		<select name="view_topics">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_sdo"].'</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_topicAdd"].'</td>
		<td>
		<select name="topic_add">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_postAdd"].'</td>
		<td>
		<select name="post_add">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_topicEdit"].'</td>
		<td>
		<select name="topic_edit">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_postEdit"].'</td>
		<td>
		<select name="post_edit">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_deleteTopics"].'</td>
		<td>
		<select name="delete_topics">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_deletePosts"].'</td>
		<td>
		<select name="delete_posts">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_sendPm"].'</td>
		<td>
		<select name="send_pm">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_attachUp"].'</td>
		<td>
		<select name="attach_up">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_attachDown"].'</td>
		<td>
		<select name="attach_down">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>	
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_mdo"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_isMod"].'</td>
		<td>
		<select name="is_mod">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modEdit"].'</td>
		<td>
		<select name="mod_edit">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modDelete"].'</td>
		<td>
		<select name="mod_delete">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_modMove"].'</td>
		<td>
		<select name="mod_move">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_modSticky"].'</td>
		<td>
		<select name="mod_sticky">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_modClose"].'</td>
		<td>
		<select name="mod_close">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modMerge"].'</td>
		<td>
		<select name="mod_merge">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modRecy"].'</td>
		<td>
		<select name="mod_recy">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>			
		<tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_ado"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_isAdmin"].'</td>
		<td>
		<select name="is_admin">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminSetting"].'</td>
		<td>
		<select name="admin_setting">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminTools"].'</td>
		<td>
		<select name="admin_tools">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminTheards"].'</td>
		<td>
		<select name="admin_theards">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminSections"].'</td>
		<td>
		<select name="admin_sections">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminHacks"].'</td>
		<td>
		<select name="admin_hacks">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminPblocks"].'</td>
		<td>
		<select name="admin_pblocks">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminMembers"].'</td>
		<td>
		<select name="admin_members">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminGroups"].'</td>
		<td>
		<select name="admin_groups">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminStyles"].'</td>
		<td>
		<select name="admin_styles">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminTitles"].'</td>
		<td>
		<select name="admin_titles">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminIcons"].'</td>
		<td>
		<select name="admin_icons">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminSmiles"].'</td>
		<td>
		<select name="admin_smiles">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminAncs"].'</td>
		<td>
		<select name="admin_ancs">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminPages"].'</td>
		<td>
		<select name="admin_pages">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_adminFilem"].'</td>
		<td>
		<select name="admin_filem">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_adminLangs"].'</td>
		<td>
		<select name="admin_langs">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_adminInputs"].'</td>
		<td>
		<select name="admin_inputs">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_otdo"].'</td>
		</tr>
		<td>'.$lang["groups_viewOnline"].'</td>
		<td>
		<select name="view_online">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<td>'.$lang["groups_rename"].'</td>
		<td>
		<select name="rename">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewMlist"].'</td>
		<td>
		<select name="view_mlist">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>				
		<tr>
		<td>'.$lang["groups_showInOnline"].'</td>
		<td>
		<select name="show_in_online">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_signup"].'</td>
		<td>
		<select name="signup">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewUserip"].'</td>
		<td>
		<select name="view_userip">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewProfile"].'</td>
		<td>
		<select name="view_profile">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_search"].'</td>
		<td>
		<select name="search">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<tr>
		<td>'.$lang["groups_viewPortal"].'</td>
		<td>
		<select name="view_portal">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_tellFriend"].'</td>
		<td>
		<select name="tell_friend">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewGetpage"].'</td>
		<td>
		<select name="view_getpage">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_theardsRating"].'</td>
		<td>
		<select name="theards_rating">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewSelftopics"].'</td>
		<td>
		<select name="view_selftopics">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_ifClosed"].'</td>
		<td>
		<select name="if_closed">
		<option value="0">'.$lang["no"].'</option>
		<option value="1">'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">تنفيذ</td>
		</tr>
		<tr>
		<td colspan="2" align="center"><input type="submit" value="'.$lang["add"].'" name="addgroup" /></td>
		</tr>
		</table>
		</form>
		';	
}
public function Addpost(){
global $eaf,$lang;
if(isset($eaf->_POST['addgroup'])){
		
			$title 		= $eaf->_POST['title'];
			$style		= $eaf->_POST['style'];
			$name         = trim($eaf->_POST['name']);
			$out          = $eaf->_POST['out'];
			$add_topic    = $eaf->_POST['topic_add'];
			$add_post     = $eaf->_POST['post_add'];
			$edit_topic   = $eaf->_POST['topic_edit'];
			$edit_post    = $eaf->_POST['post_edit'];
			$delete_topic = $eaf->_POST['delete_topics'];
			$delete_post  = $eaf->_POST['delete_posts'];
			$send_pm      = $eaf->_POST['send_pm'];
			$attach_up    = $eaf->_POST['attach_up'];
			$attach_down  = $eaf->_POST['attach_down'];
			$view_forums  = $eaf->_POST['view_forums'];
			$view_posts   = $eaf->_POST['view_topics'];
			$mod_edit     = $eaf->_POST['mod_edit'];
			$mod_delete   = $eaf->_POST['mod_delete'];
			$mod_move     = $eaf->_POST['mod_move'];
			$mod_sticky   = $eaf->_POST['mod_sticky'];
			$mod_close    = $eaf->_POST['mod_close'];
			$adminlog     = $eaf->_POST['is_admin'];
			$view_online  = $eaf->_POST['view_online'];
			$view_mlist   = $eaf->_POST['view_mlist'];
			$rename       = $eaf->_POST['rename'];
			$showin       = $eaf->_POST['show_in_online'];
			$admin_titles      = $eaf->_POST['admin_titles'];
			$admin_sections    = $eaf->_POST['admin_sections'];
			$admin_hacks       = $eaf->_POST['admin_hacks'];
			$admin_groups      = $eaf->_POST['admin_groups'];
			$admin_theards     = $eaf->_POST['admin_theards'];
			$admin_styles      = $eaf->_POST['admin_styles'];
			$admin_icons       = $eaf->_POST['admin_icons'];
			$admin_smiles      = $eaf->_POST['admin_smiles'];
			$admin_tools       = $eaf->_POST['admin_tools'];
			$admin_setting     = $eaf->_POST['admin_setting'];
			$admin_filem       = $eaf->_POST['admin_filem'];
			$admin_members     = $eaf->_POST['admin_members'];
			$search            = $eaf->_POST['search'];
			$view_profile      = $eaf->_POST['view_profile'];
			$view_userip       = $eaf->_POST['view_userip'];
			$if_closed		 = $eaf->_POST['if_closed'];
			$view_sctipt       = $eaf->_POST['script'];
			$is_mod			= $eaf->_POST['is_mod'];
			$signup			= $eaf->_POST['signup'];
			$admin_portal	  = $eaf->_POST['admin_pblocks'];
			$view_portal       = $eaf->_POST['view_portal'];
			$view_selftopics   = $eaf->_POST['view_selftopics'];
			$admin_pages       = $eaf->_POST['admin_pages'];
			$admin_ancs        = $eaf->_POST['admin_ancs'];
			$mod_merge	   = $eaf->_POST['mod_merge'];
			$mod_recy	    = $eaf->_POST['mod_recy'];
			$view_getpage    = $eaf->_POST['view_getpage'];
			$theards_rating  = $eaf->_POST['theards_rating'];
			$tell_friend     = $eaf->_POST['tell_friend'];
			$admin_langs     = $eaf->_POST['admin_langs'];
			$admin_inputs    = $eaf->_POST['admin_inputs'];
	if(empty($title) || empty($style) || empty($name)){
		$eaf->_print('<div class="red">'.$lang["empty"].'</div>');		return false;
	}
$insert = $eaf->db->query("
							INSERT INTO `" . $this->start_tabel . $this->table. "`  VALUES (
							NULL,
							'$title',
							'$style',
							'$name',
							'$out',
							'$add_topic',
							'$add_post',
							'$edit_topic',
							'$edit_post',
							'$delete_topic',
							'$delete_post',
							'$send_pm',
							'$attach_up',
							'$view_forums',
							'$view_posts',
							'$attach_down',
							'$mod_edit',
							'$mod_delete',
							'$mod_move',
							'$mod_sticky',
							'$view_online',
							'$view_mlist',
							'$showin',
							'$mod_close',
							'$rename',
							'$search',
							'$view_sctipt',
							'$is_mod',
							'$is_admin',
							'$if_closed',
							'$view_profile',
							'$view_userip',
							'$signup',
							'$admin_titles',
							'$admin_tools',
							'$admin_members',
							'$admin_hacks',
							'$admin_icons',
							'$admin_smiles',
							'$admin_styles',
							'$admin_sections',
							'$admin_setting',
							'$admin_filem',
							'$admin_theards',
							'$admin_groups',
							'$admin_portal',
							'$admin_inputs',
							'$admin_langs',
							'$view_portal',
							'$view_selftopics',
							'$admin_pages',
							'$admin_ancs',
							'$mod_merge',
							'$mod_recy',
							'$view_getpage',
							'$theards_rating',
							'$tell_friend'
							
							)");
							
					if($insert){
						
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL=groups.php" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
}

}

public function _ShowGroups(){
	
		global $eaf,$lang;
		
		$this->Query = $eaf->db->query("SELECT * FROM " . $this->start_tabel . $this->table . " ORDER BY id ASC");


		$this->ShowTable = '
		
		<table width="96%">
		<tr>
		<td colspan="5" class="head">'.$lang["groups"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_title"].'</td>
		<td>'.$lang["groups_viewdo"].'</td>
		<td>'.$lang["groups_membersMove"].'</td>
		<td>'.$lang["edit"].'</td>
		<td>'.$lang["delete"].'</td>
		</tr>
		
		';
		
		while($rows = $eaf->db->dbrows($this->Query)){
			
			if($rows['out'] == 0){
				
				$out = $lang["groups_actived"];
			
			}else{
			
				$out = $lang["groups_unactived"];	
			}
			
			$name = str_replace("{name}",$rows['title'],$rows['style']);
			
			$this->ShowTable .= '
								<tr>
								<td>'.$name.'</td>
								<td>'.$out.'</td>
								<td><a href="groups.php?action=move&id='.$rows['id'].'"><img src="icons/web.png" border="0px" /></a></td>
								<td><a href="groups.php?action=edit&id='.$rows['id'].'"><img src="icons/edit.png" border="0px" /></a></td>
								<td><a href="groups.php?action=delete&id='.$rows['id'].'"><img src="icons/recy.png" border="0px" /></a></td>
								</tr>
			
								';
		}
		$this->ShowTable .='
		</table>
		';
		
		return $this->ShowTable;
}

	public function _DEleteGroup(){
	
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));	
		
		$SystemGroups = array(1,2,4,5,6,7);
		
		if(in_array($id,$SystemGroups)){
			
			$eaf->_print('<div class="red">'.$lang["groups_cantDelete"].'</div>');
			
			$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));	
			
			return false;
		}
	
		$query = $eaf->db->query("SELECT * FROM " . $this->start_tabel . $this->table . " WHERE id=$id");
		
		if($eaf->db->dbnum($query) == 0){
			
			$eaf->_print('<div class="red">'.$lang["groups_notexists"].'</div>');
			
			$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));	
			
			return false;
		
		}else{
			
			$delete = $eaf->db->query("DELETE FROM " . $this->start_tabel . $this->table . " WHERE id=$id");	
				
				if($delete){
					
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
		}
	}
	
	public function _EDitForm(){
		
		global $eaf,$lang;	
	
		$id	= intval(abs($eaf->_REQUEST['id']));
		
		$query = $eaf->db->query("select * from " . $this->start_tabel . $this->table . " where id=$id");
		
		$rows  = $eaf->db->dbrows($query);
		
	$FormEdit = '
		<form method="post" name="addform">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td class="head" colspan="2">'.$lang["groups_edit"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_title"].'</td>
		<td><input type="text" name="title" value="'.$rows['title'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["groups_style"].'</td>
		<td><textarea name="style" style="direction:ltr;">'.$rows['style'].'</textarea></td>
		</tr>
		<tr>
		<td>'.$lang["groups_name"].'</td>
		<td><input type="text" name="name" value="'.$rows['name'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["groups_out"].'</td>
		<td>
		<select name="out">
		<option value="0"'; if($rows['out'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['out'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_script"].'</td>
		<td>
		<select name="script">
		<option value="0"'; if($rows['script'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['script'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewForums"].'</td>
		<td>
		<select name="view_forums">
		<option value="1"'; if($rows['view_forums'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_forums'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewTopics"].'</td>
		<td>
		<select name="view_topics">
		<option value="1"'; if($rows['view_topics'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_topics'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_sdo"].'</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_topicAdd"].'</td>
		<td>
		<select name="topic_add">
		<option value="1"'; if($rows['add_topic'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['add_topic'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
				<tr>
		<td>'.$lang["groups_postAdd"].'</td>
		<td>
		<select name="post_add">
		<option value="1"'; if($rows['add_post'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['add_post'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_topicEdit"].'</td>
		<td>
		<select name="topic_edit">
		<option value="1"'; if($rows['edit_topic'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['edit_topic'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_postEdit"].'</td>
		<td>
		<select name="post_edit">
		<option value="1"'; if($rows['edit_post'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['edit_post'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_deleteTopics"].'</td>
		<td>
		<select name="delete_topics">
		<option value="1"'; if($rows['delete_topic'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['delete_topic'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_deletePosts"].'</td>
		<td>
		<select name="delete_posts">
		<option value="1"'; if($rows['delete_post'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['delete_post'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_sendPm"].'</td>
		<td>
		<select name="send_pm">
		<option value="1"'; if($rows['send_pm'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['send_pm'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_attachUp"].'</td>
		<td>
		<select name="attach_up">
		<option value="1"'; if($rows['attach_up'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['attach_up'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_attachDown"].'</td>
		<td>
		<select name="attach_down">
		<option value="1"'; if($rows['attach_down'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['attach_down'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>	
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_mdo"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_isMod"].'</td>
		<td>
		<select name="is_mod">
		<option value="0"'; if($rows['is_mod'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['is_mod'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modEdit"].'</td>
		<td>
		<select name="mod_edit">
		<option value="0" '; if($rows['mod_edit'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_edit'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modDelete"].'</td>
		<td>
		<select name="mod_delete">
		<option value="0"'; if($rows['mod_delete'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_delete'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_modMove"].'</td>
		<td>
		<select name="mod_move">
		<option value="0"'; if($rows['mod_move'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_move'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>		<tr>
		<td>'.$lang["groups_modSticky"].'</td>
		<td>
		<select name="mod_sticky">
		<option value="0"'; if($rows['mod_sticky'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_sticky'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_modMerge"].'</td>
		<td>
		<select name="mod_merge">
		<option value="0"'; if($rows['mod_merge'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_merge'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_modRecy"].'</td>
		<td>
		<select name="mod_recy">
		<option value="0"'; if($rows['mod_recy'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_recy'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>	
		<tr>
		<td>'.$lang["groups_modClose"].'</td>
		<td>
		<select name="mod_close">
		<option value="0"'; if($rows['mod_close'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['mod_close'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>			
		<tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_ado"].'</td>
		</tr>
		<tr>
		<td>'.$lang["groups_isAdmin"].'</td>
		<td>
		<select name="is_admin">
		<option value="0"'; if($rows['is_admin'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['is_admin'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminSetting"].'</td>
		<td>
		<select name="admin_setting">
		<option value="0"'; if($rows['admin_setting'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_setting'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminTools"].'</td>
		<td>
		<select name="admin_tools">
		<option value="0"'; if($rows['admin_tools'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_tools'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminTheards"].'</td>
		<td>
		<select name="admin_theards">
		<option value="0" '; if($rows['admin_theards'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1" '; if($rows['admin_theards'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminSections"].'</td>
		<td>
		<select name="admin_sections">
		<option value="0"'; if($rows['admin_sections'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_sections'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminHacks"].'</td>
		<td>
		<select name="admin_hacks">
		<option value="0"'; if($rows['admin_hacks'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_hacks'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminPblocks"].'</td>
		<td>
		<select name="admin_pblocks">
		<option value="0"'; if($rows['admin_portal'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_portal'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminMembers"].'</td>
		<td>
		<select name="admin_members">
		<option value="0"'; if($rows['admin_members'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_members'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminGroups"].'</td>
		<td>
		<select name="admin_groups">
		<option value="0"'; if($rows['admin_groups'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_groups'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminStyles"].'</td>
		<td>
		<select name="admin_styles">
		<option value="0"'; if($rows['admin_styles'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_styles'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminTitles"].'</td>
		<td>
		<select name="admin_titles">
		<option value="0"'; if($rows['admin_title'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_title'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminIcons"].'</td>
		<td>
		<select name="admin_icons">
		<option value="0"'; if($rows['admin_icons'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_icons'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminSmiles"].'</td>
		<td>
		<select name="admin_smiles">
		<option value="0"'; if($rows['admin_smiles'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_smiles'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminAncs"].'</td>
		<td>
		<select name="admin_ancs">
		<option value="0"'; if($rows['admin_ancs'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_ancs'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_adminPages"].'</td>
		<td>
		<select name="admin_pages">
		<option value="0"'; if($rows['admin_pages'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_pages'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_adminFilem"].'</td>
		<td>
		<select name="admin_filem">
		<option value="0"'; if($rows['admin_filem'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_filem'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_adminLangs"].'</td>
		<td>
		<select name="admin_langs">
		<option value="0"'; if($rows['admin_langs'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_langs'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
	    <tr>
		<td>'.$lang["groups_adminInputs"].'</td>
		<td>
		<select name="admin_inputs">
		<option value="0"'; if($rows['admin_inputs'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['admin_inputs'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["groups_otdo"].'</td>
		</tr>
		<td>'.$lang["groups_viewOnline"].'</td>
		<td>
		<select name="view_online">
		<option value="1"'; if($rows['view_online'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_online'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<td>'.$lang["groups_rename"].'</td>
		<td>
		<select name="rename">
		<option value="0"'; if($rows['rename'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['rename'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewMlist"].'</td>
		<td>
		<select name="view_mlist">
		<option value="1"'; if($rows['view_memberlist'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_memberlist'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["groups_showInOnline"].'</td>
		<td>
		<select name="show_in_online">
		<option value="1"'; if($rows['show_in_online'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['show_in_online'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_signup"].'</td>
		<td>
		<select name="signup">
		<option value="1"'; if($rows['rigester'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['rigester'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewUserip"].'</td>
		<td>
		<select name="view_userip">
		<option value="0"'; if($rows['view_userip'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['view_userip'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_tellFriend"].'</td>
		<td>
		<select name="tell_friend">
		<option value="1"'; if($rows['tell_freind'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['tell_freind'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewGetpage"].'</td>
		<td>
		<select name="view_getpage">
		<option value="1"'; if($rows['view_getpage'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_getpage'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_theardsRating"].'</td>
		<td>
		<select name="theards_rating">
		<option value="1"'; if($rows['theards_rating'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['theards_rating'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewSelftopics"].'</td>
		<td>
		<select name="view_selftopics">
		<option value="0"'; if($rows['view_selftopics'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		<option value="1"'; if($rows['view_selftopics'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewProfile"].'</td>
		<td>
		<select name="view_profile">
		<option value="1"'; if($rows['view_profile'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_profile'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_search"].'</td>
		<td>
		<select name="search">
		<option value="1"'; if($rows['search'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['search'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_viewPortal"].'</td>
		<td>
		<select name="view_portal">
		<option value="1"'; if($rows['view_portal'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['view_portal'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td>'.$lang["groups_ifClosed"].'</td>
		<td>
		<select name="if_closed">
		<option value="1"'; if($rows['closed'] == 1){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["yes"].'</option>
		<option value="0"'; if($rows['closed'] == 0){ $FormEdit .= ' selected="selected" '; } $FormEdit .='>'.$lang["no"].'</option>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["post"].'</td>
		</tr>
		<tr>
		<td colspan="2" align="center"><input type="submit" value="'.$lang["edit"].'" name="editgroup" /></td>
		</tr>
		</table>
		</form>
		';	
		
		return $FormEdit;
	}
	
	public function _EditPsot(){
	
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));
			
		if($eaf->_POST['editgroup']){
			
			$title 		= $eaf->_POST['title'];
			$style		= $eaf->_POST['style'];
			$name         = trim($eaf->_POST['name']);
			$out          = $eaf->_POST['out'];
			$add_topic    = $eaf->_POST['topic_add'];
			$add_post     = $eaf->_POST['post_add'];
			$edit_topic   = $eaf->_POST['topic_edit'];
			$edit_post    = $eaf->_POST['post_edit'];
			$delete_topic = $eaf->_POST['delete_topics'];
			$delete_post  = $eaf->_POST['delete_posts'];
			$send_pm      = $eaf->_POST['send_pm'];
			$attach_up    = $eaf->_POST['attach_up'];
			$attach_down  = $eaf->_POST['attach_down'];
			$view_forums  = $eaf->_POST['view_forums'];
			$mod_edit     = $eaf->_POST['mod_edit'];
			$mod_delete   = $eaf->_POST['mod_delete'];
			$mod_move     = $eaf->_POST['mod_move'];
			$mod_sticky   = $eaf->_POST['mod_sticky'];
			$mod_close    = $eaf->_POST['mod_close'];
			$is_admin     = $eaf->_POST['is_admin'];
			$view_online  = $eaf->_POST['view_online'];
			$view_mlist   = $eaf->_POST['view_mlist'];
			$rename       = $eaf->_POST['rename'];
			$showin       = $eaf->_POST['show_in_online'];
			$admin_titles      = $eaf->_POST['admin_titles'];
			$admin_sections    = $eaf->_POST['admin_sections'];
			$admin_hacks       = $eaf->_POST['admin_hacks'];
			$admin_groups      = $eaf->_POST['admin_groups'];
			$admin_theards     = $eaf->_POST['admin_theards'];
			$admin_styles      = $eaf->_POST['admin_styles'];
			$admin_icons       = $eaf->_POST['admin_icons'];
			$admin_smiles      = $eaf->_POST['admin_smiles'];
			$admin_tools       = $eaf->_POST['admin_tools'];
			$admin_setting     = $eaf->_POST['admin_setting'];
			$admin_filem       = $eaf->_POST['admin_filem'];
			$admin_members     = $eaf->_POST['admin_members'];
			$search            = $eaf->_POST['search'];
			$view_profile      = $eaf->_POST['view_profile'];
			$view_userip       = $eaf->_POST['view_userip'];
			$if_closed		 = $eaf->_POST['if_closed'];
			$view_sctipt       = $eaf->_POST['script'];
			$is_mod			= $eaf->_POST['is_mod'];
			$signup			= $eaf->_POST['signup'];
			$view_topics       = $eaf->_POST['view_topics'];
			$admin_portal	  = $eaf->_POST['admin_pblocks'];
			$view_portal       = $eaf->_POST['view_portal'];
			$view_selftopics   = $eaf->_POST['view_selftopics'];
			$admin_pages       = $eaf->_POST['admin_pages'];
			$admin_ancs        = $eaf->_POST['admin_ancs'];
			$mod_merge	   = $eaf->_POST['mod_merge'];
			$mod_recy	    = $eaf->_POST['mod_recy'];
			$view_getpage    = $eaf->_POST['view_getpage'];
			$theards_rating  = $eaf->_POST['theards_rating'];
			$tell_friend     = $eaf->_POST['tell_friend'];
			$admin_langs     = $eaf->_POST['admin_langs'];
			$admin_inputs    = $eaf->_POST['admin_inputs'];
			$UPDATE = $eaf->db->query("UPDATE " . $this->start_tabel . $this->table . " SET 
		    `title`='$title',
			`style`='$style',
			`name`='$name',
			`out`='$out',
			`edit_topic`='$edit_topic',
			`edit_post`='$edit_post',
			`add_post`='$add_post',
			`add_topic`='$add_topic',
			`delete_topic`='$delete_topic',
			`delete_post`='$delete_post',
			`is_mod`='$is_mod',
			`send_pm`='$send_pm',
			`attach_up`='$attach_up',
			`attach_down`='$attach_down',
			`view_topics`='$view_topics',
			`view_profile`='$view_profile',
			`script`='$view_sctipt',
			`rigester`='$signup',
			`closed`='$if_closed',
			`search`='$search',
			`view_online`='$view_online',
			`view_memberlist`='$view_mlist',
			`view_userip`='$view_userip',
			`show_in_online`='$showin',
			`rename`='$rename',
			`is_admin`='$is_admin',
			`admin_title`='$admin_titles',
			`admin_hacks`='$admin_hacks',
			`admin_setting`='$admin_setting',
			`admin_tools`='$admin_tools',
			`admin_theards`='$admin_theards',
			`admin_styles`='$admin_styles',
			`admin_icons`='$admin_icons',
			`admin_smiles`='$admin_smiles',
			`admin_filem`='$admin_filem',
			`admin_members`='$admin_members',
			`admin_groups`='$admin_groups',
			`admin_sections`='$admin_sections',
			`mod_edit`='$mod_edit',
			`mod_delete`='$mod_delete',
			`mod_move`='$mod_move',
			`mod_close`='$mod_close',
			`mod_sticky`='$mod_sticky',
			`view_forums`='$view_forums',
			`admin_portal`='$admin_portal',
			`view_portal`='$view_portal',
			`view_selftopics`='$view_selftopics',
			`view_getpage`='$view_getpage',
			`tell_freind`='$tell_friend',
			`theards_rating`='$theards_rating',
			`mod_recy`='$mod_recy',
			`mod_merge`='$mod_merge',
			`admin_ancs`='$admin_ancs',
			`admin_pages`='$admin_pages',
			`admin_langs` = '$admin_langs' ,
			`admin_inputs` = '$admin_inputs' 
			WHERE id=$id
			");
			
			if($UPDATE){
				
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
		}
	}
	
	public function _MoveForm(){
	
		global $eaf,$lang;
		
		$id    = intval(abs($core->_REQUEST['id']));
		$Query = $eaf->db->query("SELECT * FROM " . tablenamestart("groups") . " WHERE id != $id");
		 $Form = '
		 		<form method="post" name="move_group">
				<table width="97%" border="0" align="center">
				<tr>
				<td class="head">'.$lang["groups_selectG"].'</td>
				</tr>
				<tr>
				<td class="tct">
				<select name="group_to">
				';
				
				while($rows = $eaf->db->dbrows($Query)){
					
					$Form .= '<option value="'.$rows['id'].'"> -- ' . $rows['title'] . ' </option>';
				}
		$Form .= '
				</select> <input type="submit" name="movegroup" value="'.$lang["move"].'" />
				</td>
				</tr>
				</table>
				
				</form>
				';	
				
				return $Form;
	}
	
	public function _MovePost(){
		
		global $eaf,$lang;
		
		$id 	= intval(abs($eaf->_REQUEST['id']));
		
		$to    = intval(abs($eaf->_POST['group_to']));
	
		if(isset($eaf->_POST['movegroup'])){
			
			$users = $eaf->db->query("SELECT * FROM members WHERE groupid=$id");
			
			$Total = 	$eaf->db->dbnum($users);		
			if($Total == 0){
				
				$eaf->_print('<div class="red">'.$lang["groups_nomove"].'</div>');	
			
				return false;
			}
			
			while($rows = $eaf->db->dbrows($users)){
					
					$update = $eaf->db->query("UPDATE members SET groupid='$to' WHERE uid=" . $rows['uid']);
					
			}
			
			if($update){
			
				$eaf->_print('<div class="green">'.$lang["groups_move_ok"].'</div>');	
			
			}else{
			
				$eaf->_print('<div class="red">'.$lang["groups_move_error"].'</div>');	
	
			}
			
		}
	}
}
?>