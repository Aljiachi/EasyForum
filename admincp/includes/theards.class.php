<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class EAFTheards{
private $id,$table;
public function __construct(){
$this->id = intval(abs($eaf->_REQUEST['fid']));
$this->table = "phpforyou";
$this->table .= "_";
$this->table .= "topics";
}
public function CloseTheards(){
global $eaf,$lang;
$Querys = $eaf->pagination->Querspagination($this->table," close=1"," tid DESC","theards.php?action=closed");
echo '
<form method="post">
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="head" colspan="4">'.$lang["theards_closed"].'</td>
</tr>
<tr>
<td class="ttable">'.$lang["theards_name"].'</td>
<td class="ttable">'.$lang["theards_writer"].'</td>
<td class="ttable">'.$lang["theards_data"].'</td>
<td class="ttable"><input type="checkbox" name="check_all" onclick="checkAll(this.form)" /></td>
</tr>';
while($rows = $eaf->db->dbrows($Querys)){
echo'
<tr>
<td>'.$rows['title'].'</td>
<td>'.$rows['username'].'</td>
<td>'.$rows['data'].'</td>
<td><input type="checkbox" name="check[]" value="'.$rows['tid'].'" /></td>
</tr>
</tr>
';
}
echo '
</table>
<div align="center"><input type="submit" name="open"  value="'.$lang["theards_doopen"].'" /></div>
</form>
';
echo $eaf->pagination->pagination();
}
public function OpenClosedTheards(){
global $eaf,$lang;
if(isset($eaf->_POST['open'])){
$check = $eaf->_POST['check'];
if(empty($check)){ 
$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
echo '<meta http-equiv="refresh" content="2;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
return false;
}
$impad = implode(",",$check);
$update = $eaf->db->query("UPDATE `".$this->table."` SET `close`='0' where `tid` in(".$impad.")");
if($update){
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
}
}
public function stickedTheards(){
global $eaf,$lang;
$Querys = $eaf->pagination->Querspagination($this->table," stayed=1"," tid DESC","theards.php?action=closed");
echo '
<form method="post">
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="head" colspan="4">'.$lang["theards_sticked"].'</td>
</tr>
<tr>
<td class="ttable">'.$lang["theards_name"].'</td>
<td class="ttable">'.$lang["theards_writer"].'</td>
<td class="ttable">'.$lang["theards_data"].'</td>
<td class="ttable"><input type="checkbox" name="check_all" onclick="checkAll(this.form)" /></td>
</tr>';
while($rows = $eaf->db->dbrows($Querys)){
echo'
<tr>
<td>'.$rows['title'].'</td>
<td>'.$rows['username'].'</td>
<td>'.$rows['data'].'</td>
<td><input type="checkbox" name="check[]" value="'.$rows['tid'].'" /></td>
</tr>
</tr>
';
}
echo '
</table>
<div align="center"><input type="submit" name="unstick"  value="'.$lang["theards_dosticky"].'" /></div>
</form>
';
echo $eaf->pagination->pagination();
}
public function UnStickTheards(){
global $eaf,$lang;
if(isset($eaf->_POST['unstick'])){
$check = $eaf->_POST['check'];
if(empty($check)){ 
$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
echo '<meta http-equiv="refresh" content="2;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
return false;
}
$impad = implode(",",$check);
$update = $eaf->db->query("UPDATE `".$this->table."` SET `stayed`='0' where `tid` in(".$impad.")");
if($update){
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
}
}
public function DeleteAll(){
global $eaf,$lang;
$sections = $eaf->db->query("select * from " . tablenamestart("sections") . " where sort = 0");
echo '
<form method="post">
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">' ;
echo '<tr>
<td class="ttable">'.$lang["theards_delete_forum"].'</td>
	 </tr>';
echo '<tr>
<td>
<select name="sections">
<option value="all">'.$lang["theards_allforums"].'</option>
';
echo ForumsList();
echo 
'</select> <input type="submit" name="section" value="'.$lang["delete"].'" />
</td>
	 </tr>';
echo '<tr>
<td class="ttable">'.$lang["theards_delete_user"].'</td>
	 </tr>';
echo '<tr>
<td><input type="text" name="user_name" /><input type="submit" name="user" value="'.$lang["delete"].'" /></td>
	 </tr>';
echo '<tr>
<td class="ttable">'.$lang["theards_delete_posts"].'</td>
	 </tr>';
echo '<tr>
<td>'.$lang["theards_postmin"].' : <input type="text" name="total_posts" /><input type="submit" name="total" value="'.$lang["delete"].'" /></td>
	 </tr>';

echo '
</table>
</form>
' ;	
}
public function DeleteWhereSection(){
global $eaf,$lang;
if(isset($eaf->_POST['section'])){
	if(!empty($eaf->_POST['sections'])){
		if($eaf->_POST['sections'] == "all"){
		$query = $eaf->db->query("SELECT * FROM " . $this->table) or die(mysql_error());
		}else{
		$query = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " where f_id=".$eaf->_POST['sections']) or die(mysql_error());
		}
		while($rows = $eaf->db->dbrows($query)){
		$query_posts = @$eaf->db->query("select  from " . tablenamestart('posts') . " where t_id=".$rows['tid']);
	    	while($row = @$eaf->db->dbrows($query_posts)){
			$posts = @$eaf->db->query("delete  from " . tablenamestart('posts') . " where pid=".$row['pid']);
	# end one while
			}
		$topics = $eaf->db->query("delete  from " . tablenamestart("topics") . " WHERE tid=".$rows['tid']) or die(mysql_error());
# end tow while
		}
	}
# end post if
				if($topics){

				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
# end issset post
}
# end function
}
public function DeleteWhereUser(){
global $eaf,$lang;
if(isset($eaf->_POST['user'])){
	if(!empty($eaf->_POST['user_name'])){
		$query = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " where username='".$eaf->_POST['user_name']."'") or die(mysql_error());
		while($rows = $eaf->db->dbrows($query)){
		$query_posts = @$eaf->db->query("select  from " . tablenamestart('posts') . " where t_id=".$rows['tid']);
	    	while($row = @$eaf->db->dbrows($query_posts)){
			$posts = @$eaf->db->query("delete  from " . tablenamestart('posts') . " where pid=".$row['pid']);
	# end one while
			}
		$topics = @$eaf->db->query("delete  from " . tablenamestart("topics") . " WHERE tid=".$rows['tid']) or die(mysql_error());
# end tow while
		}
	}
# end post if
				if($topics){

				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
# end issset post
}
# end function
}
public function DeleteWherePosts(){
global $eaf,$lang;
if(isset($eaf->_POST['total'])){
	if(!empty($eaf->_POST['total_posts'])){
		$query = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " where txts < ".$eaf->_POST['total_posts']) or die(mysql_error());
		$total  = $eaf->db->dbnum($query);
		echo $total;
		while($rows = $eaf->db->dbrows($query)){
		$query_posts = @$eaf->db->query("select  from " . tablenamestart('posts') . " where t_id=".$rows['tid']);
	    	while($row = @$eaf->db->dbrows($query_posts)){
			$posts = @$eaf->db->query("delete  from " . tablenamestart('posts') . " where pid=".$row['pid']);
	# end one while
			}
		$topics = @$eaf->db->query("delete  from " . tablenamestart("topics") . " WHERE tid=".$rows['tid']) or die(mysql_error());
# end tow while
		}
	}
# end post if
				if($topics){
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
# end issset post
}
# end function
}
	public function RestTheards(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['rest'])){
		
		$check = $eaf->_POST['check'];

		if(empty($check)){ 

			$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
			echo '<meta http-equiv="refresh" content="2;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';

			return false;

			}

		$impad = implode(",",$check);		
	
		$update = $eaf->db->query("UPDATE `".$this->table."` SET `deleted`='0' where `tid` in(".$impad.")");
		
		if($update){

				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
			
		}	
	}
	
	public function EmptyRecBin(){

		global $eaf,$lang;
		
		if(isset($eaf->_POST['empty'])){
		
		$check = $eaf->_POST['check'];

		if(empty($check)){ 
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				return false;

				}

			foreach($check as $var){
			
				$GetTheardInfo = $eaf->db->query("select pid from " . tablenamestart("posts") . " where t_id= $var");
				
				while($Rows   = $eaf->db->_object($GetTheardInfo)):
				
					$DeletePost = $eaf->db->query("delete from " . tablenamestart("posts") . " where pid = " . $Rows->pid);
				
				endwhile;
			
					$DeleteTheard = $eaf->db->query("delete from " . tablenamestart("topics") . " where tid=$var");
			}
			
			if($DeleteTheard){

				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
		}
	}
public function RecycleBin(){
global $eaf,$lang;
$Querys = $eaf->pagination->Querspagination($this->table,"deleted=1"," tid DESC","theards.php?action=recycle_bin");
echo '
<form method="post">
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="head" colspan="4">'.$lang["theards_recy"].'</td>
</tr>
<tr>
<td class="ttable">'.$lang["theards_name"].'</td>
<td class="ttable">'.$lang["theards_writer"].'</td>
<td class="ttable">'.$lang["theards_data"].'</td>
<td class="ttable"><input type="checkbox" name="check_all" onclick="checkAll(this.form)" /></td>
</tr>';
while($rows = $eaf->db->dbrows($Querys)){
echo'
<tr>
<td>'.$rows['title'].'</td>
<td>'.$rows['username'].'</td>
<td>'.$rows['data'].'</td>
<td><input type="checkbox" name="check[]" value="'.$rows['tid'].'" /></td>
</tr>
</tr>
';
}
echo '
</table>
<div align="center"><input type="submit" name="rest"  value="'.$lang["theards_reback"].'" /> | <input type="submit" name="empty"  value="'.$lang["theards_rempty"].'" /></div>
</form>
';
echo $eaf->pagination->pagination();
}
# end class 
}
?>

