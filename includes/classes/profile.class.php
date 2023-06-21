<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------





class Profile{

	private $userid , $sql , $TheardId , $PostId;
	
	public $VistorsText,$ExtraInputs,$rows,$Friends;

	public function __construct($uid,$Exists = false){
	
		global $eaf,$lang;
		
		if($Exists == false){
			
			$this->userid = $uid;
			
			if(!$eaf->db->totalWhere("members","uid",$uid)){
				
				header("location: ?action=error&do=5");	

				exit;		
			}
		
		}else{
			
		if(!$eaf->db->totalWhere("members","uid",$uid)){
		
			$this->userid = 1;
		
		}else{
			
			$this->userid = $uid;
		}
		
		}

		$this->TheardId = $eaf->security->HashId($eaf->_REQUEST['tid']);
		
		$this->PostId   = $eaf->security->HashId($eaf->_REQUEST['pid']);
	
		$this->sql    = $eaf->db->query("SELECT * FROM members WHERE uid=$this->userid");
	
		$this->rows   = $eaf->db->dbrows($this->sql);
		
		$eaf->VistorsTextPager = new Pager;
				
		$this->VistorsText = $eaf->VistorsTextPager->Querspagination("select * from " . tablenamestart("vistorsmsgs") . " where msg_u_id = $this->userid order by msg_id DESC ","?action=profile&uid=$this->userid",15);
		
		$eaf->pages = $eaf->VistorsTextPager->Pagination();
		
		$this->ExtraInputs = $eaf->db->query("select * from " . tablenamestart("inputs") . " where input_view = 1");
		
		$this->Friends     = $eaf->db->query("select * from " . tablenamestart("friends") . " where friend_uid = $this->userid  AND friend_active='yes'");

	}

	public function user_exists(){
	
		global $eaf,$lang;
	
		if($eaf->db->dbnum($this->sql) == 0){
		
			header("location: ?action=error&do=5");	
		
			exit;
	
		}

	}

	public function Username(){
	
	
		return str_replace("{name}",$this->rows['username'],UserGroup($this->rows['uid'],"style"));


	}

	public function Email(){
	
		return $this->rows['email'];

	}

	public function Avatar(){
	
		$this->avatar = $this->rows['avatar'];
	
		if(empty($this->avatar) or check_image($this->avatar) == false){
	
			$this->avatar = "images/avatar.png";
	
		}
	
		$this->avatar = "<img src='imager.php?image=" .$this->avatar . '&width=' . GetMaxAvatarSizeW() . '&height=' .GetMaxAvatarSizeH() . "' id='userAvatar".$this->userid."' />";
	
		return $this->avatar;

	}

	public function Country(){
	
		return $this->rows['cant'];

	}

	public function Userage(){
	
		return $this->rows['age'];

	}

	public function JoinDate(){
	
		return $this->rows['sig_data'];

	}

	public function Numberoftheards(){
	
		return $this->rows['totla_ps'];

	}
	
	public function Signature(){
	
		return GetBbCode($this->rows['signt']);

	}

	public function Lastloggedin(){
	
		return $this->rows['lastlogin'];

	}

	public function Groupid(){
	
		return $this->rows['groupid'];

	}

	public function Usersex(){
	
		return $this->rows['sex'];

	}

	public function Numberofposts(){
	
		return $this->rows['total_posts'];

	}
	
	public function Userid(){
	
		return $this->rows['uid'];

	}

	public function AllPosts(){
	
		$Theards = $this->Numberofposts();
		
		$Posts   = $this->Numberoftheards();
		
		return($Theards+$Posts);	
	
	}

	public function Usertitle(){
		
		global $eaf,$lang;
		
		if(!empty($this->rows['moder_gid']) && $this->rows['moder_gid'] !== 0){
			
			return $this->rows['moder_title'];	

		}else{
				
		if(UserGroup($this->Userid(),"rename") == 1){
		
			$query = $eaf->db->query("SELECT * FROM " . tablenamestart("names") . " where name_id != 2 And user_post > " . $this->AllPosts());
		
			$row = mysql_fetch_assoc($query);
		#	while(){
		
			#	if($this->AllPosts() > $row['user_post']){
			
					return $row['user_title'];
			
			#	}
	
		#	}
		
	
		}else{
		
				return UserGroup($this->Userid(),"name");
		
			}
						
		}
	}

	public function Userstars(){
	
		global $eaf,$lang;
			
		if(UserGroup($this->Userid(),"is_admin") != 1){
			
			$query = $eaf->db->query("SELECT * FROM " . tablenamestart("names") . " where name_id != 2 And user_post > " . $this->AllPosts());
	
			$row = mysql_fetch_assoc($query);
		#while($row = mysql_fetch_assoc($query)){
	
		#	if($this->AllPosts() > $row['user_post']){
		
				return $row['user_star'];
		
		#	}

		#}
		
		}else{
		
			$query = $eaf->db->query("SELECT * FROM " . tablenamestart("names") . " where name_id = 2");
			
			$row   = mysql_fetch_assoc($query);
			
			return $row['user_star'];
	
		}

	}

	public function Online(){
	
		return UserOnLine($this->Userid());	

	}
	
	public function Ip(){
			
		return $this->rows['ip'];	
		
	}
	
	public function Reputation(){
		
		global $eaf,$lang;
		
		$tid      = $eaf->security->HashId($this->TheardId,false);
		
		$Query = $eaf->db->query("select * from " . tablenamestart("reputation") . " where reputation_userid = $this->userid");
		
		$Num  = $eaf->db->dbnum($Query);
		
		return $Num;
			
	}
	
	public function Warning(){
		
		global $eaf,$lang;
		
		$tid      = $eaf->security->HashId($this->TheardId,false);
		
		$Query = $eaf->db->query("select * from " . tablenamestart("warnings") . " where warning_userid = $this->userid");
		
		$Num  = $eaf->db->dbnum($Query);
		
		return $Num;
			
	}

	public function AddVistorMsg(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['add_vistor_msg']) and !empty($eaf->_POST['add_vistor_msg'])){
			
			$By = Getuserid();
			
			$Ip = getip();
			
			$Date = arabic_data();
			
			$Text = $eaf->security->safe($eaf->_POST['vistor_msg']);
			
			$Time = time();
			
			if(empty($By) or empty($Ip) or empty($Text)){
				
				$eaf->_print($eaf->_RedMsg($lang['addGuestMessageWarning']));
				
				$eaf->_print($eaf->_Refresh("?action=profile&uid=$this->userid"));
				
				return false;
			}
			
			$Insert = $eaf->db->query("insert into " . tablenamestart("vistorsmsgs") . " values (
			
			'',
			'$this->userid',
			'$By',
			'$Date',
			'$Text',
			'$Ip',
			'$Time'
			
			)");
			
			if($Insert){
			
				$eaf->_print($eaf->_GreenMsg($lang['alert_guest_message_added']));
				
				$eaf->_print($eaf->_Refresh("?action=profile&uid=$this->userid"));			
				
				}
		}
	}
	
}
?>
