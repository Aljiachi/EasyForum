<?php
session_start();

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

	include('access.php');

	include('../connect/config.php');

	include('../includes/functions.php');
	
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Easy Forum - CPanel - <? echo ForumName();  ?></title>
<meta name="robots" content="noindex" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="nosnippet" />
<link type="text/css" rel="stylesheet" href="style/style.css" />
<script type="text/javascript" src="../includes/JQuery.js"></script>
<script type="text/javascript" src="includes/ajax.js"></script>
<link rel="shortcut icon" href="icons/favicon.png" />
</head>
	<? if($lang["dir"] == "rtl"){  ?>
	<frameset cols="*,15%" framespacing="0" border="0" frameborder="0">
		<frameset rows="40,*" frameborder="no" border="0">
			<frame src="navbar.php" name="head" frameborder="0" scrolling="no" border="no" />
			<frame src="home.php" name="main" frameborder="0" border="no" />
		</frameset>
        <noframes></noframes>
		<frame src="menu.php" name="nav" frameborder="0" border="no" />
	</frameset>
	
	<? }else{ ?>
	<frameset cols="15%,*" framespacing="0" border="0" frameborder="0">
		<frame src="menu.php" name="nav" frameborder="0" border="no" />		
        <noframes></noframes>
        <frameset rows="40,*" frameborder="no" border="0">
        			<frame src="navbar.php" name="head" frameborder="0" scrolling="no" border="no" />
			<frame src="home.php" name="main" frameborder="0" border="no" />
		</frameset>
	</frameset>
	    <? } ?>

	</html>

	