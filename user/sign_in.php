<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkUserLogin();
	Session::init();
	include_once '../classes/user.php';
	$usr = new user ();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
		$userLog = $usr->userLogin($_POST);
	}

?>
<?php 
	$title = "User Sign In";
	include_once 'includes/dheader.php';
?>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-3 col-md-3 clo-sm-3 col-xs-12 db_maplogo">
						<img src="images/big-logo-db.jpg" alt="" class="img-responsive">
    		</div>

    		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-top:100px;">
				<?php 
					if (isset($userLog)){
						echo $userLog;
					}
				?>
    			<form action="" method="post">
    				<label for="exampleInputEmail1">Sing In</label>
				  <div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="email" type="text" class="form-control" name="emailornum" placeholder="Email Address / Mobile Number">
				  </div>
				  <div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="pass" placeholder="************">
				  </div>
				  <br />
				  <button type="submit" name="login" class="btn btn-success">Log in</button>
				  <br>
				  <br>
				  
				</form>
				<a href="../forgot_password">Forgot passward?</a>
				  <br>
				  <br>
					<span>Don't Have a Digital Bazar Account ?</span><br>
				<br>
				  <a href="register.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">REGISTER</a>
    	


</div>
  </div>
</div>
<?php include '../includes/footer.php' ; ?>
