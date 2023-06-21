<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class eafUsercp{

	private $username,$query,$rows;
	
	public $LastTheards;
	
	public function __construct(){
	
		global $eaf,$lang;
		
		$this->username = UserName();
		
		if(isset($this->username)){
		
		$this->query    = $eaf->db->query("SELECT * FROM members WHERE username='$this->username'");
		
		$this->rows     = $eaf->db->dbrows($this->query);	
		
		$this->LastTheards = $eaf->db->query("select * from " . tablenamestart("topics") . " where u_id = " . $this->rows['uid'] . " order by tid desc limit 10");
									 
		}
	}
	
	public function _exists(){
		
		global $eaf,$lang;
		
			if($eaf->db->dbnum($this->query) == 0){
				
				header("location: ?action=error&do=8");	
				
				$eaf->_close();
			}
	}
	
	public function Username(){
	
		return $this->rows['username'];	
	}

	public function Password(){
	
		return $this->rows['password'];	
	}
	
	public function Email(){
	
		return $this->rows['email'];	
	}
	
	public function Sex(){
	
		return $this->rows['sex'];	
	}
	
	public function Age(){
	
		return $this->rows['age'];	
	}
	
	public function Avatar(){
	
		return resizeimg($this->rows['avatar'],150,150);	
	}
	
	public function Country(){
	
		return $this->rows['cant'];	
	}

	public function Signature(){
	
		return GetBbCode(str_replace("*=q=*","'",$this->rows['signt']));	
	}	
	
	public function EditSignature(){
	
		return $this->rows['signt'];	
	}	
	
	public function GetPostTitle($tid,$pid=null){
	
		global $eaf,$lang;
		
			if(empty($pid)){
				
				$Query = $eaf->db->query("select * from " . tablenamestart("topics") . " where tid = $tid");
				
				$Rows  = $eaf->db->dbrows($Query);
				
				return '<a href="?action=showtheard&tid='.$Rows['tid'].'" title="'.$Rows['title'].'"> ' .  substr($Rows['title'],0,25) . '</a>';
			
			}else{
				
				$TQuery = $eaf->db->query("select * from " . tablenamestart("topics") . " where tid = $tid");
				
				$TRows  = $eaf->db->dbrows($TQuery);

				$PQuery = $eaf->db->query("select * from " . tablenamestart("posts") . " where pid = $pid");
				
				$PRows  = $eaf->db->dbrows($PQuery);
				
				return '<a href="?action=showtheard&tid='.$Rows['tid'].'#post-'.$PRows['pid'].'" title="'.$Rows['title'].'"> ' .  substr($Rows['title'],0,25) . '</a>';
			
				
			}
		}
		
	
	public function EditAvatar(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit_avatar']) and !empty($eaf->_POST['edit_avatar'])){
				
		if(!empty($eaf->_POST['avatarlink'])){
	
			$avatar = strip_tags(trim(mysql_real_escape_string($eaf->_POST['avatarlink'])));
			
		}else{
	
			if(!empty($_FILES['avatarup']['name']) and isset($_FILES['avatarup'])){
									
				$types_images = array('image/png','image/jpeg','image/bmp','image/jpg','image/gif');
				
				$img   = $_FILES['avatarup']['name'];
		
				$tmp   = $_FILES['avatarup']['tmp_name'];
				
				$size  = $_FILES['avatarup']['size'];
				
				$type  = $_FILES['avatarup']['type'];
			
				if(check_image($tmp) == false) {  header("location: ?home");  return false; }
							
				if(!in_array($type,$types_images)){
				
					$eaf->_Redmsg($lang["avatar_notype"]);
					
					$eaf->_print($eaf->_Refresh('?action=usercp&do=avatar'));
					
					$eaf->_close();
					
					return false;	
				}
							
				if($size > GetMaxUpAvatarSize()){
				
					$eaf->_Redmsg($lang["avatar_size"]);
					
					$eaf->_print($eaf->_Refresh('?action=usercp&do=avatar'));
					
					$eaf->_close();
					
					return false;					
				}
	
				$up = move_uploaded_file($tmp,"avatars/".$img);
				
				$avatar = "avatars/".$img;	
				
				if(GetDeleteAvatar() == 1){
				
					@unlink($rows['avatar']);
				
				}		
		
			}
		
		}
					

		if(empty($avatar)){
		
			$avatar = $this->rows['avatar'];	
	
		}

		$Query = $eaf->db->query("UPDATE members SET avatar = '$avatar' WHERE uid = " . $this->rows['uid']) or die(mysql_error());
		

		if($Query){
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));
				
				$eaf->_print($eaf->_Refresh("?action=usercp&do=avatar"));			

				$eaf->_close();						
				
		}else{
		
				$eaf->_print($eaf->_Redmsg($lang["editporfile_error"]));

				$eaf->_print($eaf->_Refresh("?action=usercp&do=avatar"));			

				$eaf->_close();
				
		}
				
			
	}
	
	}
	
	public function EditSignt(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit_signt'])){
			
			if(GetRegisterHtml() == 0){

				$signt  = htmlspecialchars($eaf->_POST['signt']);

			}else{

				$signt  = $eaf->_POST['signt'];	

			}
			
			$update = $eaf->db->query("update members set signt='$signt' where username = '$this->username'");
			
			if($update){
				
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));
				$eaf->_print($eaf->_Refresh('?action=usercp&do=signt'));
				exit;
			}
				
			}
	}
	
	public function EditOptions(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit_options'])){
			
			$online = $eaf->_POST['option_online'];
			$getpm = $eaf->_POST['option_getpm'];
			$getgm = $eaf->_POST['option_getgm'];
			$your_style = $eaf->_POST['option_yourstyle'];
			
			$update = $eaf->db->query("update members set your_style='$your_style',option_online='$online',option_getpm='$getpm',option_getgm='$getgm'  where username = '$this->username'");
			
			if($update){
				
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));
				$eaf->_print($eaf->_Refresh('?action=usercp&do=options'));
				exit;
			}
				
			}
	}
	
	public function EditPassword(){
		
		global $eaf,$lang;
	
		if(isset($eaf->_POST['edit_password'])){
			
			$password = $eaf->security->Password($eaf->_POST['password']);

			$newpass  = $eaf->security->Password($eaf->_POST['newpass']);
						
			$Max = GetMinPassDo();
			
				if(strlen($eaf->_POST['newpass']) < $Max){
		
					$eaf->_print($eaf->_Redmsg($lang["editpass_max"]));
				
					$eaf->_print($eaf->_Refresh("?action=usercp&do=password"));			
				
					$eaf->_close();
				
					}
					
					# End

				if($this->rows['password'] !== $password){
	
					$eaf->_print($eaf->_Redmsg($lang["editpass_old"]));

				$eaf->_print($eaf->_Refresh("?action=usercp&do=password"));			

					$eaf->_close();
				
					}
					
					# End 
					
		
		
		$Query = $eaf->db->query("UPDATE `members` SET `password` = '$newpass' WHERE `uid` = " . $this->rows['uid']) or die(mysql_error());
		

		if($Query){
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));
				
				$eaf->_print($eaf->_Refresh("?action=usercp&do=password"));			

				$eaf->_close();						
				
		}else{
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_error"]));

				$eaf->_print($eaf->_Refresh("?action=usercp&do=password"));			

				$eaf->_close();
				
				}
				
				# End

		}
		
		# End

					
		}
	
	public function EditProfile(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit_profile'])){
			
			$from   = $eaf->security->safe($eaf->_POST['cant']);		

			$age    = $eaf->security->safe($eaf->_POST['age']);

			$sex	= $eaf->security->safe($eaf->_POST['sex']);
			
			$Query = $eaf->db->query("UPDATE `members` SET `sex` = '$sex',`age`='$age',`cant`='$from' WHERE `uid` = " . $this->rows['uid']) or die(mysql_error());
		
			if($Query){
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));
				
				$eaf->_print($eaf->_Refresh("?action=usercp&do=profile"));			

				$eaf->_close();						
				
			}else{
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_error"]));

				$eaf->_print($eaf->_Refresh("?action=usercp&do=profile"));			

				$eaf->_close();
				
				}
				
				# End			
		}
	}
	
	public function EditEmail(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit_email'])){
			
			$Old = $eaf->security->safe($eaf->_POST['old']);
			
			$New = $eaf->security->safe($eaf->_POST['new']);
			
			if(empty($Old) or empty($New)){
			
				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));

				$eaf->_print($eaf->_Refresh("?action=usercp&do=email"));			

				$eaf->_close();
									
			}
			
			if(!$eaf->security->email_check($New)){
	
				$eaf->_print($eaf->_Redmsg($lang["email_notexists"]));
		
				$eaf->_print($eaf->_Refresh("?action=usercp&do=email"));			

				$eaf->_close();
				
			}
						
			if($Old !== $this->rows['email']){
				
				$eaf->_print($eaf->_Redmsg($lang["oldEmail_error"]));
		
				$eaf->_print($eaf->_Refresh("?action=usercp&do=email"));			

				$eaf->_close();
				
			}
			
			$Find = $eaf->db->query("select * from members where email = '$New'");
			
			if($eaf->db->dbnum($Find) !== 0){
				
				$eaf->_print($eaf->_Redmsg($lang["emailUsed"]));
		
				$eaf->_print($eaf->_Refresh("?action=usercp&do=email"));			

				$eaf->_close();
				
			}

			$Query = $eaf->db->query("UPDATE `members` SET email='$New' WHERE `uid` = " . $this->rows['uid']) or die(mysql_error());
		
			if($Query){
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));
				
				$eaf->_print($eaf->_Refresh("?action=usercp&do=email"));			

				$eaf->_close();						
				
			}else{
		
				$eaf->_print($eaf->_Greenmsg($lang["editprofile_error"]));

				$eaf->_print($eaf->_Refresh("?action=usercp&do=email"));			

				$eaf->_close();
				
				}
		}
		
	}
	
	public function EditInputs(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['edit_inputs'])){
		
		$Inputs = $eaf->db->query("select * from " . tablenamestart("inputs"));	
		
		while($Rows = $eaf->db->dbrows($Inputs)){
			
			$IssetName  = "extra_input_";
			
			$IssetName .= $Rows['input_id'];
			
			$Value 	 = "extrainput";
		
			$Value    .=  "_";
		
			$Value    .=  $Rows['input_id']; 
			
			$Uid      = Userid();
			
			if(isset($eaf->_POST[$IssetName])){
				
				$Filde = $eaf->security->safe($eaf->_POST[$IssetName]);
				
				if($Rows->input_exists == 1){
										
					if(empty($Filde)){

						$eaf->_print($eaf->_Redmsg($lang["input_exists"]));

						$eaf->_print($eaf->_Refresh("?action=usercp&do=inputs"));			

						$eaf->_close();							
					
					} # End Empty
					
				} # End Exists
				
			$Query = $eaf->db->query("UPDATE `members` SET `$Value` = '$Filde' WHERE uid = $Uid") or die(mysql_error());
			
				(!$Query) ? false : true;
				
			} # End Isset 
			
		} # End While
		
		if($Query){
			
			$eaf->_print($eaf->_Greenmsg($lang["editprofile_ok"]));

			$eaf->_print($eaf->_Refresh("?action=usercp&do=inputs"));			

			$eaf->_close();				
		
		}else{

			$eaf->_print($eaf->_Greenmsg($lang["editprofile_error"]));

			$eaf->_print($eaf->_Refresh("?action=usercp&do=inputs"));			

			$eaf->_close();	
			
			}
			
		} # End Isset
	
	} # End Function
	
	public function Menu(){
	
		global $eaf,$lang;
		
		return print $eaf->template->display("usercp_menu");	
		
		
	}
		
}
?>
