<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkAdminSession();
	Session::init();
	include_once '../classes/content.php';
	include_once '../helpers/Format.php';
	include_once '../library/Database.php';
	$db = new Database();
	$fm = new Format();
	$cnt = new content();
	if (isset($_GET['delcont'])) {
		$id = $_GET['delcont'];
		$delcontent = $cnt->delcontentById($id);
	}
?>
<?php 
	$title="List of All Products and Services";
	include'header.php' ;
?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> ></span>
          <br>
          <hr>
          <h4 class="add_product"> Products or Services</h4>
          <br>
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
				<th> Product price (Tk.) </th>
				<th> Institute Name </th>
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
				$query = "SELECT p.*,i.InstituteName
					FROM tb_content as p, tb_institute as i
					WHERE p.InstituteID = i.InstituteID
					ORDER BY p.conID DESC LIMIT $start_form,$per_page";
				$getCnt= $db->select($query);
				
				if ($getCnt){
					$i = 1;
					while ($result = $getCnt->fetch_assoc()){
						
			?>
			<tr>
				<td><?php echo $start_form+$i ; ?></td>
				<td><a href="product.php?ID=<?php echo $result['conID']; ?>" target="_blank"><?php echo $result['conName']; ?></a></td>
				<td><?php echo $fm->textShorten($result['body'], 50); ?></td>
				<td><?php echo $result['price']; ?></td>
				<td><a href="institute.php?ID=<?php echo $result['InstituteID']; ?>"><?php echo $result['InstituteName']; ?></a></td>
				<td> <a onclick="return confirm('Are you sure to delete?')" href="?delcont=<?php echo $result['conID']; ?>">Delete</a></td> 
			</tr>
			<?php $i++; }} ?>
		</tbody>
	</table>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
                    <hr>
			<?php
				$q = "SELECT * FROM tb_content";
				$getCnts= $db->select($q);
				if(isset($getCnts)){
					$total_rows= mysqli_num_rows($getCnts);
					$total_pages= ceil($total_rows/$per_page);
					if( $total_pages > 1 ){
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
<?php include 'footer.php' ;?>
