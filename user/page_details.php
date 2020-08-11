<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$title= "DASHBOARD";
	include_once '../classes/institute.php';
	include_once '../library/Database.php';
	
	$userID = Session::get("usrid");
	
	$inst= new institute();
	
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
			header("Location:institute_list.php");
	} else {
		$ID = $_GET['ID'];
				
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Desc'])){
		$updateDetails = $inst->updateDetails($_POST,$ID);
	}
	if (empty($userID)) {
		header("Location:sign_in.php");
	}else {
		$Info = $inst->getInfoByInsId($ID);
		if (isset($Info) && !empty($Info)){
			$value = $Info->fetch_assoc();
		}
	}
	if ($value['userID'] != $userID){
		header('location:institute_list.php');
	}
	
?>
<?php include'includes/dheader.php' ;?>

    <div class="container-fluid"  style=" margin-top: 50px;">
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>

        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
                    <span class="top_location"><a href="dashboard.php">dashboard</a> ><a href="institute-list.php">All Institutes</a> > <a href="edit_institute.php?ID=<?php echo $ID;?>"><?php echo $value['InstituteName']?></a> > </span>
          <div class="scrollmenu">
            <a href="page_details.php?ID=<?php echo $ID;?>"><font color="green">Home</font></a> 
            <a href="product_list.php?ID=<?php echo $ID;?>">Product/Service</a> 
            <a href="map.php?ID=<?php echo $ID;?>">Map</a>  
            <a href="edit_contact.php?ID=<?php echo $ID;?>">Contact</a> 
          </div>
          <style>
	div.scrollmenu {
		background-color: #333;
		overflow: auto;
		white-space: nowrap;
	}

	div.scrollmenu a {
		display: inline-block;
		color: white;
		text-align: center;
		padding: 14px;
		text-decoration: none;
	}

	div.scrollmenu a:hover {
		background-color: #777;
	}
</style>
          <br>
          <hr>
          <h4 class="page_details">Page Details</h4>
          <br>
		  <?php if (isset($updateDetails)) {
		echo $updateDetails;
	}
	?>
          <form action="" method="post" enctype="multipart/form-data">
            Description:
            <textarea name="Description" rows="6" cols="4" class="form-control"><?php echo $value['Description'] ?></textarea>
			<button type="submit" name="Desc" class="btn btn-default pull-right">Save</button>
            </form>
        </div>
      </div>
    </div>
<?php include 'includes/footer.php'?>