<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class PrintTheard{
	
	private $Id,$TopicsSQl,$PostsSQl,$Rows,$TopicsTable,$PostsTable;
	
	public function Run(){
		
		global $eaf,$lang;
		
		$this->Id = $eaf->security->HashId($eaf->_REQUEST['id']);
		
		$this->TopicsTable = tablenamestart("topics");
		
		$this->PostsTable = tablenamestart("posts");
	}
	
	public function start(){
		
		global $eaf,$lang;
		
		print "<!DOCTYPE html>\n<html>\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
		print "<title>" . ForumName() . " - ".$lang["print_title"]." : " . $this->Rows->title . "</title>\n";
		$eaf->_print('<link href="look/print.css" rel="stylesheet" />'."\n");	
		print "</head>\n<body>\n";
		$eaf->_print('<div id="Header">' . ForumName() . ' </div>'."\n");
		$eaf->_print('<button onclick="window.print();">'.$lang["print_click"].'</button>');
	}

	public function end(){
	
		print "\n </body> \n </html>";	
	}
	
	public function MkSql(){
		
		global $eaf,$lang;
		
		$TheardId = $eaf->security->HashId($this->Id,false);
		
		$this->TopicsSQl = $eaf->db->query("select * from $this->TopicsTable where tid = $TheardId");
		
		if($eaf->db->dbnum($this->TopicsSQl) == 0){
			
			die($lang["alert_theard_notexists"]);
		}
		
		$this->PostsSQl  = $eaf->db->query("select * from $this->PostsTable where t_id = $TheardId");
	}
	
	public function Rows(){
		
		global $eaf,$lang;
		
		$this->Rows =  $eaf->db->_object($this->TopicsSQl);

	
	}
	
	public function GetTheard(){
		
		global $eaf,$lang;
		
		$eaf->_print('<div id="TheardBody">' . "\n");
		
		$eaf->_print('<div id="Info">' . "\n");

		$eaf->_print('<span id="Title">' . $this->Rows->title  . "</span>\t\t-\t\t\n");

		$eaf->_print('<span id="Title"> '.$lang["write_name"].' : ' . $this->Rows->username  . "</span>\t\t-\t\t\n");

		$eaf->_print('<span id="Title"> '.$lang["write_date"].' : ' . $this->Rows->data  . " </span>\t\t-\t\t\n");
		
		$eaf->_print('<span id="Title"> '.$lang["views"].' : ' . $this->Rows->views  . "</span>\n");
		
		$eaf->_print('<div id="Text">' . GetBbCode($this->Rows->text)  . " </div>\n");
		
		$eaf->_print("</div> \n");	

		$eaf->_print("</div> \n <hr /> \n");	

	}
	
	public function GetPosts(){
		
		global $eaf,$lang;
		
		while($Rows = $eaf->db->_object($this->PostsSQl)){
		
			$eaf->_print('<div id="TheardBody">' . "\n");
			
			$eaf->_print('<div id="Info">' . "\n");
			
			$eaf->_print('<span id="Title"> '.$lang["post_title"].' : ' . $Rows->ptitle  . "</span>\t\t-\t\t\n");
	
			$eaf->_print('<span id="Title"> '.$lang["write_name"].' : ' . $Rows->pusername  . "</span>\t\t-\t\t\n");
	
			$eaf->_print('<span id="Title"> '.$lang["write_date"].' : ' . $Rows->pdata  . " </span> \n");
					
			$eaf->_print('<div id="Text">' . GetBbCode($Rows->ptext)  . "</div>\n");
			
			$eaf->_print("</div> \n");	
	
			$eaf->_print("</div> \n");		
		
		}
			
	}
}
?>