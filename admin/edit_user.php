<?php
	ob_start();
	include_once '../library/Session.php';
	//Session::CheckAdminSession();
	Session::init();
	include_once '../classes/admin.php';
	include_once '../helpers/Format.php';
	$admin = new admin ();
		if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:users_list.php");
	} else {
		$ID = $_GET['ID'];
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edituser'])){
		$UpdateUserDetails = $admin->UpdateUser($_POST,$_FILES,$ID);
	}
?>
<?php 
	$title="Edit User Details";
	include'header.php'
?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> > <a href="users_list.php">All users</a> ></span>

          <br>
          <hr>
          <?php
					if (isset($UpdateUserDetails)){
						echo $UpdateUserDetails;
					}
					$getUser=$admin->getUserByID($ID);
					if(isset($getUser)){
						$result=$getUser->fetch_assoc();
					}
				?>
    			<form action="edit_user.php?ID=<?php echo $ID; ?>" method="post" enctype="multipart/form-data">
				  
				  <h4  class="personal_details">Edit User Details</h4><br />
				  <img src="../user/<?php echo $result['ProfilePic'];?>" alt="Profile Picture" width="150px" />
				  Full Name* :<input type="text" class="form-control" name="name" value="<?php echo $result['name'];?>" />
				  Email :<input type="Email" class="form-control" name="email" value="<?php echo $result['email'];?>" />
				  Mobile No. * :<input type="text" class="form-control" name="MobileNo" value="<?php echo $result['MobileNo'];?>" />
				  <br />
				  <input type="submit" name="edituser" value="Update" />
				</form>
        </div>
      </div>
    </div>
<?php include 'footer.php';?>