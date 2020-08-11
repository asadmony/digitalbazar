<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../library/Session.php');
	include_once ($filepath.'/../helpers/Format.php');
	
	class content {
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}
		
		public function contentInsert($data,$file,$userID,$InstituteID){
			$conName = $this->fm->validation($data['conName']);
			$conName = mysqli_real_escape_string($this->db->link, $conName);
			
			$body    = $this->fm->validation($data['body']);
			$body    = mysqli_real_escape_string($this->db->link, $body);
			
			$price   = $this->fm->validation($data['price']);
			$price   = mysqli_real_escape_string($this->db->link, $price);
			
			$SubCatID = mysqli_real_escape_string($this->db->link, $data['SubCatID']);
			
			$SubCatID2 = mysqli_real_escape_string($this->db->link, $data['SubCatID2']);
			
			$SubCatID3 = mysqli_real_escape_string($this->db->link, $data['SubCatID3']);
		    
			$permited  = array('jpg', 'jpeg', 'png', 'gif');
			$file_name = $file['image']['name'];
			$file_size = $file['image']['size'];
			$file_temp = $file['image']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
			$uploaded_image = "uploads/".$unique_image;
			
			$file_size   = mysqli_real_escape_string($this->db->link, $file_size);
			
			if($conName == "" || $file_name == "" || $body == "" || $price == "" || $SubCatID == "" ) {
				$msg = "Fields must not be empty";
				return $msg;
			} elseif ($file_size > 1048567) {
				echo "Image size should be less than 1MB";
				
			} elseif (in_array($file_ext, $permited) === false) {
				echo "You can upoad only".implode(',',$permited);
			}
			
			else {
				move_uploaded_file($file_temp, $uploaded_image);
				$query = "INSERT INTO tb_content(userID,InstituteID,conName,body,price,SubCatID1,SubCatID2,SubCatID3,image) VALUES('$userID','$InstituteID','$conName','$body','$price','$SubCatID','$SubCatID2','$SubCatID3','$uploaded_image')";
			}
			$contentInsert= $this->db->insert($query);
			if ($contentInsert) {
					$msg = "<div class=\"alert alert-success\">Content inserted </div>";
					return $msg;
				} else {
					$msg = "Content not inserted";
					return $msg;
				}
		}
		
		public function getAllContentByInst($ID) {
			$query = "SELECT * FROM tb_content WHERE InstituteID = '$ID'";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function getconByID($id){
			$query = "SELECT p.*,c.*
					FROM tb_content as p, tb_contentsubcategory as c
					WHERE p.SubCatID1 = c.contentSubCategoryID AND p.conID = '$id'";
		    $result = $this->db->select($query);
			return $result;
		}
		public function getProByID($id){
			$query = "SELECT p.*,c.* 
					FROM tb_content as p, tb_contentsubcategory as c
					WHERE p.SubCatID1 = c.contentSubCategoryID AND p.conID = '$id'";
		    $result = $this->db->select($query);
			return $result;
		}
		public function getAllContents(){
			$query = "SELECT * ORDER BY conID DESC";
		    $result = $this->db->select($query);
			return $result;
		}
		
		
		public function contentUpdate($data, $file, $id){
			
			$conName = $this->fm->validation($data['conName']);
			$conName = mysqli_real_escape_string($this->db->link, $conName);
			
			$body    = $this->fm->validation($data['body']);
			$body    = mysqli_real_escape_string($this->db->link, $body);
			
			$price   = $this->fm->validation($data['price']);
			$price   = mysqli_real_escape_string($this->db->link, $price);
			
			$SubCatID   = $this->fm->validation($data['SubCatID']);
			$SubCatID   = mysqli_real_escape_string($this->db->link, $SubCatID);
			$SubCatID2   = $this->fm->validation($data['SubCatID2']);
			$SubCatID2   = mysqli_real_escape_string($this->db->link, $SubCatID2);
			$SubCatID3   = $this->fm->validation($data['SubCatID3']);
			$SubCatID3   = mysqli_real_escape_string($this->db->link, $SubCatID3);
			
		
			$permited  = array('jpg', 'jpeg', 'png', 'gif');
			$file_name = $file['image']['name'];
			$file_size = $file['image']['size'];
			$file_temp = $file['image']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
			$uploaded_image = "uploads/".$unique_image;
			
			if (!empty($file_name)){
					if ($file_size > 1048567) {
						echo "Image size should be less than 1MB";
						
					} elseif (in_array($file_ext, $permited) === false) {
						echo "You can upoad only".implode(',',$permited);
					}
					
					
					
					else {
						$query   = "SELECT * FROM tb_content WHERE conID = '$id' ";
						$getdata = $this->db->select($query);
						if ($getdata) {
							while ($delImg = $getdata->fetch_assoc()){
								$dellink = $delImg['image'];
								unlink($dellink);
							}
						}
						move_uploaded_file($file_temp, $uploaded_image);
						
						$query= "UPDATE tb_content 
						SET conName = '$conName',body = '$body',price = '$price',SubCatID1 = '$SubCatID',SubCatID2 = '$SubCatID2',SubCatID3 = '$SubCatID3', image = '$uploaded_image' 
						WHERE conID = '$id'";
					}
					$contentUp= $this->db->update($query);
					if ($contentUp) {
						$msg = "Content updated";
						return $msg;
					} else {
						$msg = "Content not updated";
						return $msg;
					}
				} else {

						
					$query= "UPDATE tb_content
										SET
										conName = '$conName',body = '$body',price = '$price',SubCatID1 = '$SubCatID',SubCatID2 = '$SubCatID2',SubCatID3 = '$SubCatID3'
										WHERE conID = '$id'";
					
					$contentUp= $this->db->update($query);
					if ($contentUp) {
						$msg = "Content updated";
						return $msg;
					} else {
						$msg = "Content not updated";
						return $msg;
					}
				}
			
		}
		public function delcontentById($id) {
			$query   = "SELECT * FROM tb_content WHERE conID = '$id' ";
			$getdata = $this->db->select($query);
			if ($getdata) {
				while ($delImg = $getdata->fetch_assoc()){
					$dellink = $delImg['image'];
					unlink($dellink);
				}
			}
			$delquery   = "DELETE FROM tb_content WHERE conID = '$id' ";
			$deldata = $this->db->delete($delquery);
			
			if ($deldata) {
				$msg = "Content is deleted ";
				return $msg;
			} else {
				$msg = "Content cannot be deleted";
				return $msg;
			}
		}
	}