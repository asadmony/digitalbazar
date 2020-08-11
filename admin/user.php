<?php
	ob_start();
	include_once '../library/Session.php';
	include_once '../library/Database.php';
	Session::checkAdminSession();
	Session::init();
	include_once '../classes/user.php';
	$usr= new user();
	$db = new Database();
		if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:users_list.php");
	} else {
		$userID = $_GET['ID'];
	}
		$ProDetails= $usr->getAllInfoByUser($userID);
		if ($ProDetails){
			$result = $ProDetails->fetch_assoc();
		}
?>
<?php
	$title = $result['name'];
	include'header.php' ;
?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
    <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> > <a href="users_list.php">All Users</a> > </span>
          <h2 class="page_details">Profile Details</h2>

<table  class="table table-condensed">
		<?php 
			
			
				?>
				<tr>
					
					<td><img src="../user/<?php echo $result['ProfilePic']; ?>" alt="<?php echo $result['username']; ?>" style="height: 250px;" /></td>
				</tr>
				<tr>
					<td><strong>Total refers :</strong></td>
					<?php
						$refer=$usr->countrefer($result['MobileNo']);
						
					?>
					<td><?php 
								if (isset($refer)){
									echo $refer;
								}
							?>
							<hr />
					</td>
				</tr>
				<tr>
					<td><strong>Full Name :</strong></td>
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
			<h4 class="page_details"> Institutes by this user </h4>
			<table class="table table-condensed">
				<tr>
					<th> Serial no. </th>
					<th> Institute Name </th>
					<th> Total Products </th>
				</tr>
				<tr>
				<?php
					$get = $usr->getInstByUser($userID);
					if ($get){
						$i = 1;
						while ($inst= $get->fetch_assoc()){
							$inID=$inst['InstituteID'];
							$q = "SELECT *
							FROM tb_content 
							WHERE InstituteID = $inID";
							$getpro= $db->select($q);
							$totalpro= mysqli_num_rows($getpro);
				?>
					
				</tr>
				<tr>
					<td><?php echo $i;?></td>
					<td><a href="institute.php?ID=<?php echo $inst['InstituteID']; ?>" target="_blank"><?php echo $inst['InstituteName']; ?></a></td>
					<td><a href="../products.php?ID=<?php echo $inst['InstituteID']; ?>" target="_blank"><?php if (isset($totalpro)){ echo $totalpro; } else { echo "0";} ?></a></td>
				</tr>
				<?php }} ?>
			</table>
        </div>
    </div>
    </div>
<?php include 'footer.php';?>
