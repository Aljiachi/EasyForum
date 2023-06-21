<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class announcementsControl{
	
	private $table;
	
	public function __construct(){
		
		$this->table = tablenamestart("announcements");	
	}
	
	public function addForm(){
		
		global $lang;
		
		return '
		<form method="post">
		<table align="center" width="97%" cellpadding="0" cellspacing="0">
		<tr>
		<td colspan="2" class="head">'.$lang["add_ads"].'</td>
		</tr>
		<tr>
		<td>'.$lang["ads_title"].'</td>
		<td><input type="text" name="title" /></td>
		</tr>
		<tr>
		<td>'.$lang["ads_in"].'</td>
		<td>
		<select name="in">
		<option value="index">'.$lang["page_index"].'</option>
		<option value="all">'.$lang["page_all"].'</option>
		<option value="0">'.$lang["forums_all"].'</option>
		'.ForumsList().'
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["ads_text"].'</td>
		<td>
		<textarea name="text" id="KindBox" rows="5" style="width:90%"></textarea>
		</td>
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
		
			$title = strip_tags($eaf->_POST['title']);	
			$in = strip_tags($eaf->_POST['in']);	
			$text = $eaf->_POST['text'];
			if(empty($title) || empty($text)){
			
					$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
				
					$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
		
					return false;
						
			}	
			$date = arabic_data();
			$time = time();
			$uid  = Userid();
			$uname = UserName();
			$Insert = $eaf->db->query("insert into $this->table values ('','$title','$text','$uid','$in','$date','$time','1','$uname')") or die(mysql_error());
			if($Insert){
				
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
			}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
		}	
	}
	
	public function Delete(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) && is_numeric($eaf->_REQUEST['id'])){
			
			$id = intval(abs($eaf->_REQUEST['id']));	
		}	
		
			$Find = $eaf->db->query("select id from $this->table where id=$id");
			
			if($eaf->db->dbnum($Find) == 0){
				
				echo '<div class="red">الإبتسامة المطلوبة غير موجودة<div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
			}
			
			$Delete = $eaf->db->query("delete from $this->table where id=$id");
			
			if($Delete){
				
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
			}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
				
			}
			
	public function GetAlerts(){
	
		global $eaf,$lang;
		
		$Sql = $eaf->db->query("select * from $this->table");
		
		print '<table cellpadding="0" cellspacing="0" width="97%" align="center">';
		print "\n";	
		print '<tr>';
		print "\n";	
		print "<td>#</td>";
		print "\n";	
		print "<td>عنوان الإعلان</td>";
		print "\n";
		print "<td>كاتب الإعلان</td>";
		print "\n";
		print "<td>تاريخ الكتابة</td>";
		print "\n";
		print "<td>عدد المشاهدات</td>";
		print "\n";
		print "<td>تعديل</td>";
		print "\n";
		print "<td>حذف</td>";
		print "\n";
		print "</tr>";
		while($Rows = $eaf->db->_object($Sql)){
		print '<tr>';
		print "\n";	
		print "<td>$Rows->id</td>";
		print "\n";	
		print "<td>$Rows->title</td>";
		print "\n";
		print "<td>$Rows->u_name</td>";
		print "\n";
		print "<td>$Rows->date</td>";
		print "\n";
		print "<td>$Rows->views</td>";
		print "\n";
		print "<td><a href=\"announcements.php?action=edit&id=$Rows->id\"><img src=\"icons/edit.png\" border=\"0px\" /></a></td>";
		print "\n";
		print "<td><a href=\"announcements.php?action=delete&id=$Rows->id\"><img src=\"icons/recy.png\" border=\"0px\" /></a></td>";
		print "\n";
		print "</tr>";	
		}
		
		print "\n </table> \n";
	}
	
	public function editForm(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) && is_numeric($eaf->_REQUEST['id'])){
			
			$id = intval(abs($eaf->_REQUEST['id']));	
		}	
		
		$Find = $eaf->db->query("select id,title,text from $this->table where id=$id");
		$Rows = $eaf->db->_object($Find);
		$Form = '	<form method="post">
		<table align="center" width="97%" cellpadding="0" cellspacing="0">
		<tr>
		<td colspan="2" class="head"> '.$lang["edit_ads"].'  " '.$Rows->title.' " </td>
		</tr>
		<tr>
		<td>'.$lang["ads_title"].'</td>
		<td><input type="text" name="title" value="'.$Rows->title.'" /></td>
		</tr>
		<tr>
		<td>'.$lang["ads_in"].'</td>
		<td>
		<select name="in">
		<option value="">'.$lang["select"].'</option>
		<option value="index">'.$lang["page_index"].'</option>
		<option value="all">'.$lang["page_all"].'</option>
		<option value="0">'.$lang["forums_all"].'</option>
		'.ForumsList().'
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["ads_text"].'</td>
		<td>
		<textarea name="text" id="KindBox" rows="5" style="width:90%">'.$Rows->text.'</textarea>
		</td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="edit" value="'.$lang["edit"].'" /></td>
		</tr>
		</table>
		</form>';
		
		return $Form;
	}
	
	public function editPost(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit'])){
	
		if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) && is_numeric($eaf->_REQUEST['id'])){
			
			$id = intval(abs($eaf->_REQUEST['id']));	
		}	
		
		$Find = $eaf->db->query("select id,title,text from $this->table where id=$id");
		$Rows = $eaf->db->_object($Find);		$title = strip_tags($eaf->_POST['title']);	
		$in = strip_tags($eaf->_POST['in']);	
		$text = $eaf->_POST['text'];	
		if(empty($in)) $in = $Rows->in;	
		$Update = $eaf->db->query("update `$this->table` set `title`='$title',`in`='$in',`text`='$text' where id = $id");
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