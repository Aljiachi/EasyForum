<style type=\"text/css\">
.popularTheard{
	position:relative;
	display:block;
	margin-bottom:5px;	
}
.popularTheard:hover{
	background:#a23838;
	color:#fff;
}
.popularTheard:hover a{
		color:#fff;
}
.popularTheard a{
	margin-left:20px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	font-weight:bold;	
}
.popularTheard .number{
	float:left;
	font-family:Arial, Helvetica, sans-serif;
	font-size:20px;
	background:#a23838;
	color:#fff;
	padding:1px;
}
</style>
<?php

	$GetTopViewsTopicsMenu = $eaf->db->query(\"select * from \" . tablenamestart(\"topics\") . \" order by views desc limit 6\");

	while($RowsGetTopViewsTopicsMenu = $eaf->db->_object($GetTopViewsTopicsMenu)) : 
	$a++;
	
?>
<div class=\"popularTheard\"><a href=\"index.php?action=showtheard&tid=<?php print $RowsGetTopViewsTopicsMenu->tid; ?>\"><?php print mb_substr($RowsGetTopViewsTopicsMenu->title , 0 , 50 , 'utf-8'); ?>...</a> <div class=\"number\"><?php print $a; ?></div> <div style=\"clear:both\"></div> </div>

<?php endwhile; ?>