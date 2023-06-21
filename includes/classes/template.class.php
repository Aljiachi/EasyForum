<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Template{
	
    private $cache,$template_folder,$_vars,$Fid;
    
    public function __construct($cache_dir,$template_dir){
 
        if(!is_dir($cache_dir)){
 
            mkdir($cache_dir,0777);
 
        }
 
        if(!is_dir($template_dir)){
 
            mkdir($template_dir,0777);
 
        }
 
        $this->cache = $cache_dir;
 
        $this->template_folder = $template_dir;
 
        $this->_vars  = &$GLOBALS;
		
		if(isset($eaf->_REQUEST['fid']) and !empty($eaf->_REQUEST['fid']) and is_numeric($eaf->_REQUEST['fid'])){
			
			$this->Fid = intval(abs($eaf->_REQUEST['fid']));
		}
 
    }
    
    private function _error($msg){
 
        return '<span style="text-align:center;" dir="rtl">'. $msg . '</span>';    
 
    }
    
    public function _html($template){
 
        $dir = $this->template_folder.'/'.$template;
 
        if(empty($template)){ 
        if(!file_exists($dir)){
 
            echo $this->_error("عذراً تحقق من كتابك لإسم القالب");
 
            return false;
 
        }
 
 
            echo $this->_error("قالب $template غير موجود");
 
            return false;
 
        }
 
        $this->display_get = @file_get_contents($dir);
 
        return $this->display_get;
 
    }
 
    
 
    public function _Preg($template){
 
        $this->template = $template;
 
        unset($template);
 
        $this->template = preg_replace('/\{\/(if|loop|for|switch|foreach)\}/iU',"<?php } ?>",$this->template);
 
        $this->template = preg_replace('/\{(\/else|else)\}/iU',"<?php }else{ ?>",$this->template);
 
        $this->template = preg_replace('/\{for name\="(.*)"\s*}/iU',"<?php for($1){ ?>",$this->template);
 
        $this->template = preg_replace('/\{foreach name\="(.*)"\s*}/iU',"<?php foreach($1){ ?>",$this->template);
 
        $this->template = preg_replace('/\{if name\="(.*)"\s*}/iU','<?php if($this->_If_String($1)){ ?>',$this->template);
 
        $this->template = preg_replace('/\{loop name\="(.*)" sql\="(.*)" type\="array"\s*}/iU','<?php while($1 = $this->_array($2)){ ?>',$this->template);
 
        $this->template = preg_replace('/\{loop name\="(.*)" sql\="(.*)" type\="object"\s*}/iU','<?php while($1 = $this->_object($2)){ ?>',$this->template);
 
        $this->template = preg_replace('/\{fun name\="(.*)" vars\="(.*)" print\="true"\s*}/iU','<?php $this->_function($1($2),true); ?>',$this->template);
  
        $this->template = preg_replace('/\{fun name\="(.*)" vars\="(.*)"}/iU','<?php $this->_function($1($2),false); ?>',$this->template);
 
        $this->template = preg_replace("/\{(php|code)}/iU","<?php ",$this->template);        $this->template = preg_replace('/\{loop name\="(.*)" sql\="(.*)"\s*}/iU','<?php while($1 = $this->_fetch($2)){ ?>',$this->template);

        $this->template = preg_replace("/\{\/(php|code)}/iU"," ?>",$this->template);
 
        $this->template = preg_replace('/\{template name\="(.*)"\}/iU','<?php $this->_print($this->display("$1")); ?>',$this->template);
 
        $this->template = preg_replace('/\{print\.((.*)|"(.*)")\}/iU','<?php $this->_print($1); ?>',$this->template);

        $this->template = preg_replace('/\{echo\.((.*)|"(.*)")\}/iU','$this->_print($1)',$this->template);

        $this->template = preg_replace('/\{(QueryInputs|queryinputs|queryInputs|QUERYINPUTS)\.((.*)|"(.*)")\}/iU','$this->_vars["eaf"]->$2->Profile->ExtraInputs',$this->template);

        $this->template = preg_replace('/\{(Query|query|QUERY)\.(UsercpInputs|usercpinputs|usercpInputs|USERCPINPUTS)\}/iU','$this->_vars["eaf"]->Usercp->Inputs->UsercpInputs',$this->template);

        $this->template = preg_replace('/\{link\.((.*)|"(.*)")\}/iU','<?php $this->_link($1); ?>',$this->template);

        $this->template = preg_replace('/\{substr\.(.*),(.*),(.*)}/iU','<?php $this->_print($this->_Substr($1,$2,$3)); ?>',$this->template);

        $this->template = preg_replace('/\{(input_value|Input_Value|INPUT_VALUE)\:(.*)\.(.*)\}/iU',
		
		'<?php 
		$this->_vars["String"]  = "extrainput";
		$this->_vars["String"] .= "_";
	    $this->_vars["String"] .= $this->_vars[$2][input_id];
		$this->_print($this->_vars["eaf"]->$3->Profile->rows[$this->_vars["String"]]); 
		?>',
		
		$this->template);
 
        $this->template = preg_replace('/\{session\.((.*)|"(.*)")\}/iU','$_SESSION[$1]',$this->template);

        $this->template = preg_replace('/\{systemFunction\.((.*)|"(.*)")\}/iU','<?php print $1; ?>',$this->template);
 
        $this->template = preg_replace("/\{eval\.(.*)\}/iU",'<?php $this->_eval($1); ?>',$this->template);

        $this->template = preg_replace("/\{(UsercpReputations|usercpreputations|USERCPREPUTATIONS)\}/iU",'$this->_vars["eaf"]->reputations',$this->template);
 
        $this->template = preg_replace("/\{print_r\.(.*)\}/iU",'<?php $this->_print_r($1); ?>',$this->template);
        $this->template = preg_replace('/\{explode\s*delim\="(.*)"\s*string\="(.*)" limit="(.*)"\}/iU','<?php $this->_explode($1,$2,
 $3); ?>',$this->template);
 
        $this->template = preg_replace('/\{explode\s*delim\="(.*)"\s*string\="(.*)"\}/iU','<?php $this->_explode($1,$2,false); ?>',$this->template);
 
        $this->template = preg_replace('/\{implode\s*string\="(.*)"\s*array\="(.*)"\}/iU','<?php $this->_implode("$1",$2); ?>',$this->template);
  		
		$this->template = preg_replace("/\{(alert|Alert)}/iU",'<? $this->_print($this->_vars["eaf"]->Alert); ?>',$this->template);

		$this->template = preg_replace("/\{(Rule|Text|rule|text|RULE|TEXT)}/iU",'<? $this->_print($this->_vars["eaf"]->Forum->_Rows("rule")); ?>',$this->template);

		$this->template = preg_replace("/\{(Query|query)}/iU",'$this->_vars["eaf"]->query',$this->template);

		$this->template = preg_replace("/\{(row|Row)}/iU",'$this->_vars["row"]',$this->template);

		$this->template = preg_replace("/\{group\.(.*)}/iU",'$this->_vars["group"][$1]',$this->template);

		$this->template = preg_replace("/\{moder\.(.*)}/iU",'$this->_vars["moder"][$1]',$this->template);

		$this->template = preg_replace("/\{(UnameById|unamebyid|UNAMEBYID)\.(.*)}/iU",'<?php $this->_print(UNameById($2)) ; ?>',$this->template);

		$this->template = preg_replace("/\{(GetPostTitle|getposttitle|GETPOSTTITLE)\.(.*),(.*)}/iU",'<?php $this->_print($this->_vars["eaf"]->Usercp->GetPostTitle($2,$3)) ; ?>',$this->template);

		$this->template = preg_replace("/\{(GetPostTitle|getposttitle|GETPOSTTITLE)\.(.*)}/iU",'<?php $this->_print($this->_vars["eaf"]->Usercp->GetPostTitle($2)) ; ?>',$this->template);

		$this->template = preg_replace("/\{(rows|Rows)}/iU",'$this->_vars["rows"]',$this->template);

		$this->template = preg_replace("/\{(CloseText|Closetext|closetext)}/iU",'<? $this->_print($this->_vars["eaf"]->CloseText); ?>',$this->template);

		$this->template = preg_replace("/\{(is_moder|Is_Moder)}/iU",'is_moder()',$this->template);

		$this->template = preg_replace("/\{(PostTitle|Posttitle|posttitle|postTitle)}/iU",'<? $this->_print($this->_vars["eaf"]->PostTitle); ?>',$this->template);

		$this->template = preg_replace("/\{(PostText|Posttext|posttext|postText)}/iU",'<? $this->_print($this->_vars["eaf"]->PostText); ?>',$this->template);

		$this->template = preg_replace("/\{(smiles|Smiles|SMILES)}/iU",'$this->_vars["Got"]["Smiles"]',$this->template);

		$this->template = preg_replace("/\{(icons|Icons|ICONS)}/iU",'$this->_vars["Got"]["Icons"]',$this->template);

		$this->template = preg_replace("/\{(Quote|quote|QUOTE)}/iU",'$this->_vars["eaf"]->Addpost->Quote()',$this->template);

		$this->template = preg_replace("/\{(QuoteBy|quoteby|QUOTEBY)}/iU",'<? $this->_print($this->_vars["eaf"]->QuoteBy); ?>',$this->template);

		$this->template = preg_replace("/\{(QuoteText|quotetext|QUOTETEXT)}/iU",'<? $this->_print($this->_vars["eaf"]->QuoteText); ?>',$this->template);

		$this->template = preg_replace("/\{(TheardId|THEARDID|theardid)}/iU",'<? $this->_print($this->_vars["eaf"]->TheardId); ?>',$this->template);

		$this->template = preg_replace("/\{(pagination|paginations|pages|PagesLinks)}/iU",'<? $this->_print($this->_vars["eaf"]->pages); ?>',$this->template);

		$this->template = preg_replace("/\{(Check|check|CHECK)}/iU",'<? $this->_print($this->_vars["eaf"]->Check); ?>',$this->template);

		$this->template = preg_replace("/\{Usercp\.(LastTheards|lasttheards|LASTTHEARDS)}/iU",'$this->_vars["eaf"]->Usercp->LastTheards',$this->template);

		$this->template = preg_replace("/\{Usercp\.(.*)}/iU",'<? $this->_print($this->_vars["eaf"]->Usercp->$1()); ?>',$this->template);

		$this->template = preg_replace("/\{(Forum|forum|FORUM)\.(.*)}/iU",'<? $this->_print($this->_vars["eaf"]->Forum->_Rows("$2")); ?>',$this->template);

		$this->template = preg_replace("/\{(Home|Start|Index|Show|show)\.(.*)}/iU",'<? $this->_print($this->_vars["eaf"]->home->$2); ?>',$this->template);

#		$this->template = preg_replace("/\{(Profile|profile|PROFILE)\.(Text|text|TEXT))}/iU",'$this->_vars["eaf"]->Profile->VistorsText',$this->template);

		$this->template = preg_replace("/\{(Profile|profile|PROFILE)\.(.*)}/iU",'<? $this->_print($this->_vars["eaf"]->Profile->$2()); ?>',$this->template);
		
		$this->template = preg_replace("/\{(To_Username|to_username|ToUsername|tousername)}/iU",'<? $this->_print($this->_vars["eaf"]->To_Username); ?>',$this->template);

		$this->template = preg_replace("/\{(Profile|profile|ProFile|proFile)\:(.*)\.(.*)}/iU",'<? $this->_print($this->_vars["eaf"]->$2->Profile->$3()); ?>',$this->template);

		$this->template = preg_replace("/\{(Pmtitle|PmTitle|pmtitle|pmTitle|PMTITLE)}/iU",'<? $this->_print($this->_vars["eaf"]->PmTitle); ?>',$this->template);

		$this->template = preg_replace("/\{(PmText|Pmtext|pmtext|pmText|PMTEXT)}/iU",'<? $this->_print($this->_vars["eaf"]->PmText); ?>',$this->template);

		$this->template = preg_replace("/\{(PmUserid|PmUserId|pmtext|pmuserid|PMUSERID)}/iU",'<? $this->_print($this->_vars["eaf"]->PmUserid); ?>',$this->template);

		$this->template = preg_replace("/\{(PmDate|Pmdate|pmdate|PMDATE)}/iU",'<? $this->_print($this->_vars["eaf"]->PmDate); ?>',$this->template);

		$this->template = preg_replace("/\{(PmSenderid|PmSenderId|pmsenderid|PMSENDERID)}/iU",'<? $this->_print($this->_vars["eaf"]->PmSenderid); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Title|showtheard:title|SHOWTHEARD:TITLE)}/iU",'<? $this->_print($this->_vars["eaf"]->Showtheard->Title()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Date|showtheard:date|SHOWTHEARD:DATE)}/iU",'<? $this->_print($this->_vars["eaf"]->Showtheard->Date()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Text|showtheard:text|SHOWTHEARD:TEXT)}/iU",'<? $this->_print($this->_vars["eaf"]->Showtheard->Content()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Icon|showtheard:icon|SHOWTHEARD:ICON)}/iU",'<? $this->_print($this->_vars["eaf"]->Showtheard->Icon()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Uid|showtheard:uid|SHOWTHEARD:UID)}/iU",'$this->_vars["eaf"]->Showtheard->Userid()',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Fid|showtheard:fid|SHOWTHEARD:FID)}/iU",'<?php $this->_print($this->_vars["eaf"]->Showtheard->ForumId()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:Closed|showtheard:closed|SHOWTHEARD:CLOSED)}/iU",'$this->_vars["eaf"]->Showtheard->Closed()',$this->template);

		$this->template = preg_replace("/\{(Showtheard:LastPage|showtheard:lastpage|SHOWTHEARD:LASTPAGE)}/iU",'<?php $this->_print($this->_vars["eaf"]->Showtheard->LastPage()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:LastPost|showtheard:lastpost|SHOWTHEARD:LASTPOST)}/iU",'<?php $this->_print($this->_vars["eaf"]->Showtheard->LastPostId()); ?>',$this->template);

		$this->template = preg_replace("/\{(Showtheard:WasOnline|showtheard:wasonline|SHOWTHEARD:WASONLINE)\}/iU",'$this->_vars["eaf"]->Showtheard->WasOnline',$this->template);

		$this->template = preg_replace("/\{(User:Id|user:id|USER:ID)}/iU",'UserId()',$this->template);

		$this->template = preg_replace("/\{(UserEdit|useredit|USEREDIT)}/iU",'$this->_vars["eaf"]->UserEdit',$this->template);

		$this->template = preg_replace("/\{(UserDelete|userdelete|USERDELETE)}/iU",'$this->_vars["eaf"]->UserDelete',$this->template);

		$this->template = preg_replace("/\{(Showpost:Title|showpost:title|SHOWPOST:TITLE)}/iU",'<? $this->_print($this->_vars["eaf"]->Showpost["ptitle"]); ?>',$this->template);

		$this->template = preg_replace("/\{(Showpost:Date|showpost:date|SHOWPOST:DATE)}/iU",'<? $this->_print($this->_vars["eaf"]->Showpost["pdata"]); ?>',$this->template);

		$this->template = preg_replace("/\{(Showpost:Text|showpost:text|SHOWPOST:TEXT)}/iU",'<? $this->_print(GetBbCode($this->_vars["eaf"]->Showpost["ptext"])); ?>',$this->template);

		$this->template = preg_replace("/\{(Showpost:Postid|showpost:postid|SHOWPOST:POSTID)}/iU",'<? $this->_print($this->_vars["eaf"]->Showpost["pid"]); ?>',$this->template);

		$this->template = preg_replace("/\{(Showpost:Icon|showpost:icon|SHOWPOST:ICON)}/iU",'<? $this->_print($this->_vars["eaf"]->Showpost["picon"]); ?>',$this->template);

		$this->template = preg_replace("/\{(OnlineUsers|onlineusers|ONLINEUSERS)}/iU",'<? $this->_print($this->_vars["eaf"]->online->OnlineUsers()); ?>',$this->template);

		$this->template = preg_replace("/\{(OnlineGuest|onlineguest|ONLINEGUEST)}/iU",'<? $this->_print($this->_vars["eaf"]->online->OnlineGuest()); ?>',$this->template);

		$this->template = preg_replace("/\{(OnlineAll|onlineall|ONLINEALL)}/iU",'<? $this->_print($this->_vars["eaf"]->online->OnlineAll()); ?>',$this->template);

		$this->template = preg_replace("/\{(OnlineQuery|Onlines|onlinequery|ONLINEQUERY|ONLINES|OnLines)}/iU",'$this->_vars["Got"]["OnlineQuery"]',$this->template);

		$this->template = preg_replace("/\{(TotalStickyTheards|totalstickytheards|TOTALSTICKYTHEARDS)}/iU",'$this->_vars["eaf"]->Forum->_TotalStickyTheards()',$this->template);

		$this->template = preg_replace("/\{(OnlineQuery|Onlines|onlinequery|ONLINEQUERY|ONLINES|OnLines)}/iU",'$this->_vars["Got"]["OnlineQuery"]',$this->template);

		$this->template = preg_replace("/\{(ActivedFriends|activedfriends|ACTIVEDFRIENDS)}/iU",'$this->_vars["Got"]["ActivedFriends"]',$this->template);

		$this->template = preg_replace("/\{(UnActivedFriends|unactivedfriends|UNACTIVEDFRIENDS)}/iU",'$this->_vars["Got"]["UnActivedFriends"]',$this->template);

		$this->template = preg_replace("/\{(AvatarView|avatarview|AVATARVIEW)\.(.*)}/iU",'<?php $this->_print(AvatarView($2)); ?>',$this->template);

		$this->template = preg_replace("/\{(ReBbCode|rebbcode|REBBCODE)\.(.*)}/iU",'<?php $this->_print(GetBbCode($2)); ?>',$this->template);

		$this->template = preg_replace("/\{(Username|UserName|LogName|logname|USERNAME|LOGNAME)}/iU",'<?php $this->_print(UserName()); ?>',$this->template);

		$this->template = preg_replace("/\{(StyleMenu|JumpMenu|StylePath)}/iU",'<?php $this->_print($this->_vars["Got"]["$1"]); ?>',$this->template);

		$this->template = preg_replace("/\{(RightBlocks|rightblocks|RIGHTBLOCKS)}/iU",'$this->_vars["Got"]["RightBlocks"]',$this->template);

		$this->template = preg_replace("/\{(LeftBlocks|leftblocks|LEFTBLOCKS)}/iU",'$this->_vars["Got"]["LeftBlocks"]',$this->template);

		$this->template = preg_replace("/\{(CenterBlocks|centerblocks|CENTERBLOCKS)}/iU",'$this->_vars["Got"]["CenterBlocks"]',$this->template);

		$this->template = preg_replace("/\{(RightBlocksTitle|rightblockstitle|RIGHTBLOCKSTITLE|RBTitle)}/iU",'<?php $this->_print($this->_vars["Right"]["block_title"]); ?>',$this->template);

		$this->template = preg_replace("/\{(RightBlocksContent|rightblockscontent|RIGHTBLOCKSCONTENT|RBContent)}/iU",'<?php $this->_eval("?>" . $this->_Replace_Arrs($this->_vars[Right][block_content]) . "<?"); ?>',$this->template);

		$this->template = preg_replace("/\{(LeftBlocksTitle|leftblockstitle|LEFTBLOCKSTITLE|LBTitle)}/iU",'<?php $this->_print($this->_vars["Left"]["block_title"]); ?>',$this->template);

		$this->template = preg_replace("/\{(LeftBlocksContent|leftblockscontent|LEFTBLOCKSCONTENT|LBContent)}/iU",'<?php $this->_eval("?>" . $this->_Replace_Arrs($this->_vars[Left][block_content]) . "<?"); ?>',$this->template);

		$this->template = preg_replace("/\{(CenterBlocksTitle|centerblockstitle|LEFTBLOCKSTITLE|LBTitle)}/iU",'<?php $this->_print($this->_vars["Center"]["block_title"]); ?>',$this->template);

		$this->template = preg_replace("/\{(CenterBlocksContent|centerblockscontent|CENTERBLOCKSCONTENT|CBContent)}/iU",'<?php $this->_eval("?>" . $this->_Replace_Arrs($this->_vars[Center][block_content]) . "<?"); ?>',$this->template);

		$this->template = preg_replace("/\{(ForumsList}forumslist|FORUMSLIST)}/iU",'<?php $this->_print(ForumsList()); ?>',$this->template);
		
		$this->template = preg_replace("/\{(announcement:Title|Announcement:title)}/iU",'<? $this->_print($this->_vars["eaf"]->announcement->Rows->title); ?>',$this->template);

		$this->template = preg_replace("/\{(announcement:Date|Announcement:date)}/iU",'<? $this->_print($this->_vars["eaf"]->announcement->Rows->date); ?>',$this->template);

		$this->template = preg_replace("/\{(announcement:Text|Announcement:text)}/iU",'<? $this->_print($this->_vars["eaf"]->announcement->Rows->text); ?>',$this->template);

		$this->template = preg_replace("/\{(getPage:title|GetPage:title|getpage:title)}/iU",'<? $this->_print($this->_vars["eaf"]->getPage->Rows->page_name); ?>',$this->template);

		$this->template = preg_replace("/\{(getPage:content|GetPage:content|getpage:content)}/iU",'<? $this->_print($this->_eval("?>" . $this->_vars["eaf"]->getPage->Rows->page_text . "<?")); ?>',$this->template);

		$this->template = preg_replace("/\{(getPage:views|GetPage:views|getpage:views)}/iU",'<? $this->_print($this->_vars["eaf"]->getPage->Rows->page_views); ?>',$this->template);

		$this->template = preg_replace("/\{(getPage:time|GetPage:time|getpage:time)}/iU",'$this->_vars["eaf"]->getPage->Rows->page_time',$this->template);

		$this->template = preg_replace("/\{(getPage:date|GetPage:date|getpage:date)}/iU",'<? $this->_print($this->_vars["eaf"]->getPage->Rows->page_date); ?>',$this->template);

		$this->template = preg_replace("/\{(getPages|getpages|GetPages)}/iU",'$this->_vars["GetPagesList"]',$this->template);

		$this->template = preg_replace("/\{(forumOnline)}/iU",'$this->_vars["eaf"]->Forum->WasOnline',$this->template);

		$this->template = preg_replace("/\{GetModers}/iU",'<?php $this->_print(GetModers($this->Fid)); ?>',$this->template);

		$this->template = preg_replace("/\{GetModers\.(.*)}/iU",'<?php $this->_print(GetModers($1)); ?>',$this->template);

		$this->template = preg_replace("/\{GetTotalModers\.(.*)}/iU",'GetTotalModers($1) ',$this->template);

	    $this->template = preg_replace("/\{stylefolder}/iU",'<?php $this->_print($this->_vars["stylefolder"]); ?>',$this->template);

        $this->template = preg_replace("/\{vars\.(.*):(.*)\}/iU",'$this->_vars['.'$1'.']['.'$2'.']',$this->template);

        $this->template = preg_replace("/\{vars\.(.*)\}/iU",'$this->_vars["$1"]',$this->template);

        $this->template = preg_replace("/\{lang\.(.*)}/iU",'<?php $this->_print($this->_vars["lang"]["$1"]); ?>',$this->template);
 
        $this->template = preg_replace("/\{eaf\.(.*)\}/iU",'$this->_vars["eaf"]->$1',$this->template);
 
		$this->template = preg_replace("/\{\\$(.*)\.(.*)\}/iU",'<?php $this->_print($this->_vars["$1"]["$2"]); ?>',$this->template);

        $this->template = preg_replace("/\{\\$(.*)\->(.*)\}/iU",'<?php $this->_print($this->_vars["$1"]->$2); ?>',$this->template);
			  
	    $this->template = preg_replace("/\{\\$(.*)\}/iU",'<?php $this->_print($this->_vars["$1"]); ?>',$this->template);

#		$this->template = preg_replace("#{(.*)\}#is","<?php $this->_print($this->_vars["$1"]);",$this->template);
 		
        return $this->template;

        }
       
	public function _If_String($string){
		
			$string = str_replace('<?php',"",$string);
			
			$string = str_replace('?>','',$string);

			$string = str_replace('$this->_print(','',$string);
			
			$string = str_replace('?>','',$string);
			
			return $string;
	}
	
	public function _Replace_Arrs($String){
	
		$String = str_replace("{ReplaceArowe}","'",$String);
		
		$String = str_replace("{ReplaceArowa}",'"',$String);
		
		return $String;	
	}
    public function _include($dir){

        if(file_exists($dir)){

            ob_start();

            require($dir);

            $content = ob_get_clean();

            echo $content;

        }else{

            echo $this->_error("$dir  does not exists");

        }

    }

	private function _Substr($string,$start,$limit){
						
		$limit = $limit - 10;
		
		return(mb_substr($string,$start,$limit , 'utf-8'));
	
		}
		
	private function _GetinputValue($InputId,$Object){
		
		global $eaf,$lang;
		
		$Value  = "extrainput";
		
		$Value .= "_";
		
		$Value .= $Id;
		
		$Get    = $eaf->$Object->Profile->rows[$Value];
		
		return $Get;	
	}
		
    private function _explode($n,$array,$limit=false){

        if($limit == false){

            return explode($n,$array);    

        }else{

            return explode($n,$array,$limit);        

        }

    }

    private function _implode($n,$content){

        return implode($n,$content);

    }


    public function _fetch($query){

       return mysql_fetch_assoc($query);
				
    }

    public function _array($query){

        return mysql_fetch_array($query);

    }
	
	public function _link($link){
		
			return print "{" .$link . "}";
	}

    public function _object($query){

        return mysql_fetch_object($query);

    }

    public function _print($var){
		
        return(print $var);    

    }
    
    public function _print_r($array){

        return print_r($array);    

    }
    
    public function _eval($string){
		
		global $eaf,$lang;
		    	
		return eval($string);	
    }
 
    public function _function($string,$return){
        if($return == true){

            return $this->_print($string);

        }else{

            return($string);    

        }

    }
    
    public function _check($content){

        if(file_exists($content)){

            $check = fopen($content,"r");
			
            $read  = @fread($check,filesize($content));

            $close = fclose($check);

            return $read;

        }

		    }
    
    public function display($file){

		global $eaf,$lang;
				
		$ex = ".html";
		
		$file .= $ex;

        $md5  = md5($file);

        $dir = $this->cache.'/'.$md5.'.php';
    
	    $content = $this->_html($file);
    
	    $html = @$this->_Preg($content);
    		
	    $check= @$this->_check($dir);
    
	    if($html !== $check){
			
			if(file_exists($this->template_folder . '/' . $file)){
				
            	$open = @fopen($dir,"w");
            
				$w = @fwrite ($open,$html);
            
				@fclose($open);
				
			}
        }
       
	    unset($html,$content);
       
	    ob_start();
       
	    include($dir);
       
	    $content = ob_get_clean();
       		
	    return $content;
    
	}
    
    public function __destruct(){
    
	    unset($this->template,$this->_vars);
    
	}
}
?>