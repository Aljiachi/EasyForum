<?php

class LanguagesControl{

	private $Id,$table;
	
	public function __construct(){
		
		global $eaf,$lang;
		
		$this->Id = intval(abs($eaf->_REQUEST['id']));
		
		$this->table = tablenamestart("languages");
		
	}
	
	public function addForm(){
		
		global $lang;
		
		$Dir = opendir("../languages");
	
		$Form = '
				<form method=\"post\">
				<table width=\"97%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
				<tr>
				<td colspan=\"2\" class=\"ttable\">'.$lang["langs_add"].'</td>
				</tr>
				<tr>
				<td>'.$lang["langs_name"].'</td>
				<td>
				<input type=\"text\" name=\"lang_name\" />
				</td>
				</tr>
				<tr>
				<td>'.$lang["langs_folder"].'</td>
				<td>
				<select name=\"lang_folder\">';
				
					while($Get = readdir($Dir)){
						
						$Get = str_replace(".","",$Get);
						$Get = str_replace("..","",$Get);
						$Get = str_replace("indexhtml","",$Get);
						$Get = str_replace("indexhtm","",$Get);
					
						if(!empty($Get)) 
						
						$Form .= '<option value=\"'.$Get.'\">' . $Get . '</option>';	
					}
					
				$Form .= '</select>
				</td>
				</tr>
				<tr>
				<td>'.$lang["post"].'</td>
				<td>
				<input type=\"submit\" name=\"addlang\" value=\"'.$lang["add"].'" />
				</td>
				</tr>
				</table>
				</form>
				';	
				
				return $Form;
	}
	
	public function addPost(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['addlang'])) :
		
			$lang_name = strip_tags($eaf->_POST['lang_name']);
			
			if(empty($lang_name)){
			
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
				
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
				return false;	
		
			}
			
			$lang_folder = strip_tags(trim($eaf->_POST['lang_folder']));
			
			$Insert = $eaf->db->query("insert into $this->table values('','$lang_name','$lang_folder')");
			
			if($Insert){
					
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
			}else{
					
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
			}
			
		endif; 	
	}
	
	public function Show(){
		
		global $eaf,$lang;
	
		$Query = $eaf->db->query("select * from $this->table");
		
		print '<table width="97%" align="center" cellpadding="0" cellspacing="0">
				<tr>
				<td colspan="5" class="ttable">'.$lang["langs_show"].'</td>
				</tr>
				<tr>
				<td>'.$lang["ID"].'</td>
				<td>'.$lang["langs_name"].'</td>
				<td>'.$lang["langs_folder"].'</td>
				<td>'.$lang["edit"].'</td>
				<td>'.$lang["delete"].'</td>
				</tr>
				';	
				
		while($Rows = $eaf->db->dbrows($Query)) : 
		
		print '
				<tr>
				<td>'.$Rows["lang_id"].'</td>
				<td>'.$Rows["lang_name"].'</td>
				<td>'.$Rows["lang_folder"].'</td>
				<td><a href="languages.php?action=edit&id='.$Rows["lang_id"].'"><img src="icons/edit.png" border="0px" /></a></td>
				<td><a href="languages.php?action=delete&id='.$Rows["lang_id"].'"><img src="icons/recy.png" border="0px" /></a></td>
				</tr>
				';
		endwhile;
	}
	
	public function delete(){
	
		global $eaf,$lang;
		
		if($eaf->db->totalWhere($this->table,"lang_id",$this->Id) == 0){
	
			echo '<div class="red">'.$lang["langs_notexists"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
			exit;		
				
		}	
		
		$Delete = $eaf->db->query("delete from $this->table where lang_id = $this->Id");
		
		if($Delete) {
			
					echo '<div class="green">'.$lang["alert_ok"].'</div>';
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
					}else{
					
					echo '<div class="red">'.$lang["alert_error"].'</div>';	
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
					}
					
	}
		
	public function editForm(){
		
		global $eaf,$lang;	
		
		if($eaf->db->totalWhere($this->table,"lang_id",$this->Id) == 0){
	
			echo '<div class="red">'.$lang["langs_notexists"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
			exit;		
				
		}
		
		$Find = $eaf->db->query("select * from $this->table where lang_id = $this->Id");
		
		$Rows = $eaf->db->_object($Find);
	
		return '<form method="post">
				<table width="97%" align="center" cellpadding="0" cellspacing="0">
				<tr>
				<td colspan="2" class="ttable">'.$lang["langs_edit"].'</td>
				</tr>
				<tr>
				<td>'.$lang["langs_name"].'</td>
				<td>
				<input type="text" name="lang_name" value="'.$Rows->lang_name.'" />
				</td>
				</tr>
				<tr>
				<td>'.$lang["langs_folder"].'</td>
				<td>
				<input type="text" value="'.$Rows->lang_folder.'" name="lang_folder" />
				</td>
				</tr>
				<tr>
				<td>'.$lang["post"].'</td>
				<td>
				<input type="submit" name="editlang" value="'.$lang["edit"].'" />
				</td>
				</tr>
				</table>
				</form>';	
				
	}
	
	public function editPost(){
	
		global $eaf,$lang;
		
			if(isset($eaf->_POST['editlang'])) :
			
				$lang_name = strip_tags($eaf->_POST['lang_name']);
			
				$lang_folder = strip_tags(trim($eaf->_POST['lang_folder']));			
				
				$Update = $eaf->db->query("update $this->table set lang_name='$lang_name',lang_folder='$lang_folder' where lang_id = $this->Id");
				
				if($Update){
					
					echo '<div class="green">'.$lang["alert_ok"].'</div>';
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
					}else{
					
					echo '<div class="red">'.$lang["alert_error"].'</div>';	
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
					}
					
		endif; 
	}
	
}
?>