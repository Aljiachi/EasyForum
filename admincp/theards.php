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

	include('includes/theards.class.php');
	
	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../js/JQuery.js"></script>';
	
	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$control = new EAFTheards();

	if(UserGroup(GetUserid,"admin_theards") == 1){

	if($eaf->_REQUEST['action'] == "closed"){

		$control->OpenClosedTheards();

		$control->CloseTheards();

	}
	
	if($eaf->_REQUEST['action'] == "sticked"){

		$control->UnStickTheards();

		$control->stickedTheards();

	}

	if($eaf->_REQUEST['action'] == "delete"){

		$control->DeleteWhereSection();

		$control->DeleteWhereUser();

		$control->DeleteWherePosts();

		$control->DeleteAll();

	}
	
	if($eaf->_REQUEST['action'] == "recycle_bin"){
		
		$control->RestTheards();
		
		$control->EmptyRecBin();
	
		$control->RecycleBin();	
	}
	
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>