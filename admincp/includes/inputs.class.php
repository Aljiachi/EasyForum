<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class InputsControl{

	private $Id,$Table;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->Id = $eaf->security->HashId($eaf->_REQUEST['id']);
		
		$this->Table = tablenamestart("inputs");
		
	}
	
	public function AddInput(){
		
		global $lang;
		
		return '<div id="msg"></div>
		<form name="add_input" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
        <tr>
        <td>'.$lang["input_title"].'</td>
        <td><input type="text" name="title" /></td>
        </tr>
        <tr>
        <td>'.$lang["input_view"].'</td>
        <td>'.$lang["yes"].' <input type="radio" value="1" name="view" checked /> '.$lang["no"].'  <input type="radio" value="0" name="view" /></td>
        </tr>
        <tr>
        <td>'.$lang["input_exists"].'</td>
        <td>'.$lang["yes"].'  <input type="radio" value="1" name="exists" /> '.$lang["no"].'  <input type="radio" value="0" name="exists" checked /></td>
        </tr>
        <tr>
        <td>'.$lang["input_edit"].'</td>
        <td>'.$lang["yes"].'  <input type="radio" value="1" name="edit" checked /> '.$lang["no"].'  <input type="radio" value="0" name="edit" /></td>
        </tr>
		<tr>
        <td>'.$lang["input_sort"].'</td>
        <td><input type="text" value="0" name="order" /></td>
        </tr>
        <tr>
        <td>'.$lang["input_type"].'</td>
        <td>
        <select name="type" onChange="StringBox(this.value);">
        <option value="{text}">'.$lang["input_type:text"].'</option>
        <option value="{menu}">'.$lang["input_type:menu"].'</option>
        <option value="{radio}">'.$lang["input_type:radio"].'</option>
        </select>
        </td>
        </tr>
        <tr id="StringBox">
        <td>'.$lang["input_valuesMsg"].'</td>
        <td>
        <textarea name="strings" cols="40" rows="1"></textarea>
        </td>
        </tr>
        <tr>
        <td><input type="submit" name="addinput" value="'.$lang["add"].'" /></td>
        </tr>
        </table>
        </form>';	
	}

	public function AddPost(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['addinput'])){
		
		$title = $eaf->security->safe($eaf->_POST['title']);

		$view = $eaf->security->sint($eaf->_POST['view']);
		
		$order = $eaf->security->sint($eaf->_POST['order']);
		
		$exists = $eaf->security->sint($eaf->_POST['exists']);

		$edit = $eaf->security->sint($eaf->_POST['edit']);

		$type = $eaf->security->safe($eaf->_POST['type']);
		
		$strings = $eaf->security->safe($eaf->_POST['strings']);
		
		$strings = str_replace("\n","{sp}",$strings);
		
		if(empty($title)){
			
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');						
						
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
				return false;
		
				}
		
		$Insert = $eaf->db->query("insert into $this->Table values (
		'',
		'$type',
		'',
		'$strings',
		'$title',
		'$order',
		'$view',
		'$exists',
		'$edit'
		)");
		
		$InsertId = mysql_insert_id();
		
		$AlterInput = $eaf->db->query("ALTER TABLE `members` ADD `extrainput_$InsertId` VARCHAR( 255 ) NOT NULL ;") or die(mysql_error());
		
		
			if($Insert and $AlterInput){
			
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
		}
	}
	
	public function Show(){
		
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select * from $this->Table order by input_id asc");
		
		$Table = '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">';
		
		$Table .= '
				  <tr>
				  <td>'.$lang["ID"].'</td>
				  <td>'.$lang["input_title"].'</td>
				  <td>'.$lang["input_type"].'</td>
				  <td>'.$lang["input_edit"].'</td>
				  <td>'.$lang["input_view"].'</td>
				  <td>'.$lang["edit"].'</td>
				  <td>'.$lang["delete"].'</td>
				  </tr>
				  ';
				  
	while($rows = $eaf->db->_object($Query)){
		
		$View = str_replace("1",$lang["yes"],$rows->input_view);
		$View = str_replace("0",$lang["no"],$View);
		$Type = str_replace("{text}",$lang["input_type:text"],$rows->input_type);
		$Type = str_replace("{radio}",$lang["input_type:radio"],$Type);
		$Type = str_replace("{menu}",$lang["input_type:menu"],$Type);
		$Edit = str_replace("1",$lang["yes"],$rows->input_exists);
		$Edit = str_replace("0",$lang["no"],$Edit);
		
		$Table .= '
				  <tr>
				  <td>'.$rows->input_id.'</td>
				  <td>'.$rows->input_name.'</td>
				  <td>'.$Type.'</td>
				  <td>'.$Edit.'</td>
				  <td>'.$View.'</td>
				  <td><a href="inputs.php?action=edit&id='.$rows->input_id.'"><img src="icons/edit.png"  border="0px" /></a></td>
				  <td><a onclick="return confirm('."'".$lang["alert_access"]."'".');" href="inputs.php?action=delete&id='.$rows->input_id.'"><img src="icons/recy.png"  border="0px" /></a></td>
				  </tr>
				  ';		
	}
	$Table .= '</table>';
	
	return $Table;
	}
	
	public function Delete(){
	
		global $eaf,$lang;
		
		$Id = $eaf->security->HashId($this->Id,false);
		
		if($eaf->db->totalWhere($this->Table,"input_id",$Id) == 0){
			
				echo '<div class="red">'.$lang["input_notexists"].'</div>';	
						
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
				return false;
				
				}
				
		$Query = $eaf->db->query("delete from $this->Table where input_id = $Id");
		
		if($Query){
			
			$Delete = $eaf->db->query("ALTER TABLE `members` DROP `extrainput_$Id`");	
		}
		
		if($Delete){

				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
	}
	
	public function Edit(){
		
		global $eaf,$lang;
		
		$Id = $eaf->security->HashId($this->Id,false);
		
		if($eaf->db->totalWhere($this->Table,"input_id",$Id) == 0){
			
				echo '<div class="red">'.$lang["input_notexists"].'</div>';	
						
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
				return false;
				
				}
				
				
		$Query = $eaf->db->query("select * from $this->Table where input_id = $Id");
		
		$Rows = $eaf->db->_object($Query);
		
		$Strings = str_replace("{sp}","\n",$Rows->input_strings);
		
		$Form  = '<form name="add_input" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
        <tr>
        <td>'.$lang["input_title"].'</td>
        <td><input type="text" name="title" value="'.$Rows->input_name.'" /></td>
        </tr>
        <tr>
        <td>'.$lang["input_view"].'</td>
        <td>'.$lang["yes"].' <input type="radio" value="1" name="view" '; if($Rows->input_view == 1){ $Form .= 'checked '; } $Form .= '/> 
		'.$lang["no"].'  <input type="radio" value="0" name="view" '; if($Rows->input_view == 0){ $Form .= 'checked '; }$Form .= '/></td>
        </tr>
        <tr>
        <td>'.$lang["input_exists"].'</td>
        <td>'.$lang["yes"].'  <input type="radio" value="1" name="exists" '; if($Rows->input_exists == 1){ $Form .= 'checked ';} $Form .= '/>
		 '.$lang["no"].'  <input type="radio" value="0" name="exists" '; if($Rows->input_exists == 0){ $Form .= 'checked ';} $Form .= '/></td>
        </tr>
        <tr>
        <td>'.$lang["input_edit"].'</td>
        <td>'.$lang["yes"].'  <input type="radio" value="1" name="edit"  '; if($Rows->input_edit == 1){ $Form .= 'checked ';} $Form .= '/> 
		'.$lang["no"].'  <input type="radio" value="0" name="edit" '; if($Rows->input_edit == 0){ $Form .= 'checked ';} $Form .= '/></td>
        </tr>
		<tr>
        <td>'.$lang["input_sort"].'</td>
        <td><input type="text" value="0" name="order" value="'.$Rows->input_order.'" /></td>
        </tr>
        <tr>
        <td>'.$lang["input_type"].'</td>
        <td>
        <select name="type" onChange="StringBox(this.value);">
        <option value="{text}"'; if($Rows->input_type == "{text}"){ $Form .= 'selected';} $Form .= '>'.$lang["input_type:text"].'</option>
        <option value="{menu}"'; if($Rows->input_type == "{menu}"){ $Form .= 'selected';} $Form .= '>'.$lang["input_type:menu"].'</option>
        <option value="{radio}"'; if($Rows->input_type== "{radio}"){ $Form .= 'selected'; } $Form .= '>'.$lang["input_type:radio"].'</option>
        </select>
        </td>
        </tr>
        <tr id="StringBox">
        <td>'.$lang["input_valuesMsg"].'</td>
        <td>
        <textarea name="strings" cols="40" rows="4">'.$Strings.'</textarea>
        </td>
        </tr>
        <tr>
        <td><input type="submit" name="editinput" value="'.$lang["edit"].'" /></td>
        </tr>
        </table>
        </form>';	
		
		return $Form;		
	}
	
	public function EditPost(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['editinput'])){
			
		$Id = $eaf->security->HashId($this->Id,false);
		
		$title = $eaf->security->safe($eaf->_POST['title']);

		$view = $eaf->security->sint($eaf->_POST['view']);
		
		$order = $eaf->security->sint($eaf->_POST['order']);
		
		$exists = $eaf->security->sint($eaf->_POST['exists']);

		$edit = $eaf->security->sint($eaf->_POST['edit']);

		$type = $eaf->security->safe($eaf->_POST['type']);
		
		$strings = $eaf->security->safe($eaf->_POST['strings']);
		
		$strings = str_replace("\n","{sp}",$strings);
		
		if(empty($title)){
			
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');	
						
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
				return false;
		
				}
				
		$Update = $eaf->db->query("update `$this->Table` set 
		`input_name`='$title',
		`input_type`='$type',
		`input_order`='$order',
		`input_exists`='$exists',
		`input_view`='$view',
		`input_strings`='$strings'
		 where input_id = $Id"
		 );
		 
		 if($Update){
								
			echo '<div class="green">'.$lang["alert_ok"].'</div>';
			
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
						
			}else{
									
			echo '<div class="red">'.$lang["alert_error"].'</div>';
			
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
			}
		}
	}
}
?>