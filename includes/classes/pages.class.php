<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


session_start();

class eafPages{
	
	private $action,$tid,$uid,$sid,$fid,$pid,$do;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_REQUEST['action']) && !empty($eaf->_REQUEST['action'])) :
		
			$this->action = $eaf->security->svar($eaf->_REQUEST['action']);
			
		endif;
		
		if(isset($eaf->_REQUEST['fid']) && !empty($eaf->_REQUEST['fid'])){
		
		    if(is_numeric($eaf->_REQUEST['fid'])){
				
			$this->fid	= $eaf->security->sint($eaf->_REQUEST['fid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			}
		  }
	
		if(isset($eaf->_REQUEST['tid'])){   
		
			if(is_numeric($eaf->_REQUEST['tid'])){
				
			$this->tid    = $eaf->security->sint($eaf->_REQUEST['tid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			
				}
			
		   }
	
		if(isset($eaf->_REQUEST['pid'])){   
	
			
			if(is_numeric($eaf->_REQUEST['pid'])){
				
		    $this->pid    = $eaf->security->sint($eaf->_REQUEST['pid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			
				}
		
		   }

		if(isset($eaf->_REQUEST['uid'])){   
	
			
			if(is_numeric($eaf->_REQUEST['uid'])){
				
		    $this->uid    = $eaf->security->sint($eaf->_REQUEST['uid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			
	
		   }	
		   
		}
		
		if(isset($eaf->_REQUEST['do']) && !empty($eaf->_REQUEST['do'])) :
		
			$this->do = $eaf->security->svar($eaf->_REQUEST['do']);
			
		endif;
	}
	
	public function _Access(){
		
		global $eaf,$lang;
		
		$pages = array('forum' , 'newtheard' , 'newpost' , 'replay' , 'rating' , 'usercp' ,
					   'announcement' , 'edit_post' , 'tell' , 'fastedit_post' , 'fast_post' ,
					   'new_post' , 'contact' , 'portal' , 'showtheard' , 'topic' , 'theard' ,
					   'register' , 'login' , 'logout' , 'addwarning' , 'search' , 'find' , 
					   'profile' , 'search_do' , 'addreputation' , 'online' , 'getpage' , 'members' ,
					   'post_tools' , '' , 'send_pm' , 'sendpm' , 'forgot' , 'add_post' , 'download'
		);
		
		if(!in_array($this->action , $pages)){
		
			header('location:index.php');
		}
		
		if(UserGroup(GetUserid(),"script") != 1 or UserGroup(GetUserid(),"out") == 1){

				if($this->action !== "register" || $this->action !== "login"){
					
					$this->_TStart();
					
					$eaf->_Redmsg($eaf->_ForrText());	
				
					$this->_TEnd();
					
					$eaf->_close();
					
				}
		}
		
		if(UserGroup(GetUserid(),"closed") != 1){
			
			if(ForumCloseDo() == 0){
					
				$this->_TStart();	
				
				$eaf->CloseText = ForumCloseMsg();
				
				print $eaf->template->display('close');
				
				$this->_TEnd();
				
				$eaf->_close();
			}
		}

	}
	private function _Home(){
		
		global $eaf,$lang;
		
		if($this->action == ""){
		
		$eaf->HomeSections = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . "
												 WHERE sort='0' AND open='1' order by `order` asc");
		
			while($eaf->home = $eaf->db->_object($eaf->HomeSections)){
			
				print $eaf->template->display('sections_sub');
			}
		
		}
		
	}
		

	public function _Anncounements(){
		
		global $eaf,$lang;
		
		switch($this->action){
			
			case "" : $eaf->query = $eaf->db->query("select * from `" . tablenamestart("announcements") . "` where `in` = 'index' or `in` = 'all'"); break;

			case "forum" : $eaf->query = $eaf->db->query("select * from " . tablenamestart("announcements") . " where `in` = 'all' or `in` = '$this->fid' or `in` = '0'"); break;

			default : $eaf->query = $eaf->db->query("select * from " . tablenamestart("announcements") . " where `in` = 'all'"); break;
		
		}
		
		if($eaf->db->dbnum($eaf->query) !== 0){
		
			print $eaf->template->display("announcements");
		
		}
	}
	
	private function _Forum(){
	
		global $eaf,$lang;
		
		$eaf->Rows = array();
				
		if($this->action == "forum"){
			
		if(UserGroup(GetUserid(),"view_forums") == 1){
			
		$eaf->Forum = new Forum($this->fid);

		$eaf->Forum->_Forum_exists();

		$eaf->Forum->_ForumGetInf();

		$eaf->Forum->_ForumGetSort();

		$eaf->Forum->_LastPost();
		
		$eaf->Forum->_UpdataPostsNum();
		
		$GruopGuests  = $eaf->Forum->Gusetforumview();
		
		$GruopUsers   = $eaf->Forum->Userforumview();

		$GruopMods   	= $eaf->Forum->Modsforumview();

		$GruopMorder  = $eaf->Forum->Morderforumview();

		$GruopOut     = $eaf->Forum->Outforumview();

		$GruopUnactived     = $eaf->Forum->Unactivedforumview();
	
		# $eaf->query = $eaf->Forum->_ForumTheards();

		# $eaf->Rows['home']  = $eaf->Forum->_Rows();
		
		$eaf->SDB->TotalPosts();
				
		$eaf->SortQuery = $eaf->db->query("SELECT * FROM  " . tablenamestart('sections') . " WHERE sort = " . $eaf->Forum->_Rows("id"));
		
		if($GruopUsers and $GruopGuests and $GruopMorder and $GruopMods and $GruopOut and $GruopUnactived){

		if($eaf->Forum->_TotalForumSort() !== 0){

			print $eaf->template->display('sections_sort');
	
		}
		
		$eaf->Forum->_ForumRule();
		
		if(UserGroup(GetUserid(),"view_topics") == 1){
	
			if($eaf->Forum->_Rows("sort") != 0){
				
					if($eaf->Forum->_Rows("view_self") == 0 and UserGroup(GetUserid(),"view_selftopics") == 0){
											
						$eaf->_print($eaf->_Redmsg($lang["noTopics"]));	
						
						return false;
					}
	
						print $eaf->template->display('theards');
	
						$eaf->pages = $eaf->TheardsPager->Pagination();

						print $eaf->template->display('pagination');
					
					}
									
			if(isset($_SESSION['username'])){
			
				print $eaf->template->display('forum_static');	
			}
			
			}
		}
	
	
		}else{
			
			 $eaf->_Redmsg($eaf->_ForrText());	
			
		     }
				
		}
	}
	
	private function _Showtheard(){
		
		global $eaf,$lang;
		
		$Rows = array();
		
		if($this->action == "showtheard"){
		
		if(UserGroup(GetUserid(),"view_topics") == 1){
			
		$eaf->Showtheard = new Showtheard($this->tid);
		
		$UsErId = $eaf->Showtheard->Userid();
		
		$eaf->Showtheard->Profile = new Profile($UsErId,true);
		
		$eaf->Showtheard->Theard_exists();
				
			if($eaf->Showtheard->Userid() == UserId() and UserGroup(GetUserid(),"edit_topic") == 1){
			
				$eaf->UserEdit = true;
		
			}else{
				
				$eaf->UserEdit = false;
				
			}
			
			if($eaf->Showtheard->Userid() == UserId() and UserGroup(GetUserid(),"delete_topic") == 1){
			
				$eaf->UserDelete = true;
		
			}else{
				
				$eaf->UserDelete = false;
				
			}
				
	$eaf->PostsPager = new Pager;
				
	$result_posts = $eaf->PostsPager->Querspagination(
		
		"select * from " . tablenamestart('posts') . " where  t_id = $this->tid order by pid ".GetTopicsOrderBy(),
		
		"?action=showtheard&tid=".$this->tid,
	
		GetPageNumPosts()
	
		);
		
		print $eaf->template->display('showtheard');	

		while($eaf->Showpost = $eaf->db->dbrows($result_posts)){
		
				$eaf->post  = $eaf->Showpost['ptext'];
				
				if($eaf->Showpost['u_id'] == UserId() and UserGroup(GetUserid(),"edit_post") == 1){
			
					$eaf->UserEdit = true;
		
				}else{
				
					$eaf->UserEdit = false;
				
				}
			
				if($eaf->Showpost['u_id'] == UserId() and UserGroup(GetUserid(),"delete_post") == 1){
					
					$eaf->UserDelete = true;
		
				}else{
				
					$eaf->UserDelete = false;
				
				}

				$eaf->post = GetBbCode($post);
		
				$eaf->ShowPost->Profile = new Profile($eaf->Showpost['u_id']);
				
				print $eaf->template->display('showpost');
				
		}		 # end while			

		$eaf->PostsPager->LastPageGet();

		$eaf->pages = $eaf->PostsPager->Pagination();

		print $eaf->template->display('pagination');

		if(UserGroup(GetUserid(),"is_mod") == 1 || UserGroup(GetUserid(),"is_admin") == 1 or is_moder() == true){

				print $eaf->template->display('post_tools');

		} # end admibox

		if(isset($_SESSION['username']) and isset($_SESSION['password'])){

		if(GetFastPostDo() == 1){

		$sql_fastpost = $eaf->db->dbselect(tablenamestart('topics'),"tid=".$this->tid,"","");

		$rows_fastpost= $eaf->db->dbrows($sql_fastpost);
		
		if($rows_fastpost['close'] == 0){
		
		print $eaf->template->display('fastpost');
						
						} # end if not closed
					
					} # end if showbox
				
				} #	
				
		print $eaf->template->display('theard_online');
		
		}
		
		} # end UserG
	}
	
	public function _Register(){
	
		global $eaf,$lang;
		
		if($this->action == "register"){
			
			if(UserGroup(GetUserid(),"rigester") == 1){

				print $eaf->users->SignUp_Form();
			
			}else{
				
				$eaf->_print($eaf->_Redmsg($eaf->_ForrText()));
				
			}

		}	
	}
	

	private function _ShowAnnouncement(){
			
		global $eaf,$lang;
		
		if($this->action == "announcement"){
			
		$eaf->announcement = new ShowAnnouncement;

		$eaf->announcement->_exists();	

		$ViewPlusOne = $eaf->db->query("update ".$eaf->announcement->table." set views=views+1 where id = " . $eaf->announcement->id);	
		
		$UsErId = $eaf->announcement->Rows->u_id;
		
		$eaf->announcement->Profile = new Profile($UsErId);
				
		print $eaf->template->display("show_announcement");
		}
	}
	private function _Login(){
	
		global $eaf,$lang;
		
		if($this->action == "login"){

			print $eaf->users->Login_Form();

		}	
	}
	
	
	private function _ForGotPassWord(){
	
		global $eaf,$lang;
			
		if($this->action == "forgot"){

		print $eaf->template->display("forgot_password");	
	
		}
	
	}
	
	private function _ShowPage(){
	
		global $eaf,$lang;	
		
		if($this->action == "getpage"){
			
			if(isset($eaf->_REQUEST['id']) and !empty($eaf->_REQUEST['id']) and is_numeric($eaf->_REQUEST['id'])){
				
				$id = intval(abs($eaf->_REQUEST['id']));	
			
			
			}else{
			
				header("location: index.php");
			
			}
			
			$GetPage = $eaf->db->query("select * from " . tablenamestart("pages") . " where page_id = $id");
			
			if($eaf->db->dbnum($GetPage) == 0){
				
				# Error	
			}
			
			$eaf->getPage->Rows = $eaf->db->_object($GetPage);
			
			if($eaf->getPage->Rows->page_active == 0){
			
				print $eaf->template->display("getpage");
			
			}else{
				
				header("location: index.php");
			}
			
			
		}
	}
	
	private function _Members(){
	
		global $eaf,$lang;
		
		if($this->action == "members"){
		
			$eaf->MembersPager = new Pager;

			$eaf->query = $eaf->MembersPager->Querspagination("select * from members order by uid DESC ","?action=members",GetPageNumMembers());

			print $eaf->template->display("members");

			$eaf->pages = $eaf->MembersPager->Pagination();

			print $eaf->template->display('pagination');
	
		}	
	}
		
	private function _Online(){
	
		global $eaf,$lang;
		
		if($this->action == "online"){
	
			if(UserGroup(GetUserid(),"view_online") == 1){
				
			$eaf->OnlinePager = new Pager;
			
			$eaf->query = $eaf->OnlinePager->Querspagination("select * from ".tablenamestart("online") . " order by uid DESC ","?action=online",GetPageNumOnline());

			print $eaf->template->display("online");

			$eaf->pages = $eaf->OnlinePager->Pagination();
	
			print $eaf->template->display('pagination');

			}else{
			
				$eaf->_Redmsg($eaf->_ForrText());	
			}
		
		}
	}
	
	private function _Usercp(){
	
		global $eaf,$lang;
		
		if($this->action == "usercp"){
					
			$eaf->Usercp->_exists();
			
			print "\n<div id=\"usercp\">\n";
			
			print "\n<div id=\"right\">\n";
			
			$eaf->Usercp->Menu();
			
			print "</div>\n";
			
			print "<div id=\"panel\">\n";
			
			switch($this->do){
				
			case "sendpm": 	
						
						$this->_UsercpSendPm();
						
								break;	
				
			case "friends": 	
						
						$this->_UsercpFriends();
						
								break;	
								
			case "options": 	
						
						print $eaf->template->display("usercp_options");
						
								break;	
								
			case "pm": 	
						
						$this->_UsercpUserPm();
						
								break;	
							
			case "sent": 	
						
						$this->_UsercpUserSent();
						
								break;	
							
			case "showpm": 	
						
						$this->_UsercpShowPm();
						
								break;
								
			case "inputs": 	
						
						$eaf->Usercp->Inputs = new Inputs;
						
						print $eaf->template->display("usercp_inputs"); 
						
								break;
								
			case "reputations": 	
						
						$this->_UsercpReputations();
						
								break;	

			case "attachments": 	
						
						$this->_UsercpAttachments();
						
								break;	
								
			case "profile": 	
						
						print $eaf->template->display("usercp_profile"); 
						
								break;	
			
				case "avatar": 	
						
						print $eaf->template->display("usercp_avatar"); 
						
								break;	
			
				case "signt": 	
						
						print $eaf->template->display("usercp_signt"); 
						
								break;	

				case "password": 	
						
						print $eaf->template->display("usercp_password"); 
						
								break;	
						
				case "email": 	
						
						print $eaf->template->display("usercp_email"); 
						
								break;	
								
				default:	
						
						print $eaf->template->display("usercp_home"); 
						
								break;	
			}
			
			print "\n</div>\n";

			print "\n</div>\n";
			
			print '<div style="clear:both"></div>' . "\n";
		
			}	
	}
	
	private function _Newtheard(){
		
		global $eaf,$lang;
		
		if($this->action == "newtheard"){
			
			if(UserGroup(GetUserid(),"add_topic") == 1){

				$save_post = $_SESSION['save_last_post'];

				print $eaf->template->display('newtheard');


			}else{
			
				$eaf->_Redmsg($eaf->_ForrText());	
			}

		}	
	}
	
	private function _Editpost(){
	
		global $eaf,$lang;
	
		if($this->action == "edit_post"){

			$eaf->users->IsLoggedIn();
			
			$eaf->_Editpost = new Editpost();
			
			$eaf->_Editpost->_Rows();
		
		}
		
	}
	
	private function _FastEditpost(){
	
		global $eaf,$lang;
	
		if($this->action == "fastedit_post"){

			$eaf->users->IsLoggedIn();
			
			$eaf->_Editpost = new Editpost();
			
			$eaf->_Editpost->_Rows("fast");
			
			exit;
		
		}
		
	}
	
	private function _Addpost(){
		
		global $eaf,$lang;
		
		if($this->action == "add_post"){
			
		if(UserGroup(GetUserid(),"add_topic") == 1){
			
		$eaf->users->IsLoggedIn();

		$eaf->Addpost = new Addpost();
						
		$eaf->Addpost->_Form();
		
			}else{
			
				$eaf->_Redmsg($eaf->_ForrText());	
			}
		
		}
			
	}
	
	private function TellFriend(){
	
		global $eaf,$lang;
		
		if($this->action == "tell"){
			
			if(isset($eaf->_POST['tell_send'])){
				
				$title = $eaf->security->svar($eaf->_POST['title']);
				$to = $eaf->security->svar($eaf->_POST['to']);
				$from = $eaf->security->svar($eaf->_POST['from']);
				$msg = strip_tags($eaf->_POST['msg']);
				
				if(sendmail($to,$title,$msg,$from)){
				
					$eaf->_Greenmsg($lang["tell_ok"]);	
				
				}else{

					$eaf->_Redmsg($lang["tell_error"]);	

				}
			}
			
			print $eaf->template->display("tell");	
	
			exit;
		}
	}
	
	private function _UsercpSendPm(){
		
		global $eaf;
			
		if(UserGroup(GetUserid(),"send_pm") == 1){
		
		$eaf->SendPm = new SendPm();
		
		$eaf->SendPm->_exists();
		
		$eaf->SendPm->_Form();	
		
		}else{
			
			$eaf->_Redmsg($eaf->_ForrText());	
		
		}
			
	}
	
	private function _UsercpShowPm(){
			
		global $eaf,$lang;
			
		$Rows = array();
				
			$eaf->Pm = new GetPm();
			
			$eaf->Pm->_exists();
			
			$eaf->Pm->_IsForMe();
			
			$eaf->Pm->_IsReaded();
			
			$Rows['pm'] = $eaf->Pm->_Rows();
			
			$eaf->Pm->Profile = new Profile($Rows['pm']['sender_id']);

			$eaf->Pm->Profile->user_exists();
			
			$eaf->PmTitle = $Rows['pm']['title'];
			
			$eaf->PmText  = $Rows['pm']['text'];
			
			$eaf->PmUserid= $Rows['pm']['sender_id'];
			
			$eaf->PmDate  = $Rows['pm']['date'];

			$eaf->PmSenderName  = $Rows['pm']['sender_name'];
				
			print $eaf->template->display('showpm');		
					
		}
	
	
	private function _UsercpReputations(){
	
		global $eaf,$lang;
				
		$eaf->reputations = $eaf->db->query("select * from " . tablenamestart("reputation") . " where reputation_userid = " . Userid());
		
		print $eaf->template->display('usercp_reputations');	
		
	}
	
	private function _UsercpUserPm(){
		
		global $eaf,$lang;
					
				$eaf->users->IsLoggedIn();
		
				$eaf->NewPm  = $eaf->db->query("select * from ".tablenamestart("pm")." where s_uid = ".UserId()." and sact='0' order by sid desc");
			
				$eaf->OldPm  = $eaf->db->query("select * from ".tablenamestart("pm")." where s_uid = ".UserId()." and sact='1' order by sid desc");
				
				if(strip_tags(trim($eaf->_REQUEST['act'])) == "old"){
					
					print $eaf->template->display('usercp_oldpm');
				
				}else{

					print $eaf->template->display('usercp_newpm');
	
				}
	}
	
	private function _UsercpUserSent(){

		global $eaf,$lang;
		
		$eaf->users->IsLoggedIn();
		
		$eaf->Sent  = $eaf->db->query("select * from ".tablenamestart("pm")." where s_uid = ".UserId()." and sact='2' order by sid desc");
	
		print $eaf->template->display('usercp_sent');
	}
	
	private function _Profile(){
		
		global $eaf,$lang;
		
		if($this->action == "profile"){
			
		if(UserGroup(GetUserid(),"view_profile") == 1){
			
			$eaf->Profile = new Profile($this->uid);

			$eaf->Profile->user_exists();
			
			$eaf->Profile->AddVistorMsg();

			print $eaf->template->display('profile_pages');
			
		}else{
			
			$eaf->_Redmsg($eaf->_ForrText());	
		
		}
		
		}	
	}
	
	private function _UsercpAttachments(){
		
		global $eaf,$lang;
					
			$eaf->users->IsLoggedIn();
			
			$uid = UserId();
			
			$eaf->AttachsPager = new pager;

			$eaf->query = $eaf->AttachsPager->Querspagination("select * from " . tablenamestart('attachments') . " where a_uid = $uid order by aid DESC",
										"?action=usercp&do=attachments",
										GetPageNumAttachments()
										);

			print $eaf->template->display('attachments');

			$eaf->pages = $eaf->AttachsPager->Pagination();

			print $eaf->template->display('pagination');
	
	}
	
	private function _Search(){
		
		global $eaf,$lang;
		
		if($this->action == "search"){
		
			if(UserGroup(GetUserid(),"search") == 1){
				
				print $eaf->Search->_Page();
		
			}else{
			
				$eaf->_Redmsg($eaf->_ForrText());	
		
			}
		
		}	
		
		# Res
		
		if($this->action == "search_do"){

			print $eaf->Search->_ResultsPage();
		}
	}
	
	private function _UsercpFriends(){
	
		global $eaf,$lang;
					
			$eaf->Friends->ShowFriends();	
	}
	
	private function _Portal(){
		
			global $eaf,$lang;
			
		if($this->action == "portal"){
			
		if(UserGroup(GetUserid(),"view_portal") == 1){

						
			$eaf->Protal->View();
			
		}else{
			
			$eaf->_Redmsg($eaf->_ForrText());	
		}
		
		}
	}
	
	private function _Contact(){
	
		global $eaf,$lang;
		
		if($this->action == "contact"){
		
				print $eaf->template->display('contact');
		
		}
		
	}
	
	private function _Reputation(){
		
		global $eaf,$lang;
	
		$Reputation = new Reputation;
				
		if($this->action == "addreputation"){
				
				$Reputation->_Access();
			
				$Reputation->AddReputation();
				
				print $eaf->template->display("reputation");			
				
				$eaf->_close();
		}
	}

	private function _Warning(){
		
		global $eaf,$lang;
	
		$Warning = new Warning;
				
		if($this->action == "addwarning"){
				
				$Warning->_Access();
			
				$Warning->AddWarning();
				
				print $eaf->template->display("warning");			
				
				$eaf->_close();
		}
	}

	private function _StatBox(){
		
		global $eaf,$lang;
		
		if(THIS_PAGE == "index"){
			
			print $eaf->template->display('stats');
		
		}
	}
	
	public function _TEnd(){

		global $eaf,$lang;
	
		$eaf->sql->BlocksDownShow();
		
		print $eaf->template->display('footer');
		
		DownPage();
		
		$vars = get_defined_vars();

		foreach($vars as $kay => $v){
	
			unset($$kay);
	
		}
		

	}
	
	private function _TStart(){
		
		global $eaf,$lang;
				
		print $eaf->template->display('header');
	
		print $eaf->template->display('navbar');
	
	}
	
	public function _Script(){
		
		global $eaf,$lang;
				
		$this->_FastEditpost();
	
		$this->_Reputation();
	
		$this->_Warning();
	
		$this->TellFriend();
				
		$this->_TStart();
		
		$this->_Anncounements();
	
		$this->_Home();
		
		$this->_Forum();
	
		$this->_Showtheard();

		$this->_Register();
	
		$this->_Login();
	
		$this->_ForGotPassWord();
	
		$this->_Members();
	
		$this->_Online();
	
		$this->_Usercp();

		$this->_Newtheard();

		$this->_Editpost();

		$this->_Addpost();
		
		$this->_Profile();
		
		$this->_Search();
		
		$this->_Contact();
		
		$this->_Portal();
	
		$this->_ShowAnnouncement();
		
		$this->_ShowPage();
	
		$this->_StatBox();
	
		$this->_TEnd();
	
	}

}

	$eaf->Page = new eafPages();
	
?>