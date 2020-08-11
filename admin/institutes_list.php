<?php
	ob_start();
	include_once '../library/Session.php';
	include_once '../library/Database.php';
	Session::checkAdminSession();
	Session::init();
	include_once '../classes/admin.php';
	$adminUsername = Session::get("adminUsername");
	$admin= new admin ();
	$db   = new Database();
	if (isset($_GET['ID'])) {
		$id = $_GET['ID'];
		$delinstitute = $admin->delInstituteById($id);
	}
?>
<?php 
	$title="Users List of digitalbazar.info";
	include 'header.php' ;
?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> > 
          <br>
          <hr>
          <h4 class="add_product"> ALL INSTITUTES </h4>
          <br>
	
	<table class="table table-striped">
		<thead>
			<tr>
				<th> Serial no. </th>
				<th> Institute name  </th>
				<th> Location </th>
				<th> Phone </th>
				<th> Owner </th>
				<th> Options <br />  </th>
				
			</tr>
		</thead>
			<?php
				if(isset($delinstitute)){
					echo $delinstitute;
				}
				$per_page = 20;
				if(isset($_GET["page"])){
					$page = $_GET["page"];
				}else{
					$page = 1;
				}
				$start_form = ($page-1)*$per_page;
				$query = "SELECT u.*, i.*
					FROM tb_user as u, tb_institute as i
					WHERE u.userID = i.userID
					ORDER BY  InstituteID DESC LIMIT $start_form,$per_page";
				$getin= $db->select($query);
				
				if ($getin){
					$i = 1;
					while ($result = $getin->fetch_assoc()){
						
			?>
		<tbody>
			
			<tr>
				<td><?php echo $start_form+$i ; ?></td>
				<td><a href="institute.php?ID=<?php echo $result['InstituteID']; ?>" target="_blank"><?php echo $result['InstituteName']; ?></a></td>
				<td><?php echo $result['Location']; ?></td>
				<td><?php echo $result['Phone']; ?></td>
				<td><a href="user.php?ID=<?php echo $userID; ?>" target="_blank"><?php echo $result['name']; ?></a></td>
				<td><a href="edit_institute.php?ID=<?php echo $result['InstituteID']; ?>">Edit</a> || <a onclick="return confirm('Are you sure to delete?')" href="institutes_list.php?ID=<?php echo $result['InstituteID']; ?>">Delete</a></td>
			</tr>
					
				
				<?php $i++; }} ?>
		</tbody>
	</table>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
                    <hr>
			<?php
				$getInstutes = $admin->getAllInstitutes();
				if(isset($getInstutes)){
					$total_rows= mysqli_num_rows($getInstutes);
					$total_pages= ceil($total_rows/$per_page);
					if( $total_pages >> 1 ){
			?>
			
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
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?page=<?php echo $total_pages ?>"> Last Page</a></div>	
			<?php
			}} ?>
			</div>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>