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

	
	include("includes/hacks.class.php");

	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../js/JQuery.js"></script>';
	
	echo '<script src="../js/BlocksAn.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$blocks = new AForumHacks;
	
		if(UserGroup(GetUserid,"admin_hacks") == 1){

		$action = strip_tags(trim($eaf->_REQUEST['action']));

		if($action == ""){ 
		
		echo $blocks->ShowBlocks('hacks.php?action=updatehack','hacks.php?action=deletehack','hacks.php?action=addhack');
		
		}

		if($action == "addhack"){
			
			echo $blocks->addform('hacks.php?action=save_addhack');	
			
		}

		if($action == "save_addhack"){
			
			$blocks->addblock();
			
		}

		if($action == "deletehack"){
			
				$blocks->DeleteBlock();
				
		}

		if($action == "unactive"){
			
			$blocks->UnActiveHack();
			
		}

		if($action == "active"){
			
			$blocks->ActiveHack();
			
		}
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>
