<?php

# Easy Arab Forum v1
# Version is 1.3
# Date : 2011
# Email: php4u@hotmail.com
# offical website : http://sdb.jetr.org
# About :
# This script is a program management forums (discussion boards) that allows you to refer the matter fully in your board through the
# * Full Control Forum
# * Control the full membership of the Forum
# * Social control groups (administration - Moderators - Members)
# * full control sections and classifications
# * control subjects
# * Control design and templates
# * System Hacks or Extensions
# * ...... Etc.
# * Programming rights reserved
# * The program is f and for all
# * Programming By ree: Php4u 
# * Powered By 	   : EAF Version 1.3

	session_start();

	include('../connect/config.php');

	include("../includes/classes/bbcode.class.php");
	
	$eaf->BbCode = new eafBbCode;

	include("../includes/classes/core.class.php");

	include("../includes/classes/db.class.php");

	include("../includes/classes/security.class.php");
	
	include('../includes/functions.php');
		
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';
	
	echo '<script type="text/javascript" src="../includes/JQuery.js"></script>';
	
	echo '<script type="text/javascript" src="includes/ajax.js"></script>';

	$username = $eaf->security->Username($eaf->_POST['username']);
	
	$password = $eaf->security->Password($eaf->_POST['password']);
	

	if(empty($username) or empty($password)){

				$eaf->_print('<div class="red">'.$lang["empty"].'</div>');
	
				$eaf->_print('<meta http-equiv="refresh" content="3;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />');
		
				$eaf->_close();

	}

	$Query          = $eaf->db->query("SELECT * FROM members WHERE `username`='$username' AND `password`='$password'");
	
	$TotalRows      = $eaf->db->dbnum($Query);

	if($TotalRows == 0){

				$eaf->_print('<div class="red">'.$lang["login_error"].'</div>');
	
				$eaf->_print('<meta http-equiv="refresh" content="3;URL='.$eaf->_SERVER['HTTP_REFERER'].'" />');
	
				$eaf->_close();

	}else{
		
		
		$Rows 		   = $eaf->db->_object($Query);
	
		$UID 		    = $Rows->uid;
	
		$GID  			= $Rows->groupid;
		
		if(UserGroup("$UID","is_admin") == 0){
			
			$eaf->_print('<div class="red">'.$lang["page_error"].'</div>');
			
			$eaf->_print($eaf->_Refresh($eaf->_SERVER['HTTP_REFERER']));
			
			$eaf->_close();
	}

	$data = arabic_data();

	$InfoUpdata = $eaf->db->query("UPDATE members SET lastlogin='$data',ip='".getip()."' WHERE uid=$UID");

	$_SESSION['username']  = $Rows->username;

	$_SESSION['password']  = $Rows->password;

	$_SESSION['logindo']   = md5(rand(1123123,9992354));

	$_SESSION['user_id']   = $Rows->uid;

				$eaf->_print('<div class="green">'.$lang["login_ok"].'</div>');
	
				$eaf->_print('<meta http-equiv="refresh" content="3;URL=index.php" />');
		
				$eaf->_close();
	
		}

?>