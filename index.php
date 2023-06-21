<?php

# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

	ob_start();

	session_start();

	if(file_exists("install.done")){
	
		include('includes/common.php');

	}else{

		header("location: install/index.php");

	}

	ob_end_flush();

?>