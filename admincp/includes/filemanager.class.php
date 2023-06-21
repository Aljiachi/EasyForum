<?php


# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

class SDBFilemanagerScript{

public $filesdir;

public function __construct(){

	$this->filesdir = \"./\";	

	}

	private function FilesTypes(){

return array(  'php',  'js',  'html',  'htm',  'css',  'asp',  'xml',  'gif',  'jpeg',  'jpg',  'png',  'bmp',  'doc',  'docx',

  'txt',  'pdf',  'mp3',  'wav',  'mp4',  'wmv',  'avi',  'rm',  'ram',  'exe',  'htaccess',  'ico',  '3gp',  'ttf',  'rtf',  'mdb',

  'rar',  'zip',  'exe',  'acv',  'xls',  'asc',  'bak',  'iso',  'ini',  'ans',  'ast',  'dox',  'icon',  'sys',  'pcx',	  'tar',	

  'hpl',	'bk',	  'au',	  'emf',	  'cgi',	  'adb',  'adr',	  'pptx',	  'xlsx',	  'wma',	  'mov',		  'm4a',		

  'm4v',	'm4b',		  'm4a',		  'm4p',	'mp4v',	  'zgip',

  \"ajx\",	\"am\",	\"asa\",	\"asc\",	\"xrc\",	\"xsl\",

  \"aspx\",	\"awk\",	\"bat\",	\"c\",	\"cdf\",	\"cf\",	\"cfg\",	\"cfm\", 	\"cnf\",	\"conf\",	\"cpp\",\"css\",\"csv\",\"ctl\",\"dat\",

  \"dhtml\",	\"diz\",	\"file\",	\"forward\",	\"grp\",	\"h\",	\"hpp\",	\"hqx\",	\"hta\",	\"htc\",	\"htm\",	\"html\",	\"htpasswd\",

  \"htt\",	\"htx\",	\"in\",	\"inc\",	\"info\",\"ink\",	\"java\",	\"jsp\",	\"log\",\"logfile\",	\"m3u\",	\"m4\",	\"mak\",	\"map\",

  \"model\",	\"msg\",	\"nfo\",	\"nsi\",	\"info\",	\"old\",	\"pas\",	\"patch\",	\"perl\",	\"php\",	\"php2\",	\"php3\",	\"php4\",	\"php5\",

  \"php6\",	\"phtml\",	\"pix\",	\"pl\",	\"pm\",	\"po\",	\"pwd\",	\"py\",	\"qmail\",\"rb\",	\"rbl\",	\"rbw\",	\"readme\",	\"reg\",	\"rss\",

  \"uby\",	\"session\",	\"setup\",	\"sh\",	\"shtm\", \"shtml\",	\"sql\",	\"ssh\",	\"stm\",	\"style\",	\"svg\",

  \"tcl\",	\"text\",	\"threads\",	\"tmpl\",	\"tpl\",	\"ubb\",	\"vbs\",	\"xhtml\"

   );	

}

private function formatsize($size) {

      $sizes = array(\" Bytes\", \" KB\", \" MB\", \" GB\", \" TB\", \" PB\", \" EB\", \" ZB\", \" YB\");

      if ($size == 0) {

	  		return(\"n\a\");

			} else {

      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); 

	  			}

}

public function ftype($filedir)

{

	$filetype = strrchr($filedir,'.');

	$filetype = str_replace('.','',$filetype);

	return $filetype;

}

private function Size($file){
	
	$file = str_replace(\"//\",\"/\",$file);

	$size = filesize($file);

	$size_title = $this->formatsize($size);

	return $size_title;

}

private function what_type($file){

if(ereg(\"[a-zA-Z0-9[^@+&*%#!{}?[<>\/$.,'_-]\.[a-zA-Z0-9[^@+&*%#!{}?[<>\/$.,'_-]\",$file)){

$type = \"file\";	

}else{

$type = \"dir\";	

}

return $type;

}
	public function deleteAll($directory, $empty = false) {
    if(substr($directory,-1) == \"/\") {
        $directory = substr($directory,0,-1);
    }

    if(!file_exists($directory) || !is_dir($directory)) {
        return false;
    } elseif(!is_readable($directory)) {
        return false;
    } else {
        $directoryHandle = opendir($directory);
       
        while ($contents = readdir($directoryHandle)) {
            if($contents != '.' && $contents != '..') {
                $path = $directory . \"/\" . $contents;
               
                if(is_dir($path)) {
                   $this->deleteAll($path);
                } else {
                    unlink($path);
                }
            }
        }
       
        closedir($directoryHandle);

        if($empty == false) {
            if(!rmdir($directory)) {
                return false;
            }
        }
       
        return true;
    }
} 
private function Type($file){

	global $lang;
	
$filetype = $this->what_type($file);

if($filetype == \"dir\"){

	$file = $lang[\"type_folder\"];

}else{

	$file = $this->ftype($file);	

}

return $file;

}

private function FileDir($file){

	$type = @filetype($file);

	if($type == \"dir\"){

		$type = \"dir\";

	}else{

		$type = $this->ftype($file);	

	}

switch($type){

case \"dir\":$url = \"dir=\".$file; break;

case \"php\":

case \"html\":

case \"css\":

case \"js\":

case\"htm\":

case \"asp\":

case \"xml\":

case \"htaccess\":

case \"txt\":

$url = \"coder=\".$file; break;

case \"gif\":

case \"png\":

case \"jpg\":

case \"jpeg\":

case \"bmp\":

$url = \"photo=\".$file; break;

default :

 $url = \"link=\".$file; break;

}

	return $url;

 }

 private function mvdir($oldDir, $newDir, $replaceFiles = true) {

    if ($oldDir == $newDir) {

        trigger_error(\"Destination directory is equal of origin.\");

        return false;

    }

       

    if (!($tmpDir = opendir($oldDir))) {

        trigger_error(\"It was not possible to open origin directory.\");

        return false;

    }



    if (!is_dir($newDir)) {

        trigger_error(\"It was not possible to open destination directory.\");

        return false;       

    }



    while (($file = readdir($tmpDir)) !== false) {

        if (($file != \".\") && ($file !== \"..\")) {           

            $oldFileWithDir = $oldDir . $file;

            $newFileWithDir = $newDir . $file;

            if (is_dir($oldFileWithDir)) {               

                mkdir($newFileWithDir.\"/\", 0777);

                $this->mvdir($oldFileWithDir.\"/\", $newFileWithDir.\"/\", $replaceFiles);

                rmdir($oldFileWithDir);

            }

            else {

                if (file_exists($newFileWithDir)) {

                    if (!$replaceFiles) {

                        @unlink($oldFileWithDir);

                        continue;

                    }

                }

               

                unlink($newFileWithDir);

                copy($oldFileWithDir, $newFileWithDir);

                chmod($newFileWithDir, 0777);

                unlink($oldFileWithDir);               

            }

        }

    }

	return true;

 }

public function LocationBar($Location){

	global $eaf,$lang;
	
	$Location = str_replace(\"//\",\"/\",$Location);
	
	$Location = str_replace(\"./../\",\"../\",$Location);
	
	print '
	<table width=\"90%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
	<td class=\"head\">'.$lang[\"filem_goingto\"].'</td>
	</tr>
	<tr>
	<td>
	<input type=\"text\" id=\"location\" value=\"'.$Location.'\" dir=\"ltr\">   <input type=\"submit\" onclick=\"GoLocation()\" value=\"'.$lang[\"filem_go\"].'\" />
	<br />
	</td>
	</tr>
	</table>
	';	
}

public function ShowFilesAndFolders(){

global $eaf,$lang;

$open_dir = opendir($this->filesdir);

$table = '<table width=\"90%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">';

$table .= '

<tr>
<td class=\"head\" colspan=\"6\">'.$lang[\"filem\"].'</td>
</tr>

<tr>

<td>'.$lang[\"filem_name\"].'</td>

<td>'.$lang[\"filem_type\"].'</td>

<td>'.$lang[\"filem_size\"].'</td>

<td>'.$lang[\"filem_lastedit\"].'</td>

<td>'.$lang[\"delete\"].'</td>

</tr>

';

while($file = readdir($open_dir)){

if($file == \".\" or $file == \"..\"){

	$file = \"\";	

}

if(!empty($file)){

$table .= '

<tr>

<td><a href=\"filemanager.php?'.$this->FileDir('./'.$file).'\">'.$file.'</a></td>

<td>'.$this->Type($file).'</td>

<td>'.$this->Size($file).'</td>

<td>'.date(\"F/d/Y-H:i:s\", @fileatime($file)).'</td>

<td><a onclick=\"return confirm('.\"'\".$lang[\"alert_access\"].\"'\".');\" href=\"filemanager.php?action=delete&type='.@filetype($file).'&is='.$this->filesdir.$file.'\">'.$lang[\"delete\"].'</a></td>

</tr>

';

}

}

$table .= '</table>';

return $table;

}

public function ShowDir($dir){

global $eaf,$lang;

$open_dir = opendir($dir);

$table = '<table width=\"90%\" align=\"center\">';

$table .= '

<tr>
<td class=\"head\" colspan=\"6\">'.$lang[\"filem\"].'</td>
</tr>


<tr>

<td>'.$lang[\"filem_name\"].'</td>

<td>'.$lang[\"filem_type\"].'</td>

<td>'.$lang[\"filem_size\"].'</td>

<td>'.$lang[\"filem_lastedit\"].'</td>

<td>'.$lang[\"delete\"].'</td>

</tr>

';

while($file = readdir($open_dir)){

if($file == \".\" or $file == \"..\"){

	$file = \"\";	

}

if(!empty($file)){

$table .= '

<tr>

<td><a href=\"filemanager.php?'.$this->FileDir($dir.'/'.$file).'\">'.$file.'</a></td>

<td>'.$this->Type($file).'</td>

<td>'.$this->Size($dir.'/'.$file).'</td>

<td>'.date(\"F/d/Y-H:i:s\", @fileatime($file)).'</td>

<td><a onclick=\"return confirm('.\"'\".$lang[\"alert_access\"].\"'\".');\" href=\"filemanager.php?action=delete&type='.@filetype($file).'&is='.$dir.'/'.$file.'\">
'.$lang[\"delete\"].'</a></td>


</tr>

';

}

}

$table .= '</table>';

return $table;

}

public function Coder($file){

	global $eaf,$lang;
	
	$fileDir = $file;
	
	$file = file_get_contents($file);
	
	$file = str_replace(\"<\",\"&lt;\",$file);
	
	$file = str_replace(\">\",\"&gt;\",$file);
	
	if(isset($eaf->_POST['edit_coder'])){
		
		$content = $eaf->_POST['content'];
		$content = str_replace(\"&lt;\",\"<\",$content);
		$content = str_replace(\"&gt;\",\">\",$content);
		$content = str_replace('\"','\"',$content);	
		$content = str_replace(\"\'\",\"'\",$content);
		
		if(!is_writeable($fileDir)){
			
			$Chmod = chmod($fileDir,0755);	
		}
		
		$edit    = file_put_contents($fileDir,$content);
			
		if($edit){
				
				echo '<div class=\"green\">'.$lang[\"alert_ok\"].'</div>';
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$_SERVER['HTTP_REFERER'].'\" />';
		
			}else{
									
				echo '<div class=\"red\">'.$lang[\"alert_error\"].'</div>';
				echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$_SERVER['HTTP_REFERER'].'\" />';	
								
								}
	}
	
	print '
		<form method=\"post\" name=\"editor\">
		<table cellpadding=\"0\" cellspacing=\"0\" width=\"97%\" height=\"95%\" align=\"center\">
		<tr>
		<td class=\"head\" height=\"5%\" dir=\"ltr\">'.$fileDir.'</td>
		</tr>
		<tr>
		<td>
		<textarea name=\"content\" id=\"content\" style=\"height:95%; width:98%;\" dir=\"ltr\">'.$file.'</textarea>
		</td>
		</tr>
		</table>
		<center><input type=\"submit\" onclick=\"return postEditor();\" value=\"'.$lang['edit'].'\" name=\"edit_coder\" /></center>
		</form>
		';
		

}

public function Photo($photo){

echo '<img src=\"'.$photo.'\" />';	

}

public function Link($link){

global $eaf,$lang;

echo '<a href=\"'.$link.'\" target=\"_new\">إضغط هنا لعرض الملف</a> | ';

echo '<a href=\"'.$eaf->_SERVER['HTTP_REFERER'].'\">السابق</a>';	

}

public function UploadForm(){

	global $eaf,$lang;

	$DIR = str_ireplace(\"/filemanager.php\",\"\",$_SERVER['SCRIPT_NAME']);
	
	return '

			<table width=\"90%\" align=\"center\">

			<tr>

			<td>
			
			'.$lang[\"filem_upto\"].'

			<form method=\"post\" enctype=\"multipart/form-data\">

			<input type=\"file\" name=\"up\" /> <input type=\"submit\" name=\"upload\" value=\"'.$lang[\"filem_upload\"].'\" />

			</td>

			</tr>

			</table>

		   ';

}

public function UloadFile($dir){

	global $eaf,$lang;	
	
	$dir = str_replace(\"//\",\"/\",$dir);

	$dir = str_replace(\"./../\",\"../\",$dir);

	if(isset($eaf->_POST['upload'])){
	
		$filename = $_FILES['up']['name'];
	
		$filetmp  = $_FILES['up']['tmp_name'];
	
		$upload   = move_uploaded_file($filetmp,$dir.$filename);
			
			if($upload){
				
				$eaf->_print('<script> alert(\"'.$lang[\"file_upok\"].'\");</script>');	
			}
	
	}	

}

public function DeleteIs($file,$type){
global $eaf,$lang;

#$file = stripslashes($file);

if(in_array($this->ftype($file),$this->FilesTypes())){

	$delete = unlink($file);

}else{
	
	$delete = $this->deleteAll($file);

	}

	if($delete){

		echo '<div class=\"green\">'.$lang[\"alert_ok\"].'</div>';
		
		echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$_SERVER['HTTP_REFERER'].'\" />';
		
		}else{
									
		echo '<div class=\"red\">'.$lang[\"alert_error\"].'</div>';
		
		echo '<meta http-equiv=\"refresh\" content=\"1;URL='.$_SERVER['HTTP_REFERER'].'\" />';	
				
		}

	}

}
?>