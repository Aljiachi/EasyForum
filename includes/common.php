<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

		
	include('connect/config.php');

	include('includes/classes/core.class.php');

	include('includes/classes/db.class.php');

	include('includes/classes/bbcode.class.php');
	
	include('includes/functions.php');
	
	if(is_dir("languages/" . GetLangFolder())){
			
			include("languages/" . GetLangFolder() ."/forum.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	include('includes/classes/sql.class.php');

	include('includes/classes/security.class.php');

//	include("includes/classes/imager.class.php");
	
	include('includes/classes/template.class.php');

	include('includes/classes/users.class.php');

	include("includes/classes/contact.class.php");

	include("includes/classes/querys.class.php");

	include("includes/classes/online.class.php");

	include("includes/classes/profile.class.php");

	include("includes/classes/showtheard.class.php");

	include("includes/classes/forum.class.php");

	include("includes/classes/pm.class.php");

	include("includes/classes/search.class.php");

	include("includes/classes/usercp.class.php");

	include("includes/classes/editpost.class.php");

	include("includes/classes/addpost.class.php");

	include("includes/classes/portal.class.php");

	include("includes/classes/sendpm.class.php");

	include("includes/classes/reputation.class.php");

	include("includes/classes/warning.class.php");

	include("includes/classes/inputs.class.php");

	include("includes/classes/friends.class.php");

	include("includes/classes/theardprint.class.php");

	include("includes/classes/pager.class.php");

	include("includes/classes/show_announcement.class.php");

	include("includes/classes/pages.class.php");

	include("includes/classes/ajax.class.php");

	include("includes/classes/rating.class.php");

	include('includes/classes/files.class.php');

	include("includes/classes/globals.class.php");

	include("includes/global.php");
?>
