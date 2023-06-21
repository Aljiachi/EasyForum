<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


final class SectionsControl{
private $fid;
private $start_tabel="phpforyou_";
private $tabel="sections";
public function AddForumForm(){
global $eaf,$lang;

	$sql_sections =  $eaf->db->query("select * from " . $this->start_tabel.$this->tabel . " where sort = '0'");

	$fadd = '
	
		<div id="msg"></div>
		<div id="form">
		<form name="add_section" method="post" enctype="multipart/form-data"> 
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td>'.$lang["forums_name"].'</td>
		<td><input type="text" name="name" value="'.$eaf->_POST["name"].'" id="one"  /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_more"].'</td>
		<td><textarea name="more" rows="3" cols="25" id="KindBoxT">'.$eaf->_POST["more"].'</textarea></td>
		</tr>
		<tr>
		<td>'.$lang["forums_order"].'</td>
		<td><input type="text" name="order" value="0" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_icon"].'</td>
		<td><input type="file" name="section_icon" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_active"].'</td>
		<td>
		<select name="open">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_parent"].'</td>
		<td>
		<select name="sort">
		';
		$fadd .= ForumsList(false);
		
		$fadd.='</select>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["forums_groups"].'</td>
		</tr>		
		<tr>
		<td>'.$lang["forums_gusers"].'</td>
		<td>
		<select name="user_show">
		<option value="0">'.$lang["yes"].'</option>
		<option value="1">'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gvistors"].'</td>
		<td>
		<select name="guest_show">
		<option value="0">'.$lang["yes"].'</option>
		<option value="1">'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gsupers"].'</td>
		<td>
		<select name="mods_show">
		<option value="0">'.$lang["yes"].'</option>
		<option value="1">'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gmoders"].'</td>
		<td>
		<select name="morder_show">
		<option value="0">'.$lang["yes"].'</option>
		<option value="1">'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gbanned"].'</td>
		<td>
		<select name="out_show">
		<option value="0">'.$lang["yes"].'</option>
		<option value="1">'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gactive"].'</td>
		<td>
		<select name="act_show">
		<option value="1">'.$lang["no"].'</option>
		<option value="0">'.$lang["yes"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_tshow"].'</td>
		<td>
		<select name="theards_show">
		<option value="1">'.$lang["no"].'</option>
		<option value="0">'.$lang["yes"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["forums_rule"].'</td>
		</tr>
		<tr>
		<td class="" colspan="2">
		<textarea name="rule" cols="40" rows="3" id="KindBox"></textarea>
		</td>
		</tr>		
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="addsection" onclick="return accessempty();"  value="'.$lang["add"].'" /></td>
		</tr>
		</table>
		</form>
		</div>
';
return $fadd;
}

public function AddForumPost(){
global $eaf,$lang;

if(isset($eaf->_POST['addsection'])){
	
if(!empty($_FILES['section_icon']['name'])){
	
	$img = uploadFile("section_icon" , "../upload/sections" , true);
		
	}else{
	
	$img = $GetParent->catimg;
		
	}
	
$name= $eaf->_POST['name'];
$more= $eaf->_POST['more'];
$open= $eaf->security->sint($eaf->_POST['open']);
$sort= $eaf->security->sint($eaf->_POST['sort']);
$guset_show = $eaf->security->sint($eaf->_POST['guset_show']);
$user_show  = $eaf->security->sint($eaf->_POST['user_show']);
$mods_show  = $eaf->security->sint($eaf->_POST['mods_show']);
$morder_show  = $eaf->security->sint($eaf->_POST['morder_show']);
$out_show  = $eaf->security->sint($eaf->_POST['out_show']);
$theards_show  = $eaf->security->sint($eaf->_POST['theards_show']);
$active_show  = $eaf->security->sint($eaf->_POST['act_show']);
$order  = $eaf->security->sint($eaf->_POST['order_show']);
$rule      = $eaf->_POST['rule'];
if(empty($img)){
$img = GetCatsIconDo();
}
if(empty($name)){
echo '<div class="red">'.$lang["forums_emptyName"].'</div>';
}else{
$insert = $eaf->db->query("INSERT INTO `".$this->start_tabel.$this->tabel."` (`name`,`more`,`open`,`sort`,`catimg`,`guset_show`,`user_show`,`mods_show`,`morder_show`,`out_show`,`rule`,`view_self`,`order`,`act_show`) VALUES (
'$name',
'$more',
'$open',
'$sort',
'$img',
'$guset_show',
'$user_show',
'$mods_show',
'$morder_show',
'$out_show',
'$rule',
'$theards_show',
'$order',
'$active_show'
)");

		if($insert){
		
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
}
}
}
public function addSection(){
	
	global $lang;
	
	return '
			<form name="add_section" method="post">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td>'.$lang["forums_sname"].'</td>
		<td><input type="text" name="section_name" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_sorder"].'</td>
		<td><input type="text" name="section_order" value="0" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_smore"].'</td>
		<td><textarea name="section_more" rows="4" style="width:80%" ></textarea></td>
		</tr>
		<tr>
		<td>'.$lang["forums_sactive"].'</td>
		<td>
		<select name="section_open">
		<option value="1">'.$lang["yes"].'</option>
		<option value="0">'.$lang["no"].'</option>
		</select>		
		</td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td>
		<input type="submit" name="add_section" value="'.$lang["add"].'" />
		</td>
		</tr>
		</table>
		</form>

	';	
}
public function addSectionPost(){

	global $eaf,$lang;
	
	if(isset($eaf->_POST['add_section'])){

		$name= $eaf->_POST['section_name'];
		$more= $eaf->_POST['section_more'];
		$open= $eaf->security->sint($eaf->_POST['section_open']);
		$order= $eaf->security->sint($eaf->_POST['section_order']);

		if(empty($name)){

		echo '<div class="red">'.$lang["forums_emptyName"].'</div>';

		}else{
		
			$Insert = $eaf->db->query("INSERT INTO `".$this->start_tabel.$this->tabel. "` 
			(`name`,`more`,`open`,`sort`,`order`) VALUES (
			'$name',
			'$more',
			'$open',
			'0',
			'$order'
			)");
			
			if($Insert){
		
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}	
		}
	}	
}
public function ShowSections(){
global $eaf,$lang;
$sql = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->tabel. " WHERE sort='0'");
while($rows = $eaf->db->dbrows($sql)){
echo '
	 <table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" class="head">'.$rows['name'].' &nbsp; &nbsp; <a href="sections.php?action=edit&fid='.$rows['fid'].'"><img src="icons/edit.png" border="0px" /></a> &nbsp; &nbsp; <a onclick="deleteact('."'".$rows['fid']."'".');"><img src="icons/recy.png" border="0px" /></a></td>
  </tr>
  <tr>
     <td width="3%" class="ttable">&nbsp;</td>
    <td class="ttable" width="37%">'.$lang["forums_name"].'</td>
    <td class="ttable" width="20%">'.$lang["edit"].'</td>
	 <td class="ttable" width="20%">'.$lang["delete"].'</td>

  </tr>';
$sections = $eaf->db->query("select * from " . $this->start_tabel.$this->tabel . " where sort=".$rows['fid']);
while($row = $eaf->db->dbrows($sections)){
echo'
  <tr>
     <td class="tct" ><img src="../'.$row['catimg'].'" style="max-width:'.GetMaxIconSizeW().'px; max-height:'.GetMaxIconSizeW().'px;" /></td>
    <td class="tct" ><strong><a href="sections.php?action=sortcats&fid='.$row['fid'].'">'.$row['name'].'</a></strong><br /> '.$row['more'].' <br /> 
    </td>
    <td class="tct" ><a href="sections.php?action=edit&fid='.$row['fid'].'"><img src="icons/edit.png" border="0px" /></a></td>
    <td class="tct" style="padding:1px;"><a onclick="deleteact('."'".$row['fid']."'".');"><img src="icons/recy.png" border="0px" /></a></td>
  </tr>
	 ';
}
echo '</table>';
}
			}
public function ShowSortSections(){
global $eaf,$lang;
$this->fid = intval(abs($eaf->_REQUEST['fid']));
$sql = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->tabel. " WHERE fid=".$this->fid);
$rows = $eaf->db->dbrows($sql);
echo '
	<div align="center"><a href="'.$_SERVER['HTTP_REFERER'].'"><img src="icons/back.png" border="0px" /></a></div>
	 <table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" class="head">'.$rows['name'].' &nbsp; &nbsp; <a href="sections.php?action=edit&fid='.$rows['fid'].'"><img src="icons/edit.png" border="0px" /></a> &nbsp; &nbsp; <a onclick="deleteact('."'".$rows['fid']."'".');"><img src="icons/recy.png" border="0px" /></a></td>
  </tr>
  <tr>
      <td width="3%" class="ttable">&nbsp;</td>
    <td class="ttable" width="37%">'.$lang["forums_name"].'</td>
    <td class="ttable" width="20%">'.$lang["edit"].'</td>
	 <td class="ttable" width="20%">'.$lang["delete"].'</td>

  </tr>';
$sections = $eaf->db->dbselect($this->start_tabel.$this->tabel,"sort=".$rows['fid'],"","");
while($row = $eaf->db->dbrows($sections)){
echo'
<tr>
   <td class="tct" ><img src="../'.$row['catimg'].'" style="max-width:'.GetMaxIconSizeW().'px; max-height:'.GetMaxIconSizeW().'px;" /></td>
    <td class="tct" ><a href="sections.php?action=sortcats&fid='.$row['fid'].'">'.$row['name'].'</a> <br /> '.$row['more'].' <br /> 
    <td class="tct" ><a href="sections.php?action=edit&fid='.$row['fid'].'"><img src="icons/edit.png" border="0px" /></a></td>
    <td class="tct" style="padding:1px;"><a onclick="deleteact('."'".$row['fid']."'".');"><img src="icons/recy.png" border="0px" /></a></td>
	
</tr>
	 ';
}
echo '</table>';
}
public function DeleteSection(){
global $eaf,$lang;
$this->fid = intval(abs($eaf->_REQUEST['fid']));
$sql = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->tabel. " WHERE fid=".$this->fid);
$total = $eaf->db->dbnum($sql);
if($total == 0){
	
	echo '<div class="red">'.$lang["forums_notexists"].'</div>';

	}else{

	$sql_find = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->tabel. " WHERE sort=".$this->fid);

	while($rowt = $eaf->db->dbrows($sql_find)){

	$sql_update = $eaf->db->query("UPDATE ".$this->start_tabel.$this->tabel. " SET sort='99999999' WHERE fid=".$rowt['fid']);

	}
	
		$delete = "DELETE FROM " .$this->start_tabel.$this->tabel. " WHERE fid=".$this->fid;
	
		 $Query_DeleteTheards = $eaf->db->query("select * from " . tablenamestart("topics") . " where f_id=$this->fid");
		 
		 	while($DeleteTheards = $eaf->db->_object($Query_DeleteTheards)){
				
				$QueryDeletePosts= $eaf->db->query("select * from " . tablenamestart("posts") . " where t_id=$DeleteTheards->tid");
				
					while($DeletePosts = $eaf->db->_object($QueryDeletePosts)){
						
						$DeletePost = $eaf->db->query("delete from " . tablenamestart("posts") . " where pid=$DeletePosts->pid");
					}
					
					$DeleteTheard = $eaf->db->query("delete from " . tablenamestart("topics") . " where tid=$DeleteTheards->tid");
			}
			
       	 $query  = $eaf->db->query($delete);
			if($query){
			
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
}
}

public function EditSectionForm(){
global $eaf,$lang;
$this->fid = intval(abs($eaf->_REQUEST['fid']));
$sections = $eaf->db->query("select * from " . $this->start_tabel.$this->tabel . " where fid=".$this->fid);
$sql_sections =  $eaf->db->query("select * from " . $this->start_tabel.$this->tabel . " where  sort=0");
$rows     = $eaf->db->dbrows($sections);
$fadd = '
		<div id="msg"></div>
		<div id="form">
		<form name="add_section" method="post" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td>'.$lang["forums_name"].'</td>
		<td><input type="text" name="name" value="'.Cleanquot($rows['name']).'" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_order"].'</td>
		<td><input type="text" name="order" value="'.$rows['order'].'" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_more"].'</td>
		<td><textarea name="more" rows="3" cols="25">'.$rows["more"].'</textarea></td>
		</tr>
		<tr>
		<td>'.$lang["forums_icon"].'</td>
		<td><input type="file" name="section_icon" /></td>
		</tr>
		<tr>
		<td>'.$lang["forums_active"].'</td>
		<td>
		<select name="open">
<option value="1"';if($rows['open']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
<option value="0"';if($rows['open']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
<tr>
		<td>'.$lang["forums_parent"].'</td>
		<td>
		<select name="sort">
<option value="" selected="selected">'.$lang["select"].'</option>		
<option value="0">'.$lang["forums_index"].'</option>
		';
$fadd .= ForumsList(false);
$fadd.='</select>
		</td>
		</tr>
		<tr>
		<td class="ttable" colspan="2">'.$lang["forums_groups"].'</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gusers"].'</td>
		<td>
		<select name="user_show">
		<option value="0"';if($rows['user_show']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		<option value="1"';if($rows['user_show']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gvistors"].'</td>
		<td>
		<select name="guset_show">
		<option value="0"';if($rows['guset_show']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		<option value="1"';if($rows['guset_show']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gsupers"].'</td>
		<td>
		<select name="mods_show">
		<option value="0"';if($rows['mods_show']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		<option value="1"';if($rows['mods_show']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gmoders"].'</td>
		<td>
		<select name="morder_show">
		<option value="0"';if($rows['morder_show']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		<option value="1"';if($rows['morder_show']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gbanned"].'</td>
		<td>
		<select name="out_show">
		<option value="0"';if($rows['out_show']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		<option value="1"';if($rows['out_show']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_gactive"].'</td>
		<td>
		<select name="act_show">
		<option value="0"';if($rows['act_show']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		<option value="1"';if($rows['act_show']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>'.$lang["forums_tshow"].'</td>
		<td>
		<select name="theards_show">
		<option value="1"';if($rows['view_self']==1){$fadd .=' selected="selected"';}$fadd .='>'.$lang["no"].'</option>
		<option value="0"';if($rows['view_self']==0){$fadd .=' selected="selected"';}$fadd .='>'.$lang["yes"].'</option>
		</select>
		</td>
		</tr>

		<tr>
		<td class="ttable" colspan="2">'.$lang["forums_rule"].'</td>
		</tr>
		<tr>
		<td class="" colspan="2">
		<div id="SwitchArea">
		<textarea name="rule" cols="40" rows="3" class="Text" id="KindBox">'.$rows['rule'].'</textarea>
		</div>
		</td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="editsection" value="'.$lang["edit"].'" /></td>
		</tr>
		</table>
		</form>
		</div>

';
return $fadd;
}
public function EditPostSection(){
global $eaf,$lang;
if(isset($eaf->_POST['editsection'])){
$this->fid = intval(abs($eaf->_REQUEST['fid']));

$GetParent = $eaf->db->_object($eaf->db->query("select sort , catimg from " . $this->start_tabel . $this->tabel . " where fid = " . $this->fid));

$name= $eaf->_POST['name'];
$more= $eaf->_POST['more'];
$open= $eaf->security->sint($eaf->_POST['open']);
$sort= $eaf->security->sint($eaf->_POST['sort']);

	if(!empty($_FILES['section_icon']['name'])){
	
	$img = uploadFile("section_icon" , "../upload/sections" , true);
	
	$delete = unlink("../".$GetParent->catimg);
	
	}else{
	
	$img = $GetParent->catimg;
		
	}
	
$guset_show = $eaf->security->sint($eaf->_POST['guset_show']);
$user_show  = $eaf->security->sint($eaf->_POST['user_show']);
$mods_show  = $eaf->security->sint($eaf->_POST['mods_show']);
$morder_show  = $eaf->security->sint($eaf->_POST['morder_show']);
$out_show  = $eaf->security->sint($eaf->_POST['out_show']);
$theards_show  = $eaf->security->sint($eaf->_POST['theards_show']);
$active_show  = $eaf->security->sint($eaf->_POST['act_show']);
$order  = $eaf->security->sint($eaf->_POST['order']);
$rule	  = $eaf->_POST['rule'];

	if(empty($img)){

	$img = GetCatsIconDo();

	}

	if(empty($sort)) $sort = $GetParent->sort;

$update = $eaf->db->query("UPDATE `".$this->start_tabel.$this->tabel."` SET 

`name`='$name',
`more`='$more',
`catimg`='$img',
`sort`='$sort',
`open`='$open',
`guset_show`='$guset_show',
`user_show`='$user_show',
`mods_show`='$mods_show',
`morder_show`='$morder_show',
`out_show`='$out_show',
`rule`='$rule',
`view_self`='$theards_show',
`order`='$order',
`act_show`='$active_show'
 WHERE fid=".$this->fid);

	if($update){
	
				echo '<div class="green">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
				echo '<div class="red">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}
}
}
public function ShowNoSortSections(){
global $eaf,$lang;
echo '
	 <table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" class="head">'.$lang["forums_nosort"].'</td>
  </tr>
  <tr>
      <td width="3%" class="ttable">&nbsp;</td>
  <td class="ttable" width="37%">'.$lang["forums_name"].'</td>
    <td class="ttable" width="20%">'.$lang["edit"].'</td>
	 <td class="ttable" width="20%">'.$lang["delete"].'</td>

  </tr>';
$sections = $eaf->db->dbselect($this->start_tabel.$this->tabel,"sort='99999999'","","");
while($row = $eaf->db->dbrows($sections)){
echo'
  <tr>
    <td class="tct" ><img src="../'.$row['catimg'].'" style="max-width:'.GetMaxIconSizeW().'px; max-height:'.GetMaxIconSizeW().'px;" /></td>
    <td class="tct" ><a href="sections.php?action=sortcats&fid='.$row['fid'].'">'.$row['name'].'</a> <br /> '.$row['more'].' <br /> 
    <td class="tct" ><a href="sections.php?action=edit&fid='.$row['fid'].'"><img src="icons/edit.png" border="0px" /></a></td>
    <td class="tct" style="padding:1px;"><a onclick="deleteact('."'".$row['fid']."'".');"><img src="icons/recy.png" border="0px" /></a></td>
    </td>
  </tr>
	 ';
}
echo '</table>';
			}
}
?>