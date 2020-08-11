<?php
	ob_start();
	include_once '../library/Session.php';
	include_once '../library/Database.php';
	Session::checkAdminSession();
	Session::init();
	$db = new Database ();
	include_once '../classes/admin.php';
	$admin= new admin ();
	if (isset($_GET['ID'])) {
		$id = $_GET['ID'];
		$deluser = $admin->delUserById($id);
	}
?>
<?php 
	$title="Users List of digitalbazar.info";
	include'header.php' ;
?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> > 
          <br>
          <hr>
          <h4 class="add_product"> Users of Digitalbazar.info</h4>
          <br>

			<table class="table table-striped">
				<thead>
					<tr>
						<th> Serial no. </th>
						<th> User's name  </th>
						<th> Email </th>
						<th> Mobile Number </th>
						<th> Total referred </th>
						<th> Options <br />  </th>
						
					</tr>
				</thead>
					<?php
						if(isset($deluser)){
							echo $deluser;
						}
						$per_page = 20;
						$getUsers = $admin->getAllUser();
						if(isset($getUsers)){
							$total_rows= mysqli_num_rows($getUsers);
							$total_pages= ceil($total_rows/$per_page);
						}
						if(isset($_GET["page"])){
							$page = $_GET["page"];
						}else{
							$page = 1;
						}
						$start_form = ($page-1)*$per_page;
						$query = "SELECT *
							FROM tb_user 
							ORDER BY userID DESC LIMIT $start_form,$per_page";
						$getusr= $db->select($query);
						
						if ($getusr){
							$i = 1;
							while ($result = $getusr->fetch_assoc()){
					?>
				<tbody>
					
					<tr>
						<td><?php echo $start_form+$i ; ?></td>
						<td><a href="user.php?ID=<?php echo $result['userID']; ?>" target="_blank"><?php echo $result['name']; ?></a></td>
						<td><?php echo $result['email']; ?></td>
						<td><?php echo $result['MobileNo']; ?></td>
						<td><?php $getrefercount = $admin->countrefer($result['MobileNo']);
										if(isset($getrefercount)){
											echo $getrefercount;
										}else{
											echo "0";
										}
								?></td>
						<td><a href="edit_user.php?ID=<?php echo $result['userID']; ?>">Edit</a> || <a onclick="return confirm('Are you sure to delete?')" href="users_list.php?ID=<?php echo $result['userID']; ?>">Delete</a></td> 
					</tr>
							
						
						<?php $i++; }} ?>
				</tbody>
			</table><hr>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
			<?php if ($total_pages > 1) { ?>
						
				<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?page=1" > First Page</a></div>
						<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?page=<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
						<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pagenumber">
							<ul>
					<?php
						if($page-1>0){
							$pp=$page-1;
							$ppp=$page-2;
					?>
					<a href="?page=<?php echo $ppp; ?>"><li><?php echo $ppp; ?></li></a>
					<a href="?page=<?php echo $pp; ?>"><li><?php echo $pp; ?></li></a>
					<?php } ?>
								<a href="?page=<?php echo $page; ?>"><li><?php echo $page; ?></li></a>
								<a href="?page=<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
								<a href="?page=<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
							</ul>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?page=<?php echo $page+1; ?>"> Next Page &gt;&gt;</a></div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?page=<?php echo $total_pages; ?>"> Last Page</a></div>	
				<?php }?>
			</div>

		</div>
        </div>
     </div>
	  
<?php include 'footer.php'; ?>