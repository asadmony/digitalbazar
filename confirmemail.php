<?php
	ob_start();
	include_once 'classes/password.php';
	$pass = new password();
	if (!isset($_GET['em']) || $_GET['em'] == NULL ){
		header("Location:forgot_password");
	} else {
		$email = $_GET['em'];
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Confirm'])){
		$data = $_POST;
		$status = $pass->confirm($data,$email);
	}
	
?>
<?php 
	$title = "Confirm email";
	include_once 'includes/header.php';
?>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-3 col-md-3 clo-sm-3 col-xs-12 db_maplogo">
						<img src="<?php echo web_root; ?>user/images/big-logo-db.jpg" alt="" class="img-responsive">
    		</div>

    		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-top:100px;">
				
    				<h3 class="personal_details">Confirm your email</h3>
    				<?php 
						if (isset($status)){
							echo $status;
						}
					?>
    				<p>An email has been sent with a confirmation code to your email address. Please check inbox or spam folder. Then enter the code below. </p>
    				
    			<form action="" method="post">
				  <div class="input-group col-lg-4 col-md-4 col-sm-4 col-xs-12" >
					<input type="text" class="form-control" name="confirmcode" placeholder="Enter the confirmation code">
				  </div>
				  <br />
				  <button type="submit" name="Confirm" class="btn btn-success">Confirm</button>
				  <br>

				  
				</form>
    	</div>
  </div>
</div>
<?php include 'includes/footer.php' ; ?>
