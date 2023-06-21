<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class Inputs{

	private $Id,$Table;
	
	public $UsercpInputs;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->Id = $eaf->security->HashId($eaf->_REQUEST['id']);
		
		$this->Table = tablenamestart("inputs");
		
		$Uid = Userid();
		
		$this->UsercpInputs = $eaf->db->query("SELECT * FROM $this->Table a,members b WHERE b.uid = $Uid");
		
	}
	
	public function EditInput($Type,$Id){
		
		global $eaf,$lang;
	
		$Uid = Userid();
		
		$GetValue = $eaf->db->query("select * from members where uid = $Uid");
		
		$RowsValue = $eaf->db->_object($GetValue);
						
		$Value 	 = "extrainput";
		
		$Value    .=  "_";
		
		$Value    .=  $Id; 
							
		if($Type == "{text}"){
									
			print '<input type="text" name="extra_input_'.$Id.'" value="'.$RowsValue->$Value.'" />';
		}
		
		if($Type == "{radio}"){
			
			$QueryForeach = $eaf->db->query("select * from $this->Table where input_id = $Id");
			
			$RowsForeach  = $eaf->db->_object($QueryForeach);
		
			$Values = explode("{sp}",$RowsForeach->input_strings);
			
			foreach($Values as $kay){
				
				$Exists    = $RowsValue->$Value;
												
				$Input  = '<span class="extrainput_title">' . $kay . '</span>';
								
				$Input .= '<span class="extrainput_body"><input type="radio" name="extra_input_'.$Id.'" value="'.$kay.'"';
				
				if("$Exists" == "$kay"){
				
					$Input .= "checked";	
				}
				
				$Input .= '/></span>';	
				
				$Input .= "<br /> \n";
				
				print $Input;
			}
		}
		
		if($Type == "{menu}"){
			
			$Exists    = $RowsValue->$Value;
			
			$QueryForeach = $eaf->db->query("select * from $this->Table where input_id = $Id");
			
			$RowsForeach  = $eaf->db->_object($QueryForeach);
		
			$Values = explode("{sp}",$RowsForeach->input_strings);
			
			print '<select name="extra_input_'.$Id.'">' . "\n";
			
			foreach($Values as $kay){
								
				$option =  "<option value=\"$kay\"";
								
				if("1" == "$kay"){
				
					$option .= "checked";	
				}
				
				$option .= ">$kay</option>";	
				
				print $option;
			}
			
			print "</select>\n";
			
			unset($option,$Values,$Value,$Input,$RowsForeach,$RowsValue,$Uid);
		}
		
			
	}
	
    public function __destruct(){
    
	    unset($this->Id,$this->Table);
		    
	}	
}

?>
