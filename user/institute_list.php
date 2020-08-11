<?php
	ob_start();
	include_once '../library/Session.php';
	include_once '../library/Database.php';
	Session::checkUserSession();
	Session::init();
	include_once '../classes/institute.php';
	$userID = Session::get("usrid");
	$inst= new institute ();
	$db   = new Database();
	if (isset($_GET['delID'])) {
		$delID = $_GET['delID'];
		$delinstitute = $inst->delInstituteById($delID);
	}
?>
<?php 
	$title="Users List of digitalbazar.info";
	include'includes/dheader.php' ;
?>

    <div class="container-fluid" >
      <div class="row">
        <?php include 'includes/dsidemenu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard">dashboard</a> > 
          <br>
          <hr>
          <h4 class="add_product"> ALL INSTITUTES </h4> 
		  <a href="add_institute">Add new institute</a>
          <br>
	
	<table class="table table-striped">
		<thead>
			<tr>
				<th> Serial no. </th>
				<th> Institute name  </th>
				<th> Total Product </th>
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
				$query = "SELECT *
					FROM tb_institute 
					WHERE userID = $userID
					ORDER BY  InstituteID DESC LIMIT $start_form,$per_page";
				$getin= $db->select($query);
				
				if ($getin){
					$i = 1;
					while ($result = $getin->fetch_assoc()){
						$inID=$result['InstituteID'];
						$query = "SELECT *
						FROM tb_content 
						WHERE InstituteID = $inID";
						$getpro= $db->select($query);
						$totalpro= mysqli_num_rows($getpro);
						
			?>
		<tbody>
			
			<tr>
				<td><?php echo $start_form+$i ; ?></td>
				<td><a href="<?php echo web_root; ?>institute/<?php echo $result['InstituteName']; ?>-<?php echo $result['InstituteID']; ?>" target="_blank"><?php echo $result['InstituteName']; ?></a></td>
				<td><a href="product_list?ID=<?php echo $result['InstituteID']; ?>"><?php if (isset($totalpro)){ echo $totalpro; } else { echo "0";} ?></a></td>
				<td><a href="edit_institute?ID=<?php echo $result['InstituteID']; ?>">Edit</a> || <a onclick="return confirm('Are you sure to delete?')" href="?delID=<?php echo $result['InstituteID']; ?>">Delete</a></td>
			</tr>
					
				
				<?php $i++; }} ?>
		</tbody>
	</table>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
                    <hr>
			<?php
				$getInstutes = $inst->getInfoById($userID);
				if(!empty($getInstutes)){
					$total_rows= mysqli_num_rows($getInstutes);
					$total_pages= ceil($total_rows/$per_page);
					if( $total_pages >> 1 ){
			?>
			
			<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?page=1" > First Page</a></div>
                 	<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?page=<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pagenumber">
                    	<ul>
				<?php if ($page > 3){?>
				<a href="?page=<?php echo $page-3; ?>"><li><?php echo $page-3; ?></li></a>
				<?php }
				if ($page > 2){
				?>
				<a href="?page=<?php echo $page-2; ?>"><li><?php echo $page-2; ?></li></a>
				<?php }
				if ($page > 1){
				?>
				<a href="?page=<?php echo $page-1; ?>"><li><?php echo $page-1; ?></li></a>
				<?php } ?>
                            <a href="?page=<?php echo $page; ?>" style="color: #ff9933;"><li ><?php echo $page; ?></li></a>
                            <?php
                            if ($page+1 <= $total_pages){
                            ?>
                            <a href="?page=<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
                            <?php }
                            if ($page+2 <= $total_pages){
                            ?>
                            <a href="?page=<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
                            <?php }
                            if ($page+3 <= $total_pages){
                            ?>
                            <a href="?page=<?php echo $page+3; ?>"><li><?php echo $page+3; ?></li></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><?php
                            if ($page != $total_pages){
                            ?>
                    <a href="?page=<?php echo $page+1; ?>"> Next Page &gt;&gt;</a>
                    <?php } ?></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?page=<?php echo $total_pages ?>"> Last Page</a></div>
			<?php
			}} ?>
			</div>
			
        </div>
      </div>
    </div>
<?php include 'includes/footer.php'; ?>