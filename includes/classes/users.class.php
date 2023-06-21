<?


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------


class eafUsers
{
	
	public $login_page;
	
	public function __construct(){

		$this->login_page  = "index.php?action=login";
	
	}

	public function SignUp_Form(){

	global $eaf,$lang;

	return $eaf->template->display('register');

	}

	public function UserFinde(){

	global $eaf,$lang;

	$action = strip_tags(trim($eaf->_GET['find_user']));

	if($action){

	$sql_find_user = $eaf->db->query("SELECT * FROM members WHERE username = '".$action."'");

	$total_finde   = $eaf->db->dbnum($sql_find_user);
	
		if($total_finde == 0){
	
			echo '<font color="green">'.$lang["usernaame_notexists"].'</div>';
	
		}else{
	
			echo '<font color="red">'.$lang["username_exists"].'</div>';
	
		}

	}	

	}

	public function SignUp_Insert(){

	global $eaf,$lang;

	if(isset($eaf->_POST['adduser'])){

	$username = $eaf->security->Username($eaf->_POST['username']);

	$password = $eaf->security->Password($eaf->_POST['password']);

	$repass = $eaf->security->Password($eaf->_POST['repass']);

	$avatar = strip_tags(trim(mysql_real_escape_string($eaf->_POST['avatar'])));

	$from   = strip_tags(trim(mysql_real_escape_string($eaf->_POST['cant'])));		

	$age    = strip_tags(trim(mysql_real_escape_string($eaf->_POST['age'])));

	$email  = strip_tags(trim(mysql_real_escape_string($eaf->_POST['email'])));

	$sex	= strip_tags(trim(mysql_real_escape_string($eaf->_POST['sex'])));
	
	$Captha = strip_tags(trim(mysql_real_escape_string($eaf->_POST['captcha'])));
	$bro = getBrowser();
	
	$GetSetting = FunctionsSqlRows();

	$sign_data = date($GetSetting["signup_data"]);

	if(GetRegisterHtml() == 0){

	$signt  = strip_tags($eaf->_POST['signt']);

	}else{

	$signt  = $eaf->_POST['signt'];	

	}

	if($eaf->_POST['password'] < GetMinPassDo()){
	
		$eaf->_print($eaf->_Redmsg($lang["signup_minpass"]));
	
		$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));						
				
		exit;
				
	}

	if($Captha !== $_SESSION['CapthaCode']){
	
			$eaf->_print($eaf->_Redmsg($lang["check_captcha"]));	
			
			$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));						
			
			exit;
	
	}
	
	if(!email_check($email)){
	
				$eaf->_print($eaf->_Redmsg($lang["email_notcheck"]));	
			
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));						
			
				exit;
	
	}				

	$sql_user_finde = $eaf->db->query("SELECT * FROM members where username = '$username'");

	$total_user_finde = $eaf->db->dbnum($sql_user_finde);

	if($total_user_finde !== 0){
		
		$eaf->_print($eaf->_Redmsg($lang["signup_nameused"]));
			
		$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));			
				
		exit;
		
	}
				
	$sql_email_finde = $eaf->db->query("SELECT uid FROM members where email = '$email'");

	$total_email_finde = $eaf->db->dbnum($sql_email_finde);

	if($total_email_finde !== 0){
		
		$eaf->_print($eaf->_Redmsg($lang["signup_emailuesd"]));
			
		$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));			
				
		exit;
	
	}

	$sql_Insert_into = $eaf->db->query("INSERT INTO members (username,password,avatar,cant,age,email,sig_data,sex,ip,browser,groupid) VALUES (
	'$username',
	'$password',
	'$avatar',
	'$from',
	'$age',
	'$email',
	'$sign_data',
	'$sex',
	'".getip()."',
	'".$bro['name']. ' - ' . $bro['version'] ."',
	'".GetRegisterGroup()."'
	)");

	if($sql_Insert_into){
		
		$InsertId 			 = mysql_insert_id();
		
		$_SESSION['username'] = $username;
	
		$_SESSION['password'] = $password;
	
		$_SESSION['user_id']  = $InsertId;
	
		$_SESSION['user_log'] = 0;
		
		if(GetRegisterGroup() == 7){
			
			if(GetActiveDo() == 1){
			
				$Url = GetSiteUrl();
		
				$Id  = $eaf->security->HashId($InsertId);
			
				$Msg = $lang["signup_active_msg"] . "<br /> $Url/?action=active&code=$Id <br /> " . $lang['username'] . " : " . $username ;
			
				$Subject = ForumName() . " - " . $lang["sigunup_useractive"];
				
				$Send = sendmail($email,$Subject,$Msg);
		
				$eaf->_print($eaf->_Greenmsg($lang["signup_email_msg"]));
	
			}else{
				
				$eaf->_print($eaf->_Greenmsg($lang["signup_admin_msg"]));
			
			}
			
		}else{
		
			$eaf->_print($eaf->_Greenmsg($lang["signup_ok"]));
		
		}
	
		$eaf->_print($eaf->_Refresh('index.php'));			
		
		exit;
	
	
		}
		
	  }

	}

	public function Login_Form(){

		global $eaf,$lang;

		return $eaf->template->display('loginform');

	}

	public function Login_Post(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['login_send'])){
	
		$username = $eaf->security->Username($eaf->_POST['username']);
	
		$password = $eaf->security->Password($eaf->_POST['password']);
		
		if(empty($username) or empty($password)){
		
					$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));
				
					$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));			
					
					exit;
	
					}
	
		$sql_login_user = $eaf->db->query("SELECT * FROM members WHERE username='$username' AND password='$password'");
	
		$rows 		   = $eaf->db->dbrows($sql_login_user);
	
		$user_id 		= $rows['uid'];
	
		$totla_user_login = $eaf->db->dbnum($sql_login_user);
	
		if($totla_user_login == 0){
		
					$eaf->_print($eaf->_Redmsg($lang["login_error"]));
					
					$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));
					
					exit;
	
			}else{
	
				$data = arabic_data();
					
				$ip   = getip();
				
				$lastlogin_update = $eaf->db->query("UPDATE members SET lastlogin='$data',ip='$ip' WHERE uid=$user_id");
				
				$_SESSION['username'] = $rows['username'];
				
				$_SESSION['password'] = $rows['password'];
				
				$_SESSION['user_id']  = $rows['uid'];
					
				$username			 = $rows['username'];
				
				$eaf->_print($eaf->_Greenmsg($lang["login_ok"]));
								
				$eaf->_print($eaf->_Refresh(GoBack()));
					
				exit;
					
			}
		
		}

	}


	public function Active(){
		
		global $eaf,$lang;
		
		if(isset($eaf->_REQUEST['action'])){
			
			$Action = strip_tags(trim($eaf->_REQUEST['action']));	
		}
		
		if($Action == "active"){
	
		$Id = $eaf->security->svar($eaf->_REQUEST['code']);
		
		$Id = $eaf->security->HashId($Id,false);
		
		$GroupId = GetActviedGroup();
		
		if($eaf->db->totalWhere("members","uid",$Id)){
			
			$Active = $eaf->db->query("update `members` set `groupid`='$GroupId' where uid = $Id");
			
			if($Active){

				$eaf->_print($eaf->_Greenmsg($lang["active_ok"]));
			
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));
				
				exit;
				
				}
		}else{
			
	
				$eaf->_print($eaf->_Redmsg($lang["active_error"]));
				
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));
				
				exit;
				
				}
				
		}
	}
	
	public function LogouT(){

	global $eaf,$lang;

	if(isset($_SESSION['username']) and isset($_SESSION['password']) and isset($_SESSION['user_id'])){
	
				$eaf->_print($eaf->_Greenmsg($lang["logout_ok"]));
			
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));
				
				session_destroy();
				
				exit;

			}else{
			
				$eaf->_print($eaf->_Redmsg($lang["logout_error"]));
			
				echo '<meta http-equiv="refresh" content="3;URL='.$this->login_page.'" />';
			
				exit;
			
				}

	}

	public function LoginAccess(){

	global $eaf,$lang;

	if(isset($eaf->_POST['login_send'])){

	$username = $eaf->security->Username($eaf->_POST['username']);
	
	$password = $eaf->security->Password($eaf->_POST['password']);

	if(empty($username) or empty($password)){
	
				$eaf->_print($eaf->_Redmsg($lang["alert_empty"]));
		
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));			
			
				exit;

	}

	$sql_login_user = $eaf->db->query("SELECT * FROM members WHERE username='$username' AND password='$password'");

	$rows 		   = $eaf->db->dbrows($sql_login_user);

	$user_id 		= $rows['uid'];

	$totla_user_login = $eaf->db->dbnum($sql_login_user);

	if($totla_user_login == 0){
	
				$eaf->_print($eaf->_Redmsg($lang['login_error']));
		
				$eaf->_print($eaf->_Refresh($_SERVER['HTTP_REFERER']));						
		
				exit;

	}	else	{

				$data = arabic_data();
				
				$lastlogin_update = $eaf->db->query("UPDATE members SET lastlogin='$data' WHERE uid=$user_id");
				
				$_SESSION['username'] = $rows['username'];
			
				$_SESSION['password'] = $rows['password'];
			
				$_SESSION['user_id']  = $rows['uid'];
				
				$eaf->_print($eaf->_Greenmsg($lang["login_ok"]));
	
				$eaf->_print($eaf->_Refresh(GoBack()));			
	
				exit;
		
		}
	}	

	}
	
	public function _ForGotPssWord(){
	
		global $eaf,$lang;
		
		if(isset($eaf->_POST['forgot_password'])){
					
		$Email = strip_tags($eaf->_POST['email']);
		
		$Query = $eaf->db->query("select * from members where email = '$Email'");
		
		$Total = $eaf->db->dbnum($Query);
		
		if($Total == 0){
			
				$eaf->_print($eaf->_Redmsg($lang["forgot_email_notexists"]));
		
				$eaf->_print($eaf->_Refresh(GoBack()));
				
				$eaf->_close();
			
		}
		
		if(!function_exists("mail")){
			
				$eaf->_print($eaf->_Redmsg($lang["mail_function_notexists"]));
		
				$eaf->_print($eaf->_Refresh('index.php'));
				
				$eaf->_close();
			
		}
		
		$Rows = $eaf->db->_object($Query);
		
		$newpass = rand(111111,999999);
		
		$newpass = sha1($newpass);
		
		$newpass = substr($newpass,1,8);
		
		$UpPass  = $eaf->security->Password($newpass);
		
		$Send    = sendmail($Email,$lang["forgot_title"],$lang["forgot_text"] . "\n<br />\n" . $newpass);
		
		
		if($Send){
			
				$eaf->_print($eaf->_Greenmsg($lang["forgot_sent"]));
						
				$Updata = $eaf->db->query("UPDATE members SET password = '$UpPass' WHERE uid = $Rows->uid");
		
				$eaf->_print($eaf->_Refresh("index.php"));
				
				$eaf->_close();
		
		}else{
			
			return false;
			
		}
		
		
		}
	}
	
	public function IsLoggedIn(){
		
		global $eaf,$lang;
		
		if(!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['user_id'])){
			
			header("location: ?action=login");
			
			$eaf->_close();
			
		}
			
	}
}
?>