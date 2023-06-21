<?php

	class filesManger{
	
	public $action;
	
	private $filesExs = array('jpg' , 'JPG' , 'gif' , 'GIf' , 'PNG' , 'png' , 'bmp' , 'BMP' , 'jpge' , 'JPGE');
	
	public function DownloadAttachment(){

		global $eaf,$lang;

		if(isset($eaf->_REQUEST['action']) && !empty($eaf->_REQUEST['action'])) :
		
			$this->action = $eaf->security->svar($eaf->_REQUEST['action']);
			
		endif;
		
		if(isset($this->action) && $this->action == "download"){

			if(UserGroup(GetUserid(),"attach_down") == 1){
				
				$aid = $eaf->security->sint($eaf->_REQUEST['aid']);

				$download_query = $eaf->db->query("select * from ".tablenamestart("attachments") . " where  aid=".$aid);

				$download_rows  = $eaf->db->dbrows($download_query);

				$download_total = $eaf->db->dbnum($download_query);
	
					if($download_total == 0){
		
						header("location: ?action=error&do=8");	
					
					}else{
						
				$Update = $eaf->db->query("update ".tablenamestart("attachments") . "  set total = total+1");

				$a_name =  $download_rows['a_name'];

				$a_type =  $download_rows['a_type'];	

				$a_size =  $download_rows['a_size'];
				
				
				if(!in_array($a_type , $this->filesExs)){
					
					header("Content-Disposition: attachment; filename=$a_name"); // note difference
					readfile("upload/attachments/" . $download_rows['salt'] . '-' . $a_name); // note difference
					
				}else{
						 
/*					switch($a_type){
				
						case "png": 
						
							header("Content-Disposition: attachment; filename=$a_name"); // note difference
							header("Content-type: image/png");

							readfile("attachments/" . $download_rows['salt'] . '-' . $a_name); // note difference
							
						break;	

					}*/
					
					header("location: ./upload/attachments/" . $download_rows['salt'] . '-' . $a_name); // note difference

				}

			}

			}else{

				header("location: ?action=error&do=8");	

		}
		
		exit;

		}

		}
	
	}
	
	$eaf->filesManger = new filesManger();
?>