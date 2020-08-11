<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../library/Session.php');
	include_once ($filepath.'/../helpers/Format.php');
	
	class comment {
		private $db;
		private $fm;
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function commentInsert($data,$id,$InstituteID){
			$name = $this->fm->validation($data['name']);
			$name = mysqli_real_escape_string($this->db->link, $name);
			
			$email    = $this->fm->validation($data['email']);
			$email    = mysqli_real_escape_string($this->db->link, $email);
			
			$phone   = $this->fm->validation($data['phone']);
			$phone   = mysqli_real_escape_string($this->db->link, $phone);
			
			$message   = $this->fm->validation($data['message']);
			$message   = mysqli_real_escape_string($this->db->link, $message);
			
			if($name == "" || $email == "" || $phone == "" || $message == "" ) {
				$msg = "Fields must not be empty";
				return $msg;
			}
			else{
				$query = "INSERT INTO tb_comment(InstituteID,conID,name,email,phone,message) VALUES('$InstituteID','$id','$name','$email','$phone','$message')";
				$commentInsert= $this->db->insert($query);
				if ($commentInsert) {
						$msg = "Comment added!";
						return $msg;
					} else {
						$msg = "Error! Comment not added!";
						return $msg;
					}
			}
		}
		public function replyInsert($data,$id,$value){
			$InstituteID = $value['InstituteID'];
			$email    = $this->fm->validation($value['Email']);
			$email    = mysqli_real_escape_string($this->db->link, $email);
			
			$phone   = $this->fm->validation($value['Phone']);
			$phone   = mysqli_real_escape_string($this->db->link, $phone);
			
			$message   = $this->fm->validation($data['message']);
			$message   = mysqli_real_escape_string($this->db->link, $message);
			
			if($message == "" ) {
				$msg = "Fields must not be empty";
				return $msg;
			}
			else{
				$query = "INSERT INTO tb_comment(InstituteID,conID,name,email,phone,message) VALUES('$InstituteID','$id','Admin','$email','$phone','$message')";
				$commentInsert= $this->db->insert($query);
				if ($commentInsert) {
						$msg = "Comment added!";
						return $msg;
					} else {
						$msg = "Error! Comment not added!";
						return $msg;
					}
			}
		}
		public function getAllComments() {
			$query = "SELECT c.*,i.*,p.*
			FROM tb_comment as c, tb_institute as i, tb_content as p 
			WHERE c.InstituteID = i.InstituteID AND c.conID = p.conID
			ORDER BY c.commentID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function getCommentsByID($id) {
			$query = "SELECT * FROM tb_comment WHERE conID = '$id' ORDER BY commentID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function getCommentsByuserID($userID) {
			$query = "SELECT c.*,i.*,p.*
			FROM tb_comment as c, tb_institute as i, tb_content as p 
			WHERE c.InstituteID = i.InstituteID AND c.conID = p.conID AND i.userID = '$userID' ORDER BY c.commentID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function delcommentByID($id) {
		    $delquery   = "DELETE FROM tb_comment WHERE commentID = '$id' ";
			$deldata = $this->db->delete($delquery);
			
			if ($deldata) {
				$msg = "Comment deleted ";
				return $msg;
			} else {
				$msg = "Comment not deleted";
				return $msg;
			}
		}
	}