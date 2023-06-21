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
	include('access.php');

	include('../connect/config.php');

	include('../includes/functions.php');
	
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	
 ?>

<link type="text/css" rel="stylesheet" href="style/<?php print $lang["style"]; ?>.css" />
<div id="nav"><a><img src="icons/web.png" border="0" /><?php print $lang["welcome"]; ?> <? echo $_SESSION['username']; ?></a>     
<a href="../?home" target="_new"><img src="icons/home.png" border="0" /><?php print $lang["forum_page"]; ?></a>          
<a href="out.php" target="_parent"><img src="icons/logout.png" border="0" /><?php print $lang["logout"]; ?></a>    </div>       
