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


	include('includes/styles.class.php');
	
	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../js/JQuery.js"></script>';
	
	echo '<script src="../js/BlocksAn.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$control = new StylesControl();

	if(UserGroup(GetUserid,"admin_styles") == 1){


	if($eaf->_REQUEST['action'] == ""){

	echo $control->ShowStyles();

	}
	
	if($eaf->_REQUEST['action'] == "add_style"){

	$control->AddStylePost();

	echo $control->AddStyleForm();

	}

	if($eaf->_REQUEST['action'] == "delete_style"){

	$control->DeleteStyle();

	}

	if($eaf->_REQUEST['action'] == "edit_style"){

	$control->EditStylePost();

	echo $control->EditStyleForm();

	}

	if($eaf->_REQUEST['action'] == "templates_style"){

	$control->StyleTemplates();

	if($eaf->_REQUEST['tname']){

	$control->StyleTemplateEdit();

	}

	}

	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>