<?php

class PagesControl{
	
	private $id,$table;
	
	public function __construct(){
		
		global $eaf;
		
		$this->table = tablenamestart("pages");
		
		if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) && is_numeric($eaf->_REQUEST['id'])){
			
			$this->id = intval(abs($eaf->_REQUEST['id']));	
		
		}
	}
	
	public function addForm(){
		
		global $lang;
		
		return '
			<form method="post">
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
			<tr>
			<td colspan="2" class="head">'.$lang["pages_new"].'</td>
			</tr>
			<tr>
			<td>'.$lang["pages_title"].'</td>
			<td><input type="text" name="page_name" /></td>
			</tr>
			<tr>
			<td>'.$lang["pages_active"].'</td>
			<td>
			'.$lang["yes"].' : <input type="radio" name="page_active" value="0" checked />
			'.$lang["no"].' : <input type="radio" name="page_active" value="1" />
			</td>
			</tr>
			<tr>
			<td>'.$lang["pages_content"].'</td>
			<td><textarea id="KindBox" name="page_text" rows="6" style="width:80%" dir="ltr"></textarea></td>
			</tr>
			<tr>
			<td>'.$lang["post"].'</td>
			<td><input type="submit" name="add" value="'.$lang["add"].'" /></td>
			</tr>
			</table>
			</form>
			';	
	}
	
	public function addPost(){
	
		global $eaf,$lang;
			
		if(isset($eaf->_POST['add'])){
		
			$page_title = strip_tags(trim($eaf->_POST['page_name']));
			
			$page_active = intval(abs($eaf->_POST['page_active']));
			
			$page_text   = $eaf->_POST['page_text'];
			$page_text   = str_replace("?-->" , "?>" , $page_text);
			$page_text   = str_replace("<!--?" , "<?" , $page_text);

			if(empty($page_title) || empty($page_text)){
			
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
				
				$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
				return false;
					
			}
			
			$time = time();
			
			$date = arabic_data();
			
			$Query = $eaf->db->query("insert into $this->table values ('','$page_title','0','$page_text','$page_active','$time','$date')");
		
			if($Query){
				
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
		}
	}
	
	public function GetPages(){
	
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select * from $this->table");
		
		if($eaf->db->dbnum($Query) == 0){
			
			echo '<div class="red">'.$lang["pages_nopages"].'</div>';	
		
		}else{
			
			print '<table cellpadding="0" cellspacing="0" width="97%" align="center">';
			print "<tr>";
			print "\n";
			print "<td class=\"ttable\">".$lang["ID"]."</td>";
			print "\n";
			print "<td class=\"ttable\">".$lang["pages_title"]."</td>";
			print "\n";
			print "<td class=\"ttable\">".$lang["pages_views"]."</td>";
			print "\n";
			print "<td class=\"ttable\">".$lang["pages_date"]."</td>";
			print "\n";
			print "<td class=\"ttable\">".$lang["edit"]."</td>";
			print "\n";
			print "<td class=\"ttable\">".$lang["delete"]."</td>";
			print "\n";
			print "</tr>";

			while($Rows = $eaf->db->_object($Query)){
			
			print "<tr>";
			print "\n";
			print "<td>$Rows->page_id</td>";
			print "\n";
			print "<td>$Rows->page_name</td>";
			print "\n";
			print "<td>$Rows->page_views</td>";
			print "\n";
			print "<td>$Rows->page_date</td>";
			print "\n";
			print "<td><a href=\"pages.php?action=edit&id=$Rows->page_id\"><img src=\"icons/edit.png\" border=\"0px\" /></a></td>";
			print "\n";
			print "<td><a onclick=\"return window.confirm('".$lang["alert_access"]."');\" href=\"pages.php?action=delete&id=$Rows->page_id\"><img src=\"icons/recy.png\" border=\"0px\" /></a></td>";
			print "\n";
			print "</tr>";
			
			}
			
			print "\n </table> \n";
		}
		
	}
	
	public function delete(){
	
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select page_id from $this->table where page_id = $this->id");	
		
		if($eaf->db->dbnum($Query) == 0){

			echo '<div class="red">'.$lang["pages_notexists"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
			exit;	
		}
		
		$Delete = $eaf->db->query("delete from $this->table where page_id = $this->id");
		
		if($Delete){
			
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
				
		}
		
		public function editForm(){

		global $eaf,$lang;
		
		$editType = strip_tags($_REQUEST['type']);
		
		$Query = $eaf->db->query("select * from $this->table where page_id = $this->id");	
		
		if($eaf->db->dbnum($Query) == 0){

			echo '<div class="red">'.$lang["pages_notexists"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
			exit;	
		}
		
		$Rows = $eaf->db->_object($Query);
		
			$Form = '
			<form method="post">
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
			<tr>
			<td colspan="2" class="head">'.$lang["pages_edit"].' " ' . $Rows->page_name . ' "</td>
			</tr>
			<tr>
			<td>'.$lang["pages_title"].'</td>
			<td><input type="text" value="'.$Rows->page_name.'" name="page_name" /></td>
			</tr>
			<tr>
			<td>'.$lang["pages_active"].'</td>
			<td>
			'.$lang["yes"].' : <input type="radio" name="page_active" value="0" '; if($Rows->page_active == "0"){ $Form .= " checked ";} $Form .= '/>
			'.$lang["no"].' : <input type="radio" name="page_active" value="1"  '; if($Rows->page_active == "1"){ $Form .= " checked ";} $Form .= ' />
			</td>
			</tr>
			<tr>
			<td>'.$lang["pages_content"].'</td>
			<td><textarea name="page_text"';
			
			if($editType == "html"){
			
				$Form .= ' id="KindBox"';	
			}
			
			$Form .= 'rows="6" style="width:80%" dir="ltr">'.$Rows->page_text.'</textarea></td>
			</tr>
			<tr>
			<td>'.$lang["post"].'</td>
			<td><input type="submit" name="edit" value="'.$lang["edit"].'" /></td>
			</tr>
			</table>
			</form>
			<a href="pages.php?action=edit&id='.$this->id.'&type=html">HTML Code</a> | <a href="pages.php?action=edit&id='.$this->id.'&type=php">PHP Code</a>
			';
			
			return $Form;
		
		}
		
		public function editPost(){
			
			global $eaf,$lang;
			
			if(isset($eaf->_POST['edit'])){
			
				$page_title = strip_tags($eaf->_POST['page_name']);
			
				$page_active = intval(abs($eaf->_POST['page_active']));
			
				$page_text   = $eaf->_POST['page_text'];
				$page_text   = str_replace("?-->" , "?>" , $page_text);
				$page_text   = str_replace("<!--?" , "<?" , $page_text);

				if(empty($page_title) || empty($page_text)){
			
					$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
				
					$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
					return false;
					
				}
			
				$Update = $eaf->db->query("update $this->table set page_name='$page_title',page_text='$page_text',page_active='$page_active' where page_id = $this->id");
			
				if($Update){
					
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
			}	
		}
		
}
?>
