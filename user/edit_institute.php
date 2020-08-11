<?php
	ob_start();
	include_once '../classes/institute.php';
	include_once '../classes/category.php';
	include_once '../classes/content.php';
	include_once '../library/Database.php';
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$userID = Session::get("usrid");
	if (!isset($userID)){
		header('Location:sign_in.php');
	}
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
			header("Location:institute_list.php");
	} else {
		$ID = $_GET['ID'];
				
	}
	$inst= new institute();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])){
		$LogoUp = $inst->updateName($_POST,$ID);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logo'])){
		$LogoUp = $inst->uploadLogo($_POST,$_FILES,$ID);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cover'])){
		$CoverPicUp = $inst->uploadCoverPic($_POST,$_FILES,$ID);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['openHour'])){
		$OpenHourUp = $inst->updateOpenHour($_POST,$ID);
	}
	$Info = $inst->getInfoByInsId($ID);
	if (empty($Info)){
		header("Location:add_institute.php");
	}
	else{
		$value = $Info->fetch_assoc();
	}
	if (isset($_FILES['croppedImage'])){
		$croppedImage = $_FILES['croppedImage'];
		$to_be_upload = $croppedImage['tmp_name'];
		move_uploaded_file($to_be_upload, $value['logo']);
		echo 1;
	}
	if (isset($_FILES['croppedCover'])){
		$croppedCover = $_FILES['croppedCover'];
		$to_be_upload = $croppedCover['tmp_name'];
		move_uploaded_file($to_be_upload, $value['CoverPic']);
		echo 1;
	}
	if ($value['userID'] != $userID){
		header('location:institute_list.php');
	}
	$title="Edit ".$value['InstituteName']." Details";
	include 'includes/dheader.php';
?>
<div class="container-fluid"  style=" margin-top: 50px;">
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard">dashboard</a> > <a href="edit_institute"><?php echo $value['InstituteName'] ?></a> > </span>
 <div class="row">
          <div class="scrollmenu">
              
            <a href="page_details?ID=<?php echo $ID;?>">Home</a>
            <a href="product_list?ID=<?php echo $ID;?>">Product/Service</a>
            <a href="map?ID=<?php echo $ID;?>">Map</a>
            <a href="edit_contact?ID=<?php echo $ID;?>">Contact</a>
           
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
          </div>
          <br>
          <hr>
          <h4 class="add_product">INSTITUTE INFORMATIONS</h4>
          <br>
		  <div class="container" style="width: 500px;">
			<form action="" method="post">
				Institute Name: <input type="text" class="form-control" name="InstituteName" value="<?php echo $value['InstituteName'] ?>" />
				<button type="submit" name="name" class="btn btn-primary pull-right">Update</button>
			</form>
		  </div>
		  <hr />
		  <div class="container" style="width: 500px;" >
		 <?php 
			if (isset($LogoUp)) {
				echo $LogoUp;
			}
		?>
		<div class="logo-crop">
		<img style="height: 250px;" src="<?php echo $value['logo'] ?>" alt="">
	<!--	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#logocrop">crop</button> -->
			
			</div>
          <form action="" method="post" enctype="multipart/form-data" >
            <fieldset class="form-group">
              <label for="exampleInputname">Upload Logo (500x500) <font color="red"> *</font> </label>
              <input type="file"  name="logo">
            </fieldset>
            
            <button type="submit" name="logo" class="btn btn-primary pull-right">Upload</button>
          </form>
          
          
		  </div>
		  <hr />
		  <div  class="container" style="width: 500px;">
		  <?php 
			if (isset($CoverPicUp)) {
				echo $CoverPicUp;
			}
		?>
		<div class="Cover-crop">
		<img style="height: 250px;" src="<?php echo $value['CoverPic'] ?>" alt="">
		<form action="crop" method="post">
			<input type="hidden" name="image" value="<?php echo $value['CoverPic']; ?>" >
			<input type="hidden" name="inid" value="<?php echo $ID; ?>" >
		<button type="submit" class="btn btn-info btn-lg " >Crop</button>
		</form>
		<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Crop</button> -->
			</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Select crop area</h4>
                </div>
                <div class="modal-body">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/cropper.css" />
<script type="text/javascript" src="js/cropper.js"></script>
<style>
				.cropper-crop {
					display: none;
				}
				.cropper-bg {
					background: none;
				}
			</style>
<img style="height: 500px;" id="image" src="<?php echo $value['CoverPic']; ?>" alt="">
			
			<script>
				$("#image").cropper();
			
				function crop() {
					$("#image").cropper('getCroppedCanvas').toBlob(function (blob) {
					  var formData = new FormData();
					  formData.append('croppedCover', blob);

					  $.ajax('', {
					    method: "POST",
					    data: formData,
					    processData: false,
					    contentType: false,
					    success: function () {
					      alert('Upload success');
					      
					    },
					    error: function () {
					      console.log('Upload error');
					    }
					  });
					});
				}
			</script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-lg" id="crop" onClick=" crop(); ">Crop</button>
                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Exit</button>
                </div>
              </div>
              
            </div>
          </div>
			<!-- Modal close-->
		  <form action="" method="post" enctype="multipart/form-data">
            <fieldset class="form-group">
              <label for="exampleInputname">Upload Cover Photo ( 851 x 315 )<font color="red"> *</font> </label>
              <input type="file"  name="CoverPic">
            </fieldset>
            
            <button type="submit" name="cover" class="btn btn-primary pull-right">Upload</button>
          </form>
		 </div>
		 <hr />
		 <div class="container open_hour" style="width: 500px;">
		  <form action="" method="post" enctype="multipart/form-data">
			
				<table>
				<?php
					if (isset($OpenHourUp)){
						echo $OpenHourUp;
					}
					
					
				?>
				  <tr>
					<td>Open Hour:</td>
					<td>Saturday</td>
					<td>:</td>
					<td><input type="text" name="SaturdayOpen" class="time" value="<?php echo $value['SaturdayOpen'] ?>">am</td>
					<td><input type="text" name="SaturdayClose" class="time" value="<?php echo $value['SaturdayClose'] ?>">pm</td>
				  </tr>
				  <tr>
					<td></td>
					<td>Sunday</td>
					<td>:</td>
					<td><input type="text" name="SundayOpen" class="time" value="<?php echo $value['SundayOpen'] ?>">am</td>
					<td><input type="text" name="SundayClose" class="time" value="<?php echo $value['SundayClose'] ?>">pm</td>
				  </tr>
				  <tr>
					<td></td>
					<td>Monday</td>
					<td>:</td>
					<td><input type="text" name="MondayOpen" class="time" value="<?php echo $value['MondayOpen'] ?>">am</td>
					<td><input type="text" name="MondayClose" class="time" value="<?php echo $value['MondayClose'] ?>">pm</td>
				  </tr>
				  <tr>
					<td></td>
					<td>Tuesday</td>
					<td>:</td>
					<td><input type="text" name="TuesdayOpen" class="time" value="<?php echo $value['TuesdayOpen'] ?>">am</td>
					<td><input type="text" name="TuesdayClose" class="time" value="<?php echo $value['TuesdayClose'] ?>">pm</td>
				  </tr>
				  <tr>
					<td></td>
					<td>Wednesday</td>
					<td>:</td>
					<td><input type="text" name="WednesdayOpen" class="time" value="<?php echo $value['WednesdayOpen'] ?>">am</td>
					<td><input type="text" name="WednesdayClose" class="time" value="<?php echo $value['WednesdayClose'] ?>">pm</td>
				  </tr>
				  <tr>
					<td></td>
					<td>Thusday</td>
					<td>:</td>
					<td><input type="text" name="ThursdayOpen" class="time" value="<?php echo $value['ThursdayOpen'] ?>">am</td>
					<td><input type="text" name="ThursdayClose" class="time" value="<?php echo $value['ThursdayClose'] ?>">pm</td>
				  </tr>
				  <tr>
					<td></td>
					<td>Friday</td>
					<td>:</td>
					<td><input type="text" name="FridayOpen" class="time" value="<?php echo $value['FridayOpen'] ?>">am</td>
					<td><input type="text" name="FridayClose" class="time" value="<?php echo $value['FridayClose'] ?>">pm</td>
				  </tr>
					
				</table>
				
				<button type="submit" name="openHour" class="btn btn-default pull-right">Update</button>
         
		  </form>
        </div>
      </div>
    </div>
	</div>
<?php include 'includes/footer.php'; ?>
<script src="js/select2.min.js"></script>
<script>
	$('select').select2();
</script>
<script>
				
				
				
			</script>
			
