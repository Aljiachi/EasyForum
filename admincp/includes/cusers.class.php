<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Users_System_Control{

	private $user_id,$edit_page,$add_page,$delete_page,$show_page,$Ip;

	public function __construct($page_add,$page_edit,$page_delete,$page_show){
		
		global $eaf;
	
		$this->add_page = $page_add;
	
		$this->edit_page = $page_edit;
	
		$this->delete_page = $page_delete;
	
		$this->show_page = $page_show;
	
		$this->Ip		= getip();
	
		if(!empty($eaf->_REQUEST['uid']) and is_numeric($eaf->_REQUEST['uid'])){	
		
			$this->user_id   = intval(abs($eaf->_REQUEST['uid']));
		
		}
	
	}
	
	
	public function Users_Show(){

	global $eaf,$lang;
	
	$Querys = $eaf->pagination->Querspagination("members",""," uid ASC","members.php?action=view");

	echo '<form method="post" action="members.php?action=multiaction"><table border="0" cellpadding="0" cellspacing="0" width="96%" align="center">';

	echo '<tr>
	
	<td>'.$lang["ID"].'</td>
	
	<td>'.$lang["members_username"].'</td>
	
	<td>'.$lang["members_sigdate"].'</td>
	
	<td>'.$lang["members_lastlogin"].'</td>
	
	<td>'.$lang["members_ip"].'</td>
	
	<td>'.$lang["members_browser"].'</td>
	
	<td>'.$lang["edit"].'</td>
	
	<td>'.$lang["delete"].'</td>
	
	<td><input type="checkbox" name="check_all" onclick="checkAll(this.form)" /></td>

	</tr>';

	while($row = $eaf->db->dbrows($Querys)){

	echo '
	
	<tr>

	<td>'.$row['uid'].'</td>

	<td>'.$row['username'].'</td>
	
	<td>'.$row['sig_data'].'</td>
	
	<td>'.$row['lastlogin'].'</td>
	
	<td>'.$row['ip'].'</td>
	
	<td>'.$row['browser'].'</td>
	
	<td><a href="'.$this->edit_page.'&uid='.$row['uid'].'"><img src="icons/edit.png" border="0px" /></a></td>
	
	<td><a onclick="return confirm('."'".$lang["alert_access"]."'".');" href="'.$this->delete_page.'&uid='.$row['uid'].'"><img src="icons/recy.png" border="0px" /></a></td>
		
	<td><input type="checkbox" name="check[]" value="'.$row['uid'].'" /></td>
	
	</tr>
	
	';

	}
	
	echo '</table>
	<div style="margin:25px;" align="left">
	<input onclick="return confirm('."'".$lang["alert_access"]."'".');" type="submit" name="delete" value="'.$lang["delete"].'" />
	<input onclick="return confirm('."'".$lang["alert_access"]."'".');" type="submit" name="upban" value="'.$lang["members_unbanned"].'" />
	<input onclick="return confirm('."'".$lang["alert_access"]."'".');" type="submit" name="setban" value="'.$lang["members_banned"].'" />
	</div>
	</form>
	';
	
	echo $eaf->pagination->pagination();
	
	}
	
	
	public function BaUsersShow(){
	
		global $eaf,$lang;
		
		$Querys = $eaf->pagination->Querspagination("members"," groupid = 6"," uid ASC","members.php?action=out_members");
	
		echo '<form method="post" action="members.php?action=multiaction">
	<table border="0" cellpadding="0" cellspacing="0" width="96%" align="center">';
	
		echo '
	
		<tr>
		
		<td>'.$lang["ID"].'</td>
		
		<td>'.$lang["members_username"].'</td>
		
		<td>'.$lang["members_sigdate"].'</td>
		
		<td>'.$lang["members_lastlogin"].'</td>
		
		<td>'.$lang["members_ip"].'</td>
		
		<td>'.$lang["members_unbanned"].'</td>
		
		<td>'.$lang["edit"].'</td>
		
		<td>'.$lang["delete"].'</td>
		<td><input type="checkbox" name="check_all" onclick="checkAll(this.form)" /></td>
		
		</tr>
		
		';
	
		while($row = $eaf->db->dbrows($Querys)){
	
		echo '<tr>
	
		<td>'.$row['uid'].'</td>
	
		<td>'.$row['username'].'</td>
		
		<td>'.$row['sig_data'].'</td>
		
		<td>'.$row['lastlogin'].'</td>
		
		<td>'.$row['ip'].'</td>
		
		<td><a href="members.php?action=upban&uid='.$row['uid'].'"><img src="icons/off.png" border="0px" /></a> </td>
		
		<td><a href="'.$this->edit_page.'&uid='.$row['uid'].'"><img src="icons/edit.png" border="0px" /></a></td>
		
		<td><a href="'.$this->delete_page.'&uid='.$row['uid'].'"><img src="icons/recy.png" border="0px" /></a></td>
		<td><input type="checkbox" name="check[]" value="'.$row['uid'].'" /></td>
	
		</tr>
		
		';
	
		}
		
		echo '<table>
		<div style="margin:25px;" align="left">
		<input type="submit" name="delete" value="'.$lang["delete"].'" />
		<input type="submit" name="upban" value="'.$lang["members_unbanned"].'" />
		</div>
		</form>
		';
		
		echo $eaf->pagination->pagination();
	
	}
	
	public function multiAction(){

		global $eaf,$lang;
		
		$check = $eaf->_POST['check'];
		
		if(in_array(1 , $check)){
			
			echo '<div class="red">'.$lang["members_cantdelete"].'</div>';
	
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
			
			return false;
		
		}
		
		$impad = implode(",",$check);	

		if(isset($_POST['delete'])){
				
			$MultiAction = $eaf->db->query("DELETE FROM members WHERE `uid` in (".$impad.")");

		}
		
		if(isset($_POST['upban'])){
		
			$MultiAction = $eaf->db->query("update members set `groupid`='2' WHERE `uid` in (".$impad.")");
	
		}
		
		if(isset($_POST['setban'])){
		
			$MultiAction = $eaf->db->query("UPDATE `members` SET `groupid`='6' WHERE `uid` in (".$impad.")");
	
		}
		
			if($MultiAction){
		
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
			
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
				
				}else{
											
				echo '<div class="red">'.$lang["alert_error"].'</div>';
			
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
										
				}
		
	}
	
	public function AcUsersShow(){

	global $eaf,$lang;
	
	$Querys = $eaf->pagination->Querspagination("members"," groupid = 7"," uid ASC","members.php?action=active_members");

	echo '<table border="0" cellpadding="0" cellspacing="0" width="96%" align="center">';

	echo '

	<tr>
	
	
	<td>'.$lang["ID"].'</td>
	
	<td>'.$lang["members_username"].'</td>
	
	<td>'.$lang["members_sigdate"].'</td>
	
	<td>'.$lang["members_lastlogin"].'</td>
	
	<td>'.$lang["members_ip"].'</td>
	
	<td>'.$lang["members_active"].'</td>
	
	<td>'.$lang["edit"].'</td>
	
	<td>'.$lang["delete"].'</td>
	
	
	</tr>
	
	';

	while($row = $eaf->db->dbrows($Querys)){

	echo '
	
	<tr>

	<td>'.$row['uid'].'</td>

	<td>'.$row['username'].'</td>
	
	<td>'.$row['sig_data'].'</td>
	
	<td>'.$row['lastlogin'].'</td>
	
	<td>'.$row['ip'].'</td>
	
	<td><a href="members.php?action=activeuser&uid='.$row['uid'].'"><img src="icons/activ.png" border="0px" /></a> </td>
	
	<td><a href="'.$this->edit_page.'&uid='.$row['uid'].'"><img src="icons/edit.png" border="0px" /></a></td>
	
	<td><a href="'.$this->delete_page.'&uid='.$row['uid'].'"><img src="icons/recy.png" border="0px" /></a></td>

	</tr>
	
	';

	}
	
	echo '<table>';
	
	echo $eaf->pagination->pagination();
	
	}
	
	public function AddUser_Form(){
	
	global $eaf,$lang;
	
	$groups = $eaf->db->query("SELECT * FROM " . tablenamestart('groups'));

	$this->AddUser_Form = '
	
	<div id="msg"></div>

	<form method="post" id="signup_form" name="signup" enctype="multipart/form-data">
	
	<table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td>'.$lang["members_username"].'</td>
	<td><input type="text" name="username" id="one" />
	<tr>
	<td>'.$lang["members_password"].'</td>
	<td><input type="password" name="password" id="t" /></td>
	</tr>
	<tr>
	<td>'.$lang["members_repassword"].'</td>
	<td><input type="password" name="repass" id="repass" /></td>
	</tr>
	<tr>
	<tr>
	<td>'.$lang["members_email"].'</td>
	<td><input type="text" name="email" id="email" /></td>
	</tr>
	<tr>
	<td>'.$lang["members_country"].'</td>
	<td><input type="text" name="cant" id="from" /></td>
	</tr>
	<tr>
	<td>'.$lang["members_age"].'</td>
	<td><input type="text" name="age" id="age" /></td>
	</tr>
	<tr>
	<td>'.$lang["members_avatar"].'</td>
	<td><input type="file" name="avatarup" id="avatar" /></td>
	</tr>
	<tr>
	<td>'.$lang["members_sig"].'</td>
	<td><textarea name="signt" rows="6" cols="50" id="signt"></textarea></td>
	</tr>
	<tr>
	<td>'.$lang["members_group"].'</td>
	<td>
	<select name="group" id="z">';
	
	while($group = $eaf->db->dbrows($groups)){
	
		$this->AddUser_Form .= '<option value="'.$group['id'].'">'.$group['title'].'</option>';


	}


	$this->AddUser_Form .= '</select>
	</td>
	</tr>
	';
	$this->AddUser_Form .='
	<td>'.$lang["post"].'</td>
	<td><input type="submit" name="adduser" onclick="return accessempty();" value="'.$lang["add"].'" /></td>
	</tr>
	</table>
	</form>';
	return $this->AddUser_Form;
	}
	
	public function AddUser_Insert(){
	
	global $eaf,$lang;
	
	if(isset($eaf->_POST['adduser'])){
	
	$username = strip_tags(trim(mysql_real_escape_string($eaf->_POST['username'])));
	
	$password = md5(sha1(md5(sha1(sha1(md5(md5(sha1($eaf->_POST['password']))))))));
	
	$repass = md5(sha1(md5(sha1(sha1(md5(md5(sha1($eaf->_POST['repass']))))))));
	
	$avatar = strip_tags(trim(mysql_real_escape_string($eaf->_POST['avatar'])));
	
	$from   = strip_tags(trim(mysql_real_escape_string($eaf->_POST['cant'])));		
	
	$age    = strip_tags(trim(mysql_real_escape_string($eaf->_POST['age'])));
	
	$email  = strip_tags(trim(mysql_real_escape_string($eaf->_POST['email'])));
	
	$group    = intval(abs($eaf->_POST['group']));
	
	$sign_data = arabic_data();
	
	$signt  = $eaf->_POST['signt'];
	
	$bro = getBrowser();
	
	if(!$eaf->security->email_check($email)){
	
	echo '<div class="red">'.$lang["members_email_error"].'</div>';
	
	echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
	
	return false;
	
	}
	
	$sql_user_finde = $eaf->db->query("SELECT * FROM members where username = '$username'");
	
	$total_user_finde = $eaf->db->dbnum($sql_user_finde);
	
	if($total_user_finde !== 0){
	
	echo '<div class="red">'.$lang["members_nameused"].'</div>';
	
	echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
	
	return false;
	
	}
	
	if(!empty($_FILES['avatarup']['name']) and isset($_FILES['avatarup'])){
									
		$types_images = array('image/png','image/jpeg','image/bmp','image/jpg','image/gif');
				
		$img   = $_FILES['avatarup']['name'];
		
		$tmp   = $_FILES['avatarup']['tmp_name'];
				
		$size  = $_FILES['avatarup']['size'];
				
		$type  = $_FILES['avatarup']['type'];
			
		if(check_image($tmp) == false) {  header("location: ?home");  return false; }
						
		if(!in_array($type,$types_images)){
				
			$eaf->_Redmsg($lang["avatar_notype"]);
										
			return false;	
	
		}
						
		$up = move_uploaded_file($tmp,"../avatars/".$img);
				
		$avatar = "avatars/".$img;	
				
	}
	
	$sql_Insert_into = $eaf->db->query("insert into members (username,password,email,avatar,age,signt,cant,sig_data,ip,groupid,browser) values (
	'$username',
	'$password',
	'$email',
	'$avatar',
	'$age',
	'$signt',
	'$from',
	'$sign_data',
	'$this->Ip',
	'$group',
	'".$bro['name']. ' - ' . $bro['version'] ."'
	)");
	
	if($sql_Insert_into){
	
		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}

		}

			}



	public function DeleteUser(){

	global $eaf,$lang;

	$uid = $this->user_id;
	
	if($uid == 1){
		
		echo '<div class="red">'.$lang["members_cantdelete"].'</div>';

		echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
		
		return false;
	
	}

	if(isset($uid)){

	$sql_user_finde = $eaf->db->query("SELECT * FROM members WHERE uid=$uid");

	$total_finde    = $eaf->db->dbnum($sql_user_finde);

	if($total_finde !== 0){

	$sql_delete = $eaf->db->query("DELETE FROM members WHERE uid=$uid");

	if($sql_delete){

		echo '<div class="green">'.$lang["alert_ok"].'</div>';
	
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
	
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}


	}else{


	echo '<div class="red">'.$lang["members_notexists"].'</div>';

	echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';

	}

	}

	}

	public function UserSearch(){



		global $eaf,$lang;

	

	$form = '

	<form method="post"  name="user_search" action="members.php?action=edit">

	<table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">

	<tr>

	<td>'.$lang["members_username"].'</td>

	<td><input type="text" name="user_name_search" /></td>

	</tr>

	<tr>

	<td>'.$lang["members_userid"].'</td>

	<td><input type="text" name="user_id_search" /></td>

	</tr>

	<td>'.$lang["post"].'</td>

	<td><input type="submit" name="searchuser" value="'.$lang["search"].'" /></td>

	</tr>

	</table>

	</form>

		';	

	return $form;

	}

	public function Edit_Form(){

	global $eaf,$lang;
	
	if($uid == 1 and $_SESSION['user_id'] != 1){
		
		echo '<div class="red">'.$lang["members_cantedit"].'</div>';

		echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
		
		return false;

	}

	if(isset($eaf->_REQUEST['uid'])){

		$uid = $this->user_id;
	
		$sql_get_userdata = $eaf->db->query("SELECT * FROM members WHERE uid=$uid");
	
		$rows 			 = $eaf->db->dbrows($sql_get_userdata);
		
		$uid = $rows['uid'];

	}else if(!empty($eaf->_POST['user_name_search'])){

		$sql_get_userdata = $eaf->db->query("SELECT * FROM members WHERE username='".$eaf->_POST['user_name_search']."'");
	
		$rows 			 = $eaf->db->dbrows($sql_get_userdata);
	
		$uid = $rows['uid'];

	}else{
	
		$sql_get_userdata = $eaf->db->query("SELECT * FROM members WHERE uid='".$eaf->_POST['user_id_search']."'");
	
		$rows 			 = $eaf->db->dbrows($sql_get_userdata);
	
		$uid = $rows['uid'];

	}

	$total = $eaf->db->dbnum($sql_get_userdata);

	if($total !== 0){
	
		$userinfo		 = array($rows['username'],$rows['password'],$rows['email'],$rows['age'],$rows['cant'],$rows['avatar'],$rows['signt'],$rows['out']);
	
		$groups = $eaf->db->query("SELECT * FROM " . tablenamestart('groups'));
	
		$edit_form = '<form method="post" id="edit_form" name="signup" action="?action=edit&uid='.$uid.'" enctype="multipart/form-data">
	
	
		<table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
	
		<tr>
	
		<td>'.$lang["members_username"].'</td>
	
		<td><input type="text" name="username" value="'.Cleanquot($userinfo[0]).'" /></td>
	
		</tr>
	
		<tr>
	
		<td>'.$lang["members_password"].'</td>
	
		<td><input type="password"name="password" id="password" /></span></td>
	
		</tr>
	
		<tr>
	
		<td>'.$lang["members_email"].'</td>
	
		<td><input type="text" value="'.$userinfo[2].'" name="email" id="email" /></td>
	
		</tr>
	
		<tr>
	
		<td>'.$lang["members_country"].'</td>
	
		<td><input type="text" value="'.Cleanquot($userinfo[4]).'" name="cant" id="from" /></td>
	
		</tr>
	
		<tr>
	
		<td>'.$lang["members_age"].'</td>
	
		<td><input type="text" value="'.Cleanquot($userinfo[3]).'"  name="age" id="age" /></td>
	
		</tr>
	
		<tr>
	
		<td>'.$lang["members_avatar"].'</td>
	
		<td><input type="file" name="avatarup" id="avatar" /></td>
	
		</tr>
		<tr>
	
		<td>'.$lang["members_sig"].'</td>
	
		<td><textarea name="signt" rows="6" cols="50" id="signt">'.$userinfo[6].'</textarea></td>
	
		</tr>
	
		<tr>
	
		<td>'.$lang["members_group"].'</td>
	
		<td>
	
		<select name="group">';
	
		while($group = $eaf->db->dbrows($groups)){
	
			$edit_form  .= '<option value="'.$group['id'].'" '; 
	
				if($rows['groupid'] == $group['id']){
	
				
					$edit_form  .= ' selected="selected" ';
				
				}
		
			$edit_form  .='>'.$group['title'].'</option>';
	
		}
	
		$edit_form .='</select>
	
		</td>
	
		</tr>';
	
		$edit_form.='<tr>
	
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="edituser" value="'.$lang["edit"].'" /></td>
	
		</tr>
	
		</table>
	
		</form>';
	
			echo $edit_form;
	
		}else{
	
			echo '<div class="red">'.$lang["members_notexists"].'</div>';
		
			echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
	
		}

	}



	public function Edit_User(){

	global $eaf,$lang;
	
	if(isset($eaf->_POST['edituser'])){

	$uid = $this->user_id;
	
	$username = $eaf->security->Username($eaf->_POST['username']);

	$password = $eaf->security->Password($eaf->_POST['password']);

	$avatar = strip_tags(trim(mysql_real_escape_string($eaf->_POST['avatar'])));

	$from   = strip_tags(trim(mysql_real_escape_string($eaf->_POST['cant'])));		

	$age    = strip_tags(trim(mysql_real_escape_string($eaf->_POST['age'])));
	
	$email  = strip_tags(trim(mysql_real_escape_string($eaf->_POST['email'])));

	$group    = intval(abs($eaf->_POST['group']));

	$sql_get_userinfo_edit = $eaf->db->query("SELECT uid FROM members WHERE username='$username'");

	$rows				  = $eaf->db->dbrows($sql_get_userinfo_edit);

	$sql_access = $eaf->db->query("SELECT * FROM members WHERE uid=$uid");

	$arow       = $eaf->db->dbrows($sql_access);

	$signt  = $eaf->_POST['signt'];

	if(!$eaf->security->email_check($email)){

	echo '<div class="red">'.$lang["members_email_error"].'</div>';

	echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';

	return false;

	}

	if($eaf->db->dbnum($sql_get_userinfo_edit) !== 0 and $username !== $arow['username']){

	echo '<div class="red">'.$lang["members_nameused"].'</div>';

	echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';

	return false;

	}
	
	
	if(!empty($_FILES['avatarup']['name']) and isset($_FILES['avatarup'])){
									
		$types_images = array('image/png','image/jpeg','image/bmp','image/jpg','image/gif');
				
		$img   = $_FILES['avatarup']['name'];
		
		$tmp   = $_FILES['avatarup']['tmp_name'];
				
		$size  = $_FILES['avatarup']['size'];
				
		$type  = $_FILES['avatarup']['type'];
			
		if(check_image($tmp) == false) {  header("location: ?home");  return false; }
						
		if(!in_array($type,$types_images)){
				
			$eaf->_Redmsg($lang["avatar_notype"]);
										
			return false;	
	
		}
						
		$up = move_uploaded_file($tmp,"../avatars/".$img);
				
		$avatar = "avatars/".$img;	
				
	}else{
		
		$avatar = $arow['avatar'];
			
	}
		
	
	if(empty($eaf->_POST['password']) ){
		
		$sql_update = $eaf->db->query("UPDATE `members` SET 
	
		`username`='$username',
	
		`avatar`='$avatar',
	
		`cant`='$from',
	
		`age`='$age',
	
		`email`='$email',
	
		`signt`='$signt',
	
		`groupid`='$group'
		
		WHERE uid=$uid  
	
		");
	
	}else{
	
		
		$sql_update = $eaf->db->query("UPDATE `members` SET 
	
		`username`='$username',
	
		`password`='$password',
	
		`avatar`='$avatar',
	
		`cant`='$from',
	
		`age`='$age',
	
		`email`='$email',
	
		`signt`='$signt',
	
		`groupid`='$group'
		
		WHERE uid=$uid  
	
		");
		
	}

	if($sql_update){

		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL=members.php?action=edit&uid='.$uid.'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL=members.php?action=edit&uid='.$uid.'" />';
								
		}
	}

	}

	public function OutUserForm(){

	global $eaf,$lang;


	$form = '

	<form method="post" id="edit_form" name="signup">

	<table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">

	<tr>

	<td>'.$lang["members_username"].'</td>

	<td><input type="text" name="username" /></td>

	</tr>

	<td>'.$lang["post"].'</td>

	<td><input type="submit" name="outuser" value="'.$lang["members_banned"].'" /></td>

	</tr>

	</table>	

	</form>

		';	

	return $form;

	}

	public function OutUserPost(){
	
	global $eaf,$lang;

	if(isset($eaf->_POST['outuser'])){

		$username = mysql_real_escape_string(strip_tags(trim($eaf->_POST['username'])));
	
		$find = $eaf->db->query("SELECT * FROM members WHERE username='$username'");
		
		$rows = $eaf->db->dbrows($find);
	
		if($eaf->db->dbnum($find) !== 0){
	
		$update = $eaf->db->query("UPDATE `members` SET `groupid`='6' WHERE uid=".$rows['uid']);
	
		if($update){
	
			echo '<div class="green">'.$lang["alert_ok"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			
			}else{
										
			echo '<div class="red">'.$lang["alert_error"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
									
			}
	
		}else{
	
		echo '<div class="red">'.$lang["members_notexists"].'</div>';
		
		echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
	
		}

	}

	}

	public function _SendPm(){
	
		global $eaf,$lang;
		
		$smiles = $eaf->db->query("SELECT * FROM " . tablenamestart("smiles"));
		
		$groups = $eaf->db->query("SELECT * FROM " . tablenamestart("groups") . " WHERE id!=1 ");
		
		$Form = '
				<form name="newpm" method="post" action="">
 				 <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
 			   <tr>
      <td colspan="2" class="head">'.$lang["members_sendpm"].'</td>
    </tr>
    <tr>
          <td class="tct">'.$lang["members_sendpm_group"].'</td>
          <td width="85%" class="tct">
			<select name="group">
			<option value="0">'.$lang["all_groups"].'</option>';
			
			while($row = $eaf->db->dbrows($groups)){
				
				$Form .= '<option value="'.$row['id'].'">' . $row['title'] . '</option>';
			}

			$Form .= '</select>
					    </tr>
  						  <tr>
   						   <td class="tct">'.$lang["pm_title"].'</td>
        	 	        <td class="tct">
  					    <input name="title" type="text" class="textbut" id="title"></td>
    </tr>
    <tr>

<td class="btd" colspan="2">
<textarea id="KindBox" name="msg" rows="6">
</textarea>

</td>
</tr>
    <tr>
      <td class="tct">&nbsp;</td
      ><td class="tct"><input name="sendpm" type="submit" class="textbut" id="send" value="'.$lang["send"].'"></td>
    </tr>
  </table>
</form>

				';
				
	return $Form;
		
	}
	
	public function _SendPmPost(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['sendpm'])){
			
			$group = $eaf->_POST['group'];
			
			$title = $eaf->_POST['title'];
			
			$text  = $eaf->_POST['msg'];
		
			$date  = arabic_data();
			
			$from  = UserId();
			
			if($group == 0){
				
					$users = $eaf->db->query("SELECT * FROM members ");
			
			}else{
				
					$users = $eaf->db->query("SELECT * FROM members WHERE groupid=$group");

			}
			$_SESSION['sent'] = 0;
			
			while($rows = $eaf->db->dbrows($users)){
				
				$Send = $eaf->db->query("INSERT INTO " . tablenamestart("pm") . " VALUES (
																						'',
																						'$title',
																						'$date',
																						'$from',
																						'0',
																						'$text',
																						'".$rows['uid']."',
																						'".$_SESSION['username']."',
																						'1'
																						)");
			
			}
						
	if($Send){

		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}		
				
		}
	}
	
	public function _ShowPm(){
		
		global $eaf,$lang;
				
	   $Querys = $eaf->pagination->Querspagination(tablenamestart("pm")," admin_view = '0' and sact='2'"," sid ASC","members.php?action=pm");

		$Form = '
				<form name="inboxpm" method="post">
				<table border="0" align="center" width="97%">
				<tr>
				<td>'.$lang["pm_title"].'</td>
				<td>'.$lang["pm_sender"].'</td>
				<td>'.$lang["pm_getpm"].'</td>
				<td>'.$lang["delete"].'</td>
				<td>'.$lang["done"].'</td>
				</tr>';
				
				while($rows = $eaf->db->dbrows($Querys)){
						
						$GetUsernameQuery = $eaf->db->query("SELECT * FROM members WHERE uid=" . $rows['sfrom']);
						
						$GetUsername      = @$eaf->db->dbrows($GetUsernameQuery);
						
						$Form .= '
									<tr>
									<td><a href="members.php?action=text&id='.$rows['sid'].'">'.$rows['stitle'].'</a></td>									
									<td>'.$GetUsername['username'].'</td>									
									<td>'.$rows['s_fname'].'</td>									
									<td><input type="checkbox" value="'.$rows['sid'].'" name="delete[]" /></td>
									<td><input type="checkbox" value="'.$rows['sid'].'" name="succ[]" /></td>
									</tr>
								 ';
				}
				
		$Form .='</table>
				<div align="center" style="margin:25px;"><input type="submit" value="'.$lang['post'].'" name="inboxpmaction" /></div>
				 </form>
				';
		
		$Form .= $eaf->pagination->pagination();
			
			return $Form;
	}
	
	public function _InboxPmActions(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['inboxpmaction'])){
			
			if(!empty($eaf->_POST['delete'])){
				
				$delete = $eaf->_POST['delete'];
				
				$delete = implode(",",$delete);
				
				$delete = $eaf->db->query("DELETE FROM " . tablenamestart("pm"). " WHERE sid IN($delete)");
				
	if($delete){
				
		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}
			}
			
			if(!empty($eaf->_POST['succ'])){
				
					$succ = $eaf->_POST['succ'];
					
					$succ = implode(",",$succ);
					
					$succ = $eaf->db->query("UPDATE " . tablenamestart("pm") . " SET admin_view = '1' WHERE sid IN($succ)");
					
	if($succ){
					
		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}
			}
		}
	}
	
	public function PmText(){
	
		global $eaf,$lang;
		
		$id = intval(abs($eaf->_REQUEST['id']));
		
		$query = $eaf->db->query("select * from " . tablenamestart("pm") . " where sid=$id");	
		
		$Rows  = $eaf->db->_object($query);
		
		return '
				<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
				<tr>
				<td class="head">'.$lang["pm_title"].' : '.$Rows->stitle.' | '.$lang["pm_date"].' : '.$Rows->sdata.' | '.$lang["pm_sender"].' : '.$Rows->s_fname.'</td>
				</tr>
				<tr>
				<td>'.GetBbCode($Rows->smsg).'</td>
				</tr>
				</table>
				';
	}
	public function ActiveUser(){

	global $eaf,$lang;

	$uid = $this->user_id;

	if(isset($uid)){
		
	$Setting = FunctionsSqlRows();

	$sql_user_finde = $eaf->db->query("SELECT * FROM members WHERE uid=$uid");

	$total_finde    = $eaf->db->dbnum($sql_user_finde);

	if($total_finde !== 0){

	$sql_update = $eaf->db->query("update members set groupid=".$Setting["actived_group"]." where uid = $uid");

	if($sql_update){

		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}


	}else{


		echo '<div class="red">'.$lang["members_notexists"].'</div>';

		echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';

	}

	}

	}
	
	public function UnOutUser(){

	global $eaf,$lang;

	$uid = $this->user_id;

	if(isset($uid)){

	$sql_user_finde = $eaf->db->query("SELECT * FROM members WHERE uid=$uid");

	$total_finde    = $eaf->db->dbnum($sql_user_finde);

	$sql_update = $eaf->db->query("update members set `groupid`='2' where uid = $uid");
	if($total_finde !== 0){


	if($sql_update){

		echo '<div class="green">'.$lang["alert_ok"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
									
		echo '<div class="red">'.$lang["alert_error"].'</div>';
		echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
		}	


	}else{


	echo '<div class="red">'.$lang["members_notexists"].'</div>';

	echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';

	}

	}

	}

# end class 	
}
?>