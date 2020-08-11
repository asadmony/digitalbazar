<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../library/Session.php');
	include_once ($filepath.'/../helpers/Format.php');

?>
<?php
/**
* Adminlogin class
*/
class admin {
	private $db;
	private $fm;
	
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}
	
	public function adminLogin($data) {
		$adminUsername = $this->fm->validation($data['adminUsername']);
		$adminPass = $this->fm->validation($data['pass']);
		$adminUsername = mysqli_real_escape_string($this->db->link, $adminUsername);
		$adminPass = mysqli_real_escape_string($this->db->link, md5($adminPass));
		
		if (empty($adminUsername) || empty($adminPass)){
			$loginmsg = "Username or Password must not be empty!";
			return $loginmsg;
		} else {
			$query = "SELECT * FROM tb_admin WHERE adminUsername ='$adminUsername' AND adminPass = '$adminPass' ";
			
			$result = $this->db->select($query);
			if ($result != false) {
				$value = $result->fetch_assoc();
				Session::set("adminLogin", true);
				Session::set("adminID", $value['adminID']);
				Session::set("adminUsername", $value['adminUsername']);
				header("Location: ../admin/dashboard.php");
				
			}
			else {
				$loginmsg = "Username or Password not match !!! ";
				return $loginmsg;
			} 
		}
	}
	public function getAllUser() {
			$query = "SELECT u.*, i.*
					FROM tb_user as u, tb_institute as i
					WHERE u.userID = i.userID
					ORDER BY u.userID DESC";
			$result = $this->db->select($query);
			return $result;
	}
	
	public function getUserByID($userID) {
			$query = "SELECT * FROM tb_user WHERE userID = '$userID' ";
			$result = $this->db->select($query);
			return $result;
	}
	public function getAllInstitutes() {
			$query = "SELECT u.*, i.*
					FROM tb_user as u, tb_institute as i
					WHERE u.userID = i.userID
					ORDER BY  InstituteID DESC";
			$result = $this->db->select($query);
			return $result;
	}
	
	public function delUserById($ID) {
		$q = "SELECT * FROM tb_institute WHERE userID = '$ID'";
		$getI = $this->db->select($q);
		if ($getI) {
			while ($delI = $getI->fetch_assoc()){
				$iID = $delI['InstituteID'];
				$query   = "SELECT * FROM tb_content WHERE InstituteID = '$iID' ";
				$getdata = $this->db->select($query);
				if ($getdata) {
					while ($delc = $getdata->fetch_assoc()){
						$dellink = "../user/".$delc['image'];
						unlink($dellink);
					}
				}
				$delquery   = "DELETE FROM tb_content WHERE InstituteID = '$iID' ";
				$deldata = $this->db->delete($delquery);
				if(isset($deldata) || empty($getdata)) {
					$logo = "../user/".$delI['logo'];
					$cvr = "../user/".$delI['CoverPic'];
					unlink($logo);
					unlink($cvr);
				}
				else{
					$msg = "Products or Services of ".$delI['InstituteName']." could not be deleted!";
					return $msg;
				}
			}
		}
		$delqry   = "DELETE FROM tb_institute WHERE userID = '$ID' ";
		$delinst = $this->db->delete($delqry);
		if (isset($delinst) || empty($getI)){
			$query   = "SELECT * FROM tb_user WHERE userID = '$ID' ";
			$getdata = $this->db->select($query);
			if ($getdata) {
				while ($delImg = $getdata->fetch_assoc()){
					$dellink = "../user/".$delImg['ProfilePic'];
					unlink($dellink);
				}
			}
			$delquery   = "DELETE FROM tb_user WHERE userID = '$ID' ";
			$del = $this->db->delete($delquery);	
			if (isset($del)) {
				$msg = "  <div class=\"alert alert-success\">
									<strong>Success!</strong> User is deleted!
								</div>";
				return $msg;
			} else {
				$msg = "  <div class=\"alert alert-warning\">
									<strong>Error!</strong> User is not deleted!
								</div>";
				return $msg;
			}
		}
		else{
			$msg = "Institutes of this user could not be deleted!";
			return $msg;
		}
	}
	public function delInstituteById($ID) {
			$query   = "SELECT * FROM tb_content WHERE InstituteID = '$ID' ";
			$getdata = $this->db->select($query);
			if ($getdata) {
				while ($delImg = $getdata->fetch_assoc()){
					$dellink = "../user/".$delImg['image'];
					unlink($dellink);
				}
			}
			else{
				$msg = "Content not be deleted";
				return $msg;
			}
			$delquery   = "DELETE FROM tb_content WHERE InstituteID = '$ID' ";
			$deldata = $this->db->delete($delquery);
			
			if (isset($deldata) || empty($getdata)) {
				$q = "SELECT * FROM tb_institute WHERE InstituteID = '$ID' ";
				$get = $this->db->select($q);
				if ($get) {
					while ($delpic = $get->fetch_assoc()){
						$logo = "../user/".$delpic['logo'];
						$cvr = "../user/".$delpic['CoverPic'];
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
					$msg = "Institute is not deleted";
					return $msg;
				}
			} else {
				$msg = "Institute not be deleted! delete Products or Services first!";
				return $msg;
			}	
	}
	public function countrefer($mob) {
		$query = "SELECT * FROM tb_user WHERE ReferrersMobNo = '$mob'";
		$result = $this->db->select($query);
		if($result == ""){
			return "0";
		}else{
				$row_cnt = $result->num_rows;
				return $row_cnt;
		}
	}
	public function getInfoById($userID){
		$query   = "SELECT * FROM tb_institute WHERE userID = '$userID' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function getuserInfoById($userID){
		$query   = "SELECT * FROM tb_user WHERE userID = '$userID' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function getInfoByInstId($InstituteID){
		$query   = "SELECT * FROM tb_institute WHERE InstituteID = '$InstituteID' ";
		$result = $this->db->select($query);
		return $result;
	}
	public function UpdateUser($data,$file,$ID){
			$name            = mysqli_real_escape_string($this->db->link, $data['name']);
			$email           = mysqli_real_escape_string($this->db->link, $data['email']);
			$MobileNo        = mysqli_real_escape_string($this->db->link, $data['MobileNo']);
			$ID              = mysqli_real_escape_string($this->db->link, $ID);
			
			if($email != "" && filter_var($email, FILTER_VALIDATE_EMAIL) === false){
						$msg ="<strong>Error! The email address is not valid !</strong>";
						return $msg;
				}
				else{
					if($email != ""){
						$mailchkqry = "SELECT * FROM tb_user WHERE email = '$email' AND userID != '$ID' LIMIT 1  ";
						$mailchk = $this->db->select($mailchkqry);
						if ($mailchk != false){
							$msg = "this <strong>email</strong> already exists!";
							return $msg;
						}
					}
					
					$numchkqry = "SELECT * FROM tb_user WHERE MobileNo = '$MobileNo' AND userID != '$ID' LIMIT 1  ";
					$numchk = $this->db->select($numchkqry);
					if ($numchk != false){
						$msg = "this <strong>Number</strong> already exists!";
						return $msg;
					}
					else {
						$query="UPDATE tb_user SET name = '$name', email = '$email', MobileNo = '$MobileNo' WHERE userID = '$ID'";
							$userUp= $this->db->update($query);
						if ($userUp) {
							$msg = "User Updated!!";
							return $msg;
						} else {
							$msg = "User not Updated!!";
							return $msg;
						}
					}
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
			$uploaded_image  = "uploads/".$unique_image1;
			$uploaded_image1 = "../user/".$uploaded_image;
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
				$query="UPDATE tb_institute SET logo ='$uploaded_image' WHERE InstituteID = '$ID'";
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
			$uploaded_image  = "uploads/".$unique_image1;
			$uploaded_image1 = "../user/".$uploaded_image;
			if ($file_size1 > 1048567 ) {
				echo "Image size should be less than 1MB";
				
			}
			elseif (in_array($file_ext1, $permited) === false ) {
				echo "You can upoad only".implode(',',$permited);
			}
			else{
				move_uploaded_file($file_temp1, $uploaded_image1);
				$query="UPDATE tb_institute SET CoverPic ='$uploaded_image' WHERE InstituteID = '$ID'";
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
	
}