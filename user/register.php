<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkUserLogin();
	include_once '../classes/user.php';
	$usr = new user ();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
		$userRegister = $usr->userReg($_POST,$_FILES);
	}
?>
<?php 
	$title="Register - Directory of Bangladesh";
	include'includes/header.php' ;
?>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-3 col-md-3 clo-sm-3 col-xs-12 db_maplogo">
						<img src="images/big-logo-db.jpg" alt="" class="img-responsive">
    		</div>
    		
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-top:100px;">
				
				<?php
					if (isset($userRegister)){
						echo $userRegister;
					}
				?>
    			<form action="" method="post" enctype="multipart/form-data">
				  
				  <h4  class="personal_details">Create a new account</h4>
				  Your Name* :<input type="text" class="form-control" name="name" placeholder="(example) Md. Rashed Islam">
				  Mobile Number* :<input type="text" class="form-control" name="MobileNo" placeholder="(example) 01516138655">
				  Re-enter Mobile Number* :<input type="text" class="form-control" name="MobileNo1" placeholder="Enter same mobile number">
				  Email Address :<input type="Email" class="form-control" name="email" placeholder="support@digitalbazar.info">
				  Enter Password* :<input type="password" class="form-control" name="pass" placeholder="You can enter number and letter (minimum 6 character)">
				  Reference Mobile Number :<input type="text" class="form-control" name="ReferrersMobNo" placeholder="(example) 01516138655">
				  <button type="submit" name="register" class="btn btn-success pull-right">Submit</button>
				</form>
				<div>
				<br />
					<p>(*) Starred fields must not be empty! </p> 
					<p>Already a user? <a href="login">SING IN</a></p>
				</div>
			</div>
  </div>
</div>
<?php include 'includes/footer.php'?>
