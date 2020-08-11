<?php
	ob_start();
	$title="Congratulation!!!";
	include'includes/header.php';
	
?>

<div class="container" style=" margin-top:70px;">
	<div class="alert alert-success">
  		<strong>Success!</strong> You are successfully Registered!
	</div>
	<div class="alert alert-info">
  		Please <a href="sign_in.php" class="alert-link">Sign In</a>.
	</div>
</div>

<?php include'includes/footer.php';?>