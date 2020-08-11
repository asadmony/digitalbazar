<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	
	class category{
		private $db;
		private $fm;
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function contCatIns($contCatName){
			$catName = $this->fm->validation($contCatName);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			
			if (empty($catName)){
				$msg = "Category adding failed!";
				return $msg;
			}
			else{
				$q="SELECT * FROM tb_contentcategory WHERE  contentCategoryName = '$catName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Category is already exists!";
					return $msg;
				}
				else {
					$query="INSERT INTO tb_contentcategory(contentCategoryName) VALUES('$catName')";
					$catinsert= $this->db->insert($query);
					if ($catinsert) {
						$msg = "Category inserted";
						return $msg;
					} else {
						$msg = "Category not inserted";
						return $msg;
					}
				}
			}
		}
		public function contSubCatIns($contSubCatName,$contCatID){
			$subCatName = $this->fm->validation($contSubCatName);
			$subCatName = mysqli_real_escape_string($this->db->link, $subCatName);
			
			if (empty($subCatName)){
				$msg = "Sub-category adding failed!";
				return $msg;
			}
			else{
				$q="SELECT * FROM tb_contentsubcategory WHERE  contentSubCategoryName = '$subCatName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Sub-category is already exists!";
					return $msg;
				}
				 else {
					$query="INSERT INTO tb_contentsubcategory(contentSubCategoryName,contentCategoryID) VALUES('$subCatName','$contCatID')";
					$subcatinsert= $this->db->insert($query);
					if ($subcatinsert) {
						$msg = "Sub-category inserted";
						return $msg;
					} else {
						$msg = "Sub-category not inserted";
						return $msg;
					}
				}
			}
		}
		
		public function instCatIns($instCatName){
			$catName = $this->fm->validation($instCatName);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			
			if (empty($catName)){
				$msg = "Category adding failed!";
				return $msg;
			} 
			else{
				$q="SELECT * FROM tb_institutecategory WHERE  InstituteCategoryName = '$catName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Category is already exists!";
					return $msg;
				}
				else {
					$query="INSERT INTO tb_institutecategory(InstituteCategoryName) VALUES('$catName')";
					$catinsert= $this->db->insert($query);
					if ($catinsert) {
						$msg = "Category inserted";
						return $msg;
					} else {
						$msg = "Category not inserted";
						return $msg;
					}
				}
			}
		}
		public function instSubCatIns($instSubCatName,$instCatID){
			$subCatName = $this->fm->validation($instSubCatName);
			$subCatName = mysqli_real_escape_string($this->db->link, $subCatName);
			
			if (empty($subCatName)){
				$msg = "Sub-category adding failed!";
				return $msg;
			}
			else{
				$q="SELECT * FROM tb_institutesubcategory WHERE  InstituteSubCategoryName = '$subCatName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Sub-category is already exists!";
					return $msg;
				}
				else {
					$query="INSERT INTO tb_institutesubcategory(InstituteSubCategoryName,InstituteCategoryID) VALUES('$subCatName','$instCatID')";
					$subcatinsert= $this->db->insert($query);
					if ($subcatinsert) {
						$msg = "Sub-category inserted";
						return $msg;
					} else {
						$msg = "Sub-category not inserted";
						return $msg;
					}
				}
			}
		}
		public function getAllcontCat(){
			$query  = "SELECT * FROM tb_contentcategory ORDER BY contentCategoryName ASC";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function getAllinstCat(){
			$query  = "SELECT * FROM tb_institutecategory ORDER BY InstituteCategoryName ASC";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function getConSubCatByCat($ID){
			$query  = "SELECT * FROM tb_contentsubcategory WHERE contentCategoryID = '$ID' ORDER BY contentSubCategoryName ASC";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function getInstSubCatByCat($ID){
			$query  = "SELECT * FROM tb_institutesubcategory WHERE InstituteCategoryID = '$ID' ORDER BY InstituteSubCategoryName ASC";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function getInstCatByID($ID){
			$query  = "SELECT * FROM tb_institutecategory WHERE InstituteCategoryID = '$ID' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getInstSubCatByID($ID){
			$query  = "SELECT * FROM tb_institutesubcategory WHERE InstituteSubCategoryID = '$ID' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getConCatByID($ID){
			$query  = "SELECT * FROM tb_contentcategory WHERE contentCategoryID = '$ID' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getConSubCatByID($ID){
			$query  = "SELECT * FROM tb_contentsubcategory WHERE contentSubCategoryID = '$ID' ";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function updateinstCat($catNameE){
			$catName = $this->fm->validation($catNameE);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			
			if (empty($catName)){
				$msg = "Category adding failed!";
				return $msg;
			}
			else{
				$q="SELECT * FROM tb_InstituteCategory WHERE  InstituteCategoryName = '$catName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Category is already exists!";
					return $msg;
				}
				else {
					$query  = "UPDATE tb_institutecategory SET InstituteCategoryName = '$catName' WHERE InstituteCategoryID = '$id' ";
					
					$update_row = $this->db->update($query);
					
					if ($update_row) {
						$msg = "Category updated !";
						return $msg;
					} else {
						$msg = "Category update failed!!";
						return $msg;
					}
				}
			}
		}
		public function updatecontCat($catNameE,$id){
			$catName = $this->fm->validation($catNameE);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			
			if (empty($catName)){
				$msg = "Category adding failed!";
				return $msg;
			} 
			else{
				$q="SELECT * FROM tb_contentcategory WHERE  contentCategoryName = '$catName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Category is already exists!";
					return $msg;
				}
				else {
					$query  = "UPDATE tb_contentcategory SET contentCategoryName = '$catName' WHERE contentCategoryID = '$id' ";
					$update_row = $this->db->update($query);
					if ($update_row) {
						$msg = "Category updated !";
						return $msg;
					} else {
						$msg = "Category update failed!!";
						return $msg;
					}
				}
			}
		}
		public function updatecontSubCat($catNameE,$id){
			$catName = $this->fm->validation($catNameE);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			
			if (empty($catName)){
				$msg = "Category adding failed!";
				return $msg;
			}
			else{
				$q="SELECT * FROM tb_contentsubcategory WHERE  contentSubCategoryName = '$catName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Sub-category is already exists!";
					return $msg;
				}
				else {
					$query  = "UPDATE tb_contentsubcategory SET contentSubCategoryName = '$catName' WHERE contentSubCategoryID = '$id' ";
					$update_row = $this->db->update($query);
					if ($update_row) {
						$msg = "Category updated !";
						return $msg;
					} else {
						$msg = "Category update failed!!";
						return $msg;
					}
				}
			}
		}
		public function updateinstSubCat($catNameE,$id){
			$catName = $this->fm->validation($catNameE);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			if (empty($catName)){
				$msg = "Category adding failed!";
				return $msg;
			}
			else{
				$q="SELECT * FROM tb_institutesubcategory WHERE  InstituteSubCategoryName = '$catName' ";
				$result = $this->db->select($q);
				if(!empty($result)){
					$msg = "Adding Failed! This Sub-category is already exists!";
					return $msg;
				}
				else {
					$query  = "UPDATE tb_institutesubcategory SET InstituteSubCategoryName = '$catName' WHERE InstituteSubCategoryID = '$id' ";
					$update_row = $this->db->update($query);
					if ($update_row) {
						$msg = "Category updated !";
						return $msg;
					} else {
						$msg = "Category update failed!!";
						return $msg;
					}
				}
			}
		}
		public function delinstcatById($id){
			$query   = "DELETE FROM tb_institutecategory WHERE InstituteCategoryID = '$id' ";
			$result = $this->db->delete($query);
			if ($result) {
				$msg = "Category deleted ";
				return $msg;
			} else {
				$msg = "Category not deleted";
				return $msg;
			}
		}
		public function delcontcatById($id){
			$query   = "DELETE FROM tb_contentcategory WHERE contentCategoryID = '$id' ";
			$result = $this->db->delete($query);
			if ($result) {
				$msg = "Category deleted ";
				return $msg;
			} else {
				$msg = "Category not deleted";
				return $msg;
			}
		}
		public function delcontsubcatById($id){
			$query   = "DELETE FROM tb_contentsubcategory WHERE contentSubCategoryID = '$id' ";
			$result = $this->db->delete($query);
			if ($result) {
				$msg = "Sub-Category deleted ";
				return $msg;
			} else {
				$msg = "Sub-Category not deleted";
				return $msg;
			}
		}
		public function delinstsubcatById($id){
			$query   = "DELETE FROM tb_institutesubcategory WHERE InstituteSubCategoryID = '$id' ";
			$result = $this->db->delete($query);
			if ($result) {
				$msg = "Sub-Category deleted ";
				return $msg;
			} else {
				$msg = "Sub-Category not deleted";
				return $msg;
			}
		}
	}
