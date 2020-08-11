<?php
	ob_start();
	include_once '../library/Session.php';
	//Session::checkUserSession();
	Session::init();
	$title="Add Product or Service";
	include_once '../classes/category.php';
	include_once '../classes/content.php';
	include_once '../library/Database.php';
	$db= new Database ();
	$cat = new category();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
			header("Location:institute_list.php");
	} else {
		$ID = $_GET['ID'];
				
	}
	$userID = Session::get("usrid");
	
	$InstituteID = $ID;
	$cnt= new content();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		$insertContent = $cnt->contentInsert($_POST,$_FILES,$userID,$InstituteID);
	}
	$q="SELECT * FROM tb_institute WHERE InstituteID = '$InstituteID' ";
	$r = $db->select($q);
	if($r){
		$instInfo = $r->fetch_assoc();
	}
?>
<?php include'includes/dheader.php'?>
<link rel="stylesheet" href="css/select2.min.css" />

    <div class="container-fluid"  style=" margin-top: 50px;">
      <div class="row">
	  
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard">dashboard</a> > <a href="edit_institute?ID=<?php echo $InstituteID;?>"><?php echo $instInfo['InstituteName']; ?></a> > <a href="product_list">Products or Services</a>  </span>
          <br>
          <hr>
		  
          <h4 class="add_product">Add Product or Service</h4>
          <br>
		 <?php 
			if (isset($insertContent)) {
				echo $insertContent;
			}
		?>
          <form action="" method="post" enctype="multipart/form-data">
            <fieldset class="form-group">
              <label for="exampleInputname">Name of Product <font color="red"> *</font> </label>
              <input type="text" class="form-control" name="conName" placeholder="Name of Product">
            </fieldset>
            <fieldset class="form-group">
              <label for="exampleTextarea">Product Details <font color="red"> *</font></label>
              <textarea class="form-control" name="body" rows="3"></textarea>
            </fieldset>
            <fieldset class="form-group">
				<label for="exampleSelect1">Product Category <font color="red"> *</font></label>
				<select class="form-control" name="SubCatID"  >
					<option selected disabled>Select Category</option>
					<?php
							$q ="SELECT * FROM tb_contentsubcategory ORDER BY contentSubCategoryName ASC";
								$getcat= $db->select($q);
								if(isset($getcat) && !empty($getcat)){
									while ($cat = $getcat->fetch_assoc()){
					?>
							<option value="<?php echo $cat['contentSubCategoryID'];?>"><?php echo $cat['contentSubCategoryName'];?></option>
					<?php }}?> 
					</select> 
				<label for="exampleSelect1">Product Sub-Category (optional)</label>
				<select class="form-control" name="SubCatID2">
					<option selected disabled>Select Category</option>
					<?php
								$getcat= $db->select($q);
								if(isset($getcat) && !empty($getcat)){
									while ($cat = $getcat->fetch_assoc()){
					?>
							<option value="<?php echo $cat['contentSubCategoryID'];?>"><?php echo $cat['contentSubCategoryName'];?></option>
					<?php }}?> 
					</select> 
				<label for="exampleSelect1">Product Sub-Category (optional)</label>
				<select class="form-control" name="SubCatID3"  >
					<option selected disabled>Select Category</option>
					<?php
								$getcat= $db->select($q);
								if(isset($getcat) && !empty($getcat)){
									while ($cat = $getcat->fetch_assoc()){
					?>
							<option value="<?php echo $cat['contentSubCategoryID'];?>"><?php echo $cat['contentSubCategoryName'];?></option>
					<?php }}?> 
					</select> 
            </fieldset>
            <fieldset class="form-group">
              <label for="exampleInputprice">Product Price <font color="red"> *</font> </label>
              <input type="text" class="form-control" name="price" placeholder="price">
            </fieldset>

            <fieldset class="form-group">
              <label for="exampleInputFile">Product Photo <font color="red"> *</font></label>
              <input type="file" class="form-control-file" name="image">
            </fieldset>



            <button type="submit" name="submit" class="btn btn-primary pull-right">Upload</button>
          </form>
        </div>
      </div>
    </div>
<?php include 'includes/footer.php';?>
<script src="js/select2.min.js"></script>
<script>
	$('select').select2();
</script>
