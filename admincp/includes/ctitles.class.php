<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

 class TitlesControl{
		
	private $start_tabel="phpforyou_";
	private $table="names";
	private $title_id;
	
	public function AddSmile(){
		
			global $eaf,$lang;
		
			$this->AddSmile = '
			<div id="msg"></div>
			<form name="add_smile" method="post" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
			<tr>
			<td>'.$lang["titles_name"].'</td>
			<td><input type="text" name="smile_title"  id="one" /></td>
			</tr>
			<tr>
			<td>'.$lang["titles_star"].'</td>
			<td><input type="file" name="smile_replace" id="t" /></td>
			</tr>
			<tr>
			<td>'.$lang["titles_posts"].'</td>
			<td><input type="text" name="title_post" id="z" /></td>
			</tr>
			<tr>
			<td>'.$lang["post"].'</td>
			<td><input type="submit" name="addsmile" onclick="return accessempty();"  value="'.$lang["add"].'" /></td>
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
				$title_post = intval(abs(trim($eaf->_POST['title_post'])));
		
				if(!empty($_FILES['smile_replace']['name'])){
			
					$smile_replace = uploadFile("smile_replace" , "../upload/labels" , true);
				
				}
				
				if(empty($smile_title) || empty($smile_replace)){
		
						$eaf->_print('<div class="red">'.$lang["empty"].'</div>');					
			
						echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					
					}else{
					
						$Sql_Insert	=	$eaf->db->query("INSERT INTO ".$this->start_tabel.$this->table." (user_title,user_star,user_post) VALUES ('$smile_title','$smile_replace','$title_post')");
						
						if($Sql_Insert){
								
								echo '<div class="green">'.$lang["alert_ok"].'</div>';
								echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
						}else{
								echo '<div class="red">'.$lang["alert_error"].'</div>';	
								echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
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
				<td>'.$lang["titles_name"].'</td>
				<td>'.$lang["titles_star"].'</td>
				<td>'.$lang["edit"].'</td>
				<td>'.$lang["delete"].'</td>
				</tr>
				';	
					while($this->Row = $eaf->db->dbrows($this->Sql_SmilesShow)){
						echo '
						<tr>
							<td>'.$this->Row['name_id'].'</td>
								<td>'.$this->Row['user_title'].'</td>
							<td><img src="../'.$this->Row['user_star'].'" /></td>
							<td><a href="titles.php?action=edit_title&title_id='.$this->Row['name_id'].'"><img src="icons/edit.png" border="0px" /></a></td>
							<td><a href="titles.php?action=delete_title&title_id='.$this->Row['name_id'].'"><img src="icons/recy.png" border="0px" /></a></td>
						</tr>
							';
				}
					echo '</table>';
	}
	
	public function DeleteSmile(){
		
		global $eaf,$lang;
		
		$this->title_id = intval(abs(trim($eaf->_REQUEST['title_id'])));
		
		$sid = $this->title_id;
		
			if(isset($this->title_id)){
					$sql_smile_finde = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." WHERE name_id=$sid");
					$total_finde    = $eaf->db->dbnum($sql_smile_finde);
				if($sid == 1 or $sid == 2){
				
					echo '<div class="red">'.$lang["titles_cdelete"].'<div>';	
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
					return false;
				
				}
				
				if($total_finde !== 0){
		
						$sql_delete = $eaf->db->query("DELETE FROM ".$this->start_tabel.$this->table." WHERE name_id=$sid");
		
						if($sql_delete){
								
								echo '<div class="green">'.$lang["alert_ok"].'</div>';
								echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
							
							}else{
								
								echo '<div class="red">'.$lang["alert_error"].'</div>';	
								echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
								
								}
					}else{
										
							echo '<div class="red">'.$lang["titles_notexists"].'<div>';	
							echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				}
				
			}	
		}
	
	
	public function EditSmileForm(){
	
	
		global $eaf,$lang;
	
		$this->title_id = intval(abs(trim($eaf->_REQUEST['title_id'])));
	
		$sid = $this->title_id;
		
		$this->Sql_GetSmile = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." WHERE name_id=$sid");
	
		if($eaf->db->dbnum($this->Sql_GetSmile) == 0){
	
				echo '<div class="red">'.$lang["titles_notexists"].'<div>';	
	
				echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
	
				return false;

			}

			$this->GetRows	  = $eaf->db->dbrows($this->Sql_GetSmile);

			$this->Rows		 = array('title' => $this->GetRows['user_title'],'star' => $this->GetRows['user_star'],'post' => $this->GetRows['user_post']);

			$this->EditSmileForm =  '
			<form name="edit_smile" method="post" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
			<tr>
			<td>'.$lang["titles_name"].'</td>
			<td><input type="text" value="'.$this->Rows['title'].'" name="smile_title" /></td>
			</tr>
			<tr>
			<td>'.$lang["titles_star"].'</td>
			<td><input type="file" name="smile_replace" id="t" /></td>
			</tr>
			<tr>
			<td>'.$lang["titles_posts"].'</td>
			<td><input type="text" value="'.$this->Rows['post'].'"  name="title_post" /></td>
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
	
		$this->title_id = intval(abs(trim($eaf->_REQUEST['title_id'])));
		
		$sid = $this->title_id;
		
		$this->Sql_GetSmile = $eaf->db->query("SELECT * FROM ".$this->start_tabel.$this->table." WHERE name_id=$sid");
	
		$this->GetRows	  = $eaf->db->dbrows($this->Sql_GetSmile);
	
		if(isset($eaf->_POST['editsmile'])){
		
			$smile_title = strip_tags(trim(addslashes($eaf->_POST['smile_title'])));
		
			$title_post = intval(abs(trim($eaf->_POST['title_post'])));
		
			if(!empty($_FILES['smile_replace']['name'])){
		
				$smile_replace = uploadFile("smile_replace" , "../upload/labels" , true);
			
				$del		   = unlink("../" . $this->GetRows['user_star']);
			
			}else{
			
				$smile_replace = $this->GetRows['user_star'];		
			}
	
				$this->Post = array($smile_title,$smile_replace,$title_post);
				
				if(empty($smile_title) || empty($smile_replace)){
		
						$eaf->_print('<div class="red">'.$lang["empty"].'</div>');					
						echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
				
				}else{
				
					$this->Sql_Edit_Smile = $eaf->db->query("UPDATE ".$this->start_tabel.$this->table." SET user_title='".$this->Post[0]."',user_star='".$this->Post[1]."',user_post='".$this->Post[2]."' WHERE name_id=$sid");
					
					if($this->Sql_Edit_Smile){
						
								echo '<div class="green">'.$lang["alert_ok"].'</div>';
								echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
							
						}else{
								
								echo '<div class="red">'.$lang["alert_error"].'</div>';	
								echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
								
						}

				}

			}

		}

}

?>