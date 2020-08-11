<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../library/Session.php');
	include_once ($filepath.'/../helpers/Format.php');

	class user {
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}
		
		public function userReg($data,$file){
			$name              = mysqli_real_escape_string($this->db->link, $data['name']);
			$email             = mysqli_real_escape_string($this->db->link, $data['email']);
			$pass              = mysqli_real_escape_string($this->db->link, $data['pass']);
			$MobileNo          = mysqli_real_escape_string($this->db->link, $data['MobileNo']);
			$MobileNo1         = mysqli_real_escape_string($this->db->link, $data['MobileNo1']);
			$ReferrersMobNo    = mysqli_real_escape_string($this->db->link, $data['ReferrersMobNo']);
			
			if ( $name == "" || $pass == "" || $MobileNo == "" || $MobileNo1 == "" ) {
				$msg = " * Fields must not be empty";
				return $msg;
			}
			elseif($MobileNo != $MobileNo1){
				$msg = "The <strong>Mobile numbers </strong> don/'t match!";
				return $msg;
			}
			elseif(!preg_match('/^[a-zA-Z0-9]+$/', $pass)){
				$msg="The password may contain only numbers and letters!";
				return $msg;
			}
			elseif($email != "" && filter_var($email, FILTER_VALIDATE_EMAIL) === false){
						$msg ="<strong>Error! The email address is not valid !</strong>";
						return $msg;
			}
			elseif(strlen($pass) < 6){
				$msg = "<strong>The password must have atleast 6 digit ! </strong>";
				return $msg;
			}
			else{
				if ($email != ""){
				$mailchkqry = "SELECT * FROM tb_user WHERE email = '$email' LIMIT 1  ";
				$mailchk = $this->db->select($mailchkqry);
				if (!empty($mailchk)){
					$msg = "this <strong>email</strong> already exists!";
					return $msg;
				}
				}
				$numchkqry = "SELECT * FROM tb_user WHERE MobileNo = '$MobileNo' LIMIT 1  ";
				$numchk = $this->db->select($numchkqry);
				if ($numchk != false){
					$msg = "this <strong>Number</strong> is already registered!";
					return $msg;
				}
				else {
					$query = "INSERT INTO tb_user(name,email,password,MobileNo,ReferrersMobNo) VALUES('$name','$email','$pass','$MobileNo','$ReferrersMobNo')";
					$userReg= $this->db->insert($query);
					if ($userReg) {
						header('Location:success');
					} else {
						$msg = "Error! User not registered";
						return $msg;
					}
				}
			}
		}
		
		
		public function userLogin($data){
			
			$emailornum = mysqli_real_escape_string($this->db->link, $data['emailornum']);
			$pass       = mysqli_real_escape_string($this->db->link, $data['pass']);
			
			if (empty($emailornum) || empty($pass) ){
				$msg = "Field must not be empty";
				return $msg;
			}
			else{
				$mailchkqry = "SELECT * FROM tb_user WHERE email = '$emailornum' LIMIT 1  ";
				$mailchk = $this->db->select($mailchkqry);
				if ($mailchk == false){
					$numchkqry = "SELECT * FROM tb_user WHERE MobileNo = '$emailornum' LIMIT 1  ";
					$numchk = $this->db->select($numchkqry);
					if($numchk == false){
						$msg = "This email or number not registered!";
						return $msg;
					}else{
						$query="SELECT * FROM tb_user WHERE MobileNo ='$emailornum' AND password ='$pass'";
						$result = $this->db->select($query);
						if ($result != false) {
							$value = $result->fetch_assoc();
							Session::init();
							Session::set("usrlgn", true);
							Session::set("usrid", $value['userID']);
							Session::set("usrName", $value['name']);
							Session::set("usrNum", $value['MobileNo']);
							Session::set("userlog", "User logged! ");
							header('Location:dashboard.php');
						
						}
						else{
							$msg = "The Email or Number or password not matched";
							return $msg;
						}
					}
				}
				else{
					$query="SELECT * FROM tb_user WHERE email ='$emailornum' AND password ='$pass'";
					$result = $this->db->select($query);
					if ($result != false) {
						$value = $result->fetch_assoc();
						Session::init();
						Session::set("usrlgn", true);
						Session::set("usrid", $value['userID']);
						Session::set("usrName", $value['name']);
						Session::set("usrNum", $value['MobileNo']);
						Session::set("userlog", "User logged! ");
						header("Location:dashboard.php");
						
					}
					else{
						$msg = "email or password not matched";
						return $msg;
					}
				}
			}
		}
		public function getAllInfoByUser($userID) {
			$query = "SELECT * FROM tb_user WHERE userID = '$userID'";
			$result = $this->db->select($query);
			return $result;
		}
		public function getInstByUser($userID) {
			$query = "SELECT * FROM tb_institute WHERE userID = '$userID'";
			$result = $this->db->select($query);
			return $result;
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
		public function getTrefers($mob) {
			$query = "SELECT * FROM tb_user WHERE ReferrersMobNo = '$mob'";
			$result = $this->db->select($query);
			return $result;
		}
		public function changeProfilePic($data,$file,$userID){
			if (empty($file['ProfilePic']['name'])) {
				$msg = " Please select your desired photo!";
				return $msg;
			}else{
				$query   = "SELECT ProfilePic FROM tb_user WHERE userID = '$userID' ";
				$getdata = $this->db->select($query);
				if ($getdata != "" ) {
					while ($delImg = $getdata->fetch_assoc()){
						if(isset($delImg['ProfilePic'])){
						$dellink = $delImg['ProfilePic'];
						unlink($dellink);
						}
					}
				}
			}
			$permited        = array('jpg', 'jpeg', 'png', 'gif');
			$file_name1      = $file['ProfilePic']['name'];
			$file_size1      = $file['ProfilePic']['size'];
			$file_temp1      = $file['ProfilePic']['tmp_name'];

			$div1            = explode('.', $file_name1);
			$file_ext1       = strtolower(end($div1));
			$unique_image1   = substr(md5(time()), 0, 10).'.'.$file_ext1;
			$uploaded_image1 = "uploads/".$unique_image1;
			if ($file_size1 > 1048567 ) {
				echo "Image size should be less than 1MB";
				
			}
			elseif (in_array($file_ext1, $permited) === false  ) {
				echo "You can upoad only".implode(',',$permited);
			}
			else{
				move_uploaded_file($file_temp1, $uploaded_image1);
				$query="UPDATE tb_user SET ProfilePic = '$uploaded_image1' WHERE userID = '$userID'";
				$update_row = $this->db->update($query);
						if ($update_row){
							$msg="Your Profile Picture Changed!";
							return $msg;
						}else{
							$msg="Your Profile Picture not Changed!";
							return $msg;
						}
			}
		}
	}