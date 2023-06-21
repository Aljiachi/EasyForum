<style type="text/css">
.newTheardsBox{
	margin-top:5px;
	margin-bottom:5px;	
}
.newTheards_Title{
	border:1px solid #D7D7D7;
	background:#fff;
	padding:7px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	font-weight:bold;
	color:#000;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #f0f0f0), to(#ddd));
	background-image: -webkit-linear-gradient( #f0f0f0, #ddd);
	background-image:    -moz-linear-gradient( #fcfcfc, #f7f7f7);
	background-image:     -ms-linear-gradient( #f0f0f0, #ddd);
	background-image:      -o-linear-gradient( #f0f0f0, #ddd);
	background-image:         linear-gradient( #f0f0f0, #ddd);
	-moz-box-shadow: inset 0px 0px 3px 		#e4e4e4 , 0px 0px 9px 		#e4e4e4;
	-webkit-box-shadow: inset 0px 0px 3px 	#e4e4e4 , 0px 0px 9px 		#e4e4e4;
	box-shadow: inset 0px 0px 3px 			#e4e4e4 , 0px 0px 9px 		#e4e4e4;
}
.newTheards_Title a{ color:#000; }
.newTheards_Text{
	border:1px solid #D7D7D7;
	background:#fff;
	padding:7px;
	text-align:justify;
	line-height:140%;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
	-moz-box-shadow: inset 0px 0px 3px 		#e4e4e4 , 0px 0px 9px 		#e4e4e4 ;
	-webkit-box-shadow: inset 0px 0px 3px 	#e4e4e4 , 0px 0px 9px 		#e4e4e4 ;
	box-shadow: inset 0px 0px 3px 			#e4e4e4 , 0px 0px 9px 		#e4e4e4 ;
	color:#000;
}
.newTheards_Info{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	font-weight:normal;
	margin:2px;
	padding:2px;
	color:#777;
	text-align:right;
	direction:rtl;
	border-bottom:1px solid #bababa;
}
.newTheards_Inf span{
	margin-left:10px;
	margin-right:10px;	
}
.newTheards_Info a{color:#a23838;}
</style>
<?php

	$GetLastTopicsMenu = $eaf->db->query("select * from " . tablenamestart("topics") . " order by tid desc limit 10");

	while($RowsGetLastTopicsMenu = $eaf->db->_object($GetLastTopicsMenu)) : 
	
?>
<div class="newTheardsBox" >
	<div class="newTheards_Title"><?php if(!empty($RowsGetLastTopicsMenu->icon_id)){?><img src="<?php print $RowsGetLastTopicsMenu->icon_id; ?>" /><?php } ?><a href="index.php?action=showtheard&tid=<?php print $RowsGetLastTopicsMenu->tid; ?>"><?php print $RowsGetLastTopicsMenu->title; ?></a></div>
    <div class="newTheards_Text">
	
    	 <div class="newTheards_Info">
            <span><?php print $RowsGetLastTopicsMenu->data; ?></span> |
            <span>بواسطة : <strong><a href="index.php?action=profile&uid=<?php print $RowsGetLastTopicsMenu->u_id; ?>"><?php print $RowsGetLastTopicsMenu->username; ?></a></strong> </span> |
            <span>عدد المشاهدات : <?php print $RowsGetLastTopicsMenu->views; ?></span> |
            <span>عدد الردود : <?php print $RowsGetLastTopicsMenu->txts; ?></span>
            
        </div>		
		
        <div><?php print GetBbCode($RowsGetLastTopicsMenu->text); ?></div>
        
   </div>

   
</div>

<?php endwhile; ?>