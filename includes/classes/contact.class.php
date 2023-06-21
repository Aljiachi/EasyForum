<?


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------



class eafContact
{
	private $title;
	private $email;
	private $message;
	private $data;
	private $ip;
	private $connect;

	public function access(){
	
		global $eaf,$lang;
	
		$this->title = mysql_real_escape_string(addslashes(strip_tags($eaf->_POST['title'])));
	
		$this->email= mysql_real_escape_string(addslashes(strip_tags($eaf->_POST['email'])));
	
		$this->message = mysql_real_escape_string(addslashes($eaf->_POST['msg']));
	
		$this->data = arabic_data();
	
		$this->ip = getip();
		
		if(isset($eaf->_POST['contact_send'])){
		
			if(empty($this->title) or empty($this->email) or empty($this->message)){
			
				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));
			
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));
			
				$eaf->_close();
		
			}
	
		}

	}

	public function insert(){
	
		global $eaf,$lang;
	
		if(isset($eaf->_POST['contact_send'])){
	
			$this->insert = $eaf->db->query("INSERT INTO ". tablenamestart("contact") ." (title,email,msg,data,ip) VALUES ('$this->title','$this->email','$this->message','$this->data','$this->ip')");	
	
			if($this->insert){
		
				$eaf->_print($eaf->_Greenmsg($lang["message_sent"]));
			
				$eaf->_print($eaf->_Refresh('index.php'));
			
				$eaf->_close();
		
			}
	
		}

	}

}
?>
