<?

# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Querys {
	
	private $lastpage,$adjacents,$page,$targetpage,$prev,$next;
	
	public function Querspagination($table,$where,$order,$target){
	
		global $eaf,$lang;
	
		if($where == true){ $where = " WHERE ".$where;   }
	
		if($order == true){ $order = "ORDER BY ".$order; }
	
		$id = intval(abs($eaf->_REQUEST[$id]));
	
		$tbl_name = $table; 
	
		$adjacents = 3;
	
		$query = "SELECT COUNT(*) as num FROM $tbl_name  ".$where;
	
		$total_pages = $eaf->db->_array($eaf->db->query($query));
	
		$total_pages = $total_pages[num];
	
		$limit = 20;
	
		$page = $eaf->_REQUEST['page'];
	
		if($page)
			$start = ($page - 1) * $limit;
		else
			$start = 0;
		
		$sql_query  = "SELECT * FROM $tbl_name ".$where." ".$order." LIMIT $start,$limit";
		
		$result = $eaf->db->query($sql_query)or die ($eaf->db->_error());
		
		$total = $eaf->db->dbnum($result);
		
		if ($page == 0) $page = 1;
		
		$this->prev = $page - 1;
		
		$this->next = $page + 1;
		
		$lastpage = @ceil($total_pages/$limit);
		
		$lpm1 = $this->lastpage - 1;
		
		$this->page = $page;
		
		$this->lastpage = $lastpage;
		
		$this->adjacents = $adjacents;
		
		$this->targetpage = $target;
		
		return $result;
	
	}
	
	public function Pagination(){
		
		$pagination = "";
		
		if($this->lastpage > 1){
			
			$pagination .= "<div class=\"pagination\">";
			
			if ($this->page > 1)
				$pagination.= "<a href=\"$this->targetpage&page=$this->prev\">السابق</a>";
			else
				$pagination.= "<span class=\"disabled\">السابق</span>";
		
			if ($this->lastpage < 7 + ($this->adjacents * 2)){
				
				for ($counter = 1; $counter <= $this->lastpage; $counter++){
					
					if ($counter == $this->page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$this->targetpage&page=$counter\">$counter</a>";
				}
		
		}elseif($this->lastpage > 5 + ($this->adjacents * 2)) {
		
			if($this->page < 1 + ($this->adjacents * 2)){
				
				for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
		
					if ($counter == $this->page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$this->targetpage&page=$counter\">$counter</a>";
				}
				
			$pagination.= "...";
		
			$pagination.= "<a href=\"$this->targetpage&page=$lpm1\">$lpm1</a>";
		
			$pagination.= "<a href=\"$this->targetpage&page=$this->lastpage\">$this->lastpage</a>";
		
		}elseif($this->lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){
			
			$pagination.= "<a href=\"$this->targetpage&page=1\">1</a>";
			
			$pagination.= "<a href=\"$this->targetpage&page=2\">2</a>";
		
			$pagination.= "...";
		
		for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++){
			
			if ($counter == $this->page)
				$pagination.= "<span class=\"current\">$counter</span>";
			else
				$pagination.= "<a href=\"$this->targetpage&page=$counter\">$counter</a>";
		
		}
		
		$pagination.= "...";
		
		$pagination.= "<a href=\"$this->targetpage&page=$lpm1\">$lpm1</a>";
		
		$pagination.= "<a href=\"$this->targetpage&page=$this->lastpage\">$this->lastpage</a>";
		
		}else{
			
			$pagination.= "<a href=\"$this->targetpage&page=1\">1</a>";
			
			$pagination.= "<a href=\"$this->targetpage&page=2\">2</a>";
			
			$pagination.= "...";
			
			for ($counter = $this->lastpage - (2 + ($this->adjacents * 2)); $counter <= $this->lastpage; $counter++){
			
				if ($counter == $this->page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$this->targetpage&page=$counter\">$counter</a>";
				}
			
			}
		
		}
		
		if ($this->page < $counter - 1)
			$pagination.= "<a href=\"$this->targetpage&page=$this->next\">التالي</a>";
		else
			$pagination.= "<span class=\"disabled\">التالي</span>";
		
		$pagination.= "</div>\n";
		
		}	
		
		return $pagination;	
	
	}
# END CLASS 
}

$eaf->pagination = new Querys();

?>