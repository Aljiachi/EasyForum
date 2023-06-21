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
# * To Download Plugins, Hooks , Styles , Updates ... Visiting Our Website	session_start();

	include('access.php');

	include('../connect/config.php');

	include('../includes/functions.php');
	
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}


	include('includes/moderators.class.php');

	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../js/JQuery.js"></script>';
	
	echo '<script src="../js/BlocksAn.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$control = new ModeratorsControl;
	
	if(UserGroup(GetUserid,"admin_icons") == 1){

	if($eaf->_REQUEST['action'] == "add"){
		
		$control->PostAdd();
		
		print $control->AddForm();

	}
	
	if($eaf->_REQUEST['action'] == ""){
		
		print $control->show();
	}
	
	if($eaf->_REQUEST['action'] == "delete"){
	
		$control->delete();	
	}
	
	if($eaf->_REQUEST['action'] == "edit"){
		
		$control->postEdit();
	
		$control->edit();	
	}
	
	if($eaf->_REQUEST['action'] == "modact"){
	
		$control->getModerLogs();	
	}
	
	if($eaf->_REQUEST['action'] == "empty"){
	
		$control->EmptyActions();	
	}
	
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}

?>