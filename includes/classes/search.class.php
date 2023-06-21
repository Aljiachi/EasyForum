<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Search{
	
private $query,$rows,$sql;	

	public function __construct(){
		
		global $eaf,$lang;
	
	}
	
	public function _Sections(){
	
		global $eaf,$lang;
		
		return $eaf->db->query("SELECT * FROM " . tablenamestart('sections') . " WHERE sort!='0' ");	
	}
	
	public function _Page(){
	
		global $eaf,$lang;
		
		$eaf->query = $this->_Sections();
		
		return $eaf->template->display("search");	
	}
	
	public function SearchDo(){     
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['search_do']) and !empty($eaf->_POST['search_do'])){
			
			$word = $eaf->security->svar($eaf->_POST['search_word']);
			
			$user = $eaf->security->svar($eaf->_POST['search_user']);
			
			$section = $eaf->security->svar($eaf->_POST['section']);
		
		if(empty($section)){
		
			$section = "all";
		
		}
		
		$order = $eaf->security->svar($eaf->_POST['order']);
		
		if(empty($order)){
		
			$order = "DESC";
		
		}
		
		$in    = $eaf->security->svar($eaf->_POST['in']);
		
		if(empty($in)){
		
			$in = "title";
		
		}
		
		$sql = "SELECT * FROM `" . tablenamestart('topics') . "` WHERE ";
		
		if(!empty($word) and $in == "title"){
		
		$sql .= " `title` LIKE '%$word%'";
		
		}
		
		if(!empty($word) and $in == "post"){
		
		$sql .= " `text` LIKE '%$word%'";
		
		}
		
		if(!empty($word) and !empty($user)){
		
		$sql .= " OR `username` LIKE '%$user%'";
		
		}
		
		if(empty($word) and !empty($user)){
		
		$sql .= " `username` LIKE '%$user%'";	
		
		}
		
		if(!empty($word) || !empty($user) and $section !== "all"){
		
		$sql .= " OR `f_id` = '$section'";
		
		}
		
		if(!empty($word) || !empty($user)){
		
			$sql .= " ORDER BY `tid` ".$order;
		
		}else{
		
			$sql .= "";	
		
		}
		
		}
				
		return $sql;

	}
	
	public function _ResultsPage(){
		
		global $eaf,$lang;
		
		$this->sql = $this->SearchDo();
							
		if(trim($this->sql) == "SELECT * FROM `phpforyou_topics` WHERE"){
		
		$eaf->_print($eaf->_Redmsg($lang["search_error"]));
			
			$eaf->_print($eaf->_Refresh('?action=search'));
			
			$eaf->Page->_TEnd();
			
			$eaf->_close();	
	
		}

			
		$SSGET = @$eaf->db->query($this->SearchDo());

		if($SSGET == true){
		
			if($eaf->db->dbnum($eaf->db->query($this->sql)) == 0) {
			
				$eaf->_print($eaf->_Redmsg($lang["search_error"]));
				
				$eaf->_print($eaf->_Refresh('?action=search'));
				
				$eaf->Page->_TEnd();
				
				$eaf->_close();
				
				}
								
			$eaf->SearchPager = new pager;
				
			$eaf->query = $eaf->SearchPager->Querspagination($this->sql,"index.php?action=search",15);
			
			print $eaf->template->display('search_results');
			
			$eaf->pages = $eaf->SearchPager->Pagination();
	
			print $eaf->template->display('pagination');
		
		}else{
		
			$eaf->_print($eaf->_Redmsg($lang["search_error"]));
			
			$eaf->_print($eaf->_Refresh('?action=search'));
			
			$eaf->Page->_TEnd();
			
			$eaf->_close();	
	}
		
	}
}
	$eaf->Search = new Search();
?>
