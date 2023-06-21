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

	include('includes/options.class.php');

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
	
	$control = new AForumoptins();
		
	if(UserGroup(GetUserid,"admin_setting") == 1){

	if($eaf->_REQUEST['action'] == "forum"){

	$control->SaveEditForum();

	echo $control->ForumForm();

	}

	if($eaf->_REQUEST['action'] == "register"){

	$control->SaveEditUsers();

	echo $control->RegisterForm();

	}

	if($eaf->_REQUEST['action'] == "posts"){

	$control->EditPostAndShow();

	echo $control->PostAndShow();

	}

	if($eaf->_REQUEST['action'] == "words"){

	$control->ReplaceWordsPost();

	echo $control->ReplaceWordsForm();

	}

	if($eaf->_REQUEST['action'] == "contact_box"){

	$control->ContActShow();

	}

	if($eaf->_REQUEST['action'] == "delete_msg"){

	$control->ContActDelete();

	}
	
	if($eaf->_REQUEST['action'] == "pages"){
		
		$control->PagesPost();
		
		echo $control->PagesForm();
		
	}
	
	if($eaf->_REQUEST['action'] == "hacks"){

	$sql = $eaf->db->query("SELECT * FROM " . tablenamestart('hacks') . " WHERE hack_option!=''");

	echo '

	<table cellpadding="0" cellspacing="0" width="95%" align="center">

	<tr>

	<td>الخيارات -- التحكم بالهاكات</td>

	</tr>

	</table>

	';

	while($rows = mysql_fetch_assoc($sql)){


		$Option = str_replace("{qt}","'",$rows['hack_option']);
		$Option = str_replace("{dq}",'"',$Option);
		echo eval("?>" . $Option . "<?");
	
	}

	}
	
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}	
?>