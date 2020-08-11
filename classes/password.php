<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../library/Session.php');
	include_once ($filepath.'/../helpers/Format.php');

	class password {
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}
		
		
		public function chkmail($data){
			
			$emailornum = mysqli_real_escape_string($this->db->link, $data['emailornum']);
			
			if (empty($emailornum) ){
				$msg = "Field must not be empty";
				return $msg;
			}
			else{
				$mailchkqry = "SELECT * FROM tb_user WHERE email = '$emailornum' LIMIT 1  ";
				$mailchk = $this->db->select($mailchkqry);
				if (empty($mailchk)){
					$msg = "The email you entered is not registered!";
					return $msg;
				}
				else{
					$code = rand (10000000,99999999);
					$query="SELECT * FROM tb_confirmation WHERE email ='$emailornum' LIMIT 1";
					$result = $this->db->select($query);
					if ($result != false) {
						$q = "UPDATE tb_confirmation SET code = '$code' WHERE email = '$emailornum'";
						$done = $this->db->update($q);
					}
					else{
						$q = "INSERT INTO tb_confirmation(email,code) VALUES('$emailornum','$code')";
						$done = $this->db->insert($q);
					}
					if (isset($done)) {
						$subject = "Password Reset Confirmation - Digitalbazar";
						$message =
						"
						Hello sir,
						You have requested for a password reset operation.
						Please, Confirm your email.

						Your confirmation code is $code

						Please put this code on the required field.
						Or, You can Confirm your email by clicking link given below

						http://digitalbazar.info/confirm?em=$emailornum&c=$code

						Thank You.

						";
						$sent = mail($emailornum, $subject , $message,"From: donotreply@digitalbazar.info");
						if (isset($sent)) {
							//header("Location: confirm_email?em=".$emailornum);
							//exit();
							$msg = "A mail has been sent to your email inbox with a link. Please click that link for further process. <br> If you didn't get the mail please check in spam folder.";
							return $msg;
						}
						else {
							$msg ="Confirmation Code is not sent. Please try again";
							return $msg;
						}
					}
				}
			}
		}
		public function confirm($data,$email) {
			$code = mysqli_real_escape_string($this->db->link, $data['confirmcode']);
			$query = "SELECT * FROM tb_confirmation WHERE email ='$email'";
			$r = $this->db->select($query);
			if (isset($r)) {
				$value = $r->fetch_assoc();
				if ($value['code'] == $code) {
					$qr = "UPDATE tb_confirmation SET confirm = '1' WHERE email = '$email'";
					$rs = $this->db->update($qr);
					if (isset($rs)) {
						header("location:user/reset_password?em=$email");
						exit();
					}
					else{
						$msg = "Code not confirmed! Please, try again.";
						return $msg;
					}
				}else{
					$msg ="Confirmation Code didn't match!";
					return $msg;
				}
			}
		}
		public function change($data,$email) {
			$pass = mysqli_real_escape_string($this->db->link, $data['pass']);
			$cpass = mysqli_real_escape_string($this->db->link, $data['cpass']);

			if (!empty($pass) && $pass = $cpass ) {
				if(strlen($pass) < 6){
					$msg = "<strong>The password must have atleast 6 digit ! </strong>";
					return $msg;
				}
				elseif(!preg_match('/^[a-zA-Z0-9]+$/', $pass)){
					$msg="The password may contain only numbers and letters!";
					return $msg;
				}
				else{
					$query = "UPDATE tb_user SET password = '$pass' WHERE email = '$email'";
					$r = $this->db->update($query);
					if (isset($r)) {
						$dq = "DELETE FROM tb_confirmation WHERE email = '$email' ";
						$deldata = $this->db->delete($dq);
						$msg = "Your password has been changed successfully!";
						return $msg;
					}
					else{
						$msg = "Your password is not changed!";
						return $msg;
					}
				}
			}
			else{
				$msg = "password doesn't match! please try again.";
				return $msg;
			}
		}
		
	}