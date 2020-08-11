<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkAdminSession();
	Session::init();
	include_once '../classes/admin.php';
	$admin= new admin();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:users_list.php");
	} else {
		$InstituteID = $_GET['ID'];
	}
	$instituteDetails= $admin->getInfoByInstId($InstituteID);
	if ($instituteDetails){
		$result = $instituteDetails->fetch_assoc();
	}
	$userID   = $result['userID'];
	$userinfo = $admin->getuserInfoById($userID);
	if ($userinfo){
		$value = $userinfo->fetch_assoc();
	}
?>
<?php
	$title = $result['InstituteName'];
	include'header.php' ;
?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
    <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
         <span class="top_location"><a href="dashboard.php">dashboard</a> > <a href="institutes_list.php">All Institutes</a> > </span>
		 <div class="row">
		  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="timelinepic">
			<img src="../user/<?php echo $result['CoverPic'] ?>">
		  </div>

	    </div>
		<div class="row">
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="profilepic">
				<img src="../user/<?php echo $result['logo'] ?>">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="company_name"><?php echo $result['InstituteName'] ?></h2>
		</div>
	</div>
          <h2 class="page_details">Institute Details</h2>

<table  class="table table-condensed">
				<tr>
					<td><strong>Institute Name :</strong></td>
					<td><?php echo $result['InstituteName']; ?></td>
				</tr>
				<tr>
					<td><strong>Owner:</strong></td>
					<td><?php echo $value['name']; ?></td>
				</tr>
				<tr>
					<td><strong>Location:</strong></td>
					<td><?php echo $result['Location']; ?></td>
				</tr>
				<tr>
					<td><strong>Open hours :</strong></td>
					<td>
					
						<table width="70%">
							<tr>
								<td>Saturday</td>
								<td align="right"><?php echo $result['SaturdayOpen'] ?>am-<?php echo $result['SaturdayClose'] ?>pm</td>
							</tr>
							<tr>
								<td>Sunday</td>
								<td align="right"><?php echo $result['SundayOpen'] ?>am-<?php echo $result['SundayClose'] ?>pm</td>
							</tr>
							<tr>
								<td>Monday</td>
								<td align="right"><?php echo $result['MondayOpen'] ?>am-<?php echo $result['MondayClose'] ?>pm</td>
							</tr>
							<tr>
								<td>Tuesday</td>
								<td align="right"><?php echo $result['TuesdayOpen'] ?>am-<?php echo $result['TuesdayClose'] ?>pm</td>
							</tr>
							<tr>
								<td>Wednesday</td>
								<td align="right"><?php echo $result['WednesdayOpen'] ?>am-<?php echo $result['WednesdayClose'] ?>pm</td>
							</tr>
							<tr>
								<td>Thursday</td>
								<td align="right"><?php echo $result['ThursdayOpen'] ?>am-<?php echo $result['ThursdayClose'] ?>pm</td>
							</tr>
							<tr>
								<td>Friday</td>
								<td align="right"><?php echo $result['FridayOpen'] ?>am-<?php echo $result['FridayClose'] ?>pm</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td><strong>Description :</strong></td>
					<td><?php echo $result['Description']; ?></td>
				</tr>
				<tr>
					<td><strong>Email :</strong></td>
					<td><?php echo $result['Email']; ?></td>
				</tr>
				<tr>
					<td><strong>Phone :</strong></td>
					<td><?php echo $result['Phone']; ?></td>
				</tr>
				<tr>
					<td><strong>Address :</strong></td>
					<td><?php echo $result['Address']; ?></td>
				</tr>
			</table>
        </div>
    </div>
    </div>
<?php include 'footer.php';?>
