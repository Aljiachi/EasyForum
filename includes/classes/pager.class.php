<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------



class Pager{
	
	private $lastpage,$adjacents,$targetpage,$prev,$next;
	
	public $SetRequest = "page";
	
	public $page;

	public function Querspagination($Query,$target,$limit){

		global $eaf,$lang;

		if($where == true){ $where = " WHERE ".$where;   }
		
		if($order == true){ $order = "ORDER BY ".$order; }
		
		if(empty($this->SetRequest)) $this->SetRequest = "page";
		
		$tbl_name = $table; 

		$adjacents = 3;

		$total_pages = $eaf->db->dbnum($eaf->db->query($Query));
		
		$this->page = $eaf->_REQUEST[$this->SetRequest];
		
		if(isset($this->page)) {
		
			if(!is_numeric($this->page)) header("location: index.php");
		
		}
		
		if($this->page)

		$start = ($this->page - 1) * $limit;

		else
 
		$start = 0;

		$sql_query  = $Query. " LIMIT $start,$limit";

		$result = $eaf->db->query($sql_query)or die (mysql_error());

		$total = $eaf->db->dbnum($result);

		if ($this->page == 0) $this->page = 1;

		$this->prev = $this->page - 1;

		$this->next = $this->page + 1;

		$lastpage = ceil($total_pages/$limit);

		$lpm1 = $this->lastpage - 1;
		
		$this->lastpage = $lastpage;
				
		$this->targetpage = $target;
		
		$this->adjacents = $adjacents;
		
	return $result;

	}

	public function Pagination(){
		
		global $lang;

		$pagination = "";

		if($this->lastpage > 1){
	
			$pagination .= "<div class=\"pagination\"><table><tr>";
				
				if ($this->page > 1)

					$pagination.= "<td><a href=\"$this->targetpage&$this->SetRequest=$this->prev\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$this->prev');\">$lang[prev]</a></td>";
			
				else
									
					$pagination.= "<td><span class=\"disabled\">$lang[prev]</span></td>";

					if ($this->lastpage < 7 + ($this->adjacents * 2)){
					
						for ($counter = 1; $counter <= $this->lastpage; $counter++){

						if ($counter == $this->page)
							
							$pagination.= "<td><span class=\"current\">$counter</span></td>";

						else

							$pagination.= "<td><a href=\"$this->targetpage&$this->SetRequest=$counter\"  onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$counter');\">$counter</a></td>";
				
					}

				}
	elseif($this->lastpage > 5 + ($this->adjacents * 2)){

			if($this->page < 1 + ($this->adjacents * 2))

	{

		for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)

	{

		if ($counter == $this->page)

		$pagination.= "<td><span class=\"current\">$counter</span></td>";

		else

		$pagination.= "<td><a href=\"$this->targetpage&$this->SetRequest=$counter\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$counter');\">$counter</a></td>";

	}

		$pagination.= "<td>...</td>";

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$lpm1\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$lpm1');\">$lpm1</a></td>";

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$this->lastpage\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$this->lastpage');\">$this->lastpage</a></td>";

	}

		elseif($this->lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=1\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=1');\">1</a></td>";

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=2\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=2');\">2</a></td>";

		$pagination .="<td>...</td>";
		
		for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++){
	
			if ($counter == $this->page)
	
				$pagination .="<td><span class=\"current\">$counter</span></td>";
	
			else
			
				$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$counter\">$counter</a></td>";

	}

		$pagination .="<td>...</td>";

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$lpm1\" onclick=\"return _NextPage('this->targetpage&$this->SetRequest=$lpm1');\">$lpm1</a></td>";
	
		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$this->lastpage\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$this->lastpage');\">$this->lastpage</a></td>";
	
	}

	else

		{

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=1\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=1');\">1</a></td>";

		$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=2\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=2');\">2</a></td>";

		$pagination .="<td>...</td>";

		for ($counter = $this->lastpage - (2 + ($this->adjacents * 2)); $counter <= $this->lastpage; $counter++){

			if ($counter == $this->page)

				$pagination .="<td><span class=\"current\">$counter</span></td>";
			
			else
	
				$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$counter\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$counter');\">$counter</a></td>";

	}

	}

	}


		if ($this->page < $counter - 1)

			$pagination .="<td><a href=\"$this->targetpage&$this->SetRequest=$this->next\" onclick=\"return _NextPage('$this->targetpage&$this->SetRequest=$this->next');\">$lang[next]</a></td>";
		
		else

			$pagination .="<td><span class=\"disabled\">$lang[next]</span></td>";

			$pagination .="</tr></table></div>\n";

	}	

	return $pagination;	

	}

	public function LastPageGet(){

		global $eaf,$lang;

		$tid = intval(abs($eaf->_REQUEST['tid']));

		$query = $eaf->db->query("UPDATE ". tablenamestart("topics") ." SET lastpage='".$this->lastpage."' WHERE tid=$tid");

	}
	
}
?>