<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

	
	function GoBack(){
	
		if(!eregi("action=",$_SERVER['HTTP_REFERER']) && !eregi("index.php?action",$_SERVER['HTTP_REFERER'])){
		
			$back = "index.php";
				
		}else{

			$back = $_SERVER['HTTP_REFERER'];

		}		
		
		return $back;
	}

	function FunctionsSqlRows(){
	
	global $eaf,$lang;

	$Sql  = $eaf->db->dbselect(tablenamestart('infosite'),"","","");

	$Rows =  $eaf->db->dbrows($Sql);
	
	return $Rows;
			
	}
	
	function GetStylesList(){
		
		global $eaf,$lang;
		
		$Style = "\n";
		
		$Query = $eaf->db->query("select style_id,style_name from " . tablenamestart("styles") . " where style_select = 1");	
		
		while($Rows = $eaf->db->_object($Query)){
			
			$Style .= "<option value=\"$Rows->style_id\">$Rows->style_name</option>\n";	
		}
		
		return $Style;
	}
	
	function SelectStyleMenu(){

	global $eaf,$lang;

	$Query_Styles = $eaf->db->query("SELECT * FROM " . tablenamestart('styles') ." WHERE style_select='1'");

	$menu = '<select name="folder" onchange="reStyle(this.value);">';

	$menu .= '<option value="">'.$lang["select_style"].'</option>';

	while($rows =  $eaf->db->dbrows($Query_Styles)){

	$info  = array($rows['style_folder'],$rows['style_name'],$rows['style_id']);

	$menu .='<option value="'.$info[2].'"> -- '.$info[1].'</option>';

	}

	$menu .='</select>';

	return $menu;

	}

	function JumpMenu(){

	global $eaf,$lang;

	$sql_sections = $eaf->db->dbselect(tablenamestart('sections'),'sort = 0','','');

	$select =  '<select name="menu" onChange="return jump(this.value)">';
	
	$select .= '<option>'.$lang["fast_menu"].'</option>
	
	';

	$select .= '<option value="?home">'.$lang["home"].'</option>
	
	';

	$select .= '<option value="?action=usercp">'.$lang["usercp"].'</option>
	
	';

	$select .= '<option value="?action=search">'.$lang["search"].'</option>
	
	';

	$select .= '<optgroup label="'.$lang["forums"].'">
	
	';

	while($rows =  $eaf->db->dbrows($sql_sections)){
		
		$select.='<option value="?action=forum&fid='.$rows['fid'].'" style="margin-top:5px;"> » '.$rows['name'].'</option>
		
		';	
		
			$sections_sort = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rows['fid']);
		
			while($sort = $eaf->db->dbrows($sections_sort)){
			
				$select.='<option value="?action=forum&fid='.$sort['fid'].'"> »» '.$sort['name'].'</option>
				
				';
			
					$sections_more = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$sort['fid']);
				
				while($more = $eaf->db->dbrows($sections_more)){
					
					$select.='<option value="?action=forum&fid='.$more['fid'].'"> »»» '.$more['name'].'</option>
					
					';
					
						$sections_x = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$more['fid']);
						
						while($rowsx = $eaf->db->dbrows($sections_x)){
							
							$select.='<option value="?action=forum&fid='.$rowsx['fid'].'"> »»»» '.$rowsx['name'].'</option>
							
							';
								
								$sections_v = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowsx['fid']);
									
									while($rowsv = $eaf->db->dbrows($sections_v)){
									
										$select.='<option value="?action=forum&fid='.$rowsv['fid'].'"> »»»»» '.$rowsv['name'].'</option>
										
										';
									
											$sections_t = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowsv['fid']);
									
												while($rowst = $eaf->db->dbrows($sections_t)){
									
										
												$select.='<option value="?action=forum&fid='.$rowst['fid'].'"> »»»»»» '.$rowst['name'].'</option>
											
												';
									}
							}
					}
			}
		}
		
	}

	$select.='</select>';

	return $select;

	}
	
	function ForumsList($Displayed = true){
		
	global $eaf,$lang;
	
	$select = "";
	
	$sql_sections = $eaf->db->query("select fid,name from " . tablenamestart('sections') . " where sort = 0");
		
		while($Rows =  $eaf->db->dbrows($sql_sections)){
		
		$select.='<option value="'.$Rows['fid'].'" '; if($Displayed == true){ $select .= ' disabled="disabled"'; } $select .= '> |» '.$Rows['name'].'</option>
		
		';	
		
			$sections_sort = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$Rows['fid']);
		
			while($sort = $eaf->db->dbrows($sections_sort)){
			
				$select.='<option value="'.$sort['fid'].'"> |»» '.$sort['name'].'</option>
				
				';
			
					$sections_more = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$sort['fid']);
				
				while($more = $eaf->db->dbrows($sections_more)){
					
					$select.='<option value="'.$more['fid'].'"> |»»» '.$more['name'].'</option>
					
					';
					
						$sections_x = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$more['fid']);
						
						while($rowsx = $eaf->db->dbrows($sections_x)){
							
							$select.='<option value="'.$rowsx['fid'].'"> |»»»» '.$rowsx['name'].'</option>
							
							';
								
								$sections_v = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowsx['fid']);
									
									while($rowsv = $eaf->db->dbrows($sections_v)){
									
										$select.='<option value="'.$rowsv['fid'].'"> |»»»»» '.$rowsv['name'].'</option>
										
										';
									
											$sections_t = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowsv['fid']);
									
												while($rowst = $eaf->db->dbrows($sections_t)){
									
										
												$select.='<option value="'.$rowst['fid'].'"> |»»»»»» '.$rowst['name'].'</option>
											
												';
												
												$sections_u = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowst['fid']);
									
												while($rowsu = $eaf->db->dbrows($sections_u)){
										
												$select.='<option value="'.$rowsu['fid'].'"> |»»»»»»» '.$rowsu['name'].'</option>
											
												';
											}
									}
							}
					}
			}
		}
		
	}

	return $select;
	
	}
	
	function ForumsMenu(){
		
	global $eaf,$lang;
	
	$select = "";
	
	$sql_sections = $eaf->db->query("select fid,name from " . tablenamestart('sections') . " where sort = 0");
		
		while($rows =  $eaf->db->dbrows($sql_sections)){
		
		$select.='<p style="margin:0px;" class="forumsMenuSection"><a href="?action=forum&fid='.$rows['fid'].'" style="margin-top:5px;"> » '.$rows['name'].'</a></p>
		
		';	
		
			$sections_sort = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rows['fid']);
		
			while($sort = $eaf->db->dbrows($sections_sort)){
			
				$select.='<p style="margin:0px;" class="forumsMenuSort"><a href="?action=forum&fid='.$sort['fid'].'"> »» '.$sort['name'].'</a></p>
				
				';
			
					$sections_more = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$sort['fid']);
				
				while($more = $eaf->db->dbrows($sections_more)){
					
					$select.='<p style="margin:0px;" class="forumsMenuSort"> <a href="?action=forum&fid='.$more['fid'].'"> »»» '.$more['name'].'</a></p>
					
					';
					
						$sections_x = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$more['fid']);
						
						while($rowsx = $eaf->db->dbrows($sections_x)){
							
							$select.='<p style="margin:0px;" class="forumsMenuSort"><a href="?action=forum&fid='.$rowsx['fid'].'"> »»»» '.$rowsx['name'].'</a></p>
							
							';
								
								$sections_v = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowsx['fid']);
									
									while($rowsv = $eaf->db->dbrows($sections_v)){
									
										$select.='<p style="margin:0px;" class="forumsMenuSort"><a href="?action=forum&fid='.$rowsv['fid'].'"> »»»»» '.$rowsv['name'].'</a></p>
										
										';
									
											$sections_t = $eaf->db->query("select * from " . tablenamestart('sections') . "  where sort=".$rowsv['fid']);
									
												while($rowst = $eaf->db->dbrows($sections_t)){
									
										
												$select.='<p style="margin:0px;" class="forumsMenuSort"><a href="?action=forum&fid='.$rowst['fid'].'"> »»»»»» '.$rowst['name'].'</a></p>
											
												';
									}
							}
					}
			}
		}
	
		}
				
		return $select;
	}
	
	function GetGroupsList(){
		
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select style,name,title from " . tablenamestart("groups") );	
		
		$Get = "";
		
		while($Rows = $eaf->db->_object($Query)){
		
			$Get .= str_replace("{name}",$Rows->title,$Rows->style);
			$Get .= " , ";	
		}
		
		return $Get;
	}
	
	function GetPagesList(){
	
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select page_id,page_name from " . tablenamestart("pages") . " where page_active=0");	
		
		return $Query;
	}
	function GetUsernameStyle($uid){
		
		global $eaf,$lang;
		
		$Query  = $eaf->db->query("select groupid,moder_gid,username,uid from members where uid = $uid");
		
		$Rows   = $eaf->db->_object($Query);
		
		if(empty($Rows->moder_gid))
		
		$GetGroup = $eaf->db->_object($eaf->db->query("select style from " . tablenamestart("groups") . " where id = " . $Rows->groupid));
		
		else
		
		$GetGroup = $eaf->db->_object($eaf->db->query("select style from " . tablenamestart("groups") . " where id = " . $Rows->moder_gid));
		
		return str_replace("{name}",$Rows->username,$GetGroup->style);
	}
	
	function GetModers($Id){
		
		global $eaf,$lang;
		
		if(empty($Id)) $Id = intval(abs($eaf->_REQUEST['fid']));
		
		$Link = "";
		
		$ModersQuery = $eaf->db->query("select * from ". tablenamestart("moderators") ." where section_id = $Id");
		
	if($eaf->db->dbnum($ModersQuery) !== 0){
		
		while($rows = $eaf->db->_object($ModersQuery)){
							
			$Link .=  '<span class="moders_list" style="margin-right:2px;">
			
					   <a href="?action=profile&uid='.$rows->user_id.'">'.GetUsernameStyle($rows->user_id) . '</a>
					   
					   </span>';
					   
			$Link .= " , \n";
		}
		
	}
		return $Link;
	}
	
	function GetTotalModers($Id){
		
		global $eaf,$lang;
		
		$Link = "";
		
		$ModersQuery = $eaf->db->query("select id from ". tablenamestart("moderators") ." where section_id = $Id");
		
		if($eaf->db->dbnum($ModersQuery) == 0){
	
			return false;
		
		}else{
		
			return true;	
		}
		
	}
	
	function GetLangFolder(){
		
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select lang_folder from " . tablenamestart("languages") . " where lang_id = " . GetSiteLanguage());
		
		$Rows  = $eaf->db->_object($Query);
		
		return $Rows->lang_folder;	
	}
	function is_moder(){
	
		global $eaf,$lang;

	$username = UserName();
	
	if(isset($username)){
		
		
		if(isset($eaf->_REQUEST['fid']) and !empty($eaf->_REQUEST['fid']) and is_numeric($eaf->_REQUEST['fid'])){
			
			$fid = intval(abs($eaf->_REQUEST['fid']));

			}
			
		
		if(isset($eaf->_REQUEST['tid']) and !empty($eaf->_REQUEST['tid']) and is_numeric($eaf->_REQUEST['tid'])){
			
			$tid = intval(abs($eaf->_REQUEST['tid']));
			
			$RowsGetTheard = $eaf->db->_object($eaf->db->query("select * from " . tablenamestart("topics") . " where tid = $tid"));
			
			$fid = intval(abs($RowsGetTheard->f_id));
			
			}
			
		if(isset($fid)){
			
		$Query = $eaf->db->query("select * from " . tablenamestart("moderators"). " where user_id = " . UserId() . " and section_id = " . $fid);
		
		if($eaf->db->dbnum($Query) == 0){
			
			return false;
			
		}else{
			
			return true;	
		}
		
		}
		
	}
	
	}

	function getModerFile($Fild){
	
		global $eaf,$lang;
		
		$Access = UserName();
		
		if(isset($Access)){
						
		if(isset($eaf->_REQUEST['fid']) and !empty($eaf->_REQUEST['fid']) and is_numeric($eaf->_REQUEST['fid'])){
			
			$fid = intval(abs($eaf->_REQUEST['fid']));

			}
			
		
		if(isset($eaf->_REQUEST['tid']) and !empty($eaf->_REQUEST['tid']) and is_numeric($eaf->_REQUEST['tid'])){
			
			$tid = intval(abs($eaf->_REQUEST['tid']));
						
			$RowsGetTheard = $eaf->db->_object($eaf->db->query("select f_id,tid from " . tablenamestart("topics") . " where tid = $tid"));
			
			$fid = intval(abs($RowsGetTheard->f_id));
			
			}
			
			$Table = tablenamestart("moderators");
			
			if(isset($fid)){
			
			$Query = $eaf->db->query("select `$Fild` from `$Table` where `user_id` = " . UserId() . " and `section_id` = " . $fid);
			
			$Rows = $eaf->db->dbrows($Query);
			
			return $Rows[$Fild];
			
			}else{
				
			return 0;
				
			}
		
		}else{
		
		   return 0;	
		}
	}
	function WONForum($Forumid){
		
		global $eaf;
	
		if(!empty($Forumid) and is_numeric($Forumid) and $Forumid !== 0) : 
		
				$Num =  $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("online") . " where f_id = $Forumid"));
				
				return $Num;
						
				endif;
	
	}
	function ForumName(){

	$Rows = FunctionsSqlRows();

	return $Rows['title'];

	}
	
	function ForumDec(){

	$Rows = FunctionsSqlRows();

	return $Rows['meta'];

	}
	

	function GetRegisterGroup(){

	$Rows = FunctionsSqlRows();

	return $Rows['register_group'];

	}
	

	function GetActviedGroup(){

	$Rows = FunctionsSqlRows();

	return $Rows['actived_group'];

	}
	
	function GetActiveDo(){

	$Rows = FunctionsSqlRows();

	return $Rows['active_do'];

	}

	function GetSiteEmail(){

	$Rows = FunctionsSqlRows();

	return $Rows['email'];

	}
	

	function GetSiteUrl(){

	$Rows = FunctionsSqlRows();

	return $Rows['url'];

	}

	function ForumMeta(){

	$Rows = FunctionsSqlRows();

	return $Rows['meta'];

	}

	function ForumCloseDo(){

	$Rows = FunctionsSqlRows();

	return $Rows['close_do'];
	
	}

	function ForumCloseMsg(){
	
	$Rows = FunctionsSqlRows();

	return $Rows['close_msg'];

	}

	function ForumStyle(){

	$Rows = FunctionsSqlRows();

	return $Rows['style_id'];

	}
	
	function GetStyleFolder(){

	global $eaf,$lang;

	$sql = $eaf->db->query("select * from ".tablenamestart('styles'). " where style_id=".ForumStyle());

	$Rows =  $eaf->db->dbrows($sql);

	return $Rows['style_folder'];

	}

	function GetPageNumForum(){

	$Rows = FunctionsSqlRows();

	return $Rows['page_forum'];

	}
	
	function GetPageNumPosts(){

	$Rows = FunctionsSqlRows();

	return $Rows['page_posts'];

	}

	function GetPageNumOnline(){

	$Rows = FunctionsSqlRows();

	return $Rows['page_online'];

	}
	
	function GetPageNumMembers(){

	$Rows = FunctionsSqlRows();

	return $Rows['page_members'];

	}

	function GetPageNumAttachments(){

	$Rows = FunctionsSqlRows();

	return $Rows['page_attachments'];

	}
	
	function GetFastPostDo(){

	$Rows = FunctionsSqlRows();

	return $Rows['post_fast'];

	}

	function GetSiteLanguage(){

	$Rows = FunctionsSqlRows();

	return $Rows['language'];

	}

	function GetHtmlPost(){

	$Rows = FunctionsSqlRows();

	return $Rows['post_html'];

	}

	function GetAttachmentsTypes(){

	$Rows = FunctionsSqlRows();

	return $Rows['types'];
	
	}

	function GetAttachmentsSize(){

	
	$Rows =   FunctionsSqlRows();
	
	return $Rows['attach_size'];
	
	}

	function GetAttachmentsDo(){

	$Rows = FunctionsSqlRows();
	
	return $Rows['attach_do'];

	}

	function GetPostIcon(){

	$Rows = FunctionsSqlRows();

	return $Rows['post_usicon'];

	}

	function GetUserPmDo(){

	$Rows = FunctionsSqlRows();

	return $Rows['user_pm'];

	}

	function GetUserTitleDo(){

	$Rows = FunctionsSqlRows();

	return $Rows['sig_title'];

	}

	function GetCatsIconDo(){
		
	$Rows = FunctionsSqlRows();
	
	return $Rows['cat_usicon'];

	}

	function GetMaxAvatarSizeW(){

	$Rows =   FunctionsSqlRows();
	
	return $Rows['wavatar'];

	}
	
	function GetMaxAvatarSizeH(){
	
	$Rows =   FunctionsSqlRows();

	return $Rows['havatar'];

	}

	function GetMaxIconSizeW(){

	$Rows = FunctionsSqlRows();
	
	return $Rows['wicon'];
	
	}

	function GetMaxIconSizeH(){
	
	$Rows =   FunctionsSqlRows();

	return $Rows['hicon'];
	
	}

	function ReplaceWordsDo(){
	
	$Rows = FunctionsSqlRows();

	return $Rows['replace_words'];
	
	}

	function GetMinPassDo(){

		$Rows = FunctionsSqlRows();
	
		return $Rows['sig_pass'];

	}

	function GetTopicsOrderBy(){

	$Rows = FunctionsSqlRows();

	return $Rows['topics_sort'];

	
	}
	
	function GetProtalOrderBy(){
	
	$Rows = FunctionsSqlRows();

	return $Rows['pblocks_order'];
			
	}

	function GetRegisterHtml(){

	$Rows = FunctionsSqlRows();
	
	return $Rows['sig_html'];
	
	}
	
	function LastUser(){

		global $eaf,$lang;
		
		$sql = $eaf->db->query("SELECT * FROM members ORDER BY uid DESC LIMIT 1");
		
		$rows= $eaf->db->dbrows($sql);
		
		return '<a href="?action=profile&uid='.$rows['uid'].'">' . $rows['username'] . '</a>';	

	}

	function TotalTopics(){
	
		global $eaf,$lang;
	
		$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('topics'));	
		
		$total = $eaf->db->dbnum($sql);
	
		return $total;

	}

	function TotalPosts(){
	
	global $eaf,$lang;

	$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('posts'));	

	$total = $eaf->db->dbnum($sql);

	return $total;	

	}

	function TotalUsers(){

	global $eaf,$lang;

	$sql   = $eaf->db->query("SELECT * FROM members");	

	$total = $eaf->db->dbnum($sql);
	
	return $total;	

	}

	function UserOnLine($uid){

	global $eaf,$lang;
	
	$username = UserName();
	
	if(isset($username)){

	$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('online') . " WHERE uid = $uid");

	if($eaf->db->dbnum($sql) == 1){

	return '<span class="online">'.$lang["online"].'</span>';
	
	}else{
 
 	   return '<span class="offline">'.$lang["offline"].'</span>';	

	}
	
	}

	}

	function UserId(){

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	$sql  =   $eaf->db->query("SELECT * FROM members WHERE username='".$_SESSION['username']."'");

	$rows =   $eaf->db->dbrows($sql);

	$_SESSION['user_id'] = $rows['uid'];

	if(!isset($_SESSION['user_id'])){

	session_destroy();
	
	}

	}	

	return $_SESSION['user_id'];

	}

	function UserName(){

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){
	
	return $_SESSION['username'];	
	
	}
	
	}
	
	function PassWord(){
	
	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){
	
	return $_SESSION['password'];	
	
	}

	}

	function GetUserName(){

	global $eaf,$lang;

	if(isset($_SESSION['username'])){

	$username = $_SESSION['username'];

	}

	return $username;

	}

	function GetUserid(){

	if(empty($_SESSION['user_id'])){

		return 0;

	}else{

		return $_SESSION['user_id'];	

	}

	}

	function UserGroup($userid,$fild){

	global $eaf,$lang;

	$query = $eaf->db->query("SELECT * FROM members WHERE uid=$userid");
	
	$total = $eaf->db->dbnum($query);
	
	$rows  = $eaf->db->dbrows($query);

	if($total == 0 and $userid != 0){
	
		return false;

	}else{

	
	if($userid == 0){
		
			$gid = 1;
	
	}else{
		
		    if(!empty($rows['moder_gid']) && $rows['moder_gid'] !== 0){
				
				$gid =  $rows['moder_gid'];	
			
			}else{
			
				$gid = $rows['groupid'];	
			}
	}
	
	$group = $eaf->db->query("SELECT * FROM " . tablenamestart('groups'). " WHERE id=$gid");	

	$row   = $eaf->db->dbrows($group);

	return $row[$fild];

	}
	
	}
	
function UserGroupID($userid){

	global $eaf,$lang;

	$query = $eaf->db->query("SELECT * FROM members WHERE uid=$userid");
	
	$total = $eaf->db->dbnum($query);
	
	$rows  = $eaf->db->dbrows($query);

	if($total == 0){
	
		return 1;

	}else{
		
		return $rows['groupid'];
	
	}
	
	}
	
	function addModerLogs($tid,$do){
		
		global $eaf,$lang;
		
		$uid = UserId();
		
		$time = time();
		
		$Find = $eaf->db->query("select id from " .tablenamestart("moderators") . " where user_id = $uid");
		
		if($eaf->db->dbnum($Find) !== 0){
		
		$Query = $eaf->db->query("insert into " . tablenamestart("moderlogs") . " values ('','$uid','$tid','$do','$time')");
				
		}
	}

	function Newpm(){
	
	global $eaf,$lang;
	
	$username = UserName();
	
	if(isset($username)){
	
	$query = $eaf->db->query("SELECT * FROM " . tablenamestart("pm") . " WHERE s_uid = " . UserId() . " AND sact='0'"); 
	
	$num   = $eaf->db->dbnum($query);	
		
	if($num == 0) return $num = "0"; else return $num;
	
	}

	}
	
	function GetDeleteAvatar(){

	$Rows = FunctionsSqlRows();

	return $Rows['delete_avatar'];

	}
	
	function GetMaxUpAvatarSize(){

	$Rows = FunctionsSqlRows();

	return $Rows['avatar_up_size'];

	}
	
	function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );

}


function email_check($email) 
{
    return( ereg('^[-./0-9A-Z^_`a-z~]+'.
                 '@'.
                 '([-0-9A-Z^_`a-z]{2,}\.){1,3}'.
                 '[-0-9A-Z^_`a-z]{2,3}$',
                 $email) );
} 

function getMemberInfo($uid , $in){
	
	global $eaf,$lang;

	if($in == "password"){ return false; }
	
	$sql = $eaf->db->query("SELECT $in FROM members WHERE uid = $uid");
	
	$rows= $eaf->db->dbrows($sql);
	
	return $rows[$in];
	
}
	
	function AvatarView($uid){

	global $eaf,$lang;

	$sql = $eaf->db->query("SELECT * FROM members WHERE uid = $uid");
	
	$rows= $eaf->db->dbrows($sql);
	
	if(empty($rows['avatar'])){
		
			$avatar = "images/avatar.png";
	
	}else{
		
			$avatar = $rows['avatar'];	
	
	}
	
	return(resizeimg($avatar,80,80));

	}
	
	function NewFriends(){
	
		global $eaf,$lang;

	$username = UserName();
	
	if(isset($username)){
		
		$query = $eaf->db->query("SELECT * FROM " . tablenamestart("friends"). " WHERE friend_uid = " . UserId() . " AND friend_active = 'no'");
		
		return $eaf->db->dbnum($query);	
		
	}
	
	}
	
	function WNew(){
	
		return NewFriends() + Newpm();	
	}
	
	function arabic_data(){
		
	$Rows =   FunctionsSqlRows();

	if(!empty($Rows["timetype"])){
		
		$data = date($Rows['datatype'] . " , " . $Rows["timetype"]);
	
	}else if(empty($Rows['datatype'])){
		
		$data = date("M d, Y");

	}else{

		$data = date($Rows['datatype']);

	}
	
	return $data;
	
	}
	
	
	function Date2Number($data){
		
	$days = array($theday.'السبت',$theday.'الأحد',$theday.'الأثنين',$theday.'الثلاثاء',$theday.'الأربعاء',$theday.'الخميس',$theday.'الجمعة');
	
	$data = str_replace($days,"",$data);

	$data = str_replace(" مساءً ","",$data);

	$data = str_replace(" صباحاً ","",$data);
	
	return $data;
	
	}


	function file_size($filedir){

	$file_size = $filedir;

	$file_size = $file_size /  1024;

	$file_size = intval(abs($file_size));

	if($file_size > 1000){

	$file_size = $file_size / 1000;

	$fsize	 = intval(abs($file_size));

	$fsize = $fsize." MB ";

	}else{

	$fsize = $file_size." KB ";

	}

	return $fsize;	

	}


 function arabic_only($txt){ 
	
		if(!empty($txt)){ 
	 
			if (!ereg("[a-zA-Z0-9[^+&*%#!{}?[<>\/$.,'_-]", $txt)){ 
		
				return true;
		
			}
	
		}

	}

	function getip() {
	
		if (getenv("HTTP_CLIENT_IP")){ 
	
			$ip = getenv("HTTP_CLIENT_IP"); } 
	
		elseif(getenv("HTTP_X_FORWARDED_FOR")){ 
		
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		
		}else{ 
	
			$ip = getenv("REMOTE_ADDR"); } 
	
		return $ip; 

	}

	function tablenamestart($table){

	$table_start  = "phpforyou";

	$table_start .="_";

	$table = $table_start.$table;

	return $table;

	}
	
	function StartPage($sname,$stitle){
		
	global $eaf,$lang;
	
	$Location = strip_tags($eaf->_REQUEST['action']);
	switch($Location){
	
		case "showtheard": 
		
	$ID 	  = intval(abs($eaf->_REQUEST['tid']));

	$Query 	  = $eaf->db->query("select title from phpforyou_topics where tid=$ID");
	$Rows     = $eaf->db->dbrows($Query);
	
	$KayWordsF = trim(ForumName() . ' ' . $Rows['title']);
	
	$KayWordsF = str_replace(" ",",",$KayWordsF);
	
	$KayWordsD = trim(ForumDec() . ' ' . $Rows['title']);
	
	$KayWordsD = str_replace(" ",",",$KayWordsD);

		break;
		
		case "forum": 
		
	$ID 	  = intval(abs($eaf->_REQUEST['fid']));

	$Query 	  = $eaf->db->query("select name,more from phpforyou_sections where fid=$ID");
	$Rows     = $eaf->db->dbrows($Query);
	
	$KayWordsF = trim(ForumName() . ' ' . strip_tags($Rows['name']));
	
	$KayWordsF = str_replace(" ",",",$KayWordsF);
	
	$KayWordsD = trim(ForumDec() . ' ' . strip_tags($Rows['more']));
	
	$KayWordsD = str_replace(" ",",",$KayWordsD);

		break;
		
		default:
	
	$KayWordsF = trim(ForumName());
	
	$KayWordsF = str_replace(" ",",",$KayWordsF);
	
	$KayWordsD = trim(ForumDec());
	
	$KayWordsD = str_replace(" ",",",$KayWordsD);

		break;
		
	}

echo '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>'.$stitle.'</title>
<meta http-equiv="keywords" content="'.$KayWordsD . "," . $KayWordsF.'" />
<meta http-equiv="description" content="'.ForumDec().'" />
<meta name="generator" content="EasyForum 1.0" />
<link rel="shortcut icon" href="images/favicon.png" />
<link type="text/css" rel="stylesheet" href="styles/'.$sname.'/theme/style.css" />
<script type="text/javascript">
var ConfirmMessage = \''.$lang['confirmMessage'].'\';
var ConfirmMessageDeleteTopic = \''.$lang['confirmMessageDeleteTopic'].'\';
</script>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/easyForum.js" type="text/javascript"></script>
<script src="js/fancyBox/jquery.mousewheel.js" type="text/javascript"></script>
<script src="js/fancyBox/jquery.fancybox.js?v=2.1.3" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="js/fancyBox/jquery.fancybox.css?v=2.1.2" media="screen" />
<script type="text/javascript">
	$(\'.fancybox\').fancybox({
				closeEffect : \'elastic\',
				closeSpeed  : 150,
	});
</script>
</head>
<body dir="'.$lang["dir"].'">';	

	}

	function DownPage(){

	echo '
</body>
</html>';	

	}

	function GetBbCode($var){ 
	
		global $eaf,$lang;
			
		$var = $eaf->BbCode->replace($var);
	
		$words = ReplaceWordsDo();
	
		$words = explode("|",$words);
	
		foreach($words as $s_var){
	
			if(!empty($s_var)){
		
			$var = str_ireplace($s_var," ****** ",$var);
		
			}

		}
	
	return $var;

	}

function  resizeimg($img,$hight=50,$with=50){
  
	if(!empty($img) ){
			
		if(file_exists($img)){ $img = $img; }
		if(file_exists('../'.$img)){ $img = '../'.$img; }
			
	
		return "<img src=\"imager.php?width=$with&height=$hight&image=$img\"  border=\"0\">";  
	
	}
	
}  


function SGroup($Fid){
	
	$Forum = new Forum($Fid);
		
		if($Forum->Gusetforumview() == true and $Forum->Outforumview() == true && $Forum->Morderforumview() == true && $Forum->Modsforumview() == true and $Forum->Userforumview() == true) {
			
			return true;
	
		}else{
		
			return false;	
		}
		
	}
 
  function sendmail($to,$subject,$msg,$from = false){
		
	if($from == false){
	
		$from = GetSiteEmail();
	
	}else{
	
		$from = $from;		
	}
	
	$headers ="MIME-Version: 1.0 \r\n";
    $headers.="from: $from \r\n";
    $headers.="Content-type: text/html;charset=utf-8 \r\n";
    $headers.="X-Priority: 3\r\n";
    $headers.="X-Mailer: smail-PHP ".phpversion()."\r\n";
	
	if(mail($to,$subject,$msg,$headers)){
    
	    return true;
    
	}else{
    
	    return false;
    
	}

} 

function UNameById($Uid=null){
					
		global $eaf,$lang;
	
		$Uid   = $eaf->security->sint($Uid);
		
		$Query = $eaf->db->query("select * from members where uid = $Uid");
		
		$Rows  = $eaf->db->dbrows($Query);
		
		return $Rows['username'];
		
		}
function uploadFile($file_post_name , $to , $hash = false){
	
		
		$file_name = $_FILES[$file_post_name]['name'];
		
		if($hash == true){ $file_name = rand(0000,9999) . '-' . $file_name; }
		
		$file_size = $_FILES[$file_post_name]['size'];
		$file_type = $_FILES[$file_post_name]['type'];
		$file_temp = $_FILES[$file_post_name]['tmp_name'];
		
		if(check_image($file_temp) == false){
			
				return false;
				
			}
		
		$upload = move_uploaded_file($file_temp , $to . '/'. $file_name);
		
		if($upload == true){
			
				return str_replace("../" , "" , $to) . '/' . $file_name;
			
			}else{
				
					die($_FILES[$file_post_name]['error']);
				}
			
	}
	
     function check_image($file)
    {
        $txt = @file_get_contents($file);
        $Safe_File = true;
        if (preg_match('#&(quot|lt|gt|nbsp|<?php);#i', $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#&\#x([0-9a-f]+);#i", $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match('#&\#([0-9]+);#i', $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#([a-z]*)=([\`\'\"]*)script:#iU", $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#([a-z]*)=([\`\'\"]*)javascript:#iU", $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#([a-z]*)=([\'\"]*)vbscript:#iU", $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU", $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU", $txt))
        {
            $Safe_File = false;
        }
        elseif (preg_match("#</*(applet|link|style|script|iframe|frame|frameset)[^>]*>#i", $txt))
        {
        $Safe_File = false;
        }
        return $Safe_File;
    }
			
	function Cleanquot($string){
	
		$string = str_replace('"' , "&quot;" , $string);

		return $string;
		
	}

	function getResizedImage($file , $Type , $w , $h){
	
		global $eaf;
		
		switch($Type) {
		
			case "attachment" : 
				return GetSiteUrl() . "/imager.php?image=upload/attachments/$file&width=$w&height=$h";
			break;	
		}
		
	}
	
	$eaf->_POST    = str_replace('{$siteurl}',GetSiteUrl(),$eaf->_POST);

?>