<?php
	ob_start();
	include_once '../classes/category.php';
	include_once '../library/Session.php';
	Session::checkAdminSession();
	Session::init();
	$title = "Update category";
	include 'header.php';
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
			header("Location:institute_category_list.php");
	} else {
		$id = $_GET['ID'];
				
	}
	$cat= new category();
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$catNameE = $_POST['catNameE'];
		$Catupdate = $cat->updateinstCat($catNameE,$id);
	}

	
?>
<?php
	$title="Institute Category Update";
	include 'header.php';
?>
    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location">        <a href="dashboard.php">dashboard</a> > <a href="institute_category_list.php">All Institute Categories</a> ></span>

          <br>
          <hr>
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 dash_content">
		<h3 class="add_product">Update Institute Sub-Category<h3>
		
		<?php 
		
			if(isset($Catupdate)){
				echo $Catupdate;
			} 
			$getcat = $cat->getInstCatByID($id);
			if ($getcat){
				$result = $getcat->fetch_assoc();
				
		?>
		
			<form action="" method="post">
				<input type="text" name="catNameE" value= "<?php echo $result['catName']; ?>" class="medium" />
				<br /> <br />
				<input type="submit" name="submit" value="save" />
			</form>
			<?php } ?>
		</div>
		</div>
	</div>
</div>
<?php include 'footer.php';?>