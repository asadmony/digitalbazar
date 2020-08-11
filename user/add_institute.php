<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	include_once '../classes/user.php';
	include_once '../classes/institute.php';
	include_once '../library/Database.php';
	$inst = new institute ();
	$db = new Database ();
	$userID = Session::get("usrid");
	if (!isset($userID)){
		header('Location:sign_in.php');
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addinstitute'])){
		$data = $_POST;
		$addinstitute = $inst->addinstitute($data,$userID);
	}
	
?>
<?php
 	$title = "Add your institute";
 	include 'includes/dheader.php';
?>
<link rel="stylesheet" href="css/select2.min.css" />


    <div class="container-fluid"  style=" margin-top: 50px;">
    	<div class="row">
    		 <?php include 'includes/dsidemenu.php';?>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-top:100px;">
				<span class="top_location"><a href="dashboard.php">dashboard</a> > <a href="institute_list.php">ALL INSTITUTES</a> >  </span>
    				<h2>ADD NEW INSTITUTE</h2>
				<?php
					if (isset($addinstitute)){
						echo $addinstitute;
					}
				?>
    			<form action="" method="post">
				 
				  <h4  class="personal_details">Institute or Company Information</h4>
				  Institute/Company Name*:<input type="text" class="form-control" name="InstituteName">
				  Institute/Company Location*:<input type="text" class="form-control" name="Location">
				  Institute/Company Category*:<select class="form-control" name="SubCatID" >
																		<option selected disabled>Select one</option>
																		<?php
																			$q ="SELECT * FROM tb_institutesubcategory ORDER BY InstituteSubCategoryName ASC";
																			$getcat= $db->select($q);
																			if(!empty($getcat)){
																				while ($cat = $getcat->fetch_assoc()){
					
																	?>
																			<option value="<?php echo $cat['InstituteSubCategoryID'];?>"><?php echo $cat['InstituteSubCategoryName'];?></option>
																			<?php }}?> 
																	</select> 
																			
				  Institute/Company Category (optional):<select class="form-control" name="SubCatID2"  >
																			<option selected disabled>Select one</option>
																		<?php
																			$getcat= $db->select($q);
																			if(!empty($getcat)){
																				while ($cat = $getcat->fetch_assoc()){
					
																	?>
																			<option value="<?php echo $cat['InstituteSubCategoryID'];?>"><?php echo $cat['InstituteSubCategoryName'];?></option>
																			<?php }}?> 
																	</select> 
				  Institute/Company Category (optional):<select class="form-control" name="SubCatID3"  >
																			<option selected disabled>Select one</option>
																		<?php
																			$getcat= $db->select($q);
																			if(!empty($getcat)){
																				while ($cat = $getcat->fetch_assoc()){
					
																	?>
																			<option value="<?php echo $cat['InstituteSubCategoryID'];?>"><?php echo $cat['InstituteSubCategoryName'];?></option>
																			<?php }}?> 
																	</select> 
				  
																		
				  Division*:
				  <div class="form-group">
					  <select class="form-control" name="Division" id="sel1">
					    <option>Select one</option>
					    <option value="Barisal">Barisal</option>
					    <option value="Chittagong">Chittagong</option>
					    <option value="Dhaka">Dhaka</option>
					    <option value="Khulna">Khulna</option>
					    <option value="Mymensingh">Mymensingh</option>
					    <option value="Rajshahi">Rajshahi</option>
					    <option value="Rangpur">Rangpur</option>
					    <option value="Sylhet">Sylhet</option>
					  </select>
				  </div>
				  <br /> <br />
				  <input type="submit" name="addinstitute" value="SUBMIT" />
				</form>
				<div>
				<br />
				</div>
			</div>
  </div>
</div>


<?php include 'includes/footer.php'?>
<script src="js/select2.min.js"></script>
<script>
	$('select').select2();
</script>
