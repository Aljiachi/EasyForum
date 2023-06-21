<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class AForumoptins{
private $start_tabel="phpforyou_";
private $tabel="infosite";
private $sql;
private $rows;
public function __construct(){
global $eaf,$lang;
$this->sql = $eaf->db->query("SELECT * FROM " . $this->start_tabel.$this->tabel . "");
$this->rows= $eaf->db->dbrows($this->sql);
}
public function ForumForm(){
global $eaf,$lang;
$styles = $eaf->db->query("SELECT * FROM " . $this->start_tabel."styles");
$langs  = $eaf->db->query("SELECT * FROM " . $this->start_tabel."languages");
$attach_size = $this->rows['attach_size'] / 1024;
$form = '<div id="msg"></div>
		<div id="form">
		<form name="add_section" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td colspan="2" class="head">'.$lang["options_forum"].'</td>
		</tr>
		<tr>
		<td>'.$lang["options_fname"].'</td>
		<td><input type="text" id="title" name="title" value="'.$this->rows['title'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_fmore"].'</td>
		<td><input type="text" id="dec" name="dec" value="'.$this->rows['meta'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_femail"].'</td>
		<td><input type="text" id="dec" name="email" value="'.$this->rows['email'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_furl"].'</td>
		<td><input type="text" id="dec" name="url" value="'.$this->rows['url'].'" /> <strong>'.$lang["options_urlmsg"].'</strong></td>
		</tr>
		<tr>
		<td>'.$lang["options_close"].'</td>
		<td>
		<select name="close_do">
<option value="1"';if($this->rows['close_do']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["opened"].'</option>
<option value="0"';if($this->rows['close_do']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["closed"].'</option>
		';
		$form .= '</td>
		</tr>
		<tr>
		<td>'.$lang["options_cmsg"].'</td>
		<td>
		<textarea name="close_msg" id="KindBox" rows="4" cols="40">'.$this->rows['close_msg'].'</textarea>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_style"].'</td>
		<td>
<select name="style">';
while($srow = $eaf->db->dbrows($styles)){
$form .='<option value="'.$srow['style_id'].'" '; if($this->rows['style_id'] == $srow['style_id']){ $form .= 'selected="selected"'; } $form .='>'.$srow['style_name'].'</option>';
}
$form .='
</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_lang"].'</td>
		<td>
<select name="lang">';
while($lrow = $eaf->db->dbrows($langs)){
$form .='<option value="'.$lrow['lang_id'].'" '; 

if($this->rows['language'] == $lrow['lang_id']){ 

$form .= 'selected="selected"'; 

}

 $form .='>'.$lrow['lang_name'].'</option>';
}
$form .='
</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_catimg"].'</td>
		<td><input type="text" id="icon"  name="catimg" value="'.$this->rows['cat_usicon'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_size"].'</td>
		<td><input type="text"  id="attah_size" name="attach_size" value="'.$attach_size.'" />'.$lang["options_sizemsg"].'</td>
		</tr>
		<tr>
		<td>'.$lang["options_types"].'</td>
		<td><input type="text" id="attach_types"  name="types" style="text-align:left;direction:ltr" value="'.$this->rows['types'].'" />'.$lang["options_typesmsg"].' </td>
		</tr>
		<tr>
		<td>'.$lang["options_wcimg"].'</td>
		<td><input type="text" id="icon_w"  name="mwiconsize" value="'.$this->rows['wicon'].'" /> px</td>
		</tr>
		<tr>
		<td>'.$lang["options_hcimg"].'</td>
		<td><input type="text" id="icon_h" name="mhiconsize" value="'.$this->rows['hicon'].'" /> px</td>
		</tr>
		<tr>
		<td>'.$lang["options_wavatar"].'</td>
		<td><input type="text" id="avatar_w" name="mwavatarsize" value="'.$this->rows['wavatar'].'" /> px</td>
		</tr>
		<tr>
		<td>'.$lang["options_havatar"].'</td>
		<td><input type="text" id="avatar_h" name="mhavatarsize" value="'.$this->rows['havatar'].'" /> px</td>
		</tr>
		<tr>
		<td>'.$lang["options_blocksorder"].'</td>
		<td>
		<select name="pblocks_order">
		<option value="ASC"';if($this->rows['pblocks_order'] == "ASC"){ $form.=' selected="selected"';}$form.='>'.$lang["asc"].'</option>
		<option value="DESC"';if($this->rows['pblocks_order'] == "DESC"){ $form.=' selected="selected"';}$form.='>'.$lang["desc"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_signupData"].'</td>
		<td><input type="text" id="avatar_h" name="signup_data" value="'.$this->rows['signup_data'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_dateType"].'</td>
		<td><input type="text" id="avatar_h" name="datetype" value="'.$this->rows['datatype'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_timeType"].'</td>
		<td><input type="text" id="avatar_h" name="timetype" value="'.$this->rows['timetype'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" onclick="return Vsetting()" name="edit_forum" value="'.$lang["edit"].'" /></td>
		</tr>
		</table>
		</form>
		</div>
';
return $form;
}
public function SaveEditForum(){
global $eaf,$lang;
if(isset($eaf->_POST['edit_forum'])){
$title = $eaf->_POST['title'];
$meta  = $eaf->_POST['dec'];
$close_do = intval(abs($eaf->_POST['close_do']));
$close_msg = $eaf->_POST['close_msg'];
$style = strip_tags($eaf->_POST['style']);
$catimg= $eaf->_POST['catimg'];
$wicon = $eaf->_POST['mwiconsize'];
$hicon = $eaf->_POST['mhiconsize'];
$wavatar = $eaf->_POST['mwavatarsize'];
$havatar = $eaf->_POST['mhavatarsize'];
$Pblocks_order = $eaf->_POST['pblocks_order'];
$types   = strip_tags($eaf->_POST['types']);
$signup_data   = strip_tags($eaf->_POST['signup_data']);
$datetype   = strip_tags($eaf->_POST['datetype']);
$timetype   = strip_tags($eaf->_POST['timetype']);
$language   = intval(abs($eaf->_POST['lang']));
$attach_size = $eaf->_POST['attach_size'] * 1024;
$email   = $eaf->_POST['email'];
$url     = $eaf->_POST['url'];
if(empty($title) or empty($style) or empty($catimg) || empty($types)){
$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
return false;
}
$update = $eaf->db->query("UPDATE ".$this->start_tabel.$this->tabel." SET 
					
					title='$title',
					
					meta='$meta',
					
					close_do='$close_do',
					
					close_msg='$close_msg',
					
					style_id='$style',
					
					cat_usicon='$catimg',
					
					wicon='$wicon',
					
					hicon='$hicon',
					
					wavatar='$wavatar',
					
					havatar='$havatar',
					
					types='$types',
					
					attach_size='$attach_size',
					
					pblocks_order='$Pblocks_order',
					
					url = '$url',
					
					email = '$email' , 
					
					signup_data = '$signup_data' ,
					
					timetype = '$timetype' ,
					
					datatype = '$datetype' , 
					
					language = '$language'
					
					");
if($update){
	echo '<div class="green">'.$lang["alert_ok"].'</div>';
	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
}
}
}
public function RegisterForm(){
global $eaf,$lang;
$groups_Register = $eaf->db->query("SELECT id,name FROM " . $this->start_tabel . "groups");
$groups_Actived = $eaf->db->query("SELECT id,name FROM " . $this->start_tabel . "groups");
$form = '
		<form name="add_section" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td colspan="2" class="head">'.$lang["options_members"].'</td>
		</tr>		
		<tr>
		<td>'.$lang["options_signup"].'</td>
		<td>
		<select name="register">
<option value="1"';if($this->rows['register']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["opened"].'</option>
<option value="0"';if($this->rows['register']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["closed"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_html_sig"].'</td>
		<td>
		<select name="reg_html">
<option value="1"';if($this->rows['sig_html']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["yes"].'</option>
<option value="0"';if($this->rows['sig_html']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_userpm"].'</td>
		<td>
		<select name="user_pm">
<option value="1"';if($this->rows['user_pm']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["opened"].'</option>
<option value="0"';if($this->rows['user_pm']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["closed"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_active"].'</td>
		<td>
		<select name="active_do">
<option value="1"';if($this->rows['active_do']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["options_activeEmail"].'</option>
<option value="0"';if($this->rows['active_do']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["options_activeAdmin"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_pass"].'</td>
		<td><input type="text" name="min_pass" value="'.$this->rows['sig_pass'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_gsignup"].'</td>
		<td>
		<select name="register_group">';
while($srow = $eaf->db->dbrows($groups_Register)){
$form .='<option value="'.$srow['id'].'"';

if($this->rows['register_group']==$srow['id']){$form = $form.' selected="selected"';}$form = $form.'>'.$srow['name'].'</option>
';
}
	$form .='</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_gactived"].'</td>
		<td>
		<select name="actived_group">';
while($trow = $eaf->db->dbrows($groups_Actived)){
$form .='<option value="'.$trow['id'].'"';

if($this->rows['actived_group']==$trow['id']){$form.=' selected="selected"';}$form .= '>'.$trow['name'].'</option>
';
}
	$form .='</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" value="'.$lang["edit"].'" name="edituser" /></td>
		</tr>
		</table>
		</form>';
return $form;
}
public function SaveEditUsers(){
global $eaf,$lang;
if(isset($eaf->_POST['edituser'])){
$register = $eaf->security->sint($eaf->_POST['register']);
$add_html = $eaf->security->sint($eaf->_POST['reg_html']);
$user_pm  = $eaf->security->sint($eaf->_POST['user_pm']);
$ma_pass  = $eaf->security->sint($eaf->_POST['min_pass']);
$s_title  = $eaf->security->sint($eaf->_POST['sig_title']);
$register_Group = $eaf->security->sint($eaf->_POST['register_group']);
$actived_Group  = $eaf->security->sint($eaf->_POST['actived_group']);
$Active_Do  = $eaf->security->sint($eaf->_POST['active_do']);
if(empty($ma_pass)){
	echo '<div class="red">'.$lang["empty"].'</div>';
	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
	return false;
}
$update = $eaf->db->query("UPDATE " . $this->start_tabel.$this->tabel. " SET 	
`sig_html`='$add_html',
`sig_pass`='$ma_pass',
`user_pm`='$user_pm',
`register`='$register',
`sig_title`='$s_title',
`register_group`='$register_Group',
`actived_group`='$actived_Group',
`active_do`='$Active_Do'
");
if($update){
	echo '<div class="green">'.$lang["alert_ok"].'</div>';
	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
}

}

}
public function PostAndShow(){
global $eaf,$lang;
$form = '
		<div id="msg"></div>
		<form name="add_section" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td colspan="2" class="head">'.$lang["options_posts"].'</td>
		</tr>
		<tr>
		<td>'.$lang["options_html_posts"].'</td>
		<td>
		<select name="post_html">
<option value="1"';if($this->rows['post_html']==1){$form.=' selected="selected"';}$form.='>'.$lang["yes"].'</option>
<option value="0"';if($this->rows['post_html']==0){$form.=' selected="selected"';}$form.='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_fastpost"].'</td>
		<td>
		<select name="post_fast">
<option value="1"';if($this->rows['post_fast']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["yes"].'</option>
<option value="0"';if($this->rows['post_fast']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_attachment"].'</td>
		<td>
		<select name="attachment">
<option value="1"';if($this->rows['attach_do']==1){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["yes"].'</option>
<option value="0"';if($this->rows['attach_do']==0){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>	
		<tr>
		<td>'.$lang["options_postorder"].'</td>
		<td>
		<select name="topics_sort">
<option value="ASC"';if($this->rows['topics_sort']=="ASC"){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["asc"].'</option>
<option value="DESC"';if($this->rows['topics_sort']=="DESC"){$form = $form.' selected="selected"';}$form = $form.'>'.$lang["desc"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["options_posticon"].'</td>
		<td><input type="text" name="us_icon"  id="ticon" value="'.$this->rows['post_usicon'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="editposts" onclick="return Vposts();" value="'.$lang["edit"].'" /></td>
		</tr>
		<table>
		</form>
		';
return $form;
}
public function EditPostAndShow(){
global $eaf,$lang;
if(isset($eaf->_POST['editposts'])){
$post_html = intval(abs($eaf->_POST['post_html']));
$post_fast = intval(abs($eaf->_POST['post_fast']));
$us_icon   = strip_tags(trim($eaf->_POST['us_icon']));
$tsort     = strip_tags(trim($eaf->_POST['topics_sort']));
$attachment = intval(abs($eaf->_POST['attachment']));
if(empty($us_icon)){
	echo '<div class="red">'.$lang["empty"].'</div>';
	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
	return false;
}
$update = $eaf->db->query("UPDATE " . $this->start_tabel.$this->tabel . " SET post_html='$post_html',post_fast='$post_fast',post_usicon='$us_icon',topics_sort='$tsort',attach_do='$attachment'");
if($update){
	echo '<div class="green">'.$lang["alert_ok"].'</div>';
	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
	}
		}
			}
public function ReplaceWordsForm(){
global $eaf,$lang;
$words = $this->rows['replace_words'];
$words = str_replace("|","\n",$words);
$form = '
		<form name="add_section" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td colspan="2" class="head">'.$lang["options_words"].'</td>
		</tr>
		<tr>
		<td class="ttable">'.$lang["options_wordsMsg"].'</td>
		</tr>
		<tr>
		<td><textarea name="words" rows="5" cols="50">'.$words.'</textarea></td>
		</tr>
		<tr>
		<td><input type="submit" name="editrewords" value="'.$lang["edit"].'" /></td>
		</tr>
		</table>
		</form>
		';	
return $form;
}
public function ReplaceWordsPost()
{
global $eaf,$lang;
if(isset($eaf->_POST['editrewords'])){
$words = $eaf->_POST['words'];
$words = str_replace("\n","|",$words);
$update= $eaf->db->query('UPDATE `' . $this->start_tabel.$this->tabel . '` SET `replace_words`="'.$words.'"')or die( mysql_error());
if($update){
	echo '<div class="green">'.$lang["alert_ok"].'</div>';
	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
	}
		}	
			}
public function ContActShow()
{
global $eaf,$lang;
$this->sql_show = $eaf->db->query("SELECT * FROM phpforyou_contact")or die(mysql_error());	
$this->total_show = $eaf->db->dbnum($this->sql_show);
if($this->total_show == 0){
echo '<div class="red">'.$lang["options_inboxEmpty"].'</div>';
}
while($rows = $eaf->db->dbrows($this->sql_show)){
echo '<div class="head" dir="rtl">'.$lang["options_msgtitle"].'  : '.$rows['title'].' | '.$lang["options_msgdate"].'  : '.$rows['data'].' | '.$lang["options_msgemail"].' : '.$rows['email'].' </div>';
echo '<div id="bodypanel">'.$rows['msg'].' <hr /><a href="?action=delete_msg&id='.$rows['id'].'">حذف الرسالة</a> |  '.$lang["options_msgip"].' : '.$rows['ip'].'</div>';
}
}
public function ContActDelete()
{
global $eaf,$lang;
if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) and is_numeric($eaf->_REQUEST['id'])){$id = intval(abs($eaf->_REQUEST['id']));}
$this->sql_del = $eaf->db->query('DELETE FROM `phpforyou_contact` WHERE `id` = '.$id.'')or die(mysql_error());
if($this->sql_del){
	echo '<div class="green">'.$lang["alert_ok"].'</div>';
}
}
public function PagesForm(){
	
	global $lang;
	
	return '
		<div id="msg"></div>
		<form name="pages" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td colspan="2" class="head">'.$lang["options_pages"].'</td>
		</tr>
		<tr>
		<td>'.$lang["options_pages_theards"].'</td>
		<td><input type="text" name="page_forum" value="'.$this->rows['page_forum'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_pages_posts"].'</td>
		<td><input type="text" name="page_posts" value="'.$this->rows['page_posts'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_pages_online"].'</td>
		<td><input type="text" name="page_online" value="'.$this->rows['page_online'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_pages_members"].'</td>
		<td><input type="text" name="page_members" value="'.$this->rows['page_members'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["options_pages_attachments"].'</td>
		<td><input type="text" name="page_attachments" value="'.$this->rows['page_attachments'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" value="'.$lang["edit"].'" name="edit_pages" /></td>
		</tr>
		</table>
		</form>
			';	
}

public function PagesPost(){
	
	global $eaf,$lang;

	$page_forum = $eaf->_POST['page_forum'];	
	
	$page_posts = $eaf->_POST['page_posts'];
	
	$page_online= $eaf->_POST['page_online'];
	
	$page_members = $eaf->_POST['page_members'];
	
	$page_attachments = $eaf->_POST['page_attachments'];
	
	if(isset($eaf->_POST['edit_pages'])){
		
	if(empty($page_forum) || empty($page_posts) || empty($page_online) || empty($page_members) || empty($page_attachments)){
		
			echo '<div class="red">'.$lang["empty"].'</div>';
		
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			
			return false;
	}
	
	if($page_forum == 0 || $page_posts == 0 || $page_online == 0 || $page_members == 0 || $page_attachments == 0){
			
			echo '<div class="red">'.$lang["options_notzero"].'</div>';
			
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';

			return false;
	}
	
	$Update = $eaf->db->query("UPDATE " . $this->start_tabel . $this->tabel . " SET 
	
	page_forum='$page_forum',

	page_members='$page_members',

	page_online='$page_online',

	page_attachments='$page_attachments',

	page_posts='$page_posts'

	");
	
	if($Update){
	
		echo '<div class="green">'.$lang["alert_ok"].'</div>';	
		
	    echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';

	}
	
	}
}
}
?>