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
# * The program is free and for all
# * Programming By : Php4u 
# * Powered By 	   : EAF Version 

	@ob_start();

	@session_start();
	
	include("../includes/classes/core.class.php");
	
	include("../includes/classes/db.class.php");

	include("../includes/classes/security.class.php");

	include("../includes/classes/bbcode.class.php");
	
	$eaf->BbCode = new eafBbCode;
	
	if(!isset($_SESSION['username']) or !isset($_SESSION['password']) or !isset($_SESSION['logindo'])){
	
		session_destroy();
	
		header("location: login.php");

	}

	ob_end_flush();
	
	define(GetUserid,$_SESSION['user_id']);


?>