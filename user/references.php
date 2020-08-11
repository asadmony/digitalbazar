<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	include_once '../classes/user.php';
	include_once '../library/Database.php';
	$usr= new user();
	$db = new Database();
	$login = Session::get("userlog");
	$userID = Session::get("usrid");
	$number = Session::get("usrNum");
	
	$getTrfr= $usr->getTrefers($number);
	$refer=$usr->countrefer($number);
	
	$title="User's list referred by you - Directory of Bangladesh";
	
?>
<?php include'includes/dheader.php' ;?>

    <div class="container-fluid" style=" margin-top: 50px;">
    <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> > 
          <h2 class="page_details">Users referred by you</h2>
			<p style="color:green;">  Total refers by you : <?php 
								if (isset($refer)){
									echo $refer;
								}
							?></p> <hr /> 
<table class="table table-striped">
		<thead>
			<tr>
				<th> Serial no. </th>
				<th> Photo  </th>
				<th> Referred User's name </th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				$per_page = 20;
				if(isset($_GET["page"])){
					$page = $_GET["page"];
				}else{
					$page = 1;
				}
				$start_form = ($page-1)*$per_page;
				$query = "SELECT * FROM tb_user WHERE ReferrersMobNo = '$number'
					ORDER BY userID DESC LIMIT $start_form,$per_page";
				$getusr= $db->select($query);
				if (isset($getusr) && !empty($getusr)){
					$i = 0;
					while ($result = $getusr->fetch_assoc()){
						$i++;
			?>
			<tr>
				<td><?php echo $i ; ?></td>
				<td><img src="<?php echo $result['ProfilePic']; ?>" alt="<?php echo $result['name']; ?>" style="height: 80px;"/></td>
				<td><?php echo $result['name']; ?></td>
			</tr>
			<?php }}else{ echo "You have no refer!";} ?>
		</tbody>
	</table>
	<hr>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
                    
			<?php
				if(isset($getTrfr)){
					$total_rows= mysqli_num_rows($getTrfr);
					$total_pages= ceil($total_rows/$per_page);
					if($total_pages >> 1 ){
			?>
			
			<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?page=1" > First Page</a></div>
                 	<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?page=<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pagenumber">
                    	<ul>
				<?php
					if($page-1>0){
						$pp=$page-1;
						$ppp=$page-2;
						$pppp=$page-3;
				?>
				<a href="?page=<?php echo $pppp; ?>"><li><?php echo $pppp; ?></li></a>
				<a href="?page=<?php echo $ppp; ?>"><li><?php echo $ppp; ?></li></a>
				<a href="?page=<?php echo $pp; ?>"><li><?php echo $pp; ?></li></a>
				<?php } ?>
                            <a href="?page=<?php echo $page; ?>"><li><?php echo $page; ?></li></a>
                            <a href="?page=<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
                            <a href="?page=<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
                            <a href="?page=<?php echo $page+3; ?>"><li><?php echo $page+3; ?></li></a>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?page=<?php echo $page+1; ?>"> Next Page &gt;&gt;</a></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?page=<?php echo $total_pages ?>"> Last Page</a></div>	
			
			</div>
			<?php } } ?>
        </div>
      </div>
    </div>
<?php include 'includes/footer.php'?>