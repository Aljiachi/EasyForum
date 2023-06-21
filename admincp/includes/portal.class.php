<?php

# Easy Arab Forum v1
# Version is 1.2
# Date : 2011
# Email: php4u@hotmail.com
# offical website : http://sdb.jetr.org
# About :
# This script is a program management forums (discussion boards) that allows you to refer the matter fully in your board through the
# * Full Control Forum
# * Control the full membership of the Forum
# * Social control groups (administration - Moderators - Members)
# * full control sections and classifications
# * control subjects
# * Control design and templates
# * System Hacks or Extensions
# * ...... Etc.
# * Programming rights reserved
# * The program is free and for all
# * Programming By : Php4u 
# * Powered By 	   : EAF Version 1.3


class EafProtalControl{

	public function _AddForm(){
		
		global $lang;
	
		return '
				<form method="post" name="addnewblock">
				<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
				<tr>
				<td class="head" colspan="2">'.$lang["portal_new"].'</td>
				</tr>
				<tr>
				<td>'.$lang["portal_title"].'</td>
				<td><input type="text" name="title" /></td>
				</tr>
				<tr>
				<td>'.$lang["portal_sort"].'</td>
				<td><input type="text" name="sort" value="0" /></td>
				</tr>
				<tr>
				<td>'.$lang["portal_active"].'</td>
				<td>
				<select name="active">
				<option value="yes">'.$lang["yes"].'</option>
				<option value="no">'.$lang["no"].'</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["portal_inTemp"].'</td>
				<td>
				<select name="inTemp">
				<option value="0">'.$lang["yes"].'</option>
				<option value="1">'.$lang["no"].'</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["portal_where"].'</td>
				<td>
				<select name="where">
				<option value="1">'.$lang["portal_right"].'</option>
				<option value="2">'.$lang["portal_left"].'</option>
				<option value="3">'.$lang["portal_center"].'</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["portal_content"].'</td>
				<td>
				<textarea name="content" cols="40" rows="4" dir="ltr"></textarea>
				</td>
				</tr>
				<tr>
				<td>'.$lang["post"].'</td>
				<td><input type="submit" value="'.$lang["add"].'" name="addblock" /></td>
				</tr>
				</table>
				</form>
			   ';
	}
	
	public function _AddPost(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['addblock'])){

		$Post = array();
		
		$Post['title'] = $eaf->_POST['title'];
		
		$Post['sort']  = intval(abs($eaf->_POST['sort']));
		
		$Post['inTemp']= intval(abs($eaf->_POST['inTemp']));

		$Post['active']= intval(abs($eaf->_POST['active']));
		
		$Post['where'] = intval(abs($eaf->_POST['where']));
		
		$Post['text']  = $eaf->_POST['content'];
		
		$Post['text']  = str_replace("'","{ReplaceArowe}",$Post['text']);

		$Post['text']  = str_replace('"',"{ReplaceArowa}",$Post['text']);
		
		if(empty($Post['title']) || empty($Post['text'])){
			
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
				
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
				return false;
		}

		$Post['insert'] = $eaf->db->query("insert into " . tablenamestart("pblocks") . " values ('','".$Post['title']."','".$Post['text']."','".$Post['active']."','".$Post['sort']."','".$Post['where']."' , '".$Post['inTemp']."')");
	
		if($Post['insert']){
			
				$eaf->_print('<div class="green">'.$lang["alert_ok"].'</div>');
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
				
			}else{
				
				$eaf->_print('<div class="red">'.$lang["alert_error"].'</div>');	
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
				
			}
	}
	
	}
	
	private function BlockDo($Do){
		
		global $lang;
	
		if($Do == "yes"){
		
			return $lang["portal_actived"];	
		
		}else{
		
			return $lang["portal_unactived"];	
		}
	}
	
	public function BlockWhere($Where){
		
		global $lang;
	
		switch($Where){
		
			case 1: $Where = $lang["portal_right"]; break;
			
			case 2: $Where = $lang["portal_left"]; break;
			
			case 3: $Where = $lang["portal_center"]; break;	
		}
		
		return $Where;
	}
	
	
	private function BlockActive($Do,$id){
		
		global $lang;
	
		if($Do == "yes"){
		
			return "<a href=\"portal.php?action=unactive&id=$id\" title=\"".$lang["portal_active_1"]."\"><img src=\"icons/off.png\" border=\"0px\" /></a>";	
		
		}else{
		
			return "<a href=\"portal.php?action=active&id=$id\" title=\"".$lang["portal_active_0"]."\"><img src=\"icons/on.png\" border=\"0px\" /></a>";	
		}
	}
	public function ViewBlocks(){
		
		global $eaf,$lang;
	
		$Query = mysql_query("SELECT * FROM " . tablenamestart("pblocks"));	
		
		$Table = "
				<table cellpadding=\"0\" cellspacing=\"0\" width=\"95%\" align=\"center\">\n
				<tr>\n
				<td class=\"ttable\">".$lang["ID"]."</td>\n
				<td class=\"ttable\">".$lang["portal_title"]."</td>\n
				<td class=\"ttable\">".$lang["portal_ashow"]."</td>\n
				<td class=\"ttable\">".$lang["portal_in"]."</tD>\n
				<td class=\"ttable\">".$lang["portal_do"]."</td>\n
				<td class=\"ttable\">".$lang["edit"]."</td>\n
				<td class=\"ttable\">".$lang["delete"]."</td>\n
				</tr>\n
				";
				
				while($Rows = $eaf->db->_object($Query)){
					
					$Table .= "
							 
							 <tr>\n
							 <td>$Rows->block_id</tD>\n
							 <td>$Rows->block_title</tD>\n
							 <td>".$this->BlockDo("$Rows->block_active")."</tD>\n
							 <td>".$this->BlockWhere("$Rows->block_where")."</td>\n
							 <td>".$this->BlockActive("$Rows->block_active","$Rows->block_id")."</td>\n
							 <tD><a href='portal.php?action=edit&id=$Rows->block_id'><img src='icons/edit.png' border='0px' /><a></td>\n
							 <td><a href='portal.php?action=remove&id=$Rows->block_id' onclick='if(confirm(\"".$lang["alert_access"]."\") == false){ return false; }'><img src='icons/recy.png' border='0px' /><a></td>
							\n</tr>\n
							  ";
				}
				
		$Table .= "</table>";
				
		return $Table;
	}
	
	public function Delete(){
	
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));	
		
		$Query = $eaf->db->query("select * from " . tablenamestart("pblocks") . " where block_id = $id");
	
		if($eaf->db->dbnum($Query) == 0){
			
			$eaf->_print("<div class=\"red\">$lang[portal_notexists]</div>");
			
			$eaf->_print('<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />');
			
			return false;
		}
		
		$Rows = $eaf->db->_object($Query);
		
		$Delete = $eaf->db->query("DELETE FROM " . tablenamestart("pblocks") . " WHERE block_id = $Rows->block_id");
		
		if($Delete){
			
			echo '<div class="green">'.$lang["alert_ok"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
			echo '<div class="red">'.$lang["alert_error"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
			}
			
	}
	
	public function EditForm(){
		
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));	
		
		$Query = $eaf->db->query("select * from " . tablenamestart("pblocks") . " where block_id = $id");
	
		if($eaf->db->dbnum($Query) == 0){
			
			$eaf->_print("<div class=\"red\">$lang[portal_notexists]</div>");
			
			$eaf->_print('<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />');
			
			return false;
		}
	
				$Rows = $eaf->db->_object($Query);
				
				$Content = $Rows->block_content;
				
				$Content  = str_replace("{ReplaceArowe}","'",$Content);
	
				$Content  = str_replace("{ReplaceArowa}",'"',$Content);
		
				$Form = '
				<form method="post" name="editblockForm">
				<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
				<tr>
				<td class="head" colspan="2">'.$lang["portal_edit"].'</td>
				</tr>
				<tr>
				<td>'.$lang["portal_title"].'</td>
				<td><input type="text" name="title" value="'.$Rows->block_title.'" /></td>
				</tr>
				<tr>
				<td>'.$lang["portal_sort"].'</td>
				<td><input type="text" name="sort" value="'.$Rows->block_sort.'"  /></td>
				</tr>
				<tr>
				<td>'.$lang["portal_active"].'</td>
				<td>
				<select name="active">
				<option value="yes"'; if($Rows->block_active == "yes"){ $Form .= ' selected="selected"';}$Form .='>'.$lang["yes"].'</option>
				<option value="no"'; if($Rows->block_active == "no"){ $Form .= ' selected="selected"';}$Form .='>'.$lang["no"].'</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["portal_inTemp"].'</td>
				<td>
				<select name="inTemp">
				<option value="0"'; if($Rows->block_temp == 0){ $Form .= ' selected="selected"';}$Form .='>'.$lang["yes"].'</option>
				<option value="1"'; if($Rows->block_temp == 1){ $Form .= ' selected="selected"';}$Form .='>'.$lang["no"].'</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["portal_where"].'</td>
				<td>
				<select name="where">
				<option value="1"'; if($Rows->block_where == 1){ $Form .= ' selected="selected"';}$Form .='>'.$lang["portal_right"].'</option>
				<option value="2"'; if($Rows->block_where == 2){ $Form .= ' selected="selected"';}$Form .='>'.$lang["portal_left"].'</option>
				<option value="3"'; if($Rows->block_where == 3){ $Form .= ' selected="selected"';}$Form .='>'.$lang["portal_center"].'</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["portal_content"].'</td>
				<td>
				<textarea name="content" style="width:99%" rows="7" dir="ltr">'.$Content.'</textarea>
				</td>
				</tr>
				<tr>
				<td>'.$lang["post"].'</td>
				<td><input type="submit" value="'.$lang["edit"].'" name="editblock" /></td>
				</tr>
				</table>
				</form>
			   ';	
	return $Form;
	
	}
	
	public function EditPost(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['editblock'])){
			
		$id = intval(abs($eaf->_REQUEST['id']));	
			
		$Post = array();
		
		$Post['title'] = $eaf->_POST['title'];
		
		$Post['sort']  = intval(abs($eaf->_POST['sort']));
		
		$Post['inTemp']= intval(abs($eaf->_POST['inTemp']));

		$Post['active']= intval(abs($eaf->_POST['active']));
		
		$Post['where'] = intval(abs($eaf->_POST['where']));
		
		$Post['text']  = $eaf->_POST['content'];
		
		$Post['text']  = str_replace("'","{ReplaceArowe}",$Post['text']);

		$Post['text']  = str_replace('"',"{ReplaceArowa}",$Post['text']);
		
		if(empty($Post['title']) || empty($Post['text'])){
			
			$eaf->_print("<div class=\"red\">$lang[empty]</div>");
				
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
				return false;
		}
		
		$Edit = $eaf->db->query("UPDATE " . tablenamestart("pblocks") . " SET 
					block_title='$Post[title]',
					block_sort='$Post[sort]',
					block_where='$Post[where]',
					block_active='$Post[active]',
					block_content='$Post[text]',
					block_temp='$Post[inTemp]'
					WHERE block_id = $id					
					");
					
		if($Edit){
									
			echo '<div class="green">'.$lang["alert_ok"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
			echo '<div class="red">'.$lang["alert_error"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
			}
		}
	}
	
	public function Active(){
		
		global $eaf,$lang;
	
		$id = intval(abs($eaf->_REQUEST['id']));	
		
		$Query = $eaf->db->query("select * from " . tablenamestart("pblocks") . " where block_id = $id");
	
		if($eaf->db->dbnum($Query) == 0){
			
			$eaf->_print("<div class=\"red\">$lang[portal_notexists]</div>");
			
			$eaf->_print('<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />');
			
			return false;
		}
	
				$Rows = $eaf->db->_object($Query);

				$Active = $eaf->db->query("UPDATE " . tablenamestart('pblocks') . " SET block_active='yes' WHERE block_id=$Rows->block_id");

		if($Active){
									
			echo '<div class="green">'.$lang["alert_ok"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
			echo '<div class="red">'.$lang["alert_error"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
			}
					
	}
	
	public function UnActive(){
		
		global $eaf,$lang;
	
		$id = intval(abs($eaf->_REQUEST['id']));	
		
		$Query = $eaf->db->query("select * from " . tablenamestart("pblocks") . " where block_id = $id");
	
		if($eaf->db->dbnum($Query) == 0){
			
			$eaf->_print("<div class=\"red\">$lang[portal_notexists]</div>");
			
			$eaf->_print('<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />');
			
			return false;
		}
	
				$Rows = $eaf->db->_object($Query);

				$Active = $eaf->db->query("UPDATE " . tablenamestart('pblocks') . " SET block_active='no' WHERE block_id=$Rows->block_id");

		if($Active){
									
			echo '<div class="green">'.$lang["alert_ok"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
			echo '<div class="red">'.$lang["alert_error"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
			}
					
	}
	
}

?>