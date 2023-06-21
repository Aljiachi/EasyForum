<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Forum{
	
	private $fid,
			$rows,
			$query,
			$table;
			
	public $WasOnline;
	
	public function __construct($forum_id){
		
		global $eaf,$lang;
		
		$this->fid   = $forum_id;
		
		if(!is_numeric($this->fid)){

				header("location: index.php");
				
				exit;	
			}
		
		$this->table = tablenamestart('sections');
		
		$this->query = $eaf->db->query("select * from $this->table where fid=$this->fid");
		
		$this->rows  = $eaf->db->dbrows($this->query);	
		
		$this->WasOnline = $eaf->db->query("select * from " . tablenamestart("online") . " where f_id = $this->fid");
		

	}
	public function _ForumGetInf(){
		
		global $eaf,$lang;
		
		return $eaf->db->query("select * from $this->table where fid=$this->fid");	
	}
	
	public function _ForumGetSort(){
		
		global $eaf,$lang;
		
		return $eaf->db->query("select * from $this->table where sort=$this->fid");	
	}
	
	public function _TotalForumSort(){
		
		global $eaf,$lang;
		
		return $eaf->db->dbnum($this->_ForumGetSort());	
	}
	
	public function _Forum_exists(){
		
		global $eaf,$lang;
				
		
		if($eaf->db->dbnum($this->query) == 0){
		
			header("location: index.php");
		
			$eaf->_close();	
		
		}
	}
	
	public function _TotalTheards(){
	
		global $eaf,$lang;
	
		$query =  $eaf->db->query("select tid from " . tablenamestart("topics") . " where f_id=$this->fid");		
	
		return $eaf->db->dbnum($query);
	
	}
	
	public function _GetFastPages($id){
		
		global $eaf,$lang;
		
		$rows = $eaf->db->_object($eaf->db->query("select lastpage from " . tablenamestart("topics") . " where tid = $id"));
		
		if($rows->lastpage == 0)
		
		$page = 1; 
		
		else
		
		$page =  $rows->lastpage;
		
		if($page > 2){
			
			$link = "<span style=\"margin:2px;\" dir=\"$lang[dir]\"> ( \n";
		
		}
		
		for($x=1; $x != $page;$x++){
			
			if($x < 4){
				
				$link .= "<span class=\"pagelist\"><a href=\"?action=showtheard&tid=$id&page=$x\" style=\"margin-left:3px;\">$x</a></span>";	
			
			}
			
		}	
		
		if($page > 2){

		$link .= "...<span class=\"pagelist\"><a href=\"?action=showtheard&tid=$id&page=$rows->lastpage\" style=\"margin-left:3px;\">$rows->lastpage</a></span>";	

		$link .= "\n ) </span> \n";
		
		}
		
		return $link;
	}
		public function _TotalPosts(){
	
		global $eaf,$lang;
	
		$query = $eaf->db->query("select pid from " . tablenamestart("posts") . " where f_id=$this->fid");	
	
		return $eaf->db->dbnum($query);
	
	}
	
	public function _UpdataPostsNum(){
			
		global $eaf,$lang;
		
		$Theards = $this->_TotalTheards();
		
		$Posts   = $this->_TotalPosts();
				
		$Query = $eaf->db->query("UPDATE `" . tablenamestart("sections") . "` SET 
		
		`total_topics`='$Theards',
		
		`total_replays`='$Posts'
		
		WHERE fid = $this->fid
		
		");
				
		return $Query;
	}
	public function _LastPost(){
	
		global $eaf,$lang;
	
		$query 	= $eaf->db->query("SELECT * FROM " . tablenamestart('topics') . " WHERE f_id = $this->fid ORDER BY wtime DESC limit 1");
	
		$rows     = $eaf->db->_object($query);	
	
		$update   = $eaf->db->query("UPDATE "   .  tablenamestart('sections')  . " SET 
									 total_topics='$this->_TotalTheards()',
									 last_topic='$rows->title',
									 last_postid='$rows->tid',
									 last_postuser='$rows->username',
									 last_postuid='$rows->u_id',
									 last_postdate='".Date2Number($rows->data)."',
									 last_posticon='$rows->icon_id' 
									 WHERE fid=$this->fid");
	}
	public function _ForumId(){
	
		return $this->fid;	
	
	}
	public function _StickyTheards(){
	
		global $eaf,$lang;
	
	$uid = Userid();
		
	if($this->_Rows("view_self") == 0 and UserGroup(GetUserid(),"view_selftopics") == 0){
	
		if(isset($_SESSION['username'])){
	
		return $eaf->db->query(
		"SELECT * FROM ".tablenamestart("topics")." 
		WHERE f_id = $this->fid and stayed='1' and u_id = $uid and deleted='0'
		ORDER BY wtime DESC "
		);	
		
		}
		
	}else{
		
		return $eaf->db->query(
		"SELECT * FROM ".tablenamestart("topics")." 
		WHERE f_id = $this->fid and stayed='1' and deleted='0'
		ORDER BY wtime DESC "
		);
		
	}
	
	}
	
	public function _ForumTheards(){
	
	global $eaf,$lang;
	
	$eaf->TheardsPager = new pager;
	
	$uid = GetUserid();
		
	if($this->_Rows("view_self") == 0 and UserGroup(GetUserid(),"view_selftopics") == 0){
		
	if(isset($_SESSION['username'])){
	
	return $eaf->TheardsPager->Querspagination(
		  
		  "select * from  " . tablenamestart("topics") . " where  f_id = $this->fid and stayed='0'  and u_id = $uid and deleted='0' order by wtime DESC ",
		  
		  "page=forum&id=".$this->fid,
		  
		  GetPageNumForum()
		  
		  );	
		  
	}
		  
	}else{
		
	
	return $eaf->TheardsPager->Querspagination(
		  
		  "select * from  " . tablenamestart("topics") . " where  f_id = $this->fid and stayed='0' and deleted='0' order by wtime DESC ",
		  
		  "index.php?action=forum&fid=".$this->fid,
		  
		  GetPageNumForum()
		  
		  );	
		
	}
	
	}
	
	public function _TotalStickyTheards(){
	
		global $eaf,$lang;
	
		return $eaf->db->dbnum($this->_StickyTheards());	
	}
	public function _RowsArray(){
	
		global $eaf,$lang;
	
		$Rows	= $eaf->db->_object($this->_ForumGetInf());
	
		return array(
					'name' => $Rows->name,
					'more' => $Rows->more,
					'img'  => $Rows->img,
					'open' => $Rows->open,
					'id'   => $Rows->fid,
					'sort' => $Rows->sort,
					'rule' => $Rows->rule,
					'view_self' => $Rows->view_self

					);	
	}
	public function _SRowsArray(){
	
		global $eaf,$lang;
	
		$Rows	= $eaf->db->_object($this->_ForumGetSort());
	
		return array(
					'name' => $Rows->name,
					'more' => $Rows->more,
					'img'  => $Rows->img,
					'open' => $Rows->open,
					'id'   => $Rows->fid,
					'sort' => $Rows->sort,
					'rule' => $Rows->rule,
					'view_self' => $Rows->view_self

					);
	}
	
	public function _Rows($string){
	
		global $eaf,$lang;
		
		$Rows = array();
		
		$Rows = $this->_RowsArray();
		
		return $Rows[$string];	
	}

	public function Gusetforumview(){
	
		global $eaf,$lang;
				
			if(UserGroupID(GetUserid()) == 1){

			if($this->rows['guset_show'] == 1){
				
					return false;
					
					}else{
			
					return true;
						
					}
					
			}
			
		return true;	
						
	}
	
	public function Userforumview(){
	
		global $eaf,$lang;
		
			if(UserGroupID(GetUserid()) == 2){

			if($this->rows['user_show'] == 1){
				
					return false;
					
					}else{
			
					return true;
						
					}
			}
			
		return true;	
			
	}
	
	public function Unactivedforumview(){
	
		global $eaf,$lang;
		
			if(UserGroupID(GetUserid()) == 8){

			if($this->rows['act_show'] == 1){
				
					return false;
					
					}else{
			
					return true;
						
					}
			}
			
		return true;	
			
	}
	
	public function Modsforumview(){
	
		global $eaf,$lang;
		
		if(UserGroupID(GetUserid()) == 4){

			if($this->rows['mods_show'] == 1){
			
				
					return false;
					
					}else{
			
					return true;
						
					}
		}
	
		return true;	
		
	}
	
	public function Morderforumview(){
	
		global $eaf,$lang;
		
			if(UserGroupID(GetUserid()) == 5){

			if($this->rows['morder_show'] == 1){
				
					return false;
					
					}else{
			
					return true;
						
					}
		}
				
		return true;	
			
	}
	
	public function Outforumview(){
	
		global $eaf,$lang;
		
			if(UserGroupID(GetUserid()) == 6){

			if($this->rows['out_show'] == 1){
				
					return false;
					
					}else{
			
					return true;
						
					}
		}
				
		return true;	
			
	}
	
	public function _ForumRule(){
		
		global $eaf,$lang;
		
		$Rule = $this->_Rows("rule");
		
		if(!empty($Rule)){
		
			print $eaf->template->display("forum_rule");	
		
		}
	}
    
	public function _Sortforumview(){
	
		global $eaf,$lang;
		
		if($this->rows['sort'] == 0){
		
		$sort = false;
		
		}else{
		
		$sort = true;	
		
		}
		
		return $sort;
	}
	
}	
	
	if(isset($eaf->_REQUEST['fid']) && is_numeric($eaf->_REQUEST['fid']) && !empty($eaf->_REQUEST['fid'])){
		
		$FOrumGetId = $eaf->security->sint($eaf->_REQUEST['fid']);
		
		$eaf->System->Forum = new Forum($FOrumGetId);
	
	}
?>