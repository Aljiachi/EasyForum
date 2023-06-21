<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class eafBbCode{
	
	public $String;
	
	public function Clean($String){
			
			$HTML_VARS = array(
				'<html',
				'<form',
				'</html>',
				'</form>',
				'<body',
				'<xml',
				'</xml',
				'<head',
				'<thead',
				'</head',
				'</thead',
				'<title',
				'</title>',
				'<style',
				'</style>',
				'<link',
				'<!DOCTYPE',
				'<meta',
				'<frame',
				'<frameset',
				'<noframes',
				'<object',
				'<param',
				'</legend'
);

	$HTML_VARS_REPLACE = array(
	
				'&lt;html',
				'&lt;form',
				'&lt;/html>',
				'&lt;/form>',
				'&lt;body',
				'&lt;xml',
				'&lt;/xml',
				'&lt;head',
				'&lt;thead',
				'&lt;/head',
				'&lt;/thead',
				'&lt;title',
				'&lt;/title>',
				'&lt;style',
				'&lt;/style>',
				'&lt;link',
				'&lt;!DOCTYPE',
				'&lt;meta',
				'&lt;frameset',
				'&lt;iframe',
				'&lt;noframes',
				'&lt;/object',
				'&lt;parm',
				'&lt;/legend'			
);

	return str_replace($HTML_VARS,$HTML_VARS_REPLACE,$String);
		
	}
	
public function BbCodeToHtml($Text){
	
	$Html   = array("</table>","</em>","<td>","</td>","<tr>","</tr>","<tbody>","</tbody>","<caption>","</caption>");

	$Bbcode =  array("[/table]","[/em]","[td]","[/td]","[tr]","[/tr]","[tbody]","[/tbody]","[caption]","[/caption]");
	
	$Text   = str_replace($Bbcode,$Html,$Text);
	
	#$Text   = preg_replace("#\[table(.*)]#esiU","<table\\1>",$Text);
	
	return $Text;
}
	public function HtmlToBbCode($String){
		
		$String = str_replace('"','"',$String);

		$String = str_replace("\'","'",$String);
		
		$String = str_replace("<br /><object","<object",$String);
		$String = str_replace("<br /><param","<param",$String);
		$String = str_replace("<br /><embed","<embed",$String);
		
		$html = array(
		'<span style="font-weight:bold">(.*)<\/span>' => '[b]$1[/b]',
		'<span style="font-family\:(.*)">(.*)<\/span>' => '[font=$1]$2[/font]',
		'<span style="background-color\:(.*)">(.*)<\/span>' => '[highlight=$1]$2[/highlight]',
		'<span style="font-size\:(.*)">(.*)<\/span>' => '[size=$1]$2[/size]',
		'<span style="color\:(.*);font-size:(.*)">(.*)<\/span>' => '[color=$1][size=$2]$2[/size][/color]',
		'<span style="font-size:(.*);color\:(.*)">(.*)<\/span>' => '[size=$1][color=$2]$2[/color][/size]',
		'<span style="font-style:italic">(.*)<\/span>' => '[i]$1[/i]',
		'<span style="text-decoration:underline">(.*)<\/span>' => '[u]$1[/u]',
		'<span style="text-decoration:line-through">(.*)<\/span>' => '[s]$1[/s]',
		'<span style="(.*)">(.*)<\/span>' => '[span=$1]$2[/span]',
		'<param (.*)\>(.*)<\/param>' => '[param $1]$2[/param]',
		'<embed (.*)\>(.*)<\/embed>' => '[embed $1]$2[/embed]',
		'<object (.*)\>(.*)<\/object>' => '[object $1]$2[/object]',
		'<sup>(.*)<\/sup>' => '[sub]$1[/sub]',
		'<sup>(.*)<\/sup>' => '[sup]$1[/sub]',
		'<h1>(.*)<\/h1>' => '[h1]$1[/h1]',
		'<h2>(.*)<\/h2>' => '[h2]$1[/h2]',
		'<h3>(.*)<\/h3>' => '[h3]$1[/h3]',
		'<h4>(.*)<\/h4>' => '[h4]$1[/h4]',
		'<h5>(.*)<\/h5>' => '[h5]$1[/h5]',
		'<h6>(.*)<\/h6>' => '[h6]$1[/h6]',
		'<strong>(.*)<\/strong>' => '[b]$1[/b]',
		'<div align="(left|right|center)">(.*)<\/strong>' => '[align=$1]$2[/align]',
		'<font face="(.*)">(.*)<\/font>' => '[font=$1]$2[/align]',
		'<font size="([0-9]+?)">(.*)<\/font>' => '[size=$1]$2[/align]',
		'<font color="(.+?)">(.*)<\/font>' => '[color=$1]$2[/align]',
		'<div>(.*)<\/div>' => '[div]$1[/div]',
		'<pre>(.*)<\/pre>' => '[pre]$1[/pre]',
		'<table(.*)>(.*)<\/table>' => '[table=$1]$3[/table]',
		'<td>' => '[td]',
		'<\/td>' => '[/td]',
		'<tr>' => '[tr]',
		'<\/tr>' => '[/tr]',
		'<tbody>' => '[tbody]',
		'<\/tbody>' => '[/tbody]',
		'<address>(.*)<\/address>' => '[address]$1[/address]',
		'<br \/>' => '[br/]',
		'<br>' => '[br/]',
		'<hr \/>' => '[hr/]'
		);
		
		foreach($html as $kay => $var){

			$String = preg_replace("#".$kay."#is",$var,$String);	
		}
		
		return $String;
	}
	
	
	public function replace($String){
		
		global $eaf,$lang;
		
		$String = $this->Clean($String);

		$String = $this->BbCodeToHtml($String);
		
		$String = str_replace("*=q=*","'",$String);
						
		$String = preg_replace("#\[color=(.*)](.*)\[/color\]#esiU","\$this->getColor('\\1','\\2')",$String);

		$String = preg_replace("#\[COLOR=(.*)](.*)\[/COLOR\]#esiU","\$this->getColor('\\1','\\2')",$String);

		$String = preg_replace("#\[size=([0-9]*)](.*)\[/size\]#esiU","\$this->getSize('\\1','\\2')",$String);

		$String = preg_replace("#\[SIZE=([0-9]*)](.*)\[/SIZE\]#esiU","\$this->getSize('\\1','\\2')",$String);

		$String = preg_replace("#\[align=(.*)](.*)\[/align\]#esiU","\$this->getAlign('\\1','\\2')",$String);

		$String = preg_replace("#\[font=(.*)](.*)\[/font\]#esiU","\$this->getFont('\\1','\\2')",$String);

		$String = preg_replace("#\[FONT=(.*)](.*)\[/FONT\]#esiU","\$this->getFont('\\1','\\2')",$String);

		$String = preg_replace("#\[url=(.*)](.*)\[/url\]#esiU","\$this->getUrl('\\1','\\2')",$String);

		$String = preg_replace("#\[table=(.*)]#esiU","\$this->getTable('\\1')",$String);

		$String = preg_replace("#\[hr (.*)]#esiU","\$this->getHr('\\1')",$String);

		$String = preg_replace("#\[email=(.*)](.*)\[/email\]#esiU","\$this->getEmail('\\1','\\2')",$String);

		$String = preg_replace("#\[email](.*)\[/email\]#esiU","\$this->getEmail('\\1','')",$String);
		
		$String = preg_replace("#\[em (.*)]#esiU","\$this->getEm('\\1')",$String);

		$String = preg_replace("#\[p](.*)\[/p\]#esiU","\$this->getTag(\"p\",'\\1')",$String);

		$String = preg_replace("#\[b](.*)\[/b\]#esiU","\$this->getTag(\"b\",'\\1')",$String);

		$String = preg_replace("#\[ul](.*)\[/ul\]#esiU","\$this->getTag(\"ul\",'\\1')",$String);

		$String = preg_replace("#\[ol](.*)\[/ol\]#esiU","\$this->getTag(\"ul\",'\\1')",$String);

		$String = preg_replace("#\[li](.*)\[/li\]#esiU","\$this->getTag(\"li\",'\\1')",$String);

		$String = preg_replace("#\[center](.*)\[/center\]#esiU","\$this->getTag(\"center\",'\\1')",$String);

		$String = preg_replace("#\[CENTER](.*)\[/CENTER\]#esiU","\$this->getTag(\"center\",'\\1')",$String);

		$String = preg_replace("#\[left](.*)\[/left\]#esiU","\$this->getAlign(\"left\",'\\1')",$String);

		$String = preg_replace("#\[LEFT](.*)\[/LEFT\]#esiU","\$this->getAlign(\"left\",'\\1')",$String);

		$String = preg_replace("#\[RIGHT](.*)\[/RIGHT\]#esiU","\$this->getAlign(\"right\",'\\1')",$String);
		
		$String = preg_replace("#\[sub](.*)\[/sub\]#esiU","\$this->getTag(\"sub\",'\\1')",$String);

		$String = preg_replace("#\[sup](.*)\[/sup\]#esiU","\$this->getTag(\"sup\",'\\1')",$String);

		$String = preg_replace("#\[pre](.*)\[/pre\]#esiU","\$this->getTag(\"pre\",'\\1')",$String);

		$String = preg_replace("#\[h1](.*)\[/h1\]#esiU","\$this->getTag(\"h1\",'\\1')",$String);

		$String = preg_replace("#\[h2](.*)\[/h2\]#esiU","\$this->getTag(\"h2\",'\\1')",$String);

		$String = preg_replace("#\[h3](.*)\[/h3\]#esiU","\$this->getTag(\"h3\",'\\1')",$String);

		$String = preg_replace("#\[h4](.*)\[/h4\]#esiU","\$this->getTag(\"h4\",'\\1')",$String);

		$String = preg_replace("#\[h5](.*)\[/h5\]#esiU","\$this->getTag(\"h5\",'\\1')",$String);

		$String = preg_replace("#\[h6](.*)\[/h6\]#esiU","\$this->getTag(\"h6\",'\\1')",$String);

		$String = preg_replace("#\[div](.*)\[/div\]#esiU","\$this->getTag(\"div\",'\\1')",$String);

		$String = preg_replace("#\[pre](.*)\[/pre\]#esiU","\$this->getTag(\"pre\",'\\1')",$String);

		$String = preg_replace("#\[address](.*)\[/address\]#esiU","\$this->getTag(\"address\",'\\1')",$String);

		$String = preg_replace("#\[i](.*)\[/i\]#esiU","\$this->getTag(\"i\",'\\1')",$String);

		$String = preg_replace("#\[s](.*)\[/s\]#esiU","\$this->getTag(\"s\",'\\1')",$String);

		$String = preg_replace("#\[u](.*)\[/u\]#esiU","\$this->getTag(\"u\",'\\1')",$String);

		$String = preg_replace("#\[quote](.*)\[/quote]#esiU","\$this->getQuote(\"\",'\\1')",$String);

		$String = preg_replace("#\[quote name=(.*)](.*)\[/quote]#esiU","\$this->getQuote('\\1','\\2')",$String);

		$String = preg_replace("#\[quote=(.*)](.*)\[/quote]#esiU","\$this->getQuote('\\1','\\2')",$String);

		$String = preg_replace("#\[highlight=(.*)](.*)\[/highlight\]#esiU","\$this->getHighLight(\"\\1\",\"\\2\")",$String);

		$String = preg_replace("#\[span=(.*)](.*)\[/span\]#esiU","\$this->getTag(\"span\",'\\2\',\"style='\\1'\")",$String);

		$String = preg_replace("#\[youtube](.*)\[/youtube\]#esiU","\$this->getYoutube('\\1')",$String);

		$String = preg_replace("#\[viemo](.*)\[/viemo\]#esiU","\$this->getViemo('\\1')",$String);

		$String = preg_replace("#\[media](.*)\[/media\]#esiU","\$this->getMedia('\\1')",$String);

		$String = preg_replace("#\[ram](.*)\[/ram\]#esiU","\$this->getRam('\\1')",$String);

		$String = preg_replace("#\[php](.*)\[/php\]#esiU","\$this->getPhpCode('\\1')",$String);
		
		$String = preg_replace("#\[code](.*)\[/code\]#esiU","\$this->getCode('\\1')",$String);

		$String = str_replace("\n","<br />",$String);

		$String = str_replace("[hr][/hr]","<hr />",$String);

		$String = str_replace("[hr]","<hr />",$String);

		$String = str_replace("[br]","<br />",$String);

		$String = str_replace("[br/]","<br />",$String);

		$String = preg_replace("#\[attachment=([0-9].*)/]#esiU","\$this->getAttachment('\\1')",$String);
		
		$String = preg_replace("#\[flash=(.*) width=([0-9]+?) height=([0-9]+?)/]#esiU","\$this->getFlash('\\1','\\2','\\3')",$String);
	
		$String = str_replace("<br /><tr>","\n<tr>",$String);

		$String = str_replace("<br /></tr>","\n</tr>",$String);

		$String = str_replace("<br /><td>","\n<td>",$String);

		$String = str_replace("<br /></td>","\n</td>",$String);

		$String = str_replace("<br /><tbody>","\n</td>",$String);

		$String = str_replace("<br /></tbody>","\n</td>",$String);

		$String = str_replace("<br /><table>","\n</td>",$String);
		
		$String = str_replace("&amp;lt;","&lt;",$String);

		$String = str_replace("&amp;gt;","&gt;",$String);

		$String = str_replace("&amp;quot;",'&quot;',$String);

		$String = preg_replace("#\[img](.*)\[/img\]#esiU","\$this->getImg('\\1')",$String);
		
		$String = preg_replace("#\[url](.*)\[/url\]#esiU","\$this->getUrl('\\1')",$String);

		$String = preg_replace("#\[img=(.*)]#esiU","\$this->getImg('\\1')",$String);
		
		$String = str_ireplace(array('[/font]' , '[/size]' , '[/color]' , '[/img]' , '[/url]' , '[/code]' , '[/media]' , '[/php]') , "" , $String);
		
		$bigbang= array("[font=(.*?)]" , "[size=(.*?)]" , "[color=(.*?)]");
		
		foreach($bigbang as $var_bigbang){
			
			$String = preg_replace("/\$var_bigbang/iU" , "" , $String);
		
		}
		
		$QueryOfSmiles = $eaf->db->query("select * from " . tablenamestart("smiles"));
		
		while($Smile = $eaf->db->_object($QueryOfSmiles)){
		
			$String = str_replace($Smile->smile_title,"<img src=\"$Smile->smile_replace\" />",$String);	
		}

		return $String;
	}
	
	public function getColor($Color,$Text){
			
		$Text = str_replace('\"','"',$Text);
		
		return "<span style=\"color:$Color\">$Text</span>";	
	}
	
	public function getPhpCode($Code){
		
		$Code = str_replace("\'","'",$Code);
		
		$Code = str_replace('"','"',$Code);
		
		$Code = str_replace("<br />","\n",$Code);
		
		$Code = str_replace("?&gt;","?>",$Code);
		
		$Code = str_replace("&amp;lt;?php","",$Code);
		
		$Code = str_replace("&lt;","lt;",$Code);
		
		$Code = str_replace("lt;","<",$Code);
		
		$Code = str_replace("&quot;","quot;",$Code);
		
		$Code = str_replace("quot;",'"',$Code);
						
#		$Code = str_replace("<?php","",$Code);

		$Code = highlight_string($Code,true);

#		$Code = str_replace("quot;","&quot;",$Code);

		if(substr($Code,0,2) !== "<?"){
			
		$Code = "<?\n" . $Code . "\n";		

		}else{
		
		$Code = $Code;	
		
		}
		
		return "<div class=\"codemain\" dir=\"ltr\" align=\"left\" rel=\"php\">\n". $Code . "\n</div>\n";	
	
	}
	
	public function getTable($Option){
		
		$Option = str_replace('\"','"',$Option);
		
		return "<table style=\"$Option\">"; 	
	}
	
	public function getEm($Option){
		
		$Option = str_replace('\"','"',$Option);
		
		return "<em $Option>"; 	
	}

	public function getHr($Option){
		
		$Option = str_replace('\"','"',$Option);
		
		return "<hr $Option />"; 	
	}
	
	public function getCode($Code){
		
		$Code = str_replace("\'","'",$Code);
		
		$Code = str_replace('"','"',$Code);
				
		$Code = str_replace("<","&lt;",$Code);

		$Code = str_replace(">","&gt;",$Code);
		
		$Code = str_replace('"',"&quot;",$Code);
		
		$Code = $this->CodeRe($Code);
		
		$String = str_replace("&amp;lt;","&lt;",$String);

		$String = str_replace("&amp;gt;","&gt;",$String);
				
		return "<div class=\"codemain\" dir=\"ltr\" align=\"left\">\n" . $Code . "\n</div>\n";

	}
	
	public function getHighLight($color,$Text){
		
		$Text = str_replace('\"','"',$Text);
		
		$Text = str_replace("\'","'",$Text);
		
		return "<font style=\"background-color:$color\">$Text</font>";
		
	}
	
	public function getSize($Size,$Text){
					
		$Text = str_replace('\"','"',$Text);
		
		switch($Size){
		
			case 2: $Size = "10"; break;
			case 3: $Size = "12"; break;
			case 4: $Size = "14"; break;
			case 5: $Size = "18"; break;
			case 6: $Size = "24"; break;
			case 7: $Size = "36"; break;
		}
		
		return "<font style=\"font-size:".$Size."pt;\">$Text</font>";	
	}
	
	public function getFont($Font,$Text){
					
		$Text = str_replace('\"','"',$Text);
		
		return "<font face=\"$Font\">$Text</font>";	
	}
	
	public function getTag($Tag,$Value,$More=''){
		
		$Value = str_replace('\"','"',$Value);	
		
		return "<$Tag $More>$Value</$Tag>";
	}
	
	public function getAlign($Align,$Value){
		
		$Value = str_replace('\"','"',$Value);	
		
		return "<div align=\"$Align\">$Value</div>";
	}
	
	public function getEmail($link, $message)
        {
			if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[_a-z0-9-]+)", $link))
			{
				if(!empty($message))
               
			    return "<a href=\"mailto:$link\" target=\"_blank\">$message</a>";
				
				else
				
			    return "<a href=\"mailto:$link\" target=\"_blank\">$link</a>";

				
			}
			else
			{
                return '';
			}
        }
		
	public function getImg($Link){
		
		$Link = str_replace('\"','"',$Link);
		
		return "<img src=\"$Link\" />";
	}
	
	public function getUrl($Link,$Text=false){
		
		$Link = str_replace('\"','"',$Link);

                if($Text !== false){
		
		   return "<a href=\"$Link\">$Text</a>";

               }else{
		   
                    return "<a href=\"$Link\">$Link</a>";

               }
	}
	
	public function getYoutube($Link){
		
		$Link = str_replace('\"','"',$Link);

		$Link = str_replace("http://www.youtube.com/watch?v=","",$Link);

		$Link = str_replace("https://www.youtube.com/watch?v=","",$Link);
		
		return "<div style=\"display:block; text-align:center;\"><iframe width=\"640\" height=\"390\" src=\"http://www.youtube.com/embed/$Link\" frameborder=\"0\" allowfullscreen></iframe></div>";
	}
	
	public function getFlash($Link,$W,$H){
		
		$Link = str_replace('\"','"',$Link);
	
		return "<div style=\"display:block; text-align:center;\">
		<object width='$W' height='$H'>
		<param name='movie' value='$Link'>
		</param><param name='autostart' value='true'>
		</param><param name='allowscriptaccess' value='always'>
		</param><embed src='$Link' type='audio/x-pn-realaudio-plugin' allowscriptaccess='always' allowfullscreen='true' width='275' height='40'></embed></object></div>";
	}
	
	public function getMedia($Link){
		
		$Link = str_replace('\"','"',$Link);
	
		return '<div style="display:block; text-align:center;"><OBJECT id="VIDEO" width="320" height="160" 
				style="position:absolute; left:0;top:0;"
				CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"
				type="application/x-oleobject">
				<PARAM NAME="URL" VALUE=" ' . $Link . '">
				<PARAM NAME="SendPlayStateChangeEvents" VALUE="True">
				<PARAM NAME="AutoStart" VALUE="True">
				<PARAM name="uiMode" value="none">
				<PARAM name="PlayCount" value="9999">
				</OBJECT></div>';
	}
	
	public function getViemo($Link){
	
		$Link = str_replace('\"','"',$Link);
		
		$Link = str_replace("http://vimeo.com/","",$Link);

		$Link = str_replace("https://vimeo.com/","",$Link);
		
		return '<div style="display:block; text-align:center;"><iframe src="http://player.vimeo.com/video/'.$Link.'?title=0&byline=0&portrait=0" width="500" height="350" frameborder="0"></iframe></div>';
	
	}
	
	public function getQuote($By='',$Text){
		
		$Text = str_replace('\"','"',$Text);
		
		if(empty($By))
			
			return "<div class=\"quote_name\">نص مقتبس : </div><div class=\"quote\">$Text</div>";
		
		else
		
			return "<div class=\"quote_name\">المشاركة الأصلية بواسطة : $By</div><div class=\"quote\">$Text</div>";

		;
	}
	
	public function getAttachment($Id){
		
		global $eaf,$lang;
		
		$Query = $eaf->db->query("select * from " . tablenamestart("attachments") . " where aid = $Id");
		
		$Rows  = $eaf->db->dbrows($Query);
		
		mysql_free_result($Query);
		
		$Images = array('jpg' , 'png' , 'jpeg' , 'gif' , 'bitmap');
		
		if(!empty($Rows['a_name']) and file_exists("upload/attachments/" . $Rows['salt'] . '-' . $Rows['a_name'])){
				
			if(in_array($Rows['a_type'] , $Images)){
	
				return "<a class=\"fancybox\" href=\"".GetSiteUrl()."/upload/attachments/".$Rows['salt'] . '-' . $Rows['a_name']."\"><img src=\"".getResizedImage($Rows['salt'] . '-' . $Rows['a_name'] , 'attachment' , 720 , 720)."\" /></a>";
				
			}else{
					
				return "<div class=\"attachments\">
						<span class=\"name\"> " . $lang["file_name"] . " : <a href=\"?action=download&aid=$Rows[aid]\" target=\"_new\">$Rows[a_name]</a></span>
						<span class=\"type\"> " . $lang["file_type"] . " : $Rows[a_type]</span>
						<span class=\"size\"> " . $lang["file_size"] . " : $Rows[a_size]</span>
						<span class=\"downloads\"> " . $lang["file_downloads"] . " : $Rows[total]</span>
						</div>";	
						
			}

		}
		
	}
	
	public function CodeRe($Code){
	
		$Code = preg_replace("/\&lt;(.*)&gt;/iU","<span style=\"color: rgb(0, 0, 187);\">&lt;$1&gt;</span>",$Code);

		$Code = preg_replace("/\&quot;(.*)&quot;/iU","&quot;<span style=\"color: rgb(221, 0, 0);\">$1</span>&quot;",$Code);
						
		return $Code;	
	}
}
?>