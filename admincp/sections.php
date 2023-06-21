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


	include('includes/sections.class.php');
	
	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';
	
	echo '<script type="text/javascript" src="../js/JQuery.js"></script>';

	echo '<script src="../js/BlocksAn.js"></script>';

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

	$control = new SectionsControl();

	if(UserGroup(GetUserid,"admin_sections") == 1){

	if($eaf->_REQUEST['action'] == ""){
		
		echo $control->ShowSections();

	}

	if($eaf->_REQUEST['action'] == "addforum"){
	
	$control->AddForumPost();

	echo $control->AddForumForm();

	}
	
	if($eaf->_REQUEST['action'] == "addsection"){
		
		$control->addSectionPost();
		
		print $control->addSection();	
	}

	if($eaf->_REQUEST['action'] == "sortcats"){

	$control->ShowSortSections();

	}

	if($eaf->_REQUEST['action'] == "edit"){

	$control->EditPostSection();

	echo $control->EditSectionForm();

	}

	if($eaf->_REQUEST['action'] == "delete"){

	$control->DeleteSection();

	}

	if($eaf->_REQUEST['action'] == "nosort"){

	$control->ShowNoSortSections();

	}
	
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>