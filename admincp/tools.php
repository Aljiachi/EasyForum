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


	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	if(UserGroup(GetUserid,"admin_tools") == 1){

	if($eaf->_REQUEST['action'] == "phpinfo"){

	echo phpinfo();

	}

	if($eaf->_REQUEST['action'] == "cacheremove"){

		$sql = mysql_query("SELECT * FROM " . tablenamestart("styles"));

		while($rows = mysql_fetch_assoc($sql)){

			if ($dh = @opendir('../includes/cache/' . $rows['style_folder'] . '')) {
      
	  		  while (($file = @readdir($dh)) !== false) {
		
				@unlink('../includes/cache/' . $rows['style_folder'].'/'.$file);
       
	   		 }
        
				@closedir($dh);
    
		}

		if ($dh = @opendir('../includes/imagecache')) {
      
	  		  while (($file = @readdir($dh)) !== false) {
		
				@unlink('../includes/imagecache/'.$file);
       
	   		 }
        
				@closedir($dh);
    	
		}
}

	echo '<div class="green">'.$lang["cachRemove"].'</div>';

	}

	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>