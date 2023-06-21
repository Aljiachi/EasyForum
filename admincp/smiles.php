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


	include('includes/csmiles.class.php');

	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../js/JQuery.js"></script>';
	
	echo '<script src="../js/BlocksAn.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$control = new Smiles_Control_System();

	if(UserGroup(GetUserid,"admin_smiles") == 1){

	if($eaf->_REQUEST['action'] == ""){

		$control->SmilesShow();

	}

	if($eaf->_REQUEST['action'] == "add_smile"){
	
	$control->AddSmilePost();

	echo $control->AddSmile();

	}

	if($eaf->_REQUEST['action'] == "delete_smile"){
	
	$control->DeleteSmile();

	}

	if($eaf->_REQUEST['action'] == "edit_smile"){

	$control->EditSmilePost();

	echo $control->EditSmileForm();

	}
	
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>