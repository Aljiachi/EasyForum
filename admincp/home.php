<?php
	
	@session_start();

	include('access.php');

	include('../connect/config.php');

	include('../includes/functions.php');
	
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	function AdminMsg(){

		$sql = "SELECT admin_msg FROM " . tablenamestart("infosite");
	
		$query = mysql_query($sql);

		$rows  = mysql_fetch_assoc($query);

		return $rows['admin_msg'];	

	}

	if(isset($eaf->_POST['edit_msg'])){

		$text = $eaf->_POST['admin_post'];

		$update = mysql_query("UPDATE "	. tablenamestart("infosite") .	" SET admin_msg='$text'");

		echo ' <meta http-equiv="refresh" content="1" /> ';

	}
	
	$total_theards = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("topics")));

	$total_posts = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("posts")));
	
	$total_usersonline = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("online")." where uid != 0"));

	$total_vistonline = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("online")." where uid = 0"));

	$total_members = $eaf->db->dbnum($eaf->db->query("select * from members"));
	
	$total_pm = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("pm")));

	$total_attachs = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("attachments")));

	$total_friends = $eaf->db->dbnum($eaf->db->query("select * from " . tablenamestart("friends")));

	$total_bmembers = $eaf->db->dbnum($eaf->db->query("select * from members where groupid = 6"));

	$total_amembers = $eaf->db->dbnum($eaf->db->query("select * from members where groupid = 7"));
	
	function GetUpdate(){
		
		$context = stream_context_create(array('http' => array('header'=>'Connection: close'))); 
		
		$Url      = "jetr.org";
		
		$Folder   = "ef/update";
		
		$D		= "txt";
		
		$Slash    = "/";
		
		$File     = "get";
								
			$Content  = @file_get_contents("http://" . $Url . $Slash . $Folder . $Slash . $File . "." . $D); 	
		
		
		if(!$Content) 
		
		print "Could not connect to the server";
		
		else
		
		return $Content;
	}

	?>
    
<link type="text/css" rel="stylesheet" href="style/<?php print $lang["style"]; ?>.css" />
<table cellpadding="0" cellspacing="0" width="97%" align="center">
<tr>
<td class="head" colspan="2"><?php print $lang["vinfo"]; ?></td>
</tr>
<tr>
<td class="tct"><?php print $lang["SName"]; ?></td>
<td class="tct">Easy Forum</td>
</tr>
<tr>
<td class="tct"><?php print $lang["SV"]; ?></td>
<td class="tct">2</td>
</tr>
<tr>
<td class="tct"><?php print $lang["SP"]; ?></td>
<td class="tct"><strong>Ali aljiachi</strong></td>
</tr>
<tr>
<td class="tct"><?php print $lang["SS"]; ?></td>
<td class="tct"><strong><a href="http://www.easyforum.com" target="_new">WWW.EasyForum.COM</a></strong></td>
</tr>
<tr>
<td class="tct"><?php print $lang["HU"]; ?></td>
<td class="tct"></td>
</tr>
<tr>
<td class="tct">Php</td>
<td class="tct"><? echo phpversion(); ?></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" width="97%" align="center">
<tr>
<td class="head" colspan="1"><?php print $lang["AdminT"]; ?></td>
</tr>
<tr>
<td class="tct">
<form method="post">
  <div align="center">
    <p>
      <textarea name="admin_post" rows="6" style="width:90%"><? echo AdminMsg(); ?></textarea>
    </p>
    <p>
      <input type="submit" name="edit_msg" value="<?php print $lang["edit"]; ?>" />
    </p>
  </div>
</form>
</td>
</tr>
</table>
<table width="97%" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="5"  class="head"><?php print $lang["Stats"]; ?></td>
</tr>
<tr>
<td><?php print $lang["HT"]; ?> : <?php print $total_theards; ?></td>
<td><?php print $lang["HP"]; ?> : <?php print $total_posts; ?></td>
<td><?php print $lang["HM"]; ?> : <?php print $total_members; ?></td>
<td><?php print $lang["HI"]; ?> : <?php print $total_pm; ?></td>
<td><a href="members.php?action=out_members" style="font-weight:bold;"><?php print $lang["MB"]; ?> : <?php print $total_bmembers; ?></a></td>
</tr>
<tr>
<td><?php print $lang["OM"]; ?> : <?php print $total_usersonline; ?></td>
<td><?php print $lang["OG"]; ?> : <?php print $total_vistonline; ?></td>
<td><?php print $lang["HA"]; ?> : <?php print $total_attachs; ?></td>
<td><?php print $lang["HF"]; ?> : <?php print $total_friends; ?></td>
<td><a href="members.php?action=active_members" style="font-weight:bold;"><?php print $lang["MW"]; ?> : <?php print $total_amembers; ?></a></td>
</tr>
</table>
