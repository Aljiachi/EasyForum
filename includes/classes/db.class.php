<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------



class easyForumDb{
	
	public $Query;

	public function query($sql){

	$this->Query = mysql_query($sql);
	
	return $this->Query;
	
	}

	public function dbnum($query){

	$this->do = mysql_num_rows($query);
	
	return $this->do;

	}

	public function dbrows($query){

	$this->do = mysql_fetch_assoc($query);

	return $this->do;	

	}
	
	public function mysqlError(){ return mysql_error(); }

	public function _object($query){

	$this->do = mysql_fetch_object($query);

	return $this->do;	

	}

	public function _array($query){

		$this->do = mysql_fetch_array($query);

		return $this->do;	

	}

	public function dbselect($Tablename,$Where,$Limit,$OrderBy){

	$query = "SELECT * FROM ".$Tablename." ";
	
	if(!$Where == false){$query.=" WHERE ".$Where."";}

	if(!$OrderBy == false){$query.=" ORDER BY ".$OrderBy."";}

	if(!$Limit == false){$query.=" LIMIT ".$Limit."";} 

	return $this->query($query);

	}
	
	public function totalWhere($Table,$Colm,$Id){
		
		$this->Query = $this->query("select $Colm from $Table WHERE $Colm = $Id");
		
		return $this->dbnum($this->Query);		
			  
	}   

    public function __destruct(){
				
		unset($this->Query);   
	 }	
# end class 
}

	$eaf->db = new easyForumDb();

?>