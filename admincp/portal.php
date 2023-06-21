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


	include('includes/portal.class.php');

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

    function clearEditor(id) {
          KE.g[id].iframeDoc.open();
          KE.g[id].iframeDoc.write(KE.util.getFullHtml(id));
          KE.g[id].iframeDoc.close();
          KE.g[id].newTextarea.value = '';
      }
  </script>";
  
	$control = new EafProtalControl();
	
	$action  = $eaf->_REQUEST['action'];
		
		if(UserGroup(GetUserid,"admin_hacks") == 1){

	
	if($action == ""){
	
		print $control->ViewBlocks();	
	}
	
	if($action == "addmenu"){
		
			$control->_AddPost();
		
			$eaf->_print($control->_AddForm());
	}
	
	if($action == "remove"){
	
		$control->Delete();
			
	}
	
	if($action == "edit"){
		
		$control->EditPost();
		
		print $control->EditForm();
	}
	
	if($action == "active"){
		
		$control->Active();
	}
	
	if($action == "unactive"){
	
		$control->UnActive();	
	}
	
		}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>