<?php 
	ob_start();
	include_once 'library/Database.php';
	$db = new Database();
	if ( isset($_GET['em']) && isset($_GET['c'])) {
		$email = $_GET['em'];
		$cd = $_GET['c'];
	}else{
		header("location:login");
	}
	$q="SELECT * FROM tb_confirmation WHERE email = '$email'";
	$r = $db->select($q);
	if(!empty($r)){
		$info = $r->fetch_assoc();
	}
	if (isset($info) && $info['code'] == $cd) {
		$qr = "UPDATE tb_confirmation SET confirm = '1' WHERE email = '$email'";
		$rs = $db->update($qr);
		if(isset($rs)){
			header("location:user/reset_password?em=$email");
			exit ();
		}
	}
	else{
		header("Location: forgot_password");
	}

?>