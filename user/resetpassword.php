<?php
	ob_start();
	include_once '../classes/password.php';
	include_once '../library/Database.php';
	$db = new Database();
	$pass = new password();
	if(isset($_GET['em'])){
		$email = $_GET['em'];
	}
	else{
		header("location:../forgot_password");
	}
	$cq = "SELECT confirm FROM tb_confirmation WHERE email = '$email'";
	$cqr = $db->select($cq);
	if(empty($cqr) || $cqr != 1 ){
		header("Location: login");
		exit;
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])){
		$status = $pass->change($_POST,$email);
	}
	
?>
<?php 
	$title = "Reset your password - Digitalbazar";
	include_once '../includes/header.php';
?>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-3 col-md-3 clo-sm-3 col-xs-12 db_maplogo">
						<img src="images/big-logo-db.jpg" alt="" class="img-responsive">
    		</div>

    		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-top:100px;">
				
    			<form action="" method="post">
    				<h3 class="personal_details">Reset your password</h3>
    				<?php 
						if (isset($status)){
							echo $status;
						}
					?>
				  <div class="input-group col-lg-4 col-md-4 col-sm-4 col-xs-12" >
					<input type="password" class="form-control" name="pass" placeholder="Enter new password">
					<br />
					<input type="password" class="form-control" name="cpass" placeholder="Enter the password again">
				  </div>
				  <br />
				  <button type="submit" name="change" class="btn btn-success">Save Password</button>
				  <br>

				  
				</form>
    	</div>
  </div>
</div>
<?php include 'includes/footer.php' ; ?>
