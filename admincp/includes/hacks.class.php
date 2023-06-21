<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class AForumHacks{	
private $block_id;
public function __construct(){
	
	global $eaf;
	
	$this->block_id = abs(intval($eaf->_REQUEST['block_id']));
}
public function addform($action){
global $eaf,$lang;
$this->addform = '
<div id=\"msg\"></div>
<form name=\"addblock\" method=\"post\" action=\"'.$action.'\" enctype=\"multipart/form-data\">
<table cellpadding=\"0\" cellspacing=\"0\" width=\"95%\">
<tr>
<td>'.$lang["hooks_file"].'</td>
<td><input class=\"file\" type=\"file\" name=\"file\" id=\"one\" /></td>
</tr>
<tr>
<td>'.$lang["post"].'</td>
<td><input type=\"submit\" name=\"post\"  onclick=\"return accessempty();\" value=\"'.$lang["add"].'\" /></td>
</tr>
</table>
</form>';
return $this->addform;
# end add form function
}
	private function _Mysql($Sql){
			 global $eaf,$lang;
			 
		     set_time_limit(900);
             $w = 1;
             $cur_sql = '';
             $sql_file = $eaf->_explode("\n",$Sql);
             foreach ($sql_file as $v) {

                 $sql = trim($v);
                 
                 if ($sql[0] == '-') {
                     continue;
                 }
                 
                 if (!$sql) {
                     continue;
                 }
                 
                 $cur_sql .= $sql . ' ';
                 if (substr($sql, -1, 1) == ';') {
                     $sql_statements[] = substr(trim($cur_sql), 0, -1);
                     $cur_sql          = '';
                 }
             }

             if (count($sql_statements)) {
                 foreach ($sql_statements as $k => $v) {
				 
                     if (!$eaf->db->query($v)) {
                         $wrong = mysql_error();
                         $ww    = $w++;
                         $xxx .= "$ww => $wrong in [$v]\n\n";
                         print $xxx;
                     }
                 }
 
            }	
	}
public function addblock(){
global $eaf,$lang;
$tmpname =  $_FILES['file']['tmp_name'];
$filedir =  $_FILES['file']['name'];
$type = strrchr($filedir,'.');
if($type !== ".xml"){
echo '<div class=\"red\">'.$lang["hooks_type"].'</div>';
echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
return false;
}
if(file_exists("../includes/hacks/".$filedir)){
echo '<div class=\"red\">'.$lang["hooks_exists"].'</div>';
echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
return false;
}
$xml = $eaf->_loadxml($tmpname);
$title = $xml->title;
$control= $xml->control;
$find  = "<!-- ".$xml->find." !-->";
$sql_do  = $xml->install->mysql;
$MysqlQuery = $this->_Mysql($sql_do);
	$code = '<?xml version=\"1.0\" encoding=\"utf-8\"?>
<note>

<find>'.$xml->find.'</find>
<uninstall>
<mysql><![CDATA['.$xml->unsql.']]></mysql>
</uninstall>
';
	foreach($xml->template as $kay => $var){
		
		$code .= "<template name='".$var['name']."'>";
		
	if(!empty($var->edit) and $var->edit['do'] == "up"){
			$sql_styles = $eaf->db->query("SELECT * FROM " .tablenamestart("styles"). "");
			while($rows = $eaf->db->dbrows($sql_styles)){
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
			$template_content = $find.$var->edit.$read_template;
			$addOnTemplate = fwrite($open_template,$template_content);
			}
			
			$code .= '<edit do=\"up\"><![CDATA['.$var->edit."]]></edit>";
			
	}
	if(!empty($var->edit) and $var->edit['do'] == "down"){
			$sql_styles = $eaf->db->query("SELECT * FROM " .tablenamestart("styles"). "");
			while($rows = $eaf->db->dbrows($sql_styles)){
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
			$template_content = $read_template.$find.$var->edit;
			
			$addOnTemplate = fwrite($open_template,$template_content);
			}
			$code .= '<edit do=\"down\"><![CDATA['.$var->edit."]]></edit>";
	        }
			if(!empty($var->find_replace)){
			$sql_styles = $eaf->db->query("SELECT * FROM " .tablenamestart("styles"). "");
			while($rows = $eaf->db->dbrows($sql_styles)){
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
			$template_content = str_replace($var->find_replace,$var->replace,$read_template);
			
			$addOnTemplate = fwrite($open_template,$template_content);
			}
			$code .= "<replace><![CDATA[".$var->find_replace."]]></replace>";
			$code .= "<find_replace><![CDATA[".$var->replace."]]></find_replace>";
	        }
			$code .= "</template>";
			}
$code .= '

</note>';
$uninstall_dir = fopen("../includes/hacks/uninstall/".$filedir,w);
$uninstall_op  = fwrite($uninstall_dir,$code);
$install_dir   = file_get_contents($tmpname);
$install_op    = file_put_contents("../includes/hacks/".$filedir,$install_dir);
$control = str_replace("'","{qt}",$control);
$control = str_replace('"',"{dq}",$control);
$insert_query = $eaf->db->query("INSERT INTO `phpforyou_hacks` VALUES ('','$title','$sql_do','$control','$filedir','0','$xml->other','$xml->ver','$xml->url')")or die(mysql_error());
if($insert_query){
				echo '<div class=\"green\">'.$lang["alert_ok"].'</div>';
				#echo '<meta http-equiv=\"refresh\" content=\"1;URL=hacks.php\" />';
				
				}else{
				
				echo '<div class=\"red\">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}
}

	public function DeleteBlock(){

	global $eaf,$lang;
	
	$FindQuery = $eaf->db->query("SELECT * FROM phpforyou_hacks WHERE block_id=$this->block_id");

	$rows = $eaf->db->dbrows($FindQuery);
	
	$xml = $eaf->_loadxml("../includes/hacks/uninstall/".$rows['filedir']);
		
	$sql_do  = $xml->uninstall->mysql;

	$MysqlQuery = mysql_query($sql_do);	

	foreach($xml->template as $kay => $var){
	
	if(!empty($var->edit) and $var->edit['do'] == "up"){
		
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
	
			while($rows = $eaf->db->dbrows($sql_styles)){
	
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
	
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
	
			$template_content = str_replace($var->edit,"",$read_template);
	
			$template_content = str_replace("<!-- ".$xml->find." !-->","",$template_content);
	
			$addOnTemplate = @fwrite($open_template,$template_content);
	
			}
	
	}
	
	if(!empty($var->edit) and $var->edit['do'] == "down"){
	
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
	
			while($rows = $eaf->db->dbrows($sql_styles)){
	
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
	
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
	
			$template_content = str_replace($var->edit,"",$read_template);
	
			$template_content = str_replace("<!-- ".$xml->find." !-->","",$template_content);
	
			$addOnTemplate = fwrite($open_template,$template_content);
	
			}
	
	        }
	
			if(!empty($var->find_replace)){
	
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
	
			while($rows = $eaf->db->dbrows($sql_styles)){
	
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
	
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
	
			$template_content = str_replace($var->find_replace,$var->replace,$read_template);
	
			$addOnTemplate = fwrite($open_template,$template_content);
	
			}
	
	        }
	
			}
			

	$FileRows = $eaf->db->dbrows($eaf->db->query("SELECT filedir FROM phpforyou_hacks WHERE block_id=$this->block_id"));

	$DeleteUnFile = unlink("../includes/hacks/uninstall/".$FileRows['filedir']);


	$DeleteFile   = unlink("../includes/hacks/".$FileRows['filedir']);


	$delete_query = $eaf->db->query("DELETE FROM phpforyou_hacks WHERE block_id = $this->block_id");


	if($delete_query){
				
				echo '<div class=\"green\">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}else{
				
				echo '<div class=\"red\">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}

# end delete function

}
	
	public function UnActiveHack(){

	global $eaf,$lang;

	$this->block_id = abs(intval($eaf->_REQUEST['block_id']));

	$find_query = $eaf->db->query("SELECT * FROM phpforyou_hacks WHERE block_id=$this->block_id");

	if($eaf->db->dbnum($find_query) == 0){
		
		echo'<div class=\"red\">'.$lang["hooks_notexists"].'<div>'; 
		
		echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
		
		return false;
		
		}

	$rows = $eaf->db->dbrows($find_query);

	$xml = $eaf->_loadxml("../includes/hacks/uninstall/".$rows['filedir']);

	if($rows['is_actived'] == 1){
		
		echo'<div class=\"red\">'.$lang["hooks_isunactived"].'<div>'; 
	
		echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
		
		return false;	
	}

	$file_dir = $rows['filedir'];
	
	foreach($xml->template as $kay => $var){
	
	if(!empty($var->edit) and $var->edit['do'] == "up"){
	
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
	
			while($rows = $eaf->db->dbrows($sql_styles)){
	
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
	
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
	
			$template_content = str_replace($var->edit,"",$read_template);
	
			$template_content = str_replace("<!-- ".$var->find." !-->","",$template_content);
	
			$addOnTemplate = fwrite($open_template,$template_content);
	
			}
	
	}
	
	if(!empty($var->edit) and $var->edit['do'] == "down"){
	
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
	
			while($rows = $eaf->db->dbrows($sql_styles)){
	
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
	
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
	
			$template_content = str_replace($var->edit,"",$read_template);
	
			$template_content = str_replace("<!-- ".$var->find." !-->","",$template_content);
	
			$addOnTemplate = fwrite($open_template,$template_content);
	
			}
	
	        }
	
			if(!empty($var->find_replace)){
	
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
	
			while($rows = $eaf->db->dbrows($sql_styles)){
	
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
	
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
	
			$template_content = str_replace($var->find_replace,$var->replace,$read_template);
	
			$addOnTemplate = fwrite($open_template,$template_content);
	
			}
	
	        }
	
			}

		$unactive = $eaf->db->query("UPDATE ". tablenamestart("hacks") ." SET is_actived='1' WHERE block_id=".$this->block_id);

		if($unactive){

				echo '<div class=\"green\">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}else{
				
				echo '<div class=\"red\">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}
# end active function 
	
	}

	public function ActiveHack(){

		global $eaf,$lang;

		$this->block_id = abs(intval($eaf->_REQUEST['block_id']));

		$find_query = $eaf->db->query("SELECT * FROM phpforyou_hacks WHERE block_id=$this->block_id");
		
		if($eaf->db->dbnum($find_query) == 0){
			
			echo'<div class=\"red\">'.$lang["hooks_notexists"].'<div>'; 
			
			echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
			
			return false;
			
			}

		$rows = $eaf->db->dbrows($find_query);

		if($rows['is_actived'] == 0){
			
		echo'<div class=\"red\">'.$lang["hooks_isactived"].'<div>'; 
	
		echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
		
		return false;
		
		}

		$xml = $eaf->_loadxml("../includes/hacks/".$rows['filedir']);

		$title = $xml->title;

		$control= $xml->control;

		$find  = "<!-- ".$xml->find." !-->";
	
		foreach($xml->template as $kay => $var){

			if(!empty($var->edit) and $var->edit['do'] == "up"){
		
				$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
				
				while($rows = $eaf->db->dbrows($sql_styles)){
			
				$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
			
				$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
			
				$template_content = $find.$var->edit.$read_template;
			
				$addOnTemplate = fwrite($open_template,$template_content);
			
				}
	
		}
	
		if(!empty($var->edit) and $var->edit['do'] == "down"){
	
				$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
		
				while($rows = $eaf->db->dbrows($sql_styles)){
			
				$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
			
				$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
				
				$template_content = $read_template.$find.$var->edit;
			
				$addOnTemplate = fwrite($open_template,$template_content);
			
				}
	       	 }
			
			if(!empty($var->find_replace)){
			
			$sql_styles = $eaf->db->query("SELECT * FROM ".tablenamestart("styles")."");
			
			while($rows = $eaf->db->dbrows($sql_styles)){
			
			$read_template = file_get_contents("../styles/".$rows['style_folder']."/templates/".$var['name']);
			
			$open_template = fopen("../styles/".$rows['style_folder']."/templates/".$var['name'],'w');
			
			$template_content = str_replace($var->find_replace,$var->replace,$read_template);
			
			$addOnTemplate = fwrite($open_template,$template_content);
			
			}
	        
			}
			
			}

	$active = $eaf->db->query("UPDATE ". tablenamestart("hacks") ." SET is_actived='0' WHERE block_id=".$this->block_id);

		if($active){
				
				echo '<div class=\"green\">'.$lang["alert_ok"].'</div>';
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}else{
				
				echo '<div class=\"red\">'.$lang["alert_error"].'</div>';	
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$eaf->_SERVER['HTTP_REFERER'].'\" />';
				
				}
# end unactive function
	
	}

	public function ShowBlocks($editlink,$deltlink,$addlink){

		global $eaf,$lang;

		$this->SqlBlocks = $eaf->db->query("SELECT * FROM phpforyou_hacks");

		$this->TotalBlocks = $eaf->db->dbnum($this->SqlBlocks);

		if($this->TotalBlocks == 0){
			
			echo '<div class=\"red\">'.$lang["hooks_nohooks"].' | <strong><a href=\"'.$addlink.'\">'.$lang["hooks_add"].'</a></strong></div>';
			
			return false;
			
			}

	echo '

	<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"97%\" align=\"center\">

	<tr>

	<td class=\"ttable\">'.$lang["hooks_name"].'</td>

	<td class=\"ttable\">'.$lang["hooks_vrs"].'</td>

	<td class=\"ttable\">'.$lang["hooks_website"].'</td>

	<td class=\"ttable\">'.$lang["hooks_more"].'</td>

	<td class=\"ttable\">'.$lang["hooks_do"].'</td>

	<td class=\"ttable\">'.$lang["hooks_export"].'</td>

	<td class=\"ttable\">'.$lang["hooks_delete"].'</td>

	</tr>';

	while($this->RowsBlocks = $eaf->db->dbrows($this->SqlBlocks)){

	echo '

	<tr>

	<td>'.$this->RowsBlocks['block_title'].'</td>

	<td>'.$this->RowsBlocks['hack_ver'].'</td>

	<td>'.$this->RowsBlocks['hack_url'].'</td>

	<td>'.$this->RowsBlocks['hack_other'].'</td>

	<td>';

	if($this->RowsBlocks['is_actived'] == 0){

	echo '<a href=\"hacks.php?action=unactive&block_id='.$this->RowsBlocks['block_id'].'\"><img src=\"icons/remove.png\" title=\"'.$lang["hooks_unactive"].'\" border=\"0px\" /></a>';

	}else{

	echo '<a href=\"hacks.php?action=active&block_id='.$this->RowsBlocks['block_id'].'\"><img src=\"icons/activ.png\" title=\"'.$lang["hooks_active"].'\" border=\"0px\" /></a>';	

	}

	echo '<td><a href="../includes/hacks/'.$this->RowsBlocks['filedir'].'\"><img src=\"icons/export.png\" border=\"0px\" /></a></td>

	<td><a href=\"'.$deltlink.'&block_id='.$this->RowsBlocks['block_id'].'\"><img src=\"icons/recy.png\" border=\"0px\" /></a></td>

	</tr>';

	}
	
	echo '

	</table>

	';

	echo '<div align=\"center\"> <strong><a href=\"'.$addlink.'\">'.$lang["hooks_add"].'</a></strong></div>';

	# end show function

	}
# end class

	}

	?>
