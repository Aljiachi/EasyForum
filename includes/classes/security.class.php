<?

	# * Easy Forum
	# * Version is 2
	# * Date : 2011
	# * Email: php4u@hotmail.com
	# * offical website : http://www.easyforum.net
	# * Programming rights reserved
	# * The program is free and for all
	# * Programming By : Php4u 
	# * Powered By 	   : Php4u
	# * To Download Plugins, Hooks , Styles , Updates ... Visiting Our Website
 
	class Security{

	public function Password($var){

	return md5($var);

	}

	public function Username($var){

	return strip_tags(trim(mysql_real_escape_string($var)));	

	}

	public function safe($str,$type='all')
	
	{
	
		$str = str_replace("<script","&lt;script",$str);

		$str = str_replace("</script>","&lt;/script&gt;",$str);
    
	if ($type == 'all') {
        $this->mysql_prep($str);
        return htmlspecialchars($str);
    
    } elseif ($type == 'slash') {
        $this->mysql_prep($str);
        return $str;
    }

	}
 

	public function mysql_prep($value) 

	{

    $magic_quotes_active = get_magic_quotes_gpc();

    $new_enough_php = function_exists( "mysql_real_escape_string" ); 

    if ($new_enough_php) { 

         
        // undo any magic quote effects so mysql_real_escape_string can do the work
        if ($magic_quotes_active) { 
            $value = stripslashes($value); 
        }
        $value = mysql_real_escape_string($value);
    } 

    else { 
        // if magic quotes aren't already on then add slashes manually
        if (!$magic_quotes_active) { 
            $value = addslashes($value); 
        }
        // if magic quotes are ative, then the slashes already exist
    }
    return $value;
} 

	public function email_check($email){
  
  	  return( ereg('^[-./0-9A-Z^_`a-z~]+'.

										'@'.
                 '([-0-9A-Z^_`a-z]{2,}\.){1,3}'.
                 
				 '[-0-9A-Z^_`a-z]{2,3}$',
                 
				 $email) );

	}

	public function svar($var){

	$var = strip_tags(addslashes(trim($var)));
	
	$Array = array("SELECT","UNION","DATABASE","/","load_file","ect","public_html");
	
	$var = str_ireplace($Array,"",$var);
	
	$var = $this->safe($var);

	return $var;

	}

	public function sint($intval){

	$intval = intval(abs($intval));
		
	if(!is_numeric($intval)){
		
		header("location: index.php");
		
		exit;
	}

	return $intval;

	}

	public function sid($id){

	$id = intval(abs($id));

	if($id !== "" and !empty($id) and is_numeric($id)){

	return $id;

	}

	}

	public function _HtmlReplace($code){
		
	global $eaf,$lang;
		
	$code = $eaf->BbCode->BbCodeToHtml($code);
	
	$code = str_ireplace("<","&lt;",$code);	

	$code = str_ireplace(">","&gt;",$code);	

	return $code;

	}
	
	public function HashId($id,$hash=true)
{
$textLeft = "46q416d1q561d65qs1d6q16sd15qd";
$textRight = "61qd616d16qs1d65q1d5q1d65q1d6";
if($hash == true)
{
$id = intval(abs(ceil($id)));
$id = str_replace('-','',$id);
$var = base64_encode($textLeft.$id.$textRight);
}
else
{
$var = base64_decode($id);
$var = str_ireplace($textLeft,"",$var);
$var = str_ireplace($textRight,"",$var);
}
return $var;
}

	public function CleanHtml($Var){
	
		$Var = strip_tags($Var);
		
		$Var = addslashes($Var);
		
		return $Var;
		
	}
	
public function HtmlToBbcode($Text){
	
		$Html   = array("</table>","</em>","<td>","</td>","<tr>","</tr>","<tbody>","</tbody>","<caption>","</caption>");

		$Bbcode =  array("[/table]","[/em]","[td]","[/td]","[tr]","[/tr]","[tbody]","[/tbody]","[caption]","[/caption]");
	
	$Text = str_replace($Html,$Bbcode,$Text);
	$Text = preg_replace("#<table(.*)>#is","[table$1]",$Text);
	$Text = preg_replace("#<em(.*)>#is","[em$1]",$Text);	
	$Text = preg_replace("#<hr(.*)\/>#is","[hr$1]",$Text);	
	return $Text;
}

}
$eaf->security = new Security();
?>