<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	
	class institute{
		private $db;
		private $fm;
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}
		
		public function addinstitute($data,$userID){
			$userID             = mysqli_real_escape_string($this->db->link, $userID);
			$InstituteName     = mysqli_real_escape_string($this->db->link, $data['InstituteName']);
			$SubCatID       = mysqli_real_escape_string($this->db->link, $data['SubCatID']);
			$SubCatID2      = mysqli_real_escape_string($this->db->link, $data['SubCatID2']);
			$SubCatID3      = mysqli_real_escape_string($this->db->link, $data['SubCatID3']);
			$Location          = mysqli_real_escape_string($this->db->link, $data['Location']);
			$Division           = mysqli_real_escape_string($this->db->link, $data['Division']);
			if ($InstituteName == "" || $Location == "" || $SubCatID == ""   ) {
				$msg = " * Fields must not be empty";
				return $msg;
			}
			else{
				$q = "SELECT InstituteName FROM tb_institute WHERE userID = '$userID' AND InstituteName = '$InstituteName'";
				$chk = $this->db->select($q);
				if($chk == true && !empty($chk)){
					$msg =" This Institute is already exist!";
					return $msg;
				}else{
					$query = "INSERT INTO tb_institute (userID,InstituteName,Location,Division,SubCatID1,SubCatID2,SubCatID3) VALUES('$userID','$InstituteName','$Location','$Division','$SubCatID','$SubCatID2','$SubCatID3')";
						$addinst= $this->db->insert($query);
					if ($addinst) {
								header("Location:institute_list.php");
							
						} else {
							$msg = "Institute not added!!!";
							return $msg;
						}
					
				}
			}
		}
		public function getRandInst(){
			$query   = "SELECT * FROM tb_institute ORDER BY rand() LIMIT 6";
			$result = $this->db->select($query);
			return $result;
		}
		public function getInfoById($userID){
			$query   = "SELECT * FROM tb_institute WHERE userID = '$userID' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getInfoByInsId($InstituteID){
			$query   = "SELECT * FROM tb_institute WHERE InstituteID = '$InstituteID' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function updateContact($data,$ID){

			$Email = mysqli_real_escape_string($this->db->link, $data['Email']);
			$Phone = mysqli_real_escape_string($this->db->link, $data['Phone']);
			$Address = mysqli_real_escape_string($this->db->link, $data['Address']);
			$webAddress = mysqli_real_escape_string($this->db->link, $data['webAddress']);

				$query  = "UPDATE tb_institute SET Email = '$Email', Phone = '$Phone', Address = '$Address', webAddress = '$webAddress'  WHERE InstituteID = '$ID' ";
				
				$update_row = $this->db->update($query);
				
				if ($update_row) {
					$msg = "Contact Informations saved !";
					return $msg;
				} else {
					$msg = "Contact Informations save failed!!";
					return $msg;
				}
			
		}
		public function updateName($data,$ID){

			$InstituteName = mysqli_real_escape_string($this->db->link, $data['InstituteName']);
			

				$query  = "UPDATE tb_institute SET InstituteName = '$InstituteName'  WHERE InstituteID = '$ID' ";
				
				$update_row = $this->db->update($query);
				
				if ($update_row) {
					$msg = "Institute Name saved !";
					return $msg;
				} else {
					$msg = "Institute Name save failed!!";
					return $msg;
				}
			
		}
		public function updateDetails($data,$ID){

			$Description = mysqli_real_escape_string($this->db->link, $data['Description']);
			

				$query  = "UPDATE tb_institute SET Description = '$Description'  WHERE InstituteID = '$ID' ";
				
				$update_row = $this->db->update($query);
				
				if ($update_row) {
					$msg = "Description saved !";
					return $msg;
				} else {
					$msg = "Description save failed!!";
					return $msg;
				}
			
		}
		public function updateiframe($data,$ID){

			$iframelink = mysqli_real_escape_string($this->db->link, $data['iframelink']);
			

				$query  = "UPDATE tb_institute SET iframelink = '$iframelink'  WHERE InstituteID = '$ID' ";
				
				$update_row = $this->db->update($query);
				
				if ($update_row) {
					$msg = "iframe link saved !";
					return $msg;
				} else {
					$msg = "iframe link save failed!!";
					return $msg;
				}
			
		}
		public function uploadLogo($data,$file,$ID){
			if (empty($file['logo']['name'])) {
				$msg = "Please select your desired photo!";
				return $msg;
			}else{
				$query   = "SELECT * FROM tb_institute WHERE InstituteID = '$ID' ";
				$getdata = $this->db->select($query);
				if (isset($getdata)) {
					while ($delImg = $getdata->fetch_assoc()){
						if(isset($delImg['logo'])){
						$dellink = $delImg['logo'];
						unlink($dellink);
						}
					}
				}
			}
			$permited        = array('jpg', 'jpeg', 'png', 'gif');
			$file_name1      = $file['logo']['name'];
			$file_size1      = $file['logo']['size'];
			$file_temp1      = $file['logo']['tmp_name'];

			$div1            = explode('.', $file_name1);
			$file_ext1       = strtolower(end($div1));
			$unique_image1   = substr(md5(time()), 0, 10).'.'.$file_ext1;
			$uploaded_image1 = "uploads/".$unique_image1;
			if ($file_name1 == ""  ) {
				$msg = "Please select your desired photo!";
				return $msg;
			}
			elseif ($file_size1 > 1048567 ) {
				echo "Image size should be less than 1MB";
				
			}
			elseif (in_array($file_ext1, $permited) === false  ) {
				echo "You can upoad only".implode(',',$permited);
			}
			else{
				move_uploaded_file($file_temp1, $uploaded_image1);
				$query="UPDATE tb_institute SET logo ='$uploaded_image1' WHERE InstituteID = '$ID'";
				$update_row = $this->db->update($query);
						if ($update_row){
							$msg="Logo uplaoded!";
							return $msg;
						}else{
							$msg = "Logo not uploaded! ";
							return $msg;
						}
			}
		}
		public function uploadCoverPic($data,$file,$ID){
			if (empty($file['CoverPic']['name'])) {
				$msg = "Please select your desired photo!";
				return $msg;
			}else{
				$query   = "SELECT * FROM tb_institute WHERE InstituteID = '$ID' ";
				$getdata = $this->db->select($query);
				if (isset($getdata)) {
					while ($delImg = $getdata->fetch_assoc()){
						if(isset($delImg['CoverPic'])){
						$dellink = $delImg['CoverPic'];
						unlink($dellink);
						}
					}
				}
			}
			$permited        = array('jpg', 'jpeg', 'png', 'gif');
			$file_name1      = $file['CoverPic']['name'];
			$file_size1      = $file['CoverPic']['size'];
			$file_temp1      = $file['CoverPic']['tmp_name'];

			$div1            = explode('.', $file_name1);
			$file_ext1       = strtolower(end($div1));
			$unique_image1   = substr(md5(time()), 0, 10).'.'.$file_ext1;
			$uploaded_image1 = "uploads/".$unique_image1;
			if ($file_size1 > 1048567 ) {
				echo "Image size should be less than 1MB";
				
			}
			elseif (in_array($file_ext1, $permited) === false ) {
				echo "You can upoad only".implode(',',$permited);
			}
			else{
				move_uploaded_file($file_temp1, $uploaded_image1);
				$query="UPDATE tb_institute SET CoverPic ='$uploaded_image1' WHERE InstituteID = '$ID'";
				$update_row = $this->db->update($query);
						if ($update_row){
							$msg="Cover Photo uplaoded!";
							return $msg;
						}else{
							$msg = "Cover Photo is not uploaded ";
							return $msg;
						}
			}
		}
		public function updateOpenHour($data,$ID){
			
			$SaturdayOpen    = mysqli_real_escape_string($this->db->link, $data['SaturdayOpen']);
			$SaturdayClose   = mysqli_real_escape_string($this->db->link, $data['SaturdayClose']);
			$SundayOpen      = mysqli_real_escape_string($this->db->link, $data['SundayOpen']);
			$SundayClose     = mysqli_real_escape_string($this->db->link, $data['SundayClose']);
			$MondayOpen      = mysqli_real_escape_string($this->db->link, $data['MondayOpen']);
			$MondayClose     = mysqli_real_escape_string($this->db->link, $data['MondayClose']);
			$TuesdayOpen     = mysqli_real_escape_string($this->db->link, $data['TuesdayOpen']);
			$TuesdayClose    = mysqli_real_escape_string($this->db->link, $data['TuesdayClose']);
			$WednesdayOpen   = mysqli_real_escape_string($this->db->link, $data['WednesdayOpen']);
			$WednesdayClose  = mysqli_real_escape_string($this->db->link, $data['WednesdayClose']);
			$ThursdayOpen    = mysqli_real_escape_string($this->db->link, $data['ThursdayOpen']);
			$ThursdayClose   = mysqli_real_escape_string($this->db->link, $data['ThursdayClose']);
			$FridayOpen      = mysqli_real_escape_string($this->db->link, $data['FridayOpen']);
			$FridayClose     = mysqli_real_escape_string($this->db->link, $data['FridayClose']);
			
			$query="UPDATE tb_institute SET SaturdayOpen ='$SaturdayOpen', SaturdayClose ='$SaturdayClose', SundayOpen ='$SundayOpen', SundayClose ='$SundayClose', MondayOpen ='$MondayOpen', MondayClose ='$MondayClose', TuesdayOpen ='$TuesdayOpen', TuesdayClose ='$TuesdayClose', WednesdayOpen ='$WednesdayOpen', WednesdayClose ='$WednesdayClose', ThursdayOpen ='$ThursdayOpen', ThursdayClose ='$ThursdayClose', FridayOpen ='$FridayOpen', FridayClose ='$FridayClose' WHERE InstituteID = '$ID'";
			
				$update_row = $this->db->update($query);
						if ($update_row){
							$msg="Open Hours updated!";
							return $msg;
						}else{
							$msg="Open Hours not updated!";
							return $msg;
						}
		}
		public function updateInstitute($data,$ID){
			$InstituteName     = mysqli_real_escape_string($this->db->link, $data['InstituteName']);
			$Location          = mysqli_real_escape_string($this->db->link, $data['Location']);
			$Division           = mysqli_real_escape_string($this->db->link, $data['Division']);
			$SaturdayOpen          = mysqli_real_escape_string($this->db->link, $data['SaturdayOpen']);
			$SaturdayClose             = mysqli_real_escape_string($this->db->link, $data['SaturdayClose']);
			$SundayOpen              = mysqli_real_escape_string($this->db->link, $data['SundayOpen']);
			$SundayClose       = mysqli_real_escape_string($this->db->link, $data['SundayClose']);
			$MondayOpen       = mysqli_real_escape_string($this->db->link, $data['MondayOpen']);
			$MondayClose       = mysqli_real_escape_string($this->db->link, $data['MondayClose']);
			$TuesdayOpen            = mysqli_real_escape_string($this->db->link, $data['TuesdayOpen']);
			$TuesdayClose     = mysqli_real_escape_string($this->db->link, $data['TuesdayClose']);
			$WednesdayOpen       = mysqli_real_escape_string($this->db->link, $data['WednesdayOpen']);
			$WednesdayClose      = mysqli_real_escape_string($this->db->link, $data['WednesdayClose']);
			$ThursdayOpen          = mysqli_real_escape_string($this->db->link, $data['ThursdayOpen']);
			$ThursdayClose    = mysqli_real_escape_string($this->db->link, $data['ThursdayClose']);
			$FridayOpen  = mysqli_real_escape_string($this->db->link, $data['FridayOpen']);
			$FridayClose   = mysqli_real_escape_string($this->db->link, $data['FridayClose']);
			$Description    = mysqli_real_escape_string($this->db->link, $data['Description']);
			$Email    = mysqli_real_escape_string($this->db->link, $data['Email']);
			$Phone    = mysqli_real_escape_string($this->db->link, $data['Phone']);
			$webAddress = mysqli_real_escape_string($this->db->link, $data['webAddress']);
			$Address    = mysqli_real_escape_string($this->db->link, $data['Address']);
			$iframelink = mysqli_real_escape_string($this->db->link, $data['iframelink']);
			$query="UPDATE tb_institute SET InstituteName ='$InstituteName', Location ='$Location', Division = '$Division', SaturdayOpen ='$SaturdayOpen', SaturdayClose ='$SaturdayClose', SundayOpen ='$SundayOpen', SundayClose ='$SundayClose', MondayOpen ='$MondayOpen', MondayClose ='$MondayClose', TuesdayOpen ='$TuesdayOpen', TuesdayClose ='$TuesdayClose', WednesdayOpen ='$WednesdayOpen', WednesdayClose ='$WednesdayClose', ThursdayOpen ='$ThursdayOpen', ThursdayClose ='$ThursdayClose', FridayOpen ='$FridayOpen', FridayClose ='$FridayClose', Description ='$Description', Email ='$Email', Phone ='$Phone', webAddress = '$webAddress', Address ='$Address', iframelink = '$iframelink' WHERE InstituteID = '$ID'";
			
				$update_row = $this->db->update($query);
						if ($update_row){
							$msg="Institute updated!";
							return $msg;
						}else{
							$msg="Institute not updated!";
							return $msg;
						}
			
		}
		public function delInstituteById($ID){
			$query   = "SELECT * FROM tb_content WHERE InstituteID = '$ID' ";
			$getdata = $this->db->select($query);
			if ($getdata) {
				while ($delImg = $getdata->fetch_assoc()){
					$dellink = $delImg['image'];
					unlink($dellink);
				}
			}
			$delquery   = "DELETE FROM tb_content WHERE InstituteID = '$ID' ";
			$deldata = $this->db->delete($delquery);
			
			if (isset($deldata)) {
				$q = "SELECT * FROM tb_institute WHERE InstituteID = '$ID' ";
				$get = $this->db->select($q);
				if ($get) {
					while ($delpic = $get->fetch_assoc()){
						$logo = $delpic['logo'];
						$cvr = $delpic['CoverPic'];
						unlink($logo);
						unlink($cvr);
					}
				}
				$delqry   = "DELETE FROM tb_institute WHERE InstituteID = '$ID' ";
				$delinst = $this->db->delete($delqry);
				
				if (isset($delinst)) {
					$msg = "Institute is deleted ";
					return $msg;
				} else {
					$msg = "Institute cannot be deleted";
					return $msg;
				}
			} else {
				$msg = "Content not be deleted";
				return $msg;
			}
		}
	}

