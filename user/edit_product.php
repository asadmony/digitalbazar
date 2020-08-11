<?php
   	ob_start();
	include_once '../classes/content.php';
	include_once '../classes/category.php';
	include_once '../library/Database.php';
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$userID = Session::get("usrid");
	$db= new Database();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:product_list.php");
	} else {
		$id = $_GET['ID'];
	}
	$cat = new category();
	$cnt= new content();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$updateContent = $cnt->contentUpdate($_POST,$_FILES,$id);
	}
	$getcon = $cnt->getconByID($id);
	if (isset($getcon)){
		$value = $getcon->fetch_assoc();
	}else{
		header('location:product_list.php');
	}
	if(!empty($value['SubCatID1'])){
		$s = $value['SubCatID1'];
		$scat = $cat->getConSubCatByID($s);
		$scat1 =  $scat->fetch_assoc();
	}
	if(!empty($value['SubCatID2'])){
		$s = $value['SubCatID2'];
		$scat = $cat->getConSubCatByID($s);
		$scat2 =  $scat->fetch_assoc();
	}
	if(!empty($value['SubCatID3'])){
		$s = $value['SubCatID3'];
		$sbcat = $cat->getConSubCatByID($s);
		$scat3 =  $sbcat->fetch_assoc();
	}
	if ($value['userID'] != $userID){
		header('location:product_list.php');
	}
	 $title=$value['conName'] ;
	 
	include 'includes/dheader.php';
?>
<link rel="stylesheet" href="css/select2.min.css" />

    <div class="container-fluid"  style=" margin-top: 50px;">
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard">dashboard</a> > <a href="edit_institute">institute page</a> > <a href="product_list?ID=<?php echo $value['InstituteID'];?>">Products or Services</a></span>

          <br>
          <hr>
		  
          <h4 class="add_product">Edit Product or Service</h4>


	<?php if (isset($updateContent)) {
		echo $updateContent;
	}
	?>
	
	<form action="" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td>
				<strong>Product Name:</strong>
			</td>
			<td>
				<input class="form-control" type="text" name="conName" value="<?php echo $value['conName'] ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Product details:</strong>
			</td>
			<td>
				<textarea class="form-control" name="body"  cols="30" rows="10"><?php echo $value['body'] ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Product price(TK.):</strong>
			</td>
			<td>
				<input class="form-control" type="text" name="price" value="<?php echo $value['price'] ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<strong>Category:</strong>
			</td>
			<td>
				<select class="form-control" name="SubCatID" >
					<?php if (isset($scat1)){ ?>
					<option value="<?php echo $scat1['contentSubCategoryID'];?>"><?php echo $scat1['contentSubCategoryName'];?></option>
					<?php }else{?>
					<option selected disabled>Re-Select Category</option><?php } ?>
					<?php
							$q ="SELECT * FROM tb_contentsubcategory ORDER BY contentSubCategoryName ASC";
								$getcat= $db->select($q);
								if(isset($getcat) && !empty($getcat)){
									while ($cat = $getcat->fetch_assoc()){
					?>
							<option value="<?php echo $cat['contentSubCategoryID'];?>"><?php echo $cat['contentSubCategoryName'];?></option>
					<?php }}?> 
					</select> 
			</td>
		</tr>
		<tr>
			<td>
				<strong>Category:</strong>
			</td>
			<td>
				<select class="form-control" name="SubCatID2"  >
					<?php if (isset($scat2)){ ?>
					<option value="<?php echo $scat2['contentSubCategoryID'];?>"><?php echo $scat2['contentSubCategoryName'];?></option>
					<?php }else{?>
					<option selected disabled>Re-Select Category</option><?php } ?>
					<?php
								$getcat= $db->select($q);
								if(isset($getcat) && !empty($getcat)){
									while ($cat = $getcat->fetch_assoc()){
					?>
							<option value="<?php echo $cat['contentSubCategoryID'];?>"><?php echo $cat['contentSubCategoryName'];?></option>
					<?php }}?> 
					</select> 
			</td>
		</tr>
		<tr>
			<td>
				<strong>Category:</strong>
			</td>
			<td>
				<select class="form-control" name="SubCatID3" >
					<?php if (isset($scat3)){ ?>
					<option value="<?php echo $scat3['contentSubCategoryID'];?>"><?php echo $scat3['contentSubCategoryName'];?></option>
					<?php }else{?>
					<option selected disabled>Re-Select Category</option><?php } ?>
					<?php
								$getcat= $db->select($q);
								if(isset($getcat) && !empty($getcat)){
									while ($cat = $getcat->fetch_assoc()){
					?>
							<option value="<?php echo $cat['contentSubCategoryID'];?>"><?php echo $cat['contentSubCategoryName'];?></option>
					<?php }}?> 
					</select> 
			</td>
		</tr>
		<tr>
			<td>
				<strong>Product Image:</strong>
			</td>
			<td>
				<br />
				<img src ="<?php echo $value['image'];  ?>" height="100px" /> <br />
				<input type="file" name="image"/>
			</td>
		</tr>
		
		
		<tr>
			<br />
			<td></td>
			<td>
			<br />
				<input type="submit" name="submit" value="SAVE" />
			</td>
		</tr>
	</table>
	</form>
        </div>
      </div>
    </div>
<?php include 'includes/footer.php';?>
<script src="js/select2.min.js"></script>
<script>
	$('select').select2();
</script>
