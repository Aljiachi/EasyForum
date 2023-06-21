<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class eafSqlEngine{

	public function UpdateUsetTopicsTotals(){     

	global $eaf,$lang;

	if(isset($_SESSION['username'])){

		$sql = $eaf->db->query("select * from " . tablenamestart('topics') . " where u_id=".Userid());

		$total = $eaf->db->dbnum($sql);

		$sql_2 = $eaf->db->query("select * from " . tablenamestart('posts'). " where u_id=".Userid());

		$total_2 = $eaf->db->dbnum($sql_2);

		$update = $eaf->db->query("UPDATE members SET totla_ps='$total',total_posts='$total_2' WHERE uid=".Userid() );

	}

	}

	public function DeleteTopic($tid){

	global $eaf,$lang;

	if(isset($eaf->_REQUEST['act']) && $eaf->_REQUEST['act'] == "delete_topic"){
	
	if(isset($_SESSION['username']) and isset($_SESSION['password'])){
		
	$Moder = addModerLogs($tid,"Delete");

	$sql_query = $eaf->db->dbselect(tablenamestart('topics'),"tid=".$tid,"","");

	$rows      = $eaf->db->dbrows($sql_query);
	
	if(UserGroup(GetUserid(),"delete_topic") == 1 and $rows['username'] == $_SESSION['username']){
		
			$USerDElete = true;
	}else{

			$USerDElete = false;	
	}
	
	if(UserGroup(GetUserid(),"is_mod") == 1 and UserGroup(GetUserid(),"mod_delete") == 1){
	
		$ModDelete = true;	
	
	}else{
	
		$ModDelete = false;	
	}

	if($USerDElete || $ModDelete || UserGroup(GetUserid(),"is_admin") == 1){

	$total      = $eaf->db->dbnum($sql_query);
	
		if($total !== 0){
	
				# TOTAL IF 

	$sql_delete  = $eaf->db->query("DELETE FROM " . tablenamestart('topics') . " WHERE tid=$tid");

	$sql_views = $eaf->db->query("SELECT * FROM " . tablenamestart('posts') . " WHERE t_id=$tid");

			while($rows = $eaf->db->dbrows($sql_views)){

				$delete_post = $eaf->db->query("DELETE FROM " . tablenamestart('posts') . " WHERE pid=".$rows['pid']);	

			}

				# WHILE END 

				if($sql_delete){

				$eaf->_print($eaf->_Greenmsg($lang['alert_delete_ok']));

				$eaf->_print($eaf->_Refresh('index.php'));

					}  # SQL DELETE IF END 	
					else
	
					{ # ELSE SQL DELETE IF 
	
				$eaf->_print($eaf->_Redmsg($lang['alert_delete_error']));

				$eaf->_print($eaf->_Refresh(GoBack()));				

	} # END SQL DELETE IF END 

						} # END SQL TOTAL IF 

						else

						{ # ENSE IF TOTAL ROWS 

					$eaf->_print($eaf->_Redmsg($lang['alert_theard_noexists']));

					$eaf->_print($eaf->_Refresh(GoBack()));	
					
				} # END ELSE IF TOTAL ROWS 

	}else{
		
			$eaf->_print($eaf->_Redmsg($lang['alert_cant_delete']));

			$eaf->_print($eaf->_Refresh(GoBack()));	
	
	}# END IF LOGIN ACCESS 

	}else{
		
			$eaf->_print($eaf->_Redmsg($lang['alert_login']));

			$eaf->_print($eaf->_Refresh(GoBack()));	
		
	} # END ISSET USER
	
	} # End Action

	} # END public function 

	public function EditPost(){    

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){
		
	$title_post = $eaf->security->svar($eaf->_POST['title_post']);

	if(GetHtmlPost() == 1){

		$apost = $eaf->security->HtmlToBbcode($eaf->_POST['apost']);

	}else{
	
		$apost = $eaf->BbCode->HtmlToBbCode($eaf->security->_HtmlReplace($eaf->_POST['apost']));

	}

	$post_icon  = $eaf->security->CleanHtml($eaf->_POST['post_icon']);

	if(empty($post_icon)){

		$post_icon = GetPostIcon();
	
	}

	$tid		= $eaf->security->sint($eaf->_REQUEST['tid']);

	$pid 		= $eaf->security->sint($eaf->_REQUEST['pid']);	

	$topic_id   = $eaf->security->sint($eaf->_REQUEST['topic_id']);

	if(isset($eaf->_POST['edit_post'])){

	if($tid){
		
	$Moder = addModerLogs($tid,"Edit");

	$sql_edit_post = $eaf->db->query("UPDATE " .tablenamestart('topics'). " SET title='$title_post',text='$apost',icon_id='$post_icon' WHERE tid=$tid");

	if($sql_edit_post){

				$eaf->_print($eaf->_Greenmsg($lang['alert_edit_ok']));
		
				echo '<meta http-equiv="refresh" content="3;URL=index.php?action=showtheard&tid='.$tid.'" />';
			
				$eaf->_close();
					
					}else{
			
				$eaf->_print($eaf->_Greenmsg($lang['alert_edit_error']));

				$eaf->_print($eaf->_Refresh(GoBack()));			
				
				$eaf->_close();
				
				}

			}else{

			$sql_edit_post = $eaf->db->query("UPDATE " .tablenamestart('posts'). " SET ptitle='$title_post',ptext='$apost',picon='$post_icon' WHERE pid=$pid");

			if($sql_edit_post){
				
				$eaf->_print($eaf->_Greenmsg($lang['alert_edit_ok']));
			
				echo '<meta http-equiv="refresh" content="3;URL=index.php?action=showtheard&tid='.$topic_id.'" />';
			
				$eaf->_close();
			
			}else{
				
				$eaf->_print($eaf->_Greenmsg($lang['alert_edit_error']));
				
				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();	
			}
}
}
}
# end function
}

	public function InsertPost(){
	
	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	if(isset($eaf->_POST['addtheard'])){

	$topic_title = $eaf->security->svar($eaf->_POST['title']);

	$fid = 		 $eaf->security->sint($eaf->_REQUEST['fid']);

	$access = $eaf->db->query("select fid,sort from ".tablenamestart("sections") . " where  fid=".$fid);

	$access_rows = $eaf->db->dbrows($access);

	if($access_rows['sort'] = 0){
	
				$eaf->_print($eaf->_Redmsg($lang["alert_addinsection"]));
				
				$eaf->_print($eaf->_Refresh(GoBack()));			
	
				$eaf->_close();
				
	}

	$uid = $eaf->security->sint($_SESSION['user_id']);

	$user_name = $eaf->security->svar($_SESSION['username']);

	$data = arabic_data();

	if(GetHtmlPost() == 1){

	$content = $eaf->BbCode->HtmlToBbCode($eaf->_POST['text']);

	}else{

	$content = $eaf->BbCode->HtmlToBbCode($eaf->security->_HtmlReplace($eaf->_POST['text']));

	}
	
	$content = str_replace('"',"&quot;",$content);
	$content = str_replace("'","*=q=*",$content);
	
	$icon = $eaf->security->CleanHtml($eaf->_POST['icon']);

	$time = time();

	if(empty($icon)){

	$icon = GetPostIcon();

	}

	if(empty($topic_title) or empty($icon) or empty($content)){

				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			
		
				$eaf->_close();
				
				}else{

				$table_add_name = tablenamestart('topics');
	
				$query_insert = $eaf->db->query("INSERT INTO $table_add_name (f_id,u_id,username,title,data,text,icon_id,wtime) VALUES ('$fid','$uid','$user_name','$topic_title','$data','$content','$icon','$time')");
	
				$topic_id = mysql_insert_id();

				if($query_insert){
				
						$eaf->_print($eaf->_Greenmsg($lang["alert_addtheard_ok"]));
						echo '<meta http-equiv="refresh" content="3;URL=index.php?action=showtheard&tid='.$topic_id.'" />';
						$eaf->_close();
			
			}else{
			
			$eaf->_print($eaf->_Redmsg($lang["alert_addtheard_error"]));
			
			$eaf->_print($eaf->_Refresh(GoBack()));			

			$eaf->_close();
			
			}

	}

	}	
# end isset user
	
	}
# end function 

	}
	public function AddPost(){     

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	if(isset($eaf->_POST['addpost'])){

	$post_title = $eaf->security->svar($eaf->_POST['post_title']);

	if(!empty($eaf->_REQUEST['tid'])){

	$tid = $eaf->security->sid($eaf->_REQUEST['tid']);

	}else{

	$tid = $eaf->security->sint($eaf->_POST['topic_id']);

	}

	$data = arabic_data();
	
	$content = $eaf->BbCode->HtmlToBbCode($eaf->_POST['post_text']);	
			
	if(GetHtmlPost() == 1){

	$content = $content;

	}else{

	$content = $eaf->security->_HtmlReplace($content);

	}
	
	$content = str_replace('"',"&quot;",$content);
	$content = str_replace("'","*=q=*",$content);
	
	$post_icon = $eaf->security->CleanHtml($eaf->_POST['post_icon']);

	if(empty($post_icon)){

	$post_icon = GetPostIcon();

	}

	if(empty($post_title) or empty($post_icon) or empty($data) or empty($content)){
	
				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();
				
	}

	$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=".$tid);

	$rows = $eaf->db->dbrows($sql);

	$fid = $rows['f_id'];

	if($rows['close'] == 0){

	$SqlInsertPost = $eaf->db->query("INSERT INTO " . tablenamestart('posts') . " (t_id,f_id,u_id,ptitle,pdata,pusername,ptext,picon) VALUES (

	'$tid',

	'$fid',

	'".UserId()."',

	'$post_title',
	
	'$data',
	
	'".UserName()."',

	'$content',

	'$post_icon'

	)");

	$time = time();

	$update = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET wtime='$time' WHERE tid=$tid");

	$insert_id= mysql_insert_id();

	if($SqlInsertPost){
	
				$eaf->_print($eaf->_Greenmsg($lang["alert_addpost_ok"]));
	
				echo '<meta http-equiv="refresh" content="3;URL=index.php?action=showtheard&tid='.$tid.'" />';
			
				$_SESSION['save_last_post'] = "";
		
				$eaf->_close();

	}else{

				$eaf->_print($eaf->_Greenmsg($lang["alert_addpost_error"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();
				
				
	}
}else{
			
				$eaf->_print($eaf->_Greenmsg($lang["alert_theardclosed"]));
			
				echo '<meta http-equiv="refresh" content="3;URL=index.php?action=showtheard&tid='.$tid.'" />';
			
				$eaf->_close();	
	}

	}

	}

	}

	public function BlocksDownShow(){     

	echo '<div align="center" style="margin:4px;display:block;">Powered By : <a href="mailto:php4u@hotmail.com">Easy Forum 2</a></div>';

	}

	public function NavBarLinks(){     
	
	global $eaf,$lang;

	switch($eaf->_REQUEST['action']){

	case "": $link = '<a href="index.php">'.ForumName().'</a>'; break;

	case "showtheard": 

	$stid = $eaf->security->sid($eaf->_REQUEST['tid']);

	$sql_theard = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=$stid");

	$rows_theard = $eaf->db->dbrows($sql_theard);

	$sql_get_theard_sections = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE fid=".$rows_theard['f_id']);

	$rows_get_theard_section = $eaf->db->dbrows($sql_get_theard_sections);

	$link = '<span class="navbar-home"><a href="index.php">'.ForumName().'</a></span> <span class="navbar-spc">' . $lang["navbarSpc"] . '</span> 
	
	<span class="navbar-1"><a href="index.php?action=forum&fid='.$rows_get_theard_section['fid'].'">'.strip_tags($rows_get_theard_section['name']).'</a> </span>
	
	<span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-2">' . strip_tags($rows_theard['title']) . '</span>';

	break;
	
	case "forum": 

	$sfid = $eaf->security->sid($eaf->_REQUEST['fid']);
	
	$sql_sections = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE fid=$sfid");

	$rows_section = $eaf->db->dbrows($sql_sections);

	$link = '<span class="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc"> ' . $lang["navbarSpc"] . '
	
	<span class="navbar-1">' . strip_tags($rows_section['name']) .'</span>';

	break;

	case "newtheard": $link = '<span class="navbar-home"><a href="index.php">'.ForumName().'</a> </span><span class="navbar-spc">' . $lang["navbarSpc"] . '</span>
	<span class="navbar-1">' . $lang["navbar_newtheard"] . '</span>'; break;

	case "edit_post": $link = '<span class="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc"> ' . $lang["navbarSpc"] . '</span><span class="navbar-1">' . $lang["navbar_editpost"] . '</span>'; break;

	case "add_post": $link = '<span class="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc"> ' . $lang["navbarSpc"] . '</span>' . $lang["navbar_newpost"]; break;

	case "register": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_signup"] . '</span>'; break;

	case "usercp": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_usercp"] . '</span>'; break;

	case "login": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_login"] . '</span>'; break;

	case "members": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_members"] . '</span>'; break;

	case "search": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_search"] . '</span>'; break;

	case "search_do": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_searchres"] . '</span>'; break;

	case "contact": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span clas="navbar-spc">' . $lang["navbarSpc"] . '</span><span clas="navbar-1">' .$lang["navbar_contact"] . '</span>'; break;

	case "online": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_online"] . '</span>'; break;

	case "getpage": 
	
	$id = intval(abs($eaf->_REQUEST['id']));
	
	$Getpage = $eaf->db->_object($eaf->db->query("select page_name,page_id from " . tablenamestart("pages") . " where page_id = $id"));
	
	$link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. strip_tags($Getpage->page_name) . '</span>'; break;

	case "announcement": 
	
	$id = intval(abs($eaf->_REQUEST['id']));
	
	$Getannouncement = $eaf->db->_object($eaf->db->query("select id,title from " . tablenamestart("announcements") . " where id = $id"));
	
	$link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_announcement"] . ' : ' . strip_tags($Getannouncement->title)  . '</span>'; break;

	case "portal": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_portal"] . '</span>'; break;

	case "forgot": $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span class="navbar-spc">' . $lang["navbarSpc"] .'</span><span class="navbar-1">'. $lang["navbar_forgot_password"] . '</span>'; break;

	case "profile": 

		$sql = $eaf->db->query("SELECT * FROM members WHERE uid=".$eaf->_REQUEST['uid']);

		$row = $eaf->db->dbrows($sql);

		$link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span><span clas="navbar-spc"> ' . $lang["navbarSpc"] . '</span><span clas="navbar-1"><a href="index.php?action=members">' . $lang["members"] . '</a></span><span clas="navbar-2">' . strip_tags($row['username']) . '</span>'; break;


	default : $link = '<span clas="navbar-home"><a href="index.php">'.ForumName().'</a></span>';
	}

	return $link;
	
	}

	public function Title(){     

	global $eaf,$lang;

	switch($eaf->_REQUEST['action']){

	case "": $title = ''.ForumName().''; break;
	
	case "showtheard": 

	$stid = $eaf->security->sid($eaf->_REQUEST['tid']);

	$sql_theard = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=$stid");

	$rows_theard = $eaf->db->dbrows($sql_theard);

	$title = ''.ForumName(). $lang["titleSpc"] .$rows_theard['title'];

	break;

	case "forum": 

	$sfid = $eaf->security->sid($eaf->_REQUEST['fid']);

	$sql_sections = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE fid=$sfid");

	$rows_section = $eaf->db->dbrows($sql_sections);

	$title = ''.ForumName(). $lang["titleSpc"] . $rows_section['name'];
	
	break;

	case "newtheard": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_newtheard"]; break;

	case "edit_post": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_editpost"]; break;

	case "add_post": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_newpost"]; break;

	case "register": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_signup"]; break;

	case "usercp": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_usercp"]; break;

	case "login": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_login"]; break;

	case "members": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_members"]; break;

	case "search": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_search"]; break;

	case "search_do": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_searchres"]; break;

	case "contact": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_contact"]; break;
	
	case "online": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_online"]; break;

	case "getpage": 
	
	$id = intval(abs($eaf->_REQUEST['id']));
	
	$Getpage = $eaf->db->_object($eaf->db->query("select page_name,page_id from " . tablenamestart("pages") . " where page_id = $id"));
	
	$title = ''.ForumName(). $lang["titleSpc"] . $Getpage->page_name; break;

	case "announcement": 
			
	$id = intval(abs($eaf->_REQUEST['id']));
	
	$Getannouncement = $eaf->db->_object($eaf->db->query("select id,title from " . tablenamestart("announcements") . " where id = $id"));
	
	$title = ''.ForumName(). $lang["titleSpc"] . $Getannouncement->title; break;

	case "portal": $title = ''.ForumName(). $lang["titleSpc"] . $lang["title_portal"]; break;
	
	case "forgot": $title = ''.ForumName() . $lang["titleSpc"] . $lang["title_forgot_password"] ; break;
	
	case "profile": 

		$sql = $eaf->db->query("SELECT * FROM members WHERE uid=".$eaf->_REQUEST['uid']);

		$row = $eaf->db->dbrows($sql);

		$title = ForumName(). $lang["titleSpc"] . $lang["title_profile"] . $row['username']; break;
		
	default : $title = ForumName();

	}

	return $title;

	}

	public function DeletePost($pid){

	global $eaf,$lang;
	
	if(UserGroup(GetUserid(),"mod_delete") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("delete") == 1){
		
	$pid = $eaf->security->sint($pid);

	$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('posts') . " WHERE pid=$pid");

	if($eaf->db->dbnum($sql) !== 0){

	$Delete = $eaf->db->query("DELETE FROM " . tablenamestart('posts') . " WHERE pid=$pid");
	
			if($Delete){
		
				$eaf->_print($eaf->_Greenmsg($lang["alert_delete_ok"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			
	
				$eaf->_close();
				
			}
	}else{
			$eaf->_print($eaf->_Redmsg($lang["alert_post_notexists"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			

			$eaf->_close();
			
			}
	
		}else{
	
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
	
			$eaf->_print($eaf->_Refresh('index.php'));
	
			$eaf->_close();	

	}

	}

	public function SendMsgPm(){
	
	global $eaf,$lang;

	if(isset($eaf->_POST['sendpm'])){

	$user_to = $eaf->security->CleanHtml($eaf->_POST['to']);

	$sql_userpm = $eaf->db->query("SELECT * FROM members WHERE username = '$user_to'");

	if($eaf->db->dbnum($sql_userpm) == 0){
	
	$eaf->_print($eaf->_Redmsg($lang["alert_userto_notexists"]));

	$eaf->_print($eaf->_Refresh(GoBack()));			

	$eaf->_close();
	
	}

	$row_sqlupm = $eaf->db->dbrows($sql_userpm);
	
	if($row_sqlupm['option_getpm'] == 1){
	
		$eaf->_print($eaf->_Redmsg($lang["alert_userpm_off"]));

		$eaf->_print($eaf->_Refresh(GoBack()));			

		$eaf->_close();
	
	}

	$pm_username = $row_sqlupm['username'];

	$pm_uid      = $row_sqlupm['uid'];

	$stitle = $eaf->security->CleanHtml($eaf->_POST['title']);

	$sfname = $_SESSION['username'];

	$sdata  = arabic_data();

	$sfrom  = UserId();

	if(GetHtmlPost() == 1){

	$smsg = $eaf->BbCode->HtmlToBbCode($eaf->_POST['msg']);

	}else{

	$smsg = $eaf->security->_HtmlReplace($eaf->BbCode->HtmlToBbCode($eaf->_POST['msg']));

	}

	if(empty($stitle) or empty($sfname) or empty($sfrom) or empty($sdata) or empty($smsg) or empty($user_to)){
			
				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();
				
				}

		$send_msg = $eaf->db->query("insert into ".tablenamestart('pm')." (stitle, sdata, sfrom , sact, smsg, s_uid, s_fname) values ('$stitle','$sdata','$sfrom','0','$smsg','$pm_uid','$sfname')");

		$AddSent = $eaf->db->query("insert into ".tablenamestart('pm')." (stitle, sdata, sfrom , sact, smsg, s_uid, s_fname) values ('$stitle','$sdata','$sfrom','2','$smsg','$sfrom','$sfname')");
	
		if($send_msg){
		
				$eaf->_print($eaf->_Greenmsg($lang["alert_send_ok"]));
			
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();
	
		}

	}
	
			}

	public function DeleteNewPm(){     

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	$sid = $eaf->_POST['newsid'];

	if(isset($eaf->_POST['delete_newpm'])){

	if(empty($sid)){
		
		$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

		$eaf->_print($eaf->_Refresh(GoBack()));			

		$eaf->_close();
	
	}

	$impad = implode(",",$sid);

	$delete = $eaf->db->query("delete from ".tablenamestart('pm')." where sid in(".$impad.")");

	if($delete){

				$eaf->_print($eaf->_Greenmsg($lang["alert_deletepm_ok"]));
	
				$eaf->_print($eaf->_Refresh(GoBack()));			
		
				$eaf->_close();

	}

	}

	}

	}

	public function DeleteOldPm(){     

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	$sid = $eaf->_POST['oldsid'];

	if(isset($eaf->_POST['delete_oldpm'])){

	if(empty($sid)){

		$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));
	
		$eaf->_print($eaf->_Refresh(GoBack()));			
		
		$eaf->_close();
		
		}

	$impad = implode(",",$sid);

	$delete = $eaf->db->query("delete from ".tablenamestart('pm')." where sid in(".$impad.")");

	if($delete){
	
				$eaf->_print($eaf->_Greenmsg($lang["alert_deletepm_ok"]));
		
				$eaf->_print($eaf->_Refresh(GoBack()));			
			
				$eaf->_close();

	}

	}

	}

	}

	public function StickPost(){     

	global $eaf,$lang;
	
	if(UserGroup(GetUserid(),"mod_sticky") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("sticky") == 1){

	$tid = intval(abs($eaf->_REQUEST['tid']));

	$access = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=".$tid);

	$rows   = $eaf->db->dbrows($access);

	if($rows['stayed'] == 1){
		
			$Moder = addModerLogs($tid,"unSticky");     

			$sql = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET stayed='0' WHERE tid=".$tid);

	if($sql){
	
		$eaf->_print($eaf->_Greenmsg($lang["alert_unstcky_ok"]));

		$eaf->_print($eaf->_Refresh(GoBack()));			

		$eaf->_close();
		
	}	

	}else{

	$Moder = addModerLogs($tid,"Sticky");     

	$sql = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET stayed='1' WHERE tid=".$tid);

	if($sql){
			
		$eaf->_print($eaf->_Greenmsg($lang["alert_sticky_ok"]));

		$eaf->_print($eaf->_Refresh(GoBack()));			

		$eaf->_close();
		
	}	

	}

	}else{
	
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
	
			$eaf->_print($eaf->_Refresh('index.php'));
	
			$eaf->_close();	

	}

	}

	public function MovePost(){     

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	$tid = intval(abs($eaf->_REQUEST['tid']));

	if(isset($eaf->_POST['post_move'])){
	
	if(UserGroup(GetUserid(),"mod_move") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("move") == 1){

	$f_to = intval($eaf->_POST['section']);
	
	$Moder = addModerLogs($tid,"Move");     
	
	$sql = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET f_id='$f_to' WHERE tid=".$tid);

		if($sql){
			
				$eaf->_print($eaf->_Greenmsg($lang["alert_move_ok"]));
			
				$eaf->_print($eaf->_Refresh("index.php?action=showtheard&tid=" . $tid));
				
				$eaf->_close();

		}

	}else{
		
				$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	

	}

	}
	
	}

	}


	public function ٌRecyPost(){     

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	$tid = intval(abs($eaf->_REQUEST['tid']));
	
	if(UserGroup(GetUserid(),"mod_move") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("recy") == 1){
	
	$Moder = addModerLogs($tid,"Recy");     
	
	$sql = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET deleted='1' WHERE tid=".$tid);

		if($sql){
			
				$eaf->_print($eaf->_Greenmsg($lang["alert_recy_ok"]));
			
				$eaf->_print($eaf->_Refresh("?home"));
				
				$eaf->_close();

		}

	}else{
		
				$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	

	}

	}
	
	}

	public function ClosePost(){     

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password'])){

	if(UserGroup(GetUserid(),"mod_close") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("close") == 1){

	$tid = intval(abs($eaf->_REQUEST['tid']));

	$access = $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE tid=".$tid);

	$rows   = $eaf->db->dbrows($access);

	if($rows['close'] == 0){
		
	$Moder = addModerLogs($tid,"Close");     

	$sql = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET close='1' WHERE tid=".$tid);

	if($sql){
	
				$eaf->_print($eaf->_Greenmsg($lang["alert_close_ok"]));
				
				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();
				
	}	

	}else{
		
	$Moder = addModerLogs($tid,"Open");     

	$sql = $eaf->db->query("UPDATE " . tablenamestart('topics') . " SET close='0' WHERE tid=".$tid);

	if($sql){
	
			$eaf->_print($eaf->_Greenmsg($lang["alert_open_ok"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			

			$eaf->_close();
			
	}	

	}

	}else{
	
				$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	

	}

	}

	}

	public function CloseAll(){     

	global $eaf,$lang;

	$tid = $eaf->_POST['check'];

	if(isset($eaf->_POST['close'])){
		
	if(UserGroup(GetUserid(),"mod_close") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("close") == 1){

	if(empty($tid)){
		
		$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

		$eaf->_print($eaf->_Refresh(GoBack()));			
		
		$eaf->_close();
		
		}

		$impad = implode(",",$tid);
	
		$update = $eaf->db->query("UPDATE `".tablenamestart('topics')."` SET `close`='1' where `tid` in(".$impad.")");

		if($update){
			
			$Moder = addModerLogs($tid,"Close");     
			
			$eaf->_print($eaf->_Greenmsg($lang["alert_close_ok"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			
			
			$eaf->_close();
			
		}


	}else{

			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	
	
		}
	
	}
	
		}

	public function RecAll(){     

	global $eaf,$lang;

	$tid = $eaf->_POST['check'];

	if(isset($eaf->_POST['rec'])){
		
	if(UserGroup(GetUserid(),"mod_recy") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("recy") == 1){

	if(empty($tid)){
		
		$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

		$eaf->_print($eaf->_Refresh(GoBack()));			
		
		$eaf->_close();
		
		}

		$impad = implode(",",$tid);
	
		$update = $eaf->db->query("UPDATE `".tablenamestart('topics')."` SET `deleted`='1' where `tid` in(".$impad.")");

		if($update){
			
			$Moder = addModerLogs($tid,"Recly");     
			
			$eaf->_print($eaf->_Greenmsg($lang["alert_recy_ok"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			
			
			$eaf->_close();
			
		}

	}else{
		
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	
	
	}
	}

	}
	
	public function MergeTopic(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['post_merge'])){
			
		if(UserGroup(GetUserid(),"mod_mrege") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("mrege") == 1){
		
		$tid = intval(abs($eaf->_REQUEST['id']));
		
		$topicId = $eaf->security->CleanHtml($eaf->_POST['url']);
		
		$GetTopic = $eaf->db->query("select tid,text from " . tablenamestart("topics") . " where tid = $tid");				
		
		$topicId  = str_replace(GetSiteUrl()."/index.php?action=showtheard&tid=","",$topicId);	

		$topicId  = str_replace(GetSiteUrl()."/?action=showtheard&tid=","",$topicId);	
		
		$topicId  = str_replace(GetSiteUrl()."/theard-","",$topicId);	
		
		$topicId  = str_replace(".html","",$topicId);
				
		if(!$topicId || !is_numeric($topicId) || $topicId == 0){

			$eaf->_print($eaf->_Redmsg($lang["urlError"]));
		
			$eaf->_print($eaf->_Refresh(GoBack()));
			
			$eaf->_close();	

		}
		
		$GetMergeTopic = $eaf->db->query("select tid,text from " . tablenamestart("topics") . " where tid = $topicId");
		
		$Rows = $eaf->db->_object($GetTopic);
		
		$Row  = $eaf->db->_object($GetMergeTopic);
		
		$Merge = $eaf->db->query("update " . tablenamestart("topics") . " set text='".$Rows->text.$Row->text."' where tid=$tid");
		
		$Delete= $eaf->db->query("delete from " . tablenamestart("topics") . " where tid=$topicId");
				
		if($Merge){
		
			$UpdatePosts = $eaf->db->query("update " . tablenamestart("posts") . " set t_id='$tid' where t_id=$topicId");
			$Moder = addModerLogs($tid,"Merge");     
			$eaf->_print($eaf->_GreenMsg($lang["alert_merge_ok"]));
			$eaf->_print($eaf->_Refresh("index.php?action=showtheard&tid=$tid"));
		}
		
		exit;
		
		}else{
			
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
			$eaf->_print($eaf->_Refresh('index.php'));
			
			$eaf->_close();	

			
		}
		
		}
		
	}

	public function UnCloseAll(){     

	global $eaf,$lang;
		
	$tid = $eaf->_POST['check'];

	if(isset($eaf->_POST['unclose'])){
		
	if(UserGroup(GetUserid(),"mod_close") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("close") == 1){

	if(empty($tid)){

			$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			

			$eaf->_close();
			
			}

	$impad = implode(",",$tid);

	$update = $eaf->db->query("UPDATE `".tablenamestart('topics')."` SET `close`='0' where `tid` in(".$impad.")");

	if($update){
		
			$Moder = addModerLogs($tid,"Open");     
	
			$eaf->_print($eaf->_Greenmsg($lang["alert_close_ok"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			

			$eaf->_close();
			
			}

	}else{
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
			$eaf->_print($eaf->_Refresh('index.php'));
			
			$eaf->_close();	
	
	}
	}

	}

		public function StickAll(){     

		global $eaf,$lang;
				
		$tid = $eaf->_POST['check'];

	if(isset($eaf->_POST['stick'])){
		
	if(UserGroup(GetUserid(),"mod_sticky") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("sticky") == 1){

	if(empty($tid)){

				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();		
				
				}

	$impad = implode(",",$tid);

	$update = $eaf->db->query("UPDATE `".tablenamestart('topics')."` SET `stayed`='1' where `tid` in(".$impad.")") or die(mysql_error());

	if($update){
		
			$Moder = addModerLogs($tid,"Sticky");     

			$eaf->_print($eaf->_Greenmsg($lang["alert_sticky_ok"]));

			$eaf->_print($eaf->_Refresh(GoBack()));			
		
			$eaf->_close();
			
			}


	}else{
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
			$eaf->_print($eaf->_Refresh('index.php'));
			
			$eaf->_close();	
	}
	
	}


	}

	public function UnStickAll(){     

	global $eaf,$lang;

	$tid = $eaf->_POST['check'];

	if(isset($eaf->_POST['unstick'])){
		
	if(UserGroup(GetUserid(),"mod_sticky") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("sticky") == 1){

	if(empty($tid)){

				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

				$eaf->_print($eaf->_Refresh(GoBack()));			

				$eaf->_close();
				
				}

	$impad = implode(",",$tid);

	$update = $eaf->db->query("UPDATE `".tablenamestart('topics')."` SET `stayed`='0' where `tid` in(".$impad.")");

	if($update){
		
				$Moder = addModerLogs($tid,"unSticky");     
	
				$eaf->_print($eaf->_Greenmsg($lang["alert_unsticky_ok"]));
		
				echo '<meta http-equiv="refresh" content="3;URL='.GoBack().'" />';
			
				$eaf->_close();

	}

	}else{
			$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	
	}
	
	}

	
	}

	public function MovePostAll(){     

	global $eaf,$lang;

	$tid = $eaf->_POST['check'];

	if(isset($eaf->_POST['post_move'])){

	if(UserGroup(GetUserid(),"mod_move") == 1 || UserGroup(GetUserid(),"is_admin") || getModerFile("move") == 1){

	$f_to = intval($eaf->_POST['section']);

	$sql = $eaf->db->query("UPDATE `" . tablenamestart('topics') . "` SET `f_id`='$f_to' where `tid` in(".$tid.")");

	if($sql){
	
				$Moder = addModerLogs($tid,"Move");    
		
				$eaf->_print($eaf->_Greenmsg($lang["alert_move_ok"]));
	
				$eaf->_print($eaf->_Refresh("index.php?action=forum&fid=" . $f_to));
		
				$eaf->_close();

	}

	}else{
	
				$eaf->_print($eaf->_Redmsg($lang["alert_cant_doit"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();	

	}

	}

	}


	public function PostStyleSelect(){     

	global $eaf,$lang;

	if(isset($eaf->_REQUEST['action']) and $eaf->_REQUEST['action'] == "change"){

	$style = $eaf->_REQUEST['style'];
	
	$query = $eaf->db->query("SELECT * FROM " . tablenamestart("styles") . " WHERE style_id= $style ");
	
	$Rows  = $eaf->db->_object($query);
	
	$back  = $_SERVER['HTTP_REFERER'];
	
	$_SESSION['style_folder'] = $Rows->style_folder;
 
 	$eaf->_print($eaf->_Greenmsg($lang["alert_selectstyle"]));

	$eaf->_print($eaf->_Refresh($back));			

	$eaf->_close();
	
	}

	}
	public function AttachmentUpload(){     
	
		global $eaf,$lang;
	
		if(isset($_SESSION['username']) and isset($_SESSION['password'])){
		
			if(GetAttachmentsDo() == 1){
		
			if(isset($eaf->_POST['upattach'])){
		
			$name =  $_FILES['file']['name'];
		
			$tmp  =  $_FILES['file']['tmp_name'];
		
			$size =  $_FILES['file']['size'];
		
			$a_uid = UserId();
		
			$types= explode("|",GetAttachmentsTypes());
		
			$type = strrchr($name,".");
		
			$type = str_replace(".","",$type);
		
			if(!in_array($type,$types)){
					
					$eaf->_print($eaf->_Redmsg($lang["alert_filetype_notexists"]));
					
					$eaf->_print($eaf->_Refresh(GoBack()));			
		
					$eaf->_close();
					
					}
		
				if(file_exists("attachments/".$name)){
				
								$eaf->_print($eaf->_Redmsg($lang["alert_fileexists"]));
		
								$eaf->_print($eaf->_Refresh(GoBack()));			
		
								$eaf->_close();
								
								}
		
				if($size > GetAttachmentsSize()){
						
							$eaf->_print($eaf->_Redmsg($lang["alert_filesize"]));
		
							$eaf->_print($eaf->_Refresh(GoBack()));			
		
							$eaf->_close();
							
							}
				
				$salt = md5(sha1(time() . time() . rand(111111 , 999999) ));
			
				@move_uploaded_file($tmp, "upload/attachments/". md5($salt) . '-' . $name);
			
				$insert = $eaf->db->query("INSERT INTO " . tablenamestart("attachments") . " (a_uid,a_name,a_type,a_size , salt) VALUES (
				'$a_uid',			
				'$name',			
				'$type',
				'".file_size($size)."' ,			
				'".md5($salt)."'
				)");
			
				$id = mysql_insert_id();
			
				if($insert){
			
						$eaf->_print($eaf->_Greenmsg($lang["alert_fileup_ok"]. ' <hr /> ' . $lang["alert_filecopy_text"].' <br />
						
						<input type="text" style="direction:ltr;width:400px;" value="[attachment='.$id.' /]" /> <hr />
						
						<a href="index.php?action=download&aid='.$id.'" target="_new">'.$lang["view_attach"].'</a>
						
						'));
		
			}
	
		}
	
		}else{
	
				$eaf->_print($eaf->_Redmsg($lang["alert_attach_unactived"]));
	
				$eaf->_print($eaf->_Refresh(GoBack()));
				
				$eaf->_close();		
	
			
		}

		}

	}

	public function DeleteAttachment($id){
	
		global $eaf,$lang;
	
		$id = $eaf->security->svar($eaf->_REQUEST['id']);
	
		$query = $eaf->db->query("SELECT * FROM ".tablenamestart('attachments')." WHERE aid=$id");
	
		$rows  = $eaf->db->dbrows($query);
	
		$total = $eaf->db->dbnum($query);
		
		if($total !== 0){
		
			$delete_dir = @unlink("upload/attachments/".$rows['a_name']);
		
			$delete = $eaf->db->query("DELETE FROM ".tablenamestart('attachments')." WHERE aid=$id");
		
			if($delete){
				
						$eaf->_print($eaf->_Greenmsg($lang["alert_deleteattach_ok"]));
					
						$eaf->_print($eaf->_Refresh(GoBack()));				
					
						$eaf->_close();
		
			}else{
				
						$eaf->_print($eaf->_Refresh(GoBack()));				
					
						$eaf->_close();
				
			}
	
		}

	}

# end class 
}

	$eaf->sql  = new eafSqlEngine();

?>