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

	
	include('../includes/classes/sql.class.php');

	include('includes/groups.class.php');

	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../includes/JQuery.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$control = new Groups_Control_System();

	if(UserGroup(GetUserid,"admin_groups") == 1){

	$action = $eaf->_REQUEST['action'];

	if($action=="add"){
	
		$control->Addpost();
	
		print $control->FormAdd();

	}
	
	if($action == ""){
		
		$eaf->_print($control->_ShowGroups());
	}
	
	if($action == "delete"){
		
		$control->_DEleteGroup();
		
	}
	
	if($action == "edit"){
	
		$control->_EditPsot();
		
		$eaf->_print($control->_EDitForm());
			
	}
	
	if($action == "move"){
	
		$control->_MovePost();
		
		$eaf->_print($control->_MoveForm());	
	}

	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>