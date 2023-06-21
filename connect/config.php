<?
	
	function ThisConnectERORR(){

	echo '<div dir="rtl" style="color:red;font-size:22px;" align="center">

	An error occurred in the contact <br />

	Please send us an e-mail php4u@hotmail.com <br />
	
	Error is : '.mysql_error().'
	
	</div>';	
	exit;
	
	}
	
$CONT = array(); 
$CONT["HOSTNAME"]=  'localhost';
$CONT["DBNAME"]  =  'ef';
$CONT["DBUSER"]  =  'root';
$CONT["DBPASS"]  =  '123'; 
$connect = @mysql_connect($CONT["HOSTNAME"],$CONT["DBUSER"],$CONT["DBPASS"]);
$connect = @mysql_select_db($CONT["DBNAME"],$connect);
if(!$connect){
	ThisConnectERORR();
}
?> 