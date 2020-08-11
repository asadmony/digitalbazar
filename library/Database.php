<?php 
	define("DB_HOST", "localhost:3306");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "dbazar_datastorage"); 
?>

<?php
	Class Database{
	 public $host   = DB_HOST;
	 public $user   = DB_USER;
	 public $pass   = DB_PASS;
	 public $dbname = DB_NAME;
	 
	 
	 public $link;
	 public $error;
	 
	 public function __construct(){
	  $this->connectDB();
	 }
	 
	private function connectDB(){
	 $this->link = new mysqli($this->host, $this->user, $this->pass,
	  $this->dbname);
	 if(!$this->link){
	   $this->error ="Connection fail".$this->link->connect_error;
	  return false;
	 }
	 }
	// Select or Read data
	public function select($query){
	  $result = $this->link->query($query) or
	   die($this->link->error.__LINE__);
	  if($result->num_rows > 0){
		return $result;
	  } else {
		return false;
	  }
	 }
	 
	// Insert data
	public function insert($query){
	 $insert_row = $this->link->query($query) or
	   die($this->link->error.__LINE__);
	 if($insert_row){
	   return $insert_row;
	 } else {
	   return false;
	  }
	 }
	 
	// Update data
	 public function update($query){
	 $update_row = $this->link->query($query) or
	   die($this->link->error.__LINE__);
	 if($update_row){
	  return $update_row;
	 } else {
	  return false;
	  }
	 }
	 
	// Delete data
	 public function delete($query){
	 $delete_row = $this->link->query($query) or
	   die($this->link->error.__LINE__);
	 if($delete_row){
	   return $delete_row;
	 } else {
	   return false;
	  }
	 }
	 
	}
	$this_file = str_replace('\\', '/', __File__) ;
	$doc_root = $_SERVER['DOCUMENT_ROOT'];

	$web_root =  str_replace (array($doc_root, "library/Database.php") , '' , $this_file);
	define ('web_root' , $web_root);