<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkAdminSession();
	Session::init();
	include_once '../library/Database.php';
	$db = new Database();
	if(isset($_POST['image'])){
	    $s=$_POST['image'];
    	$_SESSION['cropimg'] = $s;
	}
	else {
	    $s = $_SESSION['cropimg'] ;
	}
	$inid = $_POST['inid'];
	if (isset($_FILES['croppedImage'])){
	$croppedImage = $_FILES['croppedImage'];
	$to_be_upload = $croppedImage['tmp_name'];
	move_uploaded_file($to_be_upload, $s);
	$image = imagecreatefrompng($s);
    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);
    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    imagedestroy($image);
    $quality = 90; // 0 = worst / smaller file, 100 = better / bigger file 
    
   
	imagejpeg($bg, $s, $quality);
    imagedestroy($bg);
	$_SESSION['cropimg'] = NULL;
	}
	
?>
<?php
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: max-age=2592000");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="../user/css/cropper.css" />
<script type="text/javascript" src="../user/js/cropper.js"></script>
<style>
				.cropper-crop {
					display: none;
				}
				.cropper-bg {
					background: none;
				}
			</style>
<img style="width: 70%;" id="image" src="<?php echo $s; ?>" alt="">
			
			<script>
				$("#image").cropper();
			
				function crop() {
					$("#image").cropper('getCroppedCanvas').toBlob(function (blob) {
					  var formData = new FormData();
					  formData.append('croppedImage', blob);

					  $.ajax('', {
					    method: "POST",
					    data: formData,
					    processData: false,
					    contentType: false,
					    success: function () {
					      window.history.back();
					      
					    },
					    error: function () {
					      console.log('Upload error');
					    }
					  });
					});
				}
			</script>
			<button id="crop" class="btn btn-primary btn-lg center-block" onClick=" crop(); ">Crop</button>
			

