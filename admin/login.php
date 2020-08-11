<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkAdminLogin();
	
	include_once '../classes/admin.php';
	$admin = new admin ();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
		$adminLog = $admin->adminLogin($_POST);
		header('Location:dashboard.php');
	}
	$title = "Admin Login";
	include_once 'header.php';
?>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-3 col-md-3 clo-sm-3 col-xs-12 db_maplogo">
						<img src="images/big-logo-db.jpg" alt="" class="img-responsive">
    		</div>

    		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:100px;">
				<?php 
					if (isset($adminLog)){
						echo $adminLog;
					}
				?>
    			<form action="" method="post">
					<h2 class="page_details">Admin Login</h2>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="email" type="text" class="form-control" name="adminUsername" placeholder="username">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" type="password" class="form-control" name="pass" placeholder="Password">
					</div>
				  <button type="submit" name="login" class="btn btn-success">Log in</button>
				  <br>
				  <br>
				  
				</form>
				
    	</div>
  </div>
</div>
<?php include 'footer.php' ; ?>
