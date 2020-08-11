<?php
ob_start();
include_once '../library/Session.php';
Session::checkUserSession();
Session::init();
include_once '../classes/user.php';
include_once '../helpers/Format.php';
include_once '../library/Database.php';
$usr= new user();
$login = Session::get("userlog");
$userID = Session::get("usrid");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pic'])){
	$upPic= $usr->changeProfilePic($_POST,$_FILES,$userID);
}

$ProDetails= $usr->getAllInfoByUser($userID);
$title=Session::get("usrName");

?>

<?php include'includes/dheader.php' ;?>
<link rel="stylesheet" href="cropper.min.css" />
<div class="container-fluid"  style=" margin-top: 50px;">
	<div class="row">

		<?php include 'includes/dsidemenu.php';?>
		
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
			<span class="top_location"><a href="dashboard.php">dashboard</a> > 
				<h2 class="page_details">Profile Details</h2>

				<table  class="table table-condensed">
					<?php 
					if(isset($upPic)){
						echo $upPic;
					}
					if ($ProDetails){
						$result = $ProDetails->fetch_assoc();

						?>
						<?php
						if (isset($_FILES['croppedImage'])){
							$croppedImage = $_FILES['croppedImage'];
							$to_be_upload = $croppedImage['tmp_name'];
							move_uploaded_file($to_be_upload, $result['ProfilePic']);
							echo 1;
						}
						?>
						<tr>

							<td>
							<?php if($result['ProfilePic'] != ''){?>
								<img src="<?php echo $result['ProfilePic']; ?>" alt="<?php echo $result['username']; ?>" style="height: 250px;" />
								<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Crop</button>
							<?php } ?>
							</td>
							<td>
								<br /> <br />
								<form action="" method="post" enctype="multipart/form-data">
									Change Profile Picture :<input type="file" name="ProfilePic" />
									<button type="submit" name="pic" class="btn btn-success pull-right">Upload</button>
								</form>
							</td>
						</tr>

						<tr>
							<td><strong>Name :</strong></td>
							<td><?php echo $result['name']; ?></td>
						</tr>
						<tr>
							<td><strong>Email :</strong></td>
							<td><?php echo $result['email']; ?></td>
						</tr>
						<tr>
							<td><strong>Reference Mobile number:</strong></td>
							<td><?php echo $result['ReferrersMobNo']; ?></td>
						</tr>
					</table>
				<?php } ?>

			</div>
		</div>
	</div>


	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">

					<style>
						.cropper-crop {
							display: none;
						}
						.cropper-bg {
							background-color: none;
						}
					</style>
					<img style="height: 500px;" id="crop" src="<?php echo $result['ProfilePic']; ?>" alt="">

					<button  onclick="crop() ">Crop</button>
					<script>
						$("#lcrop").cropper();

						function crop(){
							$("#crop").cropper('getCroppedCanvas').toBlob(function (blob) {
								var formData = new FormData();
								formData.append('croppedImage', blob);

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
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<?php include 'includes/footer.php'?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="cropper.min.js"></script>