<?php

	class RssFeed{
	
		private $Query;
		
		public function makeFeed(){
			
			global $eaf;
	
			$table = tablenamestart("topics");
							
			function xmlentities($string){
			  return str_replace ( array ('&', '"', "'", '<', '>', '\x92' ), array ('&amp;' , '"', "\'" , '&lt;' , '&gt;', '&apos;' ), $string );
			}
			
			$site = ForumName();
			$url  = GetSiteUrl();
			
			header('Content-Type: text/xml');
			echo '<?xml version="1.0" encoding="windows-1256"?>'. "\r\n";
			echo '<rss version="0.91">'."\r\n";
			echo "<channel>\r\n";
			
			echo "\t\t<title>".xmlentities($site)."</title>\r\n";
			echo "\t\t<link>$url</link>\r\n";
			echo "\t\t<description>".xmlentities("Easy Forum V 1.0")."</description>\r\n";
			
			$result = mysql_query ("SELECT tid,title,text FROM $table
											 WHERE close='0'
											 ORDER BY tid DESC limit 10");
					
			while ($row = mysql_fetch_array($result))
			{
				$id 		= $row['tid']; 
				$title 	= xmlentities($row['title']); 
				$text 	= xmlentities($row['title']); 
				$text   = strip_tags($text);
				$text   = mb_substr($text , 0 , 300 , 'utf-8');
				$thelink 	= xmlentities($url."/index.php?action=showtheard&tid=$id");
				
				echo "\t<item>\r\n";
				echo "\t\t<title>$title</title>\r\n";
				echo "\t\t<link>".$thelink."</link>\r\n";
				echo "\t\t<description>$text</description>\r\n";
				echo "\t</item>\r\n";
			}
			echo "</channel>\r\n";
			echo "</rss>";
			exit();
	
			
		}	
		
	
	}
/*	
if($_REQUEST['action'] == "rss"){
		
		$eaf->rss = new RssFeed();
		
		$eaf->rss->makeFeed();
		
	}*/
	
?>