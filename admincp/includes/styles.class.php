<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

include("zip.php");
class StylesControl extends PclZip{
	
	private $style_id;
	private $start_tabel="phpforyou_";
	private $tabel="styles";

	public function __construct(){
	// ** ** ** ** ** ** 
	}

	public function AddStyleForm(){

		global $eaf,$lang;
		$dir  = opendir("../styles");
		$form = '<div id="msg"></div>
			<form name="add_style" method="post" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
			<tr>
			<td class="ttable" colspan="2">'.$lang["styles_addstyle"].'</td>
			</tr>
			<tr>
			<td>'.$lang["styles_name"].'</td>
			<td><input type="text" name="name" id="one" /></td>
			</tr>
			<tr>
			<td>'.$lang["styles_folder"].'</td>
			<td>
			<select name="folder">
			<option value="">'.$lang["styles_selectFolder"].'</option>
			';
			while($file = readdir($dir)){
			$file = str_replace(".","",$file);
			$file = str_replace(" ","",$file);
			$file = str_replace("index","",$file);
			$file = str_replace("htm","",$file);
			if(!empty($file)){
			$form .= '<option value="'.$file.'">'.$file.'</option>';
			}
			}
	$form .= '</select>
			</td>
			</tr>
			<tr>
			<td>'.$lang["styles_up"].'</td>
			<td><input type="file" name="up_folder" /></td>
			</tr>
			<tr>
			<td>'.$lang["styles_active"].'</td>
			<td>
			<select name="do" id="z">
			<option value="1">'.$lang["yes"].'</option>
			<option value="0">'.$lang["no"].'</option>
			</select>
			</td>
			</tr>
			<tr>
			<td>'.$lang["post"].'</td>
			<td><input type="submit" value="'.$lang["add"].'" onclick="return accessempty();"  name="addstyle" /></td>
			</tr>
			</table>
			</form>
	';	
	return $form;
	}
	
	public function AddStylePost(){
		global $eaf,$lang;
		if(isset($eaf->_POST['addstyle'])){
		$name = $eaf->security->svar($eaf->_POST['name']);
		$folder = $eaf->security->svar($eaf->_POST['folder']);
		$up_folder_name = $_FILES['up_folder']['name'];
		$up_folder_tmp  = $_FILES['up_folder']['tmp_name'];
		$type = strrchr($up_folder_name,'.');
		$do = $eaf->security->sint($eaf->_POST['do']);
		if(empty($name)){
			$eaf->_print('<div class="red">'.$lang["empty"].'</div>');	
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			return false;
		}
		if(!empty($up_folder_name)){
			
			if($type !== ".zip"){
			echo '<div class="red">'.$lang["styles_type"].'</div>';
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			return false;
			}
			
			$upload = move_uploaded_file($up_folder_tmp,"../styles/".$up_folder_name);
			parent::__construct("../styles/".$up_folder_name);
			$this->extract(PCLZIP_OPT_PATH, '../styles');
			@unlink("../styles/".$up_folder_name);
		
		}
		
		if(!empty($up_folder_name)){
		
				$fname = str_replace(".zip","",$up_folder_name);
		}else{
			
				$fname = $folder;	
		}
		
			$mkdir = @mkdir('../includes/cache/'.$fname);
		
			$Sql_Insert = $eaf->db->query("INSERT INTO ".$this->start_tabel.$this->tabel." (style_name,style_folder,style_select) VALUES ('$name','$fname','$do')");	
			
			$Hooks = $eaf->db->query("select filedir from " . tablenamestart("hacks"));
		
			$Sid = mysql_insert_id();
				
			$sql_styles = $eaf->db->query("SELECT * FROM " .tablenamestart("styles"). " where style_id = $Sid");
				
			$rows_styles = $eaf->db->dbrows($sql_styles);			
			
			while($rows = $eaf->db->dbrows($Hooks)){
		
				$xml = $eaf->_loadxml("../includes/hacks/".$rows['filedir']);
		
				$title = $xml->title;
		
				$control= $xml->control;
		
				$find  = "<!-- ".$xml->find." !-->";
			
				foreach($xml->template as $kay => $var){
		
					if(!empty($var->edit) and $var->edit['do'] == "up"){
				
						$read_template = file_get_contents("../styles/".$rows_styles['style_folder']."/templates/".$var['name']);
					
						$open_template = fopen("../styles/".$rows_styles['style_folder']."/templates/".$var['name'],'w');
					
						$template_content = $find.$var->edit.$read_template;
					
						$addOnTemplate = fwrite($open_template,$template_content);
					
			
				}
			
				if(!empty($var->edit) and $var->edit['do'] == "down"){
				
						
						$read_template = file_get_contents("../styles/".$rows_styles['style_folder']."/templates/".$var['name']);
					
						$open_template = fopen("../styles/".$rows_styles['style_folder']."/templates/".$var['name'],'w');
						
						$template_content = $read_template.$find.$var->edit;
					
						$addOnTemplate = fwrite($open_template,$template_content);
					
					 }
					
					if(!empty($var->find_replace)){
		
					$read_template = file_get_contents("../styles/".$rows_styles['style_folder']."/templates/".$var['name']);
					
					$open_template = fopen("../styles/".$rows_styles['style_folder']."/templates/".$var['name'],'w');
					
					$template_content = str_replace($var->find_replace,$var->replace,$read_template);
					
					$addOnTemplate = fwrite($open_template,$template_content);
					
					}
					
					}
					
					
			} # End While 
			
			if($Sql_Insert){
		
						echo '<div class="green">'.$lang["alert_ok"].'</div>';
						echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
						}else{
						
						echo '<div class="red">'.$lang["alert_error"].'</div>';	
						echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
						
						}
				}	
		}
		
		public function deleteAll($directory, $empty = false) {
		if(substr($directory,-1) == "/") {
			$directory = substr($directory,0,-1);
		}
	
		if(!file_exists($directory) || !is_dir($directory)) {
			return false;
		} elseif(!is_readable($directory)) {
			return false;
		} else {
			$directoryHandle = opendir($directory);
		   
			while ($contents = readdir($directoryHandle)) {
				if($contents != '.' && $contents != '..') {
					$path = $directory . "/" . $contents;
				   
					if(is_dir($path)) {
					   $this->deleteAll($path);
					} else {
						unlink($path);
					}
				}
			}
		   
			closedir($directoryHandle);
	
			if($empty == false) {
				if(!rmdir($directory)) {
					return false;
				}
			}
		   
			return true;
		}
	}
	 
	public function ShowStyles(){
		
		global $eaf,$lang;
		
		$sql = $eaf->db->dbselect($this->start_tabel.$this->tabel,"","","");	
		
		$fshow = '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">';
		
		$fshow.= '<tr>
		<td class="ttable">'.$lang["ID"].'</td>
		<td class="ttable">'.$lang["styles_name"].'</td>
		<td class="ttable">'.$lang["styles_folder"].'</td>
		<td class="ttable">'.$lang["styles_actived"].'</td>
		<td class="ttable">'.$lang["styles_templates"].'</td>
		<td class="ttable">'.$lang["edit"].'</td>
		<td class="ttable">'.$lang["delete"].'</td>
		</tr>
		';
		
		while($rows = $eaf->db->dbrows($sql)){
			
			$fshow.='<tr>';
			$fshow.='<td>'.$rows['style_id'].'</td>';
			$fshow.='<td>'.$rows['style_name'].'</td>';
			$fshow.='<td>'.$rows['style_folder'].'</td>';
			
			if($rows['style_select'] == 1){$fshow.='<td>'.$lang["styles_isactived"].'</td>';}else{$fshow.='<td>'.$lang["styles_isunatvied"].'</td>';}
				$fshow.='<td><a href="styles.php?action=templates_style&style_id='.$rows['style_id'].'"><img src="icons/view.png" border="0px" /></a></td>';
				$fshow.='<td><a href="styles.php?action=edit_style&style_id='.$rows['style_id'].'"><img src="icons/edit.png" border="0px" /></a></td>';
				$fshow.='<td><a href="styles.php?action=delete_style&style_id='.$rows['style_id'].'"><img src="icons/recy.png" border="0px" /></a></td>';
				$fshow.='</tr>';
			}
			
			$fshow.='</table>';
		
			return $fshow;
		
		}
		
		public function DeleteStyle(){
			
			global $eaf,$lang;
			
			$this->style_id = abs(intval(trim($eaf->_REQUEST['style_id'])));
			
			$sid 			= $this->style_id;
			
			$Sql_Search_Style = $eaf->db->dbselect($this->start_tabel.$this->tabel,"style_id=".$sid,"","");
			
			$rows = $eaf->db->dbrows($Sql_Search_Style);
			
			if($eaf->db->dbnum($Sql_Search_Style) == 0){
			
				echo '<div class="red">'.$lang["styles_notexists"].'</div>';	
			
				echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			
			}else{
			   
			   if ($dh = opendir('../includes/cache/'.$rows_styles['style_folder'])) {
				  
					while (($file = readdir($dh)) !== false) {
						
						if(!empty($file)){
							
							if(file_exists('../includes/cache/'.$rows['style_folder']. '/' .$file)) {
						
								@unlink('../includes/cache/'.$rows['style_folder']. '/' .$file);
							
							}
						}
					}
				
					@closedir($dh);
				
				}
				
				if(is_dir('../includes/cache/'.$rows['style_folder'])){
			
					@rmdir('../includes/cache/'.$rows['style_folder']);
				
				}
				
				if(is_dir('../styles/'.$rows_styles['style_folder'])){
				
					$this->deleteAll('../styles/'.$rows['style_folder']);
				}
				
				$Delete_Style = $eaf->db->query("delete from " . $this->start_tabel.$this->tabel . " WHERE style_id=".$sid);
			
				if($Delete_Style){
					
					echo '<div class="green">'.$lang["alert_ok"].'</div>';
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
							
				}else{
							
					echo '<div class="red">'.$lang["alert_error"].'</div>';	
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
							
				}
			
			}
	
	}
	
	public function EditStyleForm(){
		
		global $eaf,$lang;
		
		$sid = intval(trim($eaf->_REQUEST['style_id']));
		
		$Sql_Search_Style = $eaf->db->query("select * from ".$this->start_tabel.$this->tabel . " where style_id=".$sid);
		
		if($eaf->db->dbnum($Sql_Search_Style) == 0){
		
			echo '<div class="red">'.$lang["styles_notexists"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
			$rows = $eaf->db->dbrows($Sql_Search_Style);
			$eform = '
					<form name="edit_smile" method="post">
					<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
					<tr>
					<td class="ttable" colspan="2">'.$lang["styles_addstyle"].'</td>
					</tr>
					<tr>
					<td>'.$lang["styles_name"].'</td>
					<td><input type="text" value="'.$rows['style_name'].'" name="name" /></td>
					</tr>
					<tr>
					<td>'.$lang["styles_folder"].'</td>
					<td><input type="" value="'.$rows['style_folder'].'" name="folder" /></td>
					</tr>
					<tr>
					<td>'.$lang["styles_active"].'</td>
					<td>
					<select name="do">';
					
					// S_S
					if($rows['style_select'] == 1){$eform.='<option value="1" selected="selected">نعم</option>';}else{$eform.='<option value="1">'.$lang["yes"].'</option>';}
					// S_S
					if($rows['style_select'] == 0){$eform.='<option value="0" selected="selected">لا</option>';}else{$eform.='<option value="0">'.$lang["no"].'</option>';}
					
					$eform.='
					</select>
					</td>
					</tr>
					<tr>
					<td>'.$lang["post"].'</td>
					<td><input type="submit" value="'.$lang["edit"].'" name="editstyle" /></td>
					</tr>
					</table>
					</form>';
		
			return $eform;
		
		}
	
	}
	
	public function EditStylePost(){
		
		global $eaf,$lang;
		
		$this->style_id = abs(intval(trim($eaf->_REQUEST['style_id'])));
		
		$sid 			= $this->style_id;
		
		if(isset($eaf->_POST['editstyle'])){
			
			$name = $eaf->security->svar($eaf->_POST['name']);
			
			$folder = $eaf->security->svar($eaf->_POST['folder']);
			
			$do = $eaf->security->sint($eaf->_POST['do']);
			
			if(empty($name) or empty($folder)){
				
				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');	echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
			
			}else{
			
				$sql_update = $eaf->db->query("UPDATE ".$this->start_tabel.$this->tabel." SET style_name='$name',style_folder='$folder',style_select='$do' WHERE style_id=$sid");
				
				if($sql_update){
			
					echo '<div class="green">'.$lang["alert_ok"].'</div>';
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
							
				}else{
							
					echo '<div class="red">'.$lang["alert_error"].'</div>';	
					echo '<meta http-equiv="refresh" content="1;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />';
							
				}
		
			}
		
		}
		
	}
	
	public function StyleTemplates(){
		
		global $eaf,$lang;
		
		$sid = intval(trim($eaf->_REQUEST['style_id']));
		
		$Sql_Search_Style = $eaf->db->query("select * from ".$this->start_tabel.$this->tabel . " where style_id=".$sid);
		
		$rows_styles			 = $eaf->db->dbrows($Sql_Search_Style);
		
		if(!is_writeable('../styles/'.$rows_styles['style_folder'].'/templates')){
		
			chmod('../styles/'.$rows_styles['style_folder'].'/templates',0777);	
		
		}
		
		if($eaf->db->dbnum($Sql_Search_Style) == 0){
		
			echo '<div class="red">'.$lang["styles_notexists"].'</div>';	
			echo '<meta http-equiv="refresh" content="1;URL='.$_SERVER['HTTP_REFERER'].'" />';
		
		}else{
			
			echo '<table cellpadding="0" cellspacing="0" border="0" width="97%" align="center">';
			echo '
			<tr>
			<td class="ttable">'.$lang["styles_selectTemplate"].'</td>
			</tr>
			<tr>
			<td>
			';
		
			echo '<select id="select_style" onchange="return editstyle(this.value,'.$sid.');">';
			echo '<option>'.$lang["styles_stemp"].'</option>';
		   
		   if ($dh = opendir('../styles/'.$rows_styles['style_folder'].'/templates')) {
				while (($file = readdir($dh)) !== false) {
				$file = str_replace('.','',$file);
				$file = str_replace('..','',$file);
				$file = str_replace('html','.html',$file);
				$file = str_replace("indexhtm","",$file);
				$file = str_replace("index","",$file);
				$tpname		 = strip_tags($eaf->_REQUEST['tname']);
				if(!empty($file)){
				if($file == $tpname){
						echo '<option value="'.$file.'"selected="selected">'.$file.'</option>';
						echo "\n";
					}else{
						echo '<option value="'.$file.'">'.$file.'</option>';
						echo "\n";
					}
					
				}
			}
				closedir($dh);
			}
	
			echo '</select>';
			echo '</td>
			</tr>
			</table>
			';
		}
		
	}
	
	public function StyleTemplateEdit(){
		
		global $eaf,$lang;
		
		$sid = intval(trim($eaf->_REQUEST['style_id']));
		
		$Sql_Search_Style = $eaf->db->query("select * from ".$this->start_tabel.$this->tabel . " where style_id=".$sid);
		
		$rows_styles			 = $eaf->db->dbrows($Sql_Search_Style);
		
		$tpl_name		 = strip_tags($eaf->_REQUEST['tname']);
		
			if(!isset($eaf->_POST['edit_temp'])){
			
				$Content = file_get_contents('../styles/'.$rows_styles['style_folder'].'/templates/'.$tpl_name);
				$Content = str_replace('>','&gt;',$Content);
				$Content = str_replace('<','&lt;',$Content);
				
				print "<form method=\"post\">\n
				<table cellpadding=\"0\" height=\"82%\" cellspacing=\"0\" width=\"97%\" align=\"center\">\n";
				
				print "<tr>\n<td class=\"ttable\" height=\"5%\">$tpl_name</td>\n</tr>\n";
				
				print "<tr>\n<td><textarea name=\"content\" style=\"width:99%;height:80%;\" dir=\"ltr\">$Content</textarea>
				<p>	<center><input type=\"submit\" name=\"edit_temp\" value=\"".$lang["edit"]."\" />\n</p>
				</td>\n</tr>\n";
				
				print "</table>\n";
				print "</form>\n";
		
			}else{
				
				$Content = $eaf->_POST['content']; 
				$Content = str_replace("\'","'",$Content);
				$Content = str_replace('"','"',$Content);
				$Content = str_replace('&gt;','>',$Content);
				$Content = str_replace('&lt;','<',$Content);
				
				if(!is_writeable('../styles/'.$rows_styles['style_folder'].'/templates/'.$tpl_name)){
					
					chmod('../styles/'.$rows_styles['style_folder'].'/templates/'.$tpl_name,0755);	
				}
				
				$Edit = file_put_contents('../styles/'.$rows_styles['style_folder'].'/templates/'.$tpl_name,$Content);
				
				if($Edit){
				
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
