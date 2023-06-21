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


?>
	<script src="../js/jquery.js" type="text/javascript"></script>
	<script src="../js/BlocksAn.js"></script>

 <script>
	$(document).ready(function(){
	
	<?php if($lang["dir"] == "ltr"){ ?>
			
		var F = "right";
		
	<? }else{ ?>
		
		var F = "left";
		
		<? } ?>
	$('.head').append('<span class="toggleLink" style="float:'+ F +'; clear:both;font-weight:bolder;">' + "-" + '</span>');
	$('span.toggleLink').click(function(){
	if ($(this).text()=="-") {
		$(this).html("+");
		$(this).parent().next('#bodypanel').hide('slow');
		}
		else {
		$(this).html("-");
		$(this).parent().next('#bodypanel').show('slow');
	}
	});
	});
	</script>
<link type="text/css" rel="stylesheet" href="style/<?php print $lang["style"]; ?>.css" />

<div class="head"><?php print $lang["options"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="options.php?action=forum" target="main"><?php print $lang["options_forum"]; ?></a></li>
<li><a href="options.php?action=register" target="main"><?php print $lang["options_register"]; ?></a></li>
<li><a href="options.php?action=posts" target="main"><?php print $lang["options_posts"]; ?></a></li>
<li><a href="options.php?action=pages" target="main"><?php print $lang["options_pages"]; ?></a></li>
<li><a href="options.php?action=contact_box" target="main"><?php print $lang["options_inbox"]; ?></a></li>
<li><a href="options.php?action=words" target="main"><?php print $lang["options_words"]; ?></a></li>
<li><a href="http://www.easyforum.com/?lang=<?php print $lang["source"]; ?>" target="main"><?php print $lang["options_store"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["fm"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="sections.php" target="main"><?php print $lang["fm_show"]; ?></a></li>
<li><a href="sections.php?action=nosort" target="main"><?php print $lang["fm_nosort"]; ?></a></li>
<li><a href="sections.php?action=addforum" target="main"><?php print $lang["fm_addforum"]; ?></a></li>
<li><a href="sections.php?action=addsection" target="main"><?php print $lang["fm_addsection"]; ?></a></li>
<li><a href="moderators.php?action=add" target="main"><?php print $lang["fm_addmoder"]; ?></a></li>
<li><a href="moderators.php" target="main"><?php print $lang["fm_cmoders"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["styles"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="styles.php" target="main"><?php print $lang["styles_show"]; ?></a></li>
<li><a href="styles.php?action=add_style" target="main"><?php print $lang["styles_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["portal"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="portal.php" target="main"><?php print $lang["portal_show"]; ?></a></li>
<li><a href="portal.php?action=addmenu" target="main"><?php print $lang["portal_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["hacks"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="hacks.php" target="main"><?php print $lang["hacks_show"]; ?></a></li>
<li><a href="hacks.php?action=addhack" target="main"><?php print $lang["hacks_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["languages"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="languages.php" target="main"><?php print $lang["languages_show"]; ?></a></li>
<li><a href="languages.php?action=add" target="main"><?php print $lang["languages_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["theards"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="theards.php?action=closed" target="main"><?php print $lang["theards_closed"]; ?></a></li>
<li><a href="theards.php?action=sticked" target="main"><?php print $lang["theards_stickyed"]; ?></a></li>
<li><a href="theards.php?action=delete" target="main"><?php print $lang["theards_delete"]; ?></a></li>
<li><a href="theards.php?action=recycle_bin" target="main"><?php print $lang["theards_recyclebin"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["groups"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="groups.php" target="main"><?php print $lang["groups_show"]; ?></a></li>
<li><a href="groups.php?action=add" target="main"><?php print $lang["groups_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["ads"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="announcements.php" target="main"><?php print $lang["ads_show"]; ?></a></li>
<li><a href="announcements.php?action=add" target="main"><?php print $lang["ads_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["icons"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="icons.php" target="main"><?php print $lang["icons_show"]; ?></a></li>
<li><a href="icons.php?action=add_icon" target="main"><?php print $lang["icons_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["smileys"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="smiles.php" target="main"><?php print $lang["smileys_show"]; ?></a></li>
<li><a href="smiles.php?action=add_smile" target="main"><?php print $lang["smileys_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["titles"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="titles.php" target="main"><?php print $lang["titles_show"]; ?></a></li>
<li><a href="titles.php?action=add_title" target="main"><?php print $lang["titles_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["mpages"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="pages.php?action=add" target="main"><?php print $lang["mpages_new"]; ?></a></li>
<li><a href="pages.php" target="main"><?php print $lang["mpages_show"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["inputs"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="inputs.php" target="main"><?php print $lang["inputs_show"]; ?></a></li>
<li><a href="inputs.php?action=add" target="main"><?php print $lang["inputs_add"]; ?></a></li>
</ul>
</div>
<div class="head"><?php print $lang["members"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="members.php?action=add" target="main"><?php print $lang["members_add"]; ?></a></li>
<li><a href="members.php" target="main"><?php print $lang["members_show"]; ?></a></li>
<li><a href="members.php?action=search" target="main"><?php print $lang["members_search"]; ?></a></li>
<li><a href="members.php?action=userdo" target="main"><?php print $lang["members_banned"]; ?></a></li>
<li><a href="members.php?action=out_members" target="main"><?php print $lang["members_viewbanned"]; ?></a></li>
<li><a href="members.php?action=sendpm" target="main"><?php print $lang["members_sendpm"]; ?></a></li>
<li><a href="members.php?action=active_members" target="main"><?php print $lang["members_gactive"]; ?></a></li>
<li><a href="members.php?action=inboxpm" target="main"><?php print $lang["members_inboxpm"]; ?></a></li>
</ul>
</div>

<div class="head"><?php print $lang["tools"]; ?></div>
<div id="bodypanel">
<ul>
<li><a href="backup.php" target="main"><?php print $lang["tools_backup"]; ?></a></li>
<li><a href="sql.php" target="main"><?php print $lang["tools_sql"]; ?></a></li>
<li><a href="tools.php?action=cacheremove" target="main"><?php print $lang["tools_cache"]; ?></a></li>
<li><a href="tools.php?action=phpinfo" target="main"><?php print $lang["tools_php"]; ?></a></li>
</ul>
</div>