<?php
	ob_start();
	$title="DASHBOARD";
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$userID = Session::get("usrid");
	$name = Session::get("usrName");
	if (!isset($userID)){
		header('Location:sign_in.php');
	}

	include 'includes/dheader.php';
?>
<div class="container-fluid"   >
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
		<div class="alert alert-success">
  		 Welcome to Dashboard!!! <strong> Mr. <?php echo $name ;?></strong> 
		</div>
		
		
      </div>
    </div>
</div>
<?php include 'includes/footer.php'?>