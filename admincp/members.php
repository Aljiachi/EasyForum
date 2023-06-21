<?php

# * Easy Forum
# * Version is 2
# * Date : 2011
# * Email: php4u@hotmail.com
# * offical website : http://www.g-scripts.com
# * Programming rights reserved
# * The program is free and forall
# * Programming By : Php4u 
# * Powered By 	   : G-scripts
# * To Download Plugins, Hooks , Styles , Updates ... Visiting Our Website
	session_start();
	
	include('access.php');

	include('../connect/config.php');

	include('../includes/functions.php');
	
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	
	include('includes/querys.class.php');
	
	include('includes/cusers.class.php');

	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script src="../js/JQuery.js"></script>';
	
	echo '<script src="../js/editor_rep.js"></script>';

	echo '<script src="../look/jscolor/jscolor.js"></script>';

	echo '<script src="../js/wseditor.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';
	
	echo " \n <script type='text/javascript' charset='utf-8' src='includes/kindeditor/kindeditor.js'></script>\n
  	<script type='text/javascript'>
    KE.show({
        id : 'KindBox',
        width : '540px',
        height : '300px',
        filterMode : true
    });
 
  </script>";

	$control = new Users_System_Control(
										
										'members.php?action=add',
										
										'members.php?action=edit',
										
										'members.php?action=delete',
										
										'members.php'
										
										);

	$action  = strip_tags(trim($eaf->_REQUEST['action']));
	
	if(UserGroup(GetUserid,"admin_members") == 1){

	if($action == "" || $action == "view"){

		$control->Users_Show();

	}

	if($action == "add"){

		$control->AddUser_Insert();

		print $control->AddUser_Form();

	}

	if($action == "search"){

		echo $control->UserSearch();

	}

	if($action == "edit"){

		$control->Edit_User();

		echo $control->Edit_Form();

	}

	if($action == "delete"){

		$control->DeleteUser();

	}

	if($action == "multiaction"){

		$control->multiAction();

	}
	
	if($action == "userdo"){

		$control->OutUserPost();

		echo $control->OutUserForm();
	}
	
	if($action == "sendpm"){
		
		$control->_SendPmPost();
		
		echo $control->_SendPm();
	}
	
	if($action == "inboxpm"){
		
		$control->_InboxPmActions();
		
		echo $control->_ShowPm();
			
	}
	
	if($action == "text"){
		
		print $control->PmText();
		
	}
	
	if($action == "active_members"){
	
		$control->AcUsersShow();
	}
	
	if($action == "out_members"){
	
		$control->BaUsersShow();
	}
	
	if($action == "upban"){
		
		$control->UnOutUser();
	}
	
	if($action == "activeuser"){
	
		$control->ActiveUser();	
	}

	
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>