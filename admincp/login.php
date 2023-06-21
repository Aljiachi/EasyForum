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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EasyForum - Cpanel</title>
<meta name="robots" content="noindex" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="nosnippet" />
<link type="text/css" rel="stylesheet" href="style/<?php print $lang["style"]; ?>.css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script src="../js/BlocksAn.js"></script>
<script type="text/javascript" src="includes/ajax.js"></script>
</head>
<body>
<div style="text-align:center;">
<div id="LoginForm">
<form name="login" action="check.php"method="post">
<input type="text" name="username" class="LF" value="username" />
<input type="password" name="password" class="LF" value="password" />
<input type="submit" name="post"  class="LF" value="<?php print $lang["login"]; ?>" />
</form>
</div>
</div>
</body>
</html>