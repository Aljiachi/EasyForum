<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


include(\"../includes/classes/core.class.php\");
include(\"../includes/classes/security.class.php\");
$step = intval(abs($eaf->_REQUEST['step'])); 
$Lang = strip_tags(trim($_GET['lang']));
if($Lang == \"ar\") $Dir = \"rtl\"; else $Dir == \"ltr\";
if($Lang == \"ar\") $Text = \"right\"; else $Text == \"left\";
$nxt  = $step + 1;
$prv  = $step - 1;
?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Easy Forum - Install</title>
<style>
body{
	margin: 0;
	padding: 0;
	font-size: 12px;
	font-family: Tahoma, arial, helvetica, \"Bitstream Vera Sans\", sans-serif;
	color: #000;
	line-height: 1.5em;
	background-color: #FDFDFD;
}
a, a:link, a:visited	{ color: #333; text-decoration: none; }
a:hover	{ color: #666; }
.header{
	padding:15px;
	border-bottom:solid 6px #CCC;
	text-align:<?php print $AText; ?>;	
}
.navbar{
	margin:5px;
	text-align:center;
	padding:6px;
	background:#fff;
	border:solid 1px #EAEAEA;
}
.navbar span{
	border-left:solid 1px #999;
	padding:8px;
}
.navbar .active{
	padding:8px;
	margin-right:0px;
	background:#FBFBFB;
	border-bottom:2px #666 solid;	
}
.box_body{
	background:#FBFBFB;
	padding:20px;
	margin:5px;
	text-align:<?php print $AText; ?>;
	border:solid 3px #EAEAEA;	
}
.title{
	font-weight:bold;
	text-decoration:underline;	
}
table{
	border-collapse:collapse;	
}
td{
	margin:4px;
	padding:6px;
	text-align:<?php print $AText; ?>;
	background:#FCFCFC;
	border:solid 1px #EBEBEB;	
}
input{
	padding:2px;
	border:solid 1px #066;
}
.green{
	color:green;
	font-weight:700;
}
.line{
	border-bottom:solid 1px #666;
	margin:3px;
	padding:3px;	
}
.red{
	color:red;
	font-weight:700;	
}
.go{
	background:#0C0;
	border:solid 3px #060;
	text-align:center;
	color:#fff;
	padding:10px;
	margin:15px;	
}
.go:hover{
	background:#fff;
	border:solid 3px #999;	
}
.go a{
	color:#fff;
	font-size:18px;	
}
.go:hover a{
	color:#030;	
}
</style>
</head>
<body dir=\"<?php print $Dir; ?>\">
<div class=\"header\">
Easy Arab Forum 1.2 Installer - Step Number :
<?php
if(empty($step)){
	echo '0';	
}else{
	echo $step;	
}
?>
</div>
<div class=\"box_body\">
<? if($step == \"\"){ ?>
<div class=\"text\">
<div class=\"go\"><a href=\"index.php?lang=ar&step=<? echo $nxt; ?>\">العربية</a></div>
<div class=\"go\"><a href=\"index.php?lang=en&step=<? echo $nxt; ?>\">English</a></div>
</div>
<? } ?>
<? if($step == 1) { ?>
<? include($Lang . \"/lang.php\"); ?>
<form name=\"info\" method=\"post\" action=\"index.php?lang=<?php print $Lang; ?>&step=2\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
<tr>
<td><?php print $Ilang[\"dbhost\"]; ?></td>
<td><input type=\"text\" name=\"dbhost\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"dbname\"]; ?></td>
<td><input type=\"text\" name=\"dbname\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"dbpass\"]; ?></td>
<td><input type=\"text\" name=\"dbpass\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"dbuser\"]; ?></td>
<td><input type=\"text\" name=\"dbuser\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"Send\"]; ?></td>
<td><input type=\"submit\" name=\"sendinfo\" /></td>
</tr>
</table>
</form>
<? } ?>
<? if($step == 2){
		include($Lang . \"/lang.php\");
		if(isset($eaf->_POST['sendinfo'])){
		$contact = mysql_connect($eaf->_POST['dbhost'],$eaf->_POST['dbuser'],$eaf->_POST['dbpass']);
		$contact = mysql_select_db($eaf->_POST['dbname'],$contact);
			if($contact){
				echo '<div class=\"green\">'.$Ilang[\"dbconnect_ok\"].'</div>';
				$dbname = $eaf->_POST['dbname'];
				$dbuser = $eaf->_POST['dbuser'];
				$dbpass = $eaf->_POST['dbpass'];
				$dbhost = $eaf->_POST['dbhost'];
				$newdir = mkdir(\"../connect\",0777);
				$new = @fopen(\"../connect/config.php\",w);
				$text= \"<?
	
	function ThisConnectERORR(){

	echo '<div dir=\"rtl\" style=\"color:red;font-size:22px;\" align=\"center\">

	An error occurred in the contact <br />

	Please send us an e-mail php4u@hotmail.com <br />
	
	Error is : '.mysql_error().'
	
	</div>';	
	exit;
	
	}
	
\".'$CONT = array(); '.\"
\".'$CONT[\"HOSTNAME\"]= '.\" '$dbhost';
\".'$CONT[\"DBNAME\"]  = '.\" '$dbname';
\".'$CONT[\"DBUSER\"]  = '.\" '$dbuser';
\".'$CONT[\"DBPASS\"]  = '.\" '$dbpass'; 
\".'$connect'.\" = @mysql_connect(\".'$CONT[\"HOSTNAME\"]'.\",\".'$CONT[\"DBUSER\"]'.\",\".'$CONT[\"DBPASS\"]'.\");
\".'$connect'.\" = @mysql_select_db(\".'$CONT[\"DBNAME\"]'.\",\".'$connect'.\");
if(!\".'$connect'.\"){
	ThisConnectERORR();
}
?> \";
				$content = @fwrite($new,$text);
				file_put_contents(\"../install.done\",\"Is Installed\");
				file_put_contents(\"../connect/.htaccess\",\"deny from all\");
				file_put_contents(\"../connect/index.html\",'<html><head><title>EasyForum</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"></head><body bgcolor=\"#FFFFFF\"></body></html>');
						
						if($content){
						
							echo '<div class=\"green\">'.$Ilang[\"dbfile_ok\"].'</div>';
						
						?>
                        
                        <div class=\"go\"><a href=\"index.php?lang=<?php print $Lang; ?>&step=<? echo $nxt; ?>\"><?php print $Ilang[\"ne\"]; ?></a></div>
						
						<?
						
						}else{
						
							echo '<div class=\"red\">'.$Ilang[\"dbfile_error\"].'</div>';
						    echo' <div class=\"go\"><a href=\"index.php?lang='.$Lang.'&step='.$prv.'\">'.$Ilang[\"pr\"].'</a></div>';
	
						}
				
			}else{
				echo '<div class=\"red\">'.$Ilang[\"dbconnect_error\"].' <br />
				'.mysql_error().'
				</div>';
               echo' <div class=\"go\"><a href=\"index.php?lang='.$Lang.'&step='.$prv.'\">'.$Ilang[\"pr\"].'</a></div>';
			}
		}
} ?>
<?
if($step == 3){
			include(\"../connect/config.php\");
			include($Lang . \"/lang.php\");
           $filename = $Lang . \"/database.sql\"; 
             set_time_limit(900);
             $w = 1;
             
             $cur_sql = '';
             
             if (function_exists('file')) {
                 $sql_file = file($filename);
             } else {
                 $open     = fopen($filename, 'r');
                 $fdata    = fread($open, filesize($filename));
                 $sql_file = explode(\"\n\", $fdata);
             }
             
             foreach ($sql_file as $v) {

                 $sql = trim($v);
                 
                 if ($sql[0] == '-') {
                     continue;
                 }
                 
                 if (!$sql) {
                     continue;
                 }
                 
                 $cur_sql .= $sql . ' ';
                 if (substr($sql, -1, 1) == ';') {
                     $sql_statements[] = substr(trim($cur_sql), 0, -1);
                     $cur_sql          = '';
                 }
             }

             if (count($sql_statements)) {
                 foreach ($sql_statements as $k => $v) {
				 
                     if (!mysql_query($v)) {
                         $wrong = mysql_error();
                         $ww    = $w++;
                         $xxx .= \"$ww => $wrong in [$v]\n\n\";
                         
                     }
                 }
 
            }
$sql = \"SHOW TABLES FROM \".$CONT['DBNAME'];
$result = mysql_query($sql);
echo '<div class=\"green\">'.$Ilang[\"table_ok\"].'</div>' ;
echo '<ol>';
while($row = mysql_fetch_array($result)){
echo  \"<li>\" . $row[0] . \"</li>\n\";
}
echo '</ol><div class=\"line\"></div>';	
echo '<div class=\"green\">'.$Ilang[\"insert_ok\"].'</div>';
?>
<div class=\"go\"><a href=\"index.php?lang=<?php print $Lang; ?>&step=<? echo $nxt; ?>\"><? echo $Ilang[\"ne\"]; ?></a></div>
<? }
?>
<? if($step == 4) { ?>
<? include($Lang . \"/lang.php\"); ?>
<form name=\"info\" method=\"post\" action=\"index.php?lang=<?php print $Lang; ?>&step=5\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
<tr>
<td><?php print $Ilang[\"fname\"]; ?></td>
<td><input type=\"text\" name=\"title\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"fdec\"]; ?></td>
<td><input type=\"text\" name=\"meta\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"furl\"]; ?></td>
<td><input type=\"text\" name=\"url\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"fmail\"]; ?></td>
<td><input type=\"text\" name=\"email\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"username\"]; ?></td>
<td><input type=\"text\" name=\"username\" /></td>
</tr>
<tr>
<td><?php print $Ilang[\"password\"]; ?></td>
<td><input type=\"text\" name=\"password\" /></td>
</tr>
<tr>
<tr>
<td><?php print $Ilang[\"email\"]; ?></td>
<td><input type=\"text\" name=\"mail\" /></td>
</tr>
<tr>
<tr>
<td><?php print $Ilang[\"Send\"]; ?></td>
<td><input type=\"submit\" name=\"info_send\" /></td>
</tr>
</table>
</form>
<? } ?>
<? if($step == 5){
		include(\"../connect/config.php\");
		include($Lang . \"/lang.php\");
		if(isset($eaf->_POST['info_send'])){
			$title = $eaf->_POST['title'];
			$meta  = $eaf->_POST['meta'];
			$furl  = $eaf->_POST['url'];
			$fmail  = $eaf->_POST['email'];
			$username = $eaf->_POST['username'];
			$password = $eaf->security->Password($eaf->_POST['password']);
			$mail  = $eaf->_POST['mail'];
			$sex   = $eaf->_POST['sex'];
			$cant  = $eaf->_POST['cant'];
				if(empty($title) || empty($meta) || empty($username) || empty($password)){
					echo '<div class=\"red\">'.$Ilang[\"empty\"].'</div>';
					?>
                    <div class=\"go\"><a href=\"index.php?lang=<?php print $Lang; ?>&step=<? echo $prv; ?>\"><?php print $Ilang[\"pr\"]; ?></a></div>
<?
					return false;
				}
			$insert_info = mysql_query(\"UPDATE `phpforyou_infosite` SET title='$title',meta='$meta',email='$fmail',url='$furl'\") or die(mysql_error());
			$insert_user = mysql_query(\"INSERT INTO members (username,password,totla_ps,total_posts,email,groupid) values 
			(
			'$username',
			'$password',
			'0',
			'0',
			'$mail',
			'3'
			)
			
			\");
							if($insert_info and $insert_user){
								$_SESSION['username'] = $username;
								$_SESSION['password'] = $password;
								$_SESSION['user_id']  = mysql_insert_id();

		if(file_exists('../install.done')){

			@mail('php4u@hotmail.com','NEW Easy Forum User','install to :'.$_SERVER['HTTP_HOST'].' | SiteName : '.$title,\"php4u@hotmail.com\");

			}
								echo '<div class=\"green\">'.$Ilang[\"last_ok\"].'</div>';
								?>
                                <div class=\"go\"><a href=\"index.php?lang=<?php print $Lang; ?>&step=<? echo $nxt; ?>\"><? echo $Ilang[\"ne\"]; ?></a></div>
<?
							}else{
								echo '<div class=\"red\">'.$Ilang[\"last_error\"].' <br /> '.mysql_error().'</div>';
								?>
                                <div class=\"go\"><a href=\"index.php?lang=<?php print $Lang; ?>&step=<? echo $prv; ?>\"><? echo $Ilang[\"pr\"]; ?></a></div>
                                <?	
							}
		}
} ?>
<? 
if($step == 6){ 
include($Lang . \"/lang.php\");
$rand = rand(000000,999999);
$md5  = md5($rand);
$md5  = substr($md5,1, -17);
$rename = rename('../install','../'.$md5);

	print $Ilang[\"End\"];
} 
?>
</div>
</body>
</html>