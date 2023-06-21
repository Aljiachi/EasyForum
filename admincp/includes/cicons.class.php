<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class Icons_Control_System
{
private $start_tabel="phpforyou_";
private $table="icons";
private $smile_id;
public function AddSmile(){
		
		global $lang;
		$this->AddSmile = '
		<div id="msg"></div>
		<form name="add_smile" method="post" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td>'.$lang["icons_title"].'</td>
		<td><input type="text" name="smile_title" id="one" /></td>
		</tr>
		<tr>
		<td>'.$lang["icons_url"].'</td>
		<td><input type="file" name="smile_replace" id="t" /></td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="addsmile" onclick="return accessempty();" value="'.$lang["add"].'" /></td>
		</tr>
		</table>
		</form>
		'
		;
				return $this->AddSmile;
			}
public function AddSmilePost(){
global $eaf,$lang;
	if(isset($eaf->_POST['addsmile'])){
		$smile_title = strip_tags(trim(addslashes($eaf->_POST['smile_title'])));
	
		if(!empty($_FILES['smile_replace']['name'])){
	
			$smile_replace = uploadFile("smile_replace" , "../upload/icons" , true);
					
		}
					if(empty($smile_title) || empty($smile_replace)){
					$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
					
					echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			}else 		{
				$Sql_Insert 		=		$eaf->db->query("INSERT INTO ".$this->start_tabel.$this->table." (icon_title,icon_url) VALUES ('$smile_title','$smile_replace')");
								if($Sql_Insert){
									
									echo '<div class="green">'.$lang["alert_ok"].'</div>';
									echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
								}else{
									
									echo '<div class="red">'.$lang["alert_error"].'</div>';
									echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
								}
							}
	}
				}


public function SmilesShow(){
global $eaf,$lang;
$this->Sql_SmilesShow = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." ");
	echo '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">';
		echo '
			<tr>
			<td>'.$lang["ID"].'</td>
			<td>'.$lang["icons_title"].'</td>
			<td>'.$lang["icons_icon"].'</td>
			<td>'.$lang["edit"].'</td>
			<td>'.$lang["delete"].'</td>
			</tr>
			';	
				while($this->Row = $eaf->db->dbrows($this->Sql_SmilesShow)){
					echo '
					<tr>
						<td>'.$this->Row['icon_id'].'</td>
							<td>'.$this->Row['icon_title'].'</td>
						<td><img src="../'.$this->Row['icon_url'].'" /></td>
						<td><a href="icons.php?action=edit_icon&icon_id='.$this->Row['icon_id'].'"><img src="icons/edit.png"  border="0px" /></a></td>
						<td><a href="icons.php?action=delete_icon&icon_id='.$this->Row['icon_id'].'"><img src="icons/recy.png"  border="0px" /></a></td>
					</tr>
						';
			}
				echo '</table>';
}
public function DeleteSmile(){
global $eaf,$lang;
$this->smile_id = intval(abs(trim($eaf->_REQUEST['icon_id'])));
	$sid = $this->smile_id;
		if(isset($this->smile_id)){
			$sql_smile_finde = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." WHERE icon_id=$sid");
			$total_finde    = $eaf->db->dbnum($sql_smile_finde);
				if($total_finde !== 0){
					$sql_delete = $eaf->db->query("DELETE FROM ".$this->start_tabel.$this->table." WHERE icon_id=$sid");
						if($sql_delete){
															
									echo '<div class="green">'.$lang["alert_ok"].'</div>';
									echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
								}else{
									
									echo '<div class="red">'.$lang["alert_error"].'</div>';
									echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
								}
								
									}else{
								
										echo '<div class="red">'.$lang["icons_notexists"].'<div>';	
										echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
										}
				
				
						}	
}


public function EditSmileForm(){
global $eaf,$lang;
		$this->smile_id = intval(abs(trim($eaf->_REQUEST['icon_id'])));
		$sid = $this->smile_id;
		$this->Sql_GetSmile = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." WHERE icon_id=$sid");
		if($eaf->db->dbnum($this->Sql_GetSmile) == 0){
			echo '<div class="red">'.$lang["icons_notexists"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
				return false;
		}
		$this->GetRows	  = $eaf->db->dbrows($this->Sql_GetSmile);
		$this->Rows		 = array('title' => $this->GetRows['icon_title'],'replace' => $this->GetRows['icon_url']);
		$this->EditSmileForm = '
		<form name="edit_smile" method="post" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
		<tr>
		<td>'.$lang["icons_title"].'</td>
		<td><input type="text" value="'.$this->Rows['title'].'" name="smile_title" /></td>
		</tr>
		<tr>
		<td>'.$lang["icons_url"].'</td>
		<td><input type="file" value="'.$this->Rows['replace'].'" name="smile_replace" /></td>
		</tr>
		<tr>
		<td>'.$lang["post"].'</td>
		<td><input type="submit" name="editsmile" value="'.$lang["edit"].'" /></td>
		</tr>
		</table>
		</form>
		'
		;	
		return $this->EditSmileForm;
}


public function EditSmilePost(){
global $eaf,$lang;
		$this->smile_id = intval(abs(trim($eaf->_REQUEST['icon_id'])));
		$sid = $this->smile_id;
		$this->Sql_GetSmile = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." WHERE icon_id=$sid");
		if($eaf->db->dbnum($this->Sql_GetSmile) == 0){
			echo '<div class="red">'.$lang["icons_notexists"].'</div>';
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
				return false;
		}
		$this->GetRows	  = $eaf->db->dbrows($this->Sql_GetSmile);
	if(isset($eaf->_POST['editsmile'])){
		$smile_title = strip_tags(trim(addslashes($eaf->_POST['smile_title'])));

		if(!empty($_FILES['smile_replace']['name'])){
	
			$smile_replace = uploadFile("smile_replace" , "../upload/icons" , true);
		
			$del		   = unlink("../" . $this->GetRows['icon_url']);
		
		}else{
		
			$smile_replace = $this->GetRows['icon_url'];		
		}
			
		$this->Post = array($smile_title,$smile_replace);
			if(empty($smile_title) || empty($smile_replace)){
					$eaf->_print('<div class="red">'.$lang["empty"].'</div>');						
					echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			}else{
			$this->Sql_Edit_Smile = $eaf->db->query("UPDATE ".$this->start_tabel.$this->table." SET icon_title='".$this->Post[0]."',icon_url='".$this->Post[1]."' WHERE icon_id=$sid");
				if($this->Sql_Edit_Smile){
							
								echo '<div class="green">'.$lang["alert_ok"].'</div>';
								echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
							
							}else{		
								
								echo '<div class="red">'.$lang["alert_error"].'</div>';
								echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';	
								
								}
								
			}
		}
	}
}
?>