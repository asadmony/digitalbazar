<?php
    ob_start();
    $title ="Edit Contact Details";
	include_once '../classes/content.php';
	include_once '../classes/category.php';
	include_once '../classes/institute.php';
	include_once '../library/Database.php';
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$userID = Session::get("usrid");
	
	$inst= new institute();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
			header("Location:institute_list.php");
	} else {
		$ID = $_GET['ID'];
				
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$updateContact = $inst->updateContact($_POST,$ID);
	}
	if (!isset($userID)) {
		header("Location:sign_in.php");
	}else {
		$ContactInfo = $inst->getInfoByInsId($ID);
		if (!empty($ContactInfo)){
			$value = $ContactInfo->fetch_assoc();
		}else{
			header('location:institute_list.php');
		}
	}
	if ($value['userID'] != $userID){
		header('location:institute_list.php');
	}
	
?>
<?php include'includes/dheader.php'?>

    <div class="container-fluid" style="margin-top: 50px; padding-top: 0px;">
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> ><a href="institute-list.php">All Institutes</a> > <a href="edit_institute.php?ID=<?php echo $ID;?>"><?php echo $value['InstituteName']?></a> > </span>
	
          <div class="scrollmenu">
            <a href="page_details.php?ID=<?php echo $ID;?>">Home</a>    
            <a href="product_list.php?ID=<?php echo $ID;?>">Product/Service</a> 
            <a href="map.php?ID=<?php echo $ID;?>">Map</a>  
            <a href="edit_contact.php?ID=<?php echo $ID;?>"><font color="green">Contact</font></a>  
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
          <h4 class="add_product">Edit Product or Service</h4>


	<?php if (isset($updateContact)) {
		echo $updateContact;
	}
	?>
	
	<form action="" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td>
				<strong>Email:</strong>
			</td>
			<td>
				<input class="form-control" type="email" name="Email" value="<?php echo $value['Email'] ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Phone:</strong>
			</td>
			<td>
				<input class="form-control" type="text" name="Phone" value="<?php echo $value['Phone'] ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Web Address:</strong>
			</td>
			<td>
				<input class="form-control" type="text" name="webAddress" value="<?php echo $value['webAddress'] ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Address:</strong>
			</td>
			<td>
				<input class="form-control" name="Address"  cols="30" rows="10"><?php echo $value['Address'] ?> />
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td>
				<br />
				<input type="submit" name="submit" value="save" />
			</td>
		</tr>
	</table>
	</form>
        </div>
      </div>
    </div>
<?php include 'includes/footer.php'; ?>
