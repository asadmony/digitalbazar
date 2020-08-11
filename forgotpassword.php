<?php
	ob_start();
	include_once 'classes/password.php';
	$pass = new password ();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])){
		$status = $pass->chkmail($_POST);
	}
	
?>
<?php 
	$title = "Forgot password - Directory of Bangladesh";
	include_once 'includes/header.php';
?>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-3 col-md-3 clo-sm-3 col-xs-12 db_maplogo">
						<img src="<?php echo web_root; ?>user/images/big-logo-db.jpg" alt="" class="img-responsive">
    		</div>

    		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:100px;">
				<h3 class="personal_details">Forgot Password</h3>
    				
    				<?php 
					if (isset($status)){
						echo $status;
					}
				?>
    				<form action="" method="post">
				  <div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="email" type="email" class="form-control" name="emailornum" placeholder="Your Email Address">
				  </div>
				  
				  <button type="submit" name="email" class="btn btn-success">Next</button>
				  </form>
				  <br>
				  
    	</div>
  </div>
</div>
<?php include 'includes/footer.php' ;?>