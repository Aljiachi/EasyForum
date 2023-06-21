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
			
		$eaf->Global = new Globals();
		
		$eaf->Global->_Run();
	
		if(isset($eaf->_REQUEST['action'])){
	
			$action = $eaf->security->svar($eaf->_REQUEST['action']);
	
			}
		
		if(isset($eaf->_REQUEST['fid']) && !empty($eaf->_REQUEST['fid'])){
		
		    if(is_numeric($eaf->_REQUEST['fid'])){
				
			$fid	= $eaf->security->sint($eaf->_REQUEST['fid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			}
		  }
	
		if(isset($eaf->_REQUEST['tid'])){   
		
			if(is_numeric($eaf->_REQUEST['tid'])){
				
			$tid    = $eaf->security->sint($eaf->_REQUEST['tid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			
				}
			
		   }
	
		if(isset($eaf->_REQUEST['pid'])){   
	
			
			if(is_numeric($eaf->_REQUEST['pid'])){
				
		    $pid    = $eaf->security->sint($eaf->_REQUEST['pid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			
				}
		
		   }

		if(isset($eaf->_REQUEST['uid'])){   
	
			
			if(is_numeric($eaf->_REQUEST['uid'])){
				
		    $uid    = $eaf->security->sint($eaf->_REQUEST['uid']);
		   
		    }else{
			
				header("location: index.php");
				
				exit;	
			
	
		   }	
		
		}
		   
		$Got = array(	
				"ForumName"  	=>  ForumName()  			 		,
				"ForumMeta"  	=>  ForumMeta()   			   		,
				"CloseDo"    	=>  ForumCloseDo()		   			,
				"CloseText"  	=>  ForumCloseMsg()		   			, 
				"StylePath"  	=>  GetStyleFolder() 		  		,
				"Theards"		=>  TotalTopics()			 		,
				"Posts"      	=>  TotalPosts()			  		,
				"Users"	  		=>  TotalUsers()	 		  		,
				"NavLinks"   	=>  $eaf->sql->NavBarLinks() 		, 
				"LastUser"   	=>  LastUser()						,				
				"StyleMenu"  	=>  SelectStyleMenu()				,
				"JumpMenu"   	=>  JumpMenu()						,				
				"OnlineQuery"  	=>  $eaf->online->UsersOnline()		,				
				"Smiles"	 	=> $eaf->SDB->Smiles()				,				
				"Icons"	  		=> $eaf->SDB->Icons()		 		,
				"Newpm"      	=> NewPm()							,
				"ActivedFriends"=> $eaf->Friends->QueryFriendsActived() ,
				"UnActivedFriends" => $eaf->Friends->QueryFriendsUnActived(),
				"RightBlocks" 	=> $eaf->Protal->GetRightBLocks(),
				"LeftBlocks" 	=> $eaf->Protal->GetLeftBLocks(),
				"CenterBlocks" 	=> $eaf->Protal->GetCenterBLocks()	 ,
				"NewFriends" 	=> NewFriends()				 		 ,
				"WNew" 			=> WNew()							 ,
				"GetGroupsList" => GetGroupsList()			 		 ,				
				"OptionsQuery" 	=> $eaf->db->query("select * from " . tablenamestart("infosite"))
				);
			
				$Got["options"]      = $eaf->db->dbrows($Got['OptionsQuery']);	

		if(isset($eaf->_REQUEST['fid'])){

			$Got['TheardsQuery'] = $eaf->System->Forum->_ForumTheards();
			
			$Got['StickyTheards']= $eaf->System->Forum->_StickyTheards();
						
			$Got['totalTheards']   = $eaf->System->Forum->_TotalTheards();
			
		}
		
		if(isset($_SESSION['style_folder']))  $stylefolder = $_SESSION['style_folder']; else $stylefolder = GetStyleFolder();	
			
		$username 	 	  = GetUserName();

		$attachmentsTypes = GetAttachmentsTypes();
	
		$attachments_size  = GetAttachmentsSize();

		$attachments_do    = GetAttachmentsDo();
		
		$ForumName		 = ForumName();
		
		$Location          = $eaf->_SERVER['REQUEST_URI'];

		$UserId			= UserId();
		
		$GetStylesList     = GetStylesList();
		
		$GetPagesList      = GetPagesList();
		
		$Rows = array();
	
		$group = array(
						UserGroup(GetUserid(),"edit_topic"),
						UserGroup(GetUserid(),"delete_topic"),
						UserGroup(GetUserid(),"mod_edit"),
						UserGroup(GetUserid(),"mod_delete"),
						UserGroup(GetUserid(),"mod_move"),
						UserGroup(GetUserid(),"mod_sticky"),
						UserGroup(GetUserid(),"view_userip"),
						UserGroup(GetUserid(),"is_mod")	,
						UserGroup(GetUserid(),"is_admin"),
						UserGroup(GetUserid(),"mod_close"),
						UserGroup(GetUserid(),"view_userip")							
						
						);
		$moder = array(
					getModerFile("edit"),
					getModerFile("delete"),
					getModerFile("sticky"),
					getModerFile("move"),
					getModerFile("close"),
					getModerFile("merge"),
					getModerFile("recy")
					);
					
		$eaf->Page->_Access();

		$eaf->Page->_Script();

?>