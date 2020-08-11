<?php
	ob_start();
	include_once '../library/Session.php';
	Session::CheckAdminSession();
	Session::init();
	
?>
<?php
	$title="DASHBOARD - digitalbazar.info";
	include 'header.php';
?>
<div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
        
		
		<div class="alert alert-success">
			<strong>Welcome back!</strong> Admin Sir!
		</div>
		
		
		
      </div>
    </div>
	</div>

<?php include 'footer.php';?>