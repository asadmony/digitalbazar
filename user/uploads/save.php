<?php
    $s = $_SESSION['cropimg'] ;
	header('location: '.$s);
	if (isset($_FILES['croppedImage'])){
	$croppedImage = $_FILES['croppedImage'];
	$to_be_upload = $croppedImage['tmp_name'];
	$ss = substr($s, 8) ;
	unlink($ss);
	move_uploaded_file($to_be_upload, $ss);
	}
?>