<?php

# * Easy Forum
# * Version is 2
# * Date : 2011
# * Email: php4u@hotmail.com
# * offical website : http://www.g-scripts.com
# * Programming rights reserved
# * The program is free and forall
# * Programming By : Php4u 
# * Powered By 	   : G-scripts
# * To Download Plugins, Hooks , Styles , Updates ... Visiting Our Website	

	ob_start();
	
	include('access.php');

	include('../connect/config.php');

	include('../includes/functions.php');
	
	if(is_dir("../languages/" . GetLangFolder())){
			
			include("../languages/" . GetLangFolder() ."/admin.php");
		
		}else{
		
			die("Language File is Not Exists");	
		}

	
			if(UserGroup(GetUserid,"admin_tools") == 0){

				echo '<div class="red">'.$lang["page_error"].' </div>';	
	
				exit;	
	
			}

$dbname = $CONT["DBNAME"];
require("zip.lib.php");

$action = $eaf->_REQUEST['x'];
if(!isset($action)) $action = "code";

IF ($action=="save"){

function get_table_def($table, $crlf,$dbname,$drop)
{
IF ($drop == "1"){
$schema_create = "DROP TABLE IF EXISTS $table;$crlf";
}
$db = $table;

$schema_create .= "CREATE TABLE $table ($crlf";

$result = mysql_query("SHOW FIELDS FROM " .$dbname.".". $table) or die();
while($row = mysql_fetch_array($result))
{
$schema_create .= "   $row[Field] $row[Type]";

if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0"))
$schema_create .= " DEFAULT '$row[Default]'";
if($row["Null"] != "YES")
$schema_create .= " NOT NULL";
if($row["Extra"] != "")
$schema_create .= " $row[Extra]";
$schema_create .= ",$crlf";
}

$schema_create = ereg_replace(",".$crlf."$", "", $schema_create);
$result = mysql_query("SHOW KEYS FROM " .$dbname."." .
$table) or die();
while($row = mysql_fetch_array($result))
{
$kname=$row['Key_name'];
$comment=(isset($row['Comment'])) ? $row['Comment'] : '';
$sub_part=(isset($row['Sub_part'])) ? $row['Sub_part'] : '';

if(($kname != "PRIMARY") && ($row['Non_unique'] == 0))
$kname="UNIQUE|$kname";

if($comment=="FULLTEXT")
$kname="FULLTEXT|$kname";
if(!isset($index[$kname]))
$index[$kname] = array();

if ($sub_part>1)
$index[$kname][] = $row['Column_name'] . "(" . $sub_part . ")";
else
$index[$kname][] = $row['Column_name'];
}

while(list($x, $columns) = @each($index))
{
$schema_create .= ",$crlf";
          if($x == "PRIMARY")
            $schema_create .= "   PRIMARY KEY (";
          elseif (substr($x,0,6) == "UNIQUE")
            $schema_create .= "   UNIQUE " .substr($x,7)." (";
          elseif (substr($x,0,8) == "FULLTEXT")
            $schema_create .= "   FULLTEXT ".substr($x,9)." (";
          else
            $schema_create .= "   KEY $x (";

         $schema_create .= implode($columns,", ") . ")";
      }

      $schema_create .= "$crlf)";
      if(get_magic_quotes_gpc()) {
        return (stripslashes($schema_create));
      } else {
        return ($schema_create);
      }
   }
   function get_table_content($db, $table, $limit_from = 0, $limit_to = 0,$handler)
   {
      // Defines the offsets to use
      if ($limit_from > 0) {
         $limit_from--;
      } else {
         $limit_from = 0;
      }
      if ($limit_to > 0 && $limit_from >= 0) {
         $add_query  = " LIMIT $limit_from, $limit_to";
      } else {
         $add_query  = '';
      }

      get_table_content_fast($db, $table, $add_query,$handler);

   }

   function get_table_content_fast($db, $table, $add_query = '',$handler)
   {
      $result = mysql_query('SELECT * FROM ' . $db . '.' . $table . $add_query) or die();
      if ($result != false) {

         @set_time_limit(1200); // 20 Minutes

         // Checks whether the field is an integer or not
         for ($j = 0; $j < mysql_num_fields($result); $j++) {
            $field_set[$j] = mysql_field_name($result, $j);
            $type          = mysql_field_type($result, $j);
            if ($type == 'tinyint' || $type == 'smallint' || $type == 'mediumint' || $type == 'int' ||
               $type == 'bigint'  ||$type == 'timestamp') {
               $field_num[$j] = true;
            } else {
               $field_num[$j] = false;
            }
         } // end for

         // Get the scheme
         if (isset($GLOBALS['showcolumns'])) {
            $fields        = implode(', ', $field_set);
            $schema_insert = "INSERT INTO $table ($fields) VALUES (";
         } else {
            $schema_insert = "INSERT INTO $table VALUES (";
         }

         $field_count = mysql_num_fields($result);
         $search  = array("\x0a","\x0d","\x1a"); //\x08\\x09, not required
         $replace = array("\\n","\\r","\Z");


         while ($row = mysql_fetch_row($result)) {
            for ($j = 0; $j < $field_count; $j++) {
               if (!isset($row[$j])) {
                  $values[]     = 'NULL';
               } else if (!empty($row[$j])) {
                  // a number
                  if ($field_num[$j]) {
                     $values[] = $row[$j];
                  }
                  // a string
                  else {
                     $values[] = "'" . str_replace($search, $replace, addslashes($row[$j])) . "'";
                  }
               } else {
                  $values[]     = "''";
               } // end if
            } // end for

            $insert_line = $schema_insert . implode(',', $values) . ')';
            unset($values);

            // Call the handler
            $handler($insert_line);
         } // end while
      } // end if ($result != false)

      return true;
   }


   function my_handler($sql_insert)
   {
      global $crlf, $asfile;
      global $tmp_buffer;

      if(empty($asfile))
         $tmp_buffer.= htmlspecialchars("$sql_insert;$crlf");
      else
         $tmp_buffer.= "$sql_insert;$crlf";
   }



   function faqe_db_error()
   {
      return mysql_error();
   }



   function faqe_db_insert_id($result)
   {
      return mysql_insert_id($result);
   }

   $date1 = time();
   $date2 = date("j-n-Y",$date1);

$target="file";
if($target=="file")
{
If ($eaf->_POST['zipfile']==1){
header('Content-Type: application/x-zip');
header('Content-Disposition: filename="database-'.$date2.'-EasyForum.zip"');
}else{
header('Content-Type: application/octetstream');
header('Content-Disposition: filename="database-'.$date2.'-EasyForum.sql"');
}
$asfile="download";
}

$crlf="\r\n";

$dump_buffer="";

$tables = mysql_query("show tables from $dbname");
$num_tables = mysql_num_rows($tables);

if($num_tables == 0)
{
echo "# No Tables Found";
exit;
}

$dump_buffer.= "# backup $crlf";
$dump_buffer.= "# Easy Forum v2 $crlf";
$dump_buffer.= "# PHPFORYOU 2010 - 2011 $crlf";
$dump_buffer.= "# date ".date("d / m / y / h:s")."$crlf";
$dump_buffer.= "# database name : $dbname $crlf";
$dump_buffer.= "# tables : $dbname $crlf";


$i = 0;
while($i < $num_tables)
{
$table = mysql_tablename($tables, $i);

IF ($eaf->_POST[$table] == "1"){
$dump_buffer.= "# --------------------------------------------------------$crlf";
$dump_buffer.= "$crlf#$crlf";
$dump_buffer.= "# Table '$table'$crlf";
$dump_buffer.= "#$crlf$crlf";
$db = $table;
$drop = $eaf->_POST['drop'];
$dump_buffer.= get_table_def($table, $crlf,$dbname,$drop).";$crlf";
$dump_buffer.= "$crlf#$crlf";
$dump_buffer.= "# Table '$table'$crlf";
$dump_buffer.= "#$crlf$crlf";
$tmp_buffer="";
get_table_content($dbname, $table, 0, 0, 'my_handler', $dbname);
$dump_buffer.=$tmp_buffer;
}
$i++;
$dump_buffer.= "$crlf";
}

If ($eaf->_POST['zipfile']==1){
$zipfile = new zipfile();
$zipfile -> addFile($dump_buffer, "database.sql");
echo $zipfile -> file();
}else{
echo $dump_buffer;
}

exit;

}elseif($action=="code"){
echo $h;

?>
<link type="text/css" rel="stylesheet" href="style/<?php print $lang["style"]; ?>.css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script src="../js/BlocksAn.js"></script>
<script type="text/javascript" src="includes/ajax.js"></script>
<form method='post' action='backup.php?x=save'>

<table align="center" width='100%' cellpadding="0" cellspacing="0">

<tr>
<td width='100%' colspan="3" class="head"><?php print $lang["backup_title"]; ?></td>
</tr>

<tr>
<td width="3%"  class='ttable'><input type="checkbox" name="check_all" onclick="checkAll(this.form)" /></td>
<td width="80%"  class='ttable' ><?php print $lang["backup_table"]; ?></td>
<td width="17%"   class='ttable'><strong><?php print $lang["backup_cont"]; ?></strong></td>
</tr>

<?php
$tables = mysql_query("show tables from $dbname");
$num_tables = mysql_num_rows($tables);
if($num_tables == 0)
{
echo '<div align="center">'.$lang["backup_error"].'</div>';
exit;
}
$i = 0;
while($i < $num_tables)
{
$table = mysql_tablename($tables, $i);
$RowNum = mysql_query("select * from ".$table);
$RowTotal = mysql_num_rows($RowNum);
echo "<tr>
<td class='tct'><input ID='" .$table . "1' type='checkbox' name='" .$table . "' value='1' ".$hh." /></td>
<td class='tct'><LABEL id='" .$table . "' FOR='" .$table . "1'>" .$table . "</LABEL></td>
<td class='tct'>$RowTotal</td>
</tr>\r\n";
$i++;
}

echo "

<tr>
<td width='100%' colspan='3' class='tct'><input ID='x2' type='checkbox' name='zipfile' value='1' /> <LABEL FOR='x2'>Zipped</LABEL></td>
</tr>

<tr>
<td width='100%' colspan='3' class='tct'><input class='buttonx' type='submit' value='$lang[post]' /></td>
</tr>

</table>

</form>";
}
ob_end_flush();
?>