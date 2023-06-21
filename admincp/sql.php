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


	echo '<link type="text/css" rel="stylesheet" href="style/'.$lang["style"].'.css" />';

	echo '<script type="text/javascript" src="../includes/JQuery.js"></script>';

	echo '<script type="text/javascript" src="includes/ajax.js"></script>';
	
	if(UserGroup(GetUserid,"admin_tools") == 1){

	echo'

	<div class="head">'.$lang["tools_sql"].'</div>

	<div id="bodypanel">

	<div align="center">
	
	<form method="post" action="?save=sql" name="sql_vars">

	<textarea rows="8" style="direction:ltr;" name="sql" cols="60"></textarea> <br />

	<input type="submit" name="send" value="'.$lang["post"].'" />

	</form>

	</div>

	</div>

	';

	if($eaf->_REQUEST['save'] == "sql"){

	$sql_vars = $eaf->_POST['sql'];

	$sql_vars = str_replace("\'", "'",$sql_vars);

	$sql_vars = str_replace('\"', '"',$sql_vars);

     $Query = mysql_query($sql_vars);
	 
		if($Query)
	
		{

	
		echo '<div class="green">';

		echo $lang["alert_ok"] . "  <br />

		<div style='direction:ltr;'>".$sql_vars."</div>

		";

		echo "</div>";

		}else{

			echo  '<div class="red">'.$lang["alert_error"].'
	
			<div style="direction:ltr;">
			
			sql db : '.$sql_vars.' <br />

			        mysql error : '.mysql_error().' </div>
			
			</div>

			';

		}

		}
	}else{
		
		echo '<div class="red">'.$lang["page_error"].' </div>';

	}
?>