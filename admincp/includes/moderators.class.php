<?php

class ModeratorsControl{
	
	private $Id;
	
	public function __counstruct(){
		
		global $eaf,$lang;
		
		$this->Id = intval(abs($eaf->_REQUEST['id']));
	}
	
	public function AddForm(){
		
		global $eaf,$lang;
		
		$Groups = $eaf->db->query("select id,title from " . tablenamestart("groups") . " where id!=1 and id!=2 and id!=3 and id!=4 and id!=6 and id!=7");
		
		$Form =  '
		<form method="post">
		<table width="97%" align="center" cellpadding="0" cellspacing="0">
		<tr>
		<td>'.$lang["moders_username"].'</td>
		<td><input type="text" name="user_id" /></td>
		</tr>
		<tr>
		<td>'.$lang["moders_forum"].'</td>
		<td>
		<select name="section_id">';
		
			$Form .= ForumsList();
			
		$Form .= '
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["moders_group"].'</td>
		<td>
		<select name="group_id">
		';
		while($rows = $eaf->db->_object($Groups)){
			
			$Form .= '<option value="'.$rows->id.'"> -- '.$rows->title.'</option>';
		}
		$Form .= '
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["moders_title"].'</td>
		<td><input type="text" name="user_title" /></td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="addmoder" value="'.$lang["add"].'" /></td>
		</tr>
		</table>	
 	</form>
		';
		
		return $Form;
	}
	
	public function PostAdd(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['addmoder'])){
			
			$username = $eaf->_POST['user_id'];	
			
			if(empty($username)){
			
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
				
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
				return false;
			}
			
			$Find = $eaf->db->query("select uid from members where `username` = '$username'") or die(mysql_error());
			
			if($eaf->db->dbnum($Find) == 0){
		
				echo '<div class="red">'.$lang["moders_notexists"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';	
			
				return false;
				
			}
			
			$RowsFind = $eaf->db->dbrows($Find);

			if($RowsFind['groupid'] = 3 || $RowsFind['groupid'] = 4 || $RowsFind['groupid'] = 6 || $RowsFind['groupid'] = 7){
			
				echo '<div class="red"> Õﬁﬁ „‰ — »… «·⁄÷Ê</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';	
			
				return false;
				
			}
						
			$user_id = $RowsFind['uid'];
			
			$section_id = $eaf->_POST['section_id'];
			
			$FindNum = $eaf->db->dbnum($eaf->db->query("select id from " . tablenamestart("moderators") . " where user_id = '$user_id' and section_id = '$section_id'"));
			
			if($FindNum !== 0){
				
					echo '<div class="red">'.$lang["moders_exists"].'</div>';
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';			
					
					return false;
				}
				
		$user_title = $eaf->_POST['user_title'];
			 
		$group_id   = $eaf->_POST['group_id'];
				
		$time = time();
				
			$Add = $eaf->db->query("insert into " . tablenamestart("moderators") . " values ('','$section_id','$user_id','','','','','','','')");
			
			$location   = mysql_insert_id();

//			$Edit_Group = $eaf->db->query("update members set moder_gid='$group_id' where uid=$user_id");
			
			if(!empty($user_title)){
			
				$Edit_Title = $eaf->db->query("update members set moder_title='$user_title' where uid=$user_id");
	
			}
			
			if($Add){	
				
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL=moderators.php?action=edit&id='.$location.'" />';	
			}
			
			}	
	}
	
	public function GetUsername($id){
		
		global $eaf,$lang;
		
		$Rows = $eaf->db->dbrows($eaf->db->query("select username from members where uid = $id"));
		
		return $Rows['username'];	
	}

	public function GetTheard($id){
		
		global $eaf,$lang;
		
		$Rows = $eaf->db->dbrows($eaf->db->query("select title from ". tablenamestart("topics") ." where tid = $id"));
		
		return $Rows['title'];	
	}
	
	public function GetSectionName($id){
		
		global $eaf,$lang;
		
		$Rows = $eaf->db->dbrows($eaf->db->query("select name from ". tablenamestart("sections") ." where fid = $id"));
		
		return $Rows['name'];	
	}
	
	public function show(){
		
		global $eaf,$lang;
		
		$query = $eaf->db->query("select * from " . tablenamestart("moderators"));	
		
		$table  = '<table width="97%" align="center" cellpadding="0" cellspacing="0">';
		
		$table .= '<tr>';
		
		$table .= '<td>'.$lang["moders_username"].'</td>';

		$table .= '<td>'.$lang["moders_in"].'</td>';

		$table .= '<td>'.$lang["moders_logs"].'</td>';

		$table .= '<td>'.$lang["moders_edit"].'</td>';

		$table .= '<td>'.$lang["delete"].'</td>';

		$table .= '</tr>';
		
		while($rows = $eaf->db->dbrows($query)){
		
		$table .= '<tr>';
		
		$table .= '<td>'.$this->GetUsername($rows['user_id']).'</td>';

		$table .= '<td>'.$this->GetSectionName($rows['section_id']).'</td>';

		$table .= '<td><a href="?action=modact&id='.$rows['user_id'].'"><img src="icons/view.png" border="0px" /></a></td>';

		$table .= '<td><a href="?action=edit&id='.$rows['id'].'"><img src="icons/edit.png" border="0px" /></a></td>';

		$table .= '<td><a href="?action=delete&id='.$rows['id'].'"><img src="icons/recy.png" border="0px" /></a></td>';

		$table .= '</tr>';
		
		}
		
		return $table;
	}
	
	public function delete(){
		
		global $eaf,$lang;
		
		$table = tablenamestart("moderators");
		
		$id    = intval(abs($eaf->_REQUEST['id']));
		
		$Find = $eaf->db->query("select id,user_id from $table where id = $id") or die(mysql_error());
		
		if($eaf->db->dbnum($Find) == 0){
		
			echo '<div class="red">'.$lang["moders_notexists"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
		}
			
		$Rows = $eaf->db->dbrows($Find);
		
		$uid = $Rows['user_id'];
		
		$Update = $eaf->db->query("update members set moder_title='',moder_gid='0' where uid=$uid");
	
		$delete = $eaf->db->query("delete from " .  tablenamestart("moderators") . " where id = $id");
		
		if($delete){
		
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';	
		}
		
	}
	
	public function edit(){

		global $eaf,$lang;
		
		$table = tablenamestart("moderators");
		
		$id    = intval(abs($eaf->_REQUEST['id']));
		
		$Find = $eaf->db->query("select * from $table where id = $id") or die(mysql_error());
		
		$rows = $eaf->db->_object($Find);
		
		print '<form method="post">';
		print "\n";
		print '<table width="97%" cellpadding="0" cellspacing="0" align="center">';
		print "\n";
		print '<tr>';
		print "\n";
		print '<td class="ttable" colspan="2">'.$lang["moders_editpage"].'</td>';
		print "\n";
		print '</tr>';
		print '<tr>';
		print "\n";
		print '<td>'.$lang["moders_editTopics"].' : </td>
		<td><select name="edit">
		<option value="0"'; if($rows->edit == 0){ print " selected=\"selected\" "; } print '>'.$lang["no"].'</option>
		<option value="1"'; if($rows->edit == 1){ print " selected=\"selected\" "; } print '>'.$lang["yes"].'</option>
		</select></td>';
		print '</tr><tr>';
		print "\n";
		print '<td>'.$lang["moders_deleteTopics"].' : </td>
		<td><select name="delete">
		<option value="0"'; if($rows->delete == 0){ print " selected=\"selected\" "; } print '>'.$lang["no"].'</option>
		<option value="1"'; if($rows->delete == 1){ print " selected=\"selected\" "; } print '>'.$lang["yes"].'</option>
		</select></td>';
		print "\n";
		print '</tr><tr>';
		print '<td>'.$lang["moders_stickyTopics"].' : </td>
		<td><select name="sticky">
		<option value="0"'; if($rows->sticky == 0){ print " selected=\"selected\" "; } print '>'.$lang["no"].'</option>
		<option value="1"'; if($rows->sticky == 1){ print " selected=\"selected\" "; } print '>'.$lang["yes"].'</option>
		</select></td>';
		print "\n";
		print '</tr><tr>';
		print '<td>'.$lang["moders_moveTopics"].' : </td>
		<td><select name="move">
		<option value="0"'; if($rows->move == 0){ print " selected=\"selected\" "; } print '>'.$lang["no"].'</option>
		<option value="1"'; if($rows->move == 1){ print " selected=\"selected\" "; } print '>'.$lang["yes"].'</option>
		</select></td>';
		print "\n";
		print '</tr><tr>';
		print '<td>'.$lang["moders_mergeTopics"].' : </td>
		<td><select name="merge">
		<option value="0"'; if($rows->merge == 0){ print " selected=\"selected\" "; } print '>'.$lang["no"].'</option>
		<option value="1"'; if($rows->merge == 1){ print " selected=\"selected\" "; } print '>'.$lang["yes"].'</option>
		</select></td>';
		print "\n";
		print '</tr>';
		print "\n";
		print '</tr><tr>';
		print '<td>'.$lang["moders_Recy"].' : </td>
		<td><select name="recy">
		<option value="0"'; if($rows->recy == 0){ print " selected=\"selected\" "; } print '>'.$lang["no"].'</option>
		<option value="1"'; if($rows->recy == 1){ print " selected=\"selected\" "; } print '>'.$lang["yes"].'</option>
		</select></td>';
		print "\n";
		print '</tr>';
		print "\n";
		print '</table>';
		print "\n";
		print '<center><input type="submit" value="'.$lang["edit"].'" name="update" /></center>';
		print '</form>';
	}
	
	public function postEdit(){
		
		global $eaf,$lang;	
		
		if(isset($eaf->_POST['update'])){
		
			$table = tablenamestart("moderators");
			$id    = intval(abs($eaf->_REQUEST['id']));
			$edit = intval(abs($eaf->_POST['edit']));	
			$delete = intval(abs($eaf->_POST['delete']));	
			$move = intval(abs($eaf->_POST['move']));	
			$sticky = intval(abs($eaf->_POST['sticky']));	
			$merge = intval(abs($eaf->_POST['merge']));
			$recy = intval(abs($eaf->_POST['recy']));
			
			$update = $eaf->db->query("update `$table` set `edit`='$edit',`delete`='$delete',`move`='$move',`sticky`='$sticky',`merge`='$merge',`recy`='$recy' where `id` = $id");	
		
			if($update){
		
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL=moderators.php" />';	
				
				}
		}
	}
	
	public function getModerLogs(){
		
		global $eaf,$lang;
	
		$table = tablenamestart("moderlogs");
		$id    = intval(abs($eaf->_REQUEST['id']));
		$Query = $eaf->db->query("select * from $table where user_id = $id");
		
			if($eaf->db->dbnum($Query) == 0){
				
				echo '<div class="red">'.$lang["moders_logs_empty"].'</div>';
				echo '<meta http-equiv="refresh" content="3;URL=moderators.php" />';	
				return false;
			}
			
			print '<table width="97%" align="center" cellpadding="0" cellspacing="0">';
			print '<tr>';
			print '<tr>';
			print '<td class="ttable" colspan="4">'.$lang["moders_logs"].'</td>';
			print '</tr>';
			print '<td>'.$lang["ID"].'</td>';
			print '<td>'.$lang["moderlog_date"].'</td>';
			print '<td>'.$lang["moderlog_post"].'</td>';
			print '<td>'.$lang["moderlog_action"].'</td>';
			print '</tr>';
			while($rows = $eaf->db->_object($Query)){
			$Dos = array(
			"Delete" => $lang["do_delete"]	,
			"Edit" => $lang["do_edit"]	  ,
			"unSticky" => $lang["do_unsticky"]  ,
			"Sticky" => $lang["do_sticky"]	,
			"Close" => $lang["do_close"]	 ,
			"Open" => $lang["do_open"]	  ,
			"Move" => $lang["do_move"]	  ,
			"Merge" => $lang["do_merge"]	 ,
			"Recly" => $lang["do_rec"]
			);
			foreach($Dos as $kay => $var) : 

			$rows->do = str_replace($kay,$var,$rows->do);
			
			endforeach;
			
			print '<tr>';
			print '<td>'.$rows->id.'</td>';
			print '<td>'.date("y-m-d g:i A",$rows->time).'</td>';
			print '<td><a href="#'.$rows->theard_id.'">'.$this->GetTheard($rows->theard_id).'</a></td>';
			print '<td>'.$rows->do.'</td>';
			print '</tr>';
			
			}
			print '</table>';		
			print '<center><input type="button" value="'.$lang["empty_moderlogs"].'" onclick="location = '."'moderators.php?action=empty&id=$id'".'" /></center>';
				
		}
		
		public function EmptyActions(){
		
			global $eaf,$lang;
			
			$table = tablenamestart("moderlogs");
			$id    = intval(abs($eaf->_REQUEST['id']));
			
			if(isset($id)){
			
				$Delete = $eaf->db->query("delete from $table where user_id = $id");	
			
			}else{
				
				$Delete = $eaf->db->query("delete from $table");
			}
			
			if($Delete){
				
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
	
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
						
					}else{
								
				echo '<div class="red">'.$lang["alert_error"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
					}
					
			 }
}
?>