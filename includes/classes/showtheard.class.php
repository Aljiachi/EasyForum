<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------



class Showtheard{

	private $tid,$query,$rows;
	
	public $WasOnline,$Rating;

	public function __construct($theard_id){
	
		global $eaf,$lang;
	
		$this->tid 		  = $theard_id;
		
		    if(!is_numeric($this->tid)){
				
				header("location: index.php");
				
				exit;	
			}
	
		$this->query		= $eaf->db->query("SELECT * FROM " . tablenamestart("topics") . " WHERE tid='$this->tid'");
			
		$Num				= $eaf->db->dbnum($this->query);
		
		if($Num == 0){

				header("location: index.php");
				
				exit;	
		}
	
		$this->rows  		 = $eaf->db->dbrows($this->query);	

		$this->view		 = $eaf->db->query("UPDATE ". tablenamestart('topics') . " SET views=views+1 WHERE tid=".$this->tid);
	
		$this->posts	    = $eaf->db->query("SELECT * FROM ".tablenamestart("posts"). " WHERE t_id=".$this->tid . " order by pid DESC");
		
		$RowsOf			 = $eaf->db->_object($this->posts);
		
		$this->Rating = $eaf->db->dbnum($eaf->db->query("select id from " . tablenamestart("trating") . " where tid = $this->tid"));

		$this->update_posts = $eaf->db->query("UPDATE ". tablenamestart('topics') . " 
											SET txts='".$eaf->db->dbnum($this->posts)."',
											lastpostid='".$RowsOf->pid."',
											lastpost_title='".$RowsOf->ptitle."',
											lastpost_icon='".$RowsOf->picon."',
											lastpost_user='".$RowsOf->pusername."',
											lastpost_time='".$RowsOf->time."',
											rating = '$this->Rating'
											WHERE tid=".$this->tid);
	
	
		$update_section_of_posts = $eaf->db->query("update ".tablenamestart("posts"). " set f_id='" . $this->rows['f_id'] . "' where t_id = $this->tid");
	
		$this->WasOnline = $eaf->db->query("select * from " . tablenamestart("online") . " where t_id = $this->tid");
		
		
	}

	public function Theard_exists(){
	
		global $eaf,$lang;
			
			if($eaf->db->dbnum($this->query) == 0){
		
				header("location: ?action=error&do=8");	
		
				$eaf->_close();
	
			}

	}

	public function Title(){

		return $this->rows['title'];

	}

	public function Content(){
	
		return GetBbCode($this->rows['text']);

	}

	public function Forumid(){

		return $this->rows['f_id'];

	}

	public function Userid(){
	
		return $this->rows['u_id'];

	}

	public function Date(){

		return $this->rows['data'];

	}

	public function Totalviews(){
	
		return $this->rows['views'];

	}

	public function Totalposts(){

		return $this->rows['txts'];
	
	}

	public function Closed(){
		
		return $this->rows['close'];
	
	}
	
	public function LastPage(){
		
		return $this->rows['lastpage'];
	
	}
	
	public function LastPostId(){
		
		return $this->rows['lastpostid'];
	
	}

	public function Icon(){
	
		if(!empty($this->rows['icon_id'])){

			return $this->rows['icon_id'];
	
		}else{
		
			return GetPostIcon(); 	
	
		}

	}


}
?>