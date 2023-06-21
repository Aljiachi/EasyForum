<?php

# Easy Arab Forum v1
# Version is 1.3
# Date : 2011
# Email: php4u@hotmail.com
# offical website : http://sdb.jetr.org
# About :
# This script is a program management forums (discussion boards) that allows you to refer the matter fully in your board through the
# * Full Control Forum
# * Control the full membership of the Forum
# * Social control groups (administration - Moderators - Members)
# * full control sections and classifications
# * control subjects 
# * Control design and templates
# * System Hacks or Extensions
# * Portal System With Add Blocks 
# * ...... Etc.
# * Programming rights reserved
# * The program is free and for all
# * Programming By : Php4u 
# * Powered By 	   : EAF Version 1.3

class Globals{

	public function _Run(){
			
		global $eaf,$lang;
		
		if(isset($eaf->_REQUEST['action']) && !empty($eaf->_REQUEST['action'])){
			
			$action = $eaf->security->svar($eaf->_REQUEST['action']);
				
		}
	
		if(!$eaf->db->query("select * from phpforyou_online limit 1") ){
			
				@$eaf->db->query("REPAIR TABLE `phpforyou_online`");
		}
			
		if(isset($_SESSION['style_folder'])){
											
				if(!is_dir('styles/'.$_SESSION['style_folder'])){
											
					$_SESSION['style_folder'] = GetStyleFolder();
											
					if(!is_dir('styles/'.GetStyleFolder())){
											
							die("<font color=\"red\" size=\"7\">Style Folder Not Exists</div>");
											
					}
											
		}else{
												
				$StyleFolderGet = $_SESSION['style_folder'];
	
		}
									
				$eaf->template = new Template('includes/cache/'.$_SESSION['style_folder'], 'styles/'.$_SESSION['style_folder'].'/templates');
											
	
		}else{
	
				if(!is_dir('styles/'.GetStyleFolder())){
											
						die("<font color=\"red\" size=\"7\">Style Folder Not Exists</div>");
									
				}
											
				if(isset($_SESSION['username'])){
												
						$GetUserStyleInfo = $eaf->db->_object($eaf->db->query("select your_style from members where uid=" . Userid()));
											
						$GetUserStyle     = $eaf->db->_object($eaf->db->query("select style_folder from " . tablenamestart("styles") . " where style_id = " . $GetUserStyleInfo->your_style));
												
						if($GetUserStyleInfo->your_style == 0){
	
								$RootSTyle    = GetStyleFolder();	
		
						}else{
												
								$RootSTyle    = $GetUserStyle->style_folder;
												
						}
											
				}else{
											
						$RootSTyle    = GetStyleFolder();	
				
				}
											
				$eaf->template = new Template('includes/cache/'.$RootSTyle, 'styles/'.$RootSTyle.'/templates');
																					
				$StyleFolderGet = GetStyleFolder();							
											
		}
	
		$eaf->users   	= new eafUsers;
		
		$eaf->call    	= new eafContact;
	
		$eaf->online  	= new eafOnline;
		
		$eaf->Friends 	= new eafFriends;
		
		$eaf->Protal  	= new eafPortal;
	
		$eaf->Usercp 	= new eafUsercp;
	
		$eaf->BbCode 	= new eafBbCode;
	
		$eaf->Ajax   	= new eafAjax;
		
		$eaf->Rating 	= new eafRating;
		
	/*
		if($action == "imager"){
	
			$imager = new Imager();
				
			// Start Imager 
			$imager->run();
				
			exit;	
	
			}*/
			
		if($action == "print"){
			
			$eaf->Print = new PrintTheard;
			
			$eaf->Print->Run();
			
			$eaf->Print->MkSql();
			
			$eaf->Print->Rows();
			
			$eaf->Print->start();
					
			$eaf->Print->GetTheard();
	
			$eaf->Print->GetPosts();
			
			$eaf->Print->end();
			
			$eaf->_close();
		}
	
	
		# Ajax
				
		$eaf->Ajax->Replay();	
				
		$eaf->Ajax->VistorMsg();	
	
		$eaf->Ajax->Editguestmsg();	
	
		$eaf->Ajax->Deleteguestmsg();	
	
		$eaf->Ajax->GetUser();	
		
		$eaf->Rating->run();
	
		$eaf->Friends->addFriend();
	
		$eaf->filesManger->DownloadAttachment();
	
		# Get Title , Style , Javascript , Meta
		StartPage($StyleFolderGet,$eaf->sql->Title());
	
		$eaf->SDB->ThisPage();
		
		# Sql Querys 
		$eaf->sql->EditPost();	
		
		$eaf->sql->InsertPost();
	
		$eaf->sql->AddPost();
	
		$eaf->sql->SendMsgPm();
	
		$eaf->sql->DeleteNewPm();
	
		$eaf->sql->DeleteOldPm();
	
		$eaf->sql->PostStyleSelect();
		
		# Contact
		$eaf->call->access();
	
		$eaf->call->insert();
	
		$eaf->SDB->Act();
	
		if($eaf->_REQUEST['action'] == "tools_all") {
		
			$eaf->sql->CloseAll();
		
			$eaf->sql->RecAll();
		
			$eaf->sql->UnCloseAll();
		
			$eaf->sql->StickAll();
		
			$eaf->sql->UnStickAll();
		
			if(isset($eaf->_POST['move'])){
		
			$eaf->query = $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE sort!='0' ");	
		
			$eaf->Check = $eaf->_POST['check'];
		
			if(empty($eaf->Check)){
		
				$eaf->_Redmsg($lang["alert_empty"]);
			
				echo ' <meta http-equiv="refresh" content="3;URL='.$_SERVER['HTTP_REFERER'].'" />';
			
				$eaf->_close();
				
			}
		
			$eaf->Check = implode(",",$eaf->Check);
			
			print $eaf->template->display('post_move');
			
			$eaf->_close();
			
			}
			
			$eaf->sql->MovePostAll();
		
		}
			
		if($eaf->_REQUEST['action'] == "post_tools"){
		
			if(UserGroup(GetUserid(),"is_admin") == 1 || UserGroup(GetUserid(),"is_mod") == 1){
			
				switch($eaf->_REQUEST['do']){
			
				case "stick":	
					
					$eaf->sql->StickPost();
					
				break;
			
				case "merge":	
					
					$eaf->sql->MergeTopic();
			
					print $eaf->template->display("post_merge");		
					
					exit;
					
				break;
			
				case "close":	
					
						$eaf->sql->ClosePost(); 
						
					break;
			
				case "recy":	
					
						$eaf->sql->ٌRecyPost(); 
						
					break;
			
				case "move": 
			
					$eaf->sql->MovePost();
			
					$eaf->SDB->MoveTemplate();
			
					exit;
			
				break;
			
				}
			
				
			}else{	
						
				echo $eaf->_Redmsg($lang["alert_cant_doit"]);
						
				echo '<meta http-equiv="refresh" content="3;URL='.$_SERVER['HTTP_REFERER'].'" />';
						
				exit;	
			
			}
	
		}
		
		$eaf->SDB->Errors();
	
		$eaf->users->LoginAccess();
	
		$eaf->users->SignUp_Insert();
		
		if($eaf->_REQUEST['action'] == "logout"){
		
			$eaf->users->LogouT();
	
		}
		
		# Who'is online
		$eaf->online->OnLine();
		
		$eaf->sql->UpdateUsetTopicsTotals();
	
		$eaf->SDB->UploadAttachment();
			
		$eaf->Friends->DeleteFriend();
	
		$eaf->Friends->AcceptFriend();
	
		$eaf->sql->DeleteTopic($eaf->_REQUEST['tid']);	
		
		$eaf->users->_ForGotPssWord();
	
		$eaf->Usercp->EditAvatar();
	
		$eaf->Usercp->EditSignt();
	
		$eaf->Usercp->EditPassword();
		
		$eaf->Usercp->EditProfile();
		
		$eaf->Usercp->EditEmail();
	
		$eaf->Usercp->EditInputs();
	
		$eaf->Usercp->EditOptions();
		
		$eaf->users->Active();
	
	}
	
	
}
?>