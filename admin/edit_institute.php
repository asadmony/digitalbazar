<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkAdminSession();
	Session::init();
	include_once '../classes/institute.php';
	include_once '../classes/admin.php';
	$admin = new admin ();
	$inst = new institute ();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:institutes_list.php");
	} else {
		$InstituteID = $_GET['ID'];
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logo'])){
		$LogoUp = $admin->uploadLogo($_POST,$_FILES,$InstituteID);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cover'])){
		$CoverPicUp = $admin->uploadCoverPic($_POST,$_FILES,$InstituteID);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
		$UpdateInstitute = $inst->updateInstitute($_POST,$InstituteID);
	}
	$getIns = $inst->getInfoByInsId($InstituteID);
	if (isset($getIns)){
		$value = $getIns->fetch_assoc();
	}
?>
<?php
	$title="Edit Institute Details";
	include 'header.php';
?>
  <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
        <a href="dashboard.php">dashboard</a> > <a href="institutes_list.php">All Institutes </a> >
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-top:100px;">
				<h4  class="personal_details">Update Images</h4>
				<div class="container" style="width: 500px;" >
					 <?php 
						if (isset($LogoUp)) {
							echo $LogoUp;
						}
					?>
					<img style="height: 250px;" src="../user/<?php echo $value['logo'] ?>" alt="">
					<form action="" method="post" enctype="multipart/form-data">
						<fieldset class="form-group">
						  <label for="exampleInputname">Select a Logo (500x500) <font color="red"> *</font> </label>
						  <input type="file"  name="logo">
					    </fieldset>
						
						<button type="submit" name="logo" class="btn btn-primary pull-right">Upload</button>
					</form>
				</div>
				<div  class="container" style="width: 500px;">
					  <?php 
						if (isset($CoverPicUp)) {
							echo $CoverPicUp;
						}
					?>
					<img style="height: 250px;" src="../user/<?php echo $value['CoverPic'] ?>" alt="">
					<form action="crop.php" method="post">
            			<input type="hidden" name="image" value="../user/<?php echo $value['CoverPic']; ?>" >
            			<input type="hidden" name="inid" value="<?php echo $InstituteID; ?>" >
            		<button type="submit" class="btn btn-info btn-lg " >Crop</button>
            		</form>
					  <form action="" method="post" enctype="multipart/form-data">
						<fieldset class="form-group">
						  <label for="exampleInputname">Select a Cover Photo (851x315)<font color="red"> *</font> </label>
						  <input type="file"  name="CoverPic">
						</fieldset>
						
						<button type="submit" name="cover" class="btn btn-primary pull-right">Upload</button>
					  </form>
				</div>
				<?php
					if (isset($UpdateInstitute)){
						echo $UpdateInstitute;
					}
				?>
    			<form action="" method="post" enctype="multipart/form-data">
				 
				  <h4  class="personal_details">Institute or Company Information</h4>
				  Institute/Company Name:<input type="text" class="form-control" name="InstituteName" value="<?php echo $value['InstituteName']; ?>">
				  Location:<input type="text" class="form-control" name="Location" value="<?php echo $value['Location']; ?>">
				  Division*:
				  <div class="form-group">
					  <select class="form-control" name="Division" id="sel1">
					    <option selected value="<?php echo $value['Division']; ?>" ><?php echo $value['Division']; ?></option>
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
				  <div class="open_hour">
					<table>
					  <tr>
						<td>Open Hour: </td>
						<td>Saturday</td>
						<td>:</td>
						<td><input type="text" name="SaturdayOpen" class="time" value="<?php echo $value['SaturdayOpen']; ?>">am </td>
						<td>  </td>
						<td><input type="text" name="SaturdayClose" class="time" value="<?php echo $value['SaturdayClose']; ?>">pm</td>
					  </tr>
					  <tr>
						<td></td>
						<td>Sunday</td>
						<td>:</td>
						<td><input type="text" name="SundayOpen" class="time" value="<?php echo $value['SundayOpen']; ?>">am</td>
						<td></td>
						<td><input type="text" name="SundayClose" class="time" value="<?php echo $value['SundayClose']; ?>">pm</td>
					  </tr>
					  <tr>
						<td></td>
						<td>Monday</td>
						<td>:</td>
						<td><input type="text" name="MondayOpen" class="time" value="<?php echo $value['MondayOpen']; ?>">am</td>
						<td></td>
						<td><input type="text" name="MondayClose" class="time" value="<?php echo $value['MondayClose']; ?>">pm</td>
					  </tr>
					  <tr>
						<td></td>
						<td>Tuesday</td>
						<td>:</td>
						<td><input type="text" name="TuesdayOpen" class="time" value="<?php echo $value['TuesdayOpen']; ?>">am</td>
						<td></td>
						<td><input type="text" name="TuesdayClose" class="time" value="<?php echo $value['TuesdayClose']; ?>">pm</td>
					  </tr>
					  <tr>
						<td></td>
						<td>Wednesday</td>
						<td>:</td>
						<td><input type="text" name="WednesdayOpen" class="time" value="<?php echo $value['WednesdayOpen']; ?>">am</td>
						<td></td>
						<td><input type="text" name="WednesdayClose" class="time" value="<?php echo $value['WednesdayClose']; ?>">pm</td>
					  </tr>
					  <tr>
						<td></td>
						<td>Thusday</td>
						<td>:</td>
						<td><input type="text" name="ThursdayOpen" class="time" value="<?php echo $value['ThursdayOpen']; ?>">am</td>
						<td></td>
						<td><input type="text" name="ThursdayClose" class="time" value="<?php echo $value['ThursdayClose']; ?>">pm</td>
					  </tr>
					  <tr>
						<td></td>
						<td>Friday</td>
						<td>:</td>
						<td><input type="text" name="FridayOpen" class="time" value="<?php echo $value['FridayOpen']; ?>">am</td>
						<td></td>
						<td><input type="text" name="FridayClose" class="time" value="<?php echo $value['FridayClose']; ?>">pm</td>
					  </tr>
					</table>
				</div>
				Description :<textarea class="form-control" name="Description" rows="3"><?php echo $value['Description']; ?>"</textarea>
				Email :<input type="text" class="form-control" name="Email" value="<?php echo $value['Email']; ?>">
				Phone:<input type="text" class="form-control" name="Phone" value="<?php echo $value['Phone']; ?>">
				Web Address:<input type="text" class="form-control" name="webAddress" value="<?php echo $value['webAddress']; ?>">
				Address :<input type="text" class="form-control" name="address" value="<?php echo $value['Address']; ?>">
				Enter Map iframe link: <textarea name="iframelink" rows="6" cols="4" class="form-control"><?php echo $value['iframelink'] ?></textarea>
				  

				  <button type="submit" name="update" class="btn btn-success pull-right">Submit</button>
				</form>
				<div>
				<br />
					<p>Already a user? <a href="sing_in.php">SING IN</a></p>
				</div>
			</div>
  </div>
</div>
<?php include 'footer.php'?>