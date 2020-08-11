<?php
	ob_start();
	$title="List of Your Products and Services";
	include_once '../classes/content.php';
	include_once '../classes/category.php';
	include_once '../classes/institute.php';
	include_once '../helpers/Format.php';
	include_once '../library/Database.php';
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$db = new Database();
	$userID = Session::get("usrid");
	$fm = new Format();
	$cnt = new content();
	
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
			header("Location:institute_list.php");
	} else {
		$ID = $_GET['ID'];
				
	}
	$inst= new institute();
	
	$Info = $inst->getInfoByInsId($ID);
	if (!empty($Info)){
		$instInfo = $Info->fetch_assoc();
	}else{
		header('location:institute_list.php');
	}
	if ($instInfo['userID'] != $userID){
		header('location:institute_list.php');
	}
	$getTCnt= $cnt->getAllContentByInst($ID);
	
	if (isset($_GET['delcont'])) {
		$did = $_GET['delcont'];
		$delcontent = $cnt->delcontentById($did);
	}
?>
<?php include'includes/dheader.php' ;?>

    <div class="container-fluid"  style=" margin-top: 50px;">
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> ><a href="institute_list.php">All Institutes</a> > <a href="edit_institute.php?ID=<?php echo $ID;?>"><?php echo $instInfo['InstituteName']?></a> > </span>
          <div class="scrollmenu">
            <a href="page_details.php?ID=<?php echo $ID;?>">Home</a>
            <a href="product_list.php?ID=<?php echo $ID;?>"><font color="green">Product/Service</font></a>
            <a href="map.php?ID=<?php echo $ID;?>">Map</a>
            <a href="edit_contact.php?ID=<?php echo $ID;?>">Contact</a>
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
          <br>
          <hr>
          <h4 class="add_product"> Products or Services</h4>
          <br>
          <a href="add_product.php?ID=<?php echo $ID;?>">Add more Product</a>
		 <?php
		if (isset($delcontent)) {
			echo $delcontent;
		}
	?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th> Serial no. </th>
				<th> Product Name  </th>
				<th> Product description </th>
				<th> Product price </th>
				<th> Product Image </th>
				<th> Options <br />  </th>
				
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
				$query = "SELECT *
					FROM tb_content WHERE InstituteID = '$ID'
					ORDER BY conID DESC LIMIT $start_form,$per_page";
				$getCnt= $db->select($query);
				
				if ($getCnt){
					$i = 0;
					while ($result = $getCnt->fetch_assoc()){
						$i++;
			?>
			<tr>
				<td><?php echo $start_form+$i ; ?></td>
				<td><a href="../product.php?ID=<?php echo $result['conID']; ?>" target="_blank"><?php echo $result['conName']; ?></a></td>
				<td><?php echo $fm->textShorten($result['body'], 50); ?></td>
				<td>TK. <?php echo $result['price']; ?></td>
				<td><img src ="<?php echo $result['image'];  ?>" height="60px" /> </td>
				<td><a href="edit_product.php?ID=<?php echo $result['conID']; ?>">Edit</a> || <a onclick="return confirm('Are you sure to delete?')" href="?delcont=<?php echo $result['conID']; ?>">Delete</a></td> 
			</tr>
			<?php }} ?>
		</tbody>
	</table>
	<hr>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
                    
			<?php
				$q="SELECT * FROM tb_content WHERE InstituteID = '$ID' ";
				$getTCnt= $db->select($q);
				if(!empty($getTCnt)){
					$total_rows= mysqli_num_rows($getTCnt);
					$total_pages= ceil($total_rows/$per_page);
					if($total_pages >> 1 ){
			?>
			
			<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?ID=<?php echo $ID;?>&page=1" > First Page</a></div>
                 	<div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?ID=<?php echo $ID;?>&page=<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pagenumber">
                    	<ul>
				<?php if ($page > 3){?>
				<a href="?ID=<?php echo $ID;?>&page=<?php echo $page-3; ?>"><li><?php echo $page-3; ?></li></a>
				<?php }
				if ($page > 2){
				?>
				<a href="?ID=<?php echo $ID;?>&page=<?php echo $page-2; ?>"><li><?php echo $page-2; ?></li></a>
				<?php }
				if ($page > 1){
				?>
				<a href="?ID=<?php echo $ID;?>&page=<?php echo $page-1; ?>"><li><?php echo $page-1; ?></li></a>
				<?php } ?>
                            <a href="?ID=<?php echo $ID;?>&page=<?php echo $page; ?>" style="color: #ff9933;"><li ><?php echo $page; ?></li></a>
                            <?php
                            if ($page+1 <= $total_pages){
                            ?>
                            <a href="?ID=<?php echo $ID;?>&page=<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
                            <?php }
                            if ($page+2 <= $total_pages){
                            ?>
                            <a href="?ID=<?php echo $ID;?>&page=<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
                            <?php }
                            if ($page+3 <= $total_pages){
                            ?>
                            <a href="?ID=<?php echo $ID;?>&page=<?php echo $page+3; ?>"><li><?php echo $page+3; ?></li></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><?php
                            if ($page != $total_pages){
                            ?>
                    <a href="?ID=<?php echo $ID;?>&page=<?php echo $page+1; ?>"> Next Page &gt;&gt;</a>
                    <?php } ?></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?ID=<?php echo $ID;?>&page=<?php echo $total_pages ?>"> Last Page</a></div>	
			<?php } } ?>
			</div>
			
        </div>
      </div>
    </div>
<?php include 'includes/footer.php'?>