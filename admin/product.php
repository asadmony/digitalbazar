<?php 
	ob_start();
	include_once '../library/Session.php';
	Session::CheckAdminSession();
	Session::init();
	include_once '../classes/content.php';
	include_once '../classes/category.php';
	include_once '../classes/institute.php';
	$inst = new institute();
	$cat = new category();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:products_list.php");
	} else {
		$id = $_GET['ID'];
	}
	$cnt= new content();
	$getcon = $cnt->getProByID($id);
	if (isset($getcon)){
		$value = $getcon->fetch_assoc();
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
	$userID = $value['userID'];
	$getIns = $inst->getInfoById($userID);
	if (isset($getIns)){
		$result = $getIns->fetch_assoc();
	}
	
?>
<?php 
	$title=$value['conName'];
	include 'header.php';
?>
    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
    <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> > <a href="products_list.php">All Products or Services</a> > </span>
          <h2 class="page_details">Product Details</h2>
		  
<img src="../user/<?php echo $value['image'];?>" alt="<?php echo $value['conName'];?>" height ="200px" />
<h2><?php echo $value['conName'];?></h2>
<br />

<strong>Institute or Company:</strong> <a href="institute.php?ID=<?php echo $result['InstituteID'];?>"><?php echo $result['InstituteName'];?></a>

	<br />
<strong>Product Category: <?php echo $value['contentSubCategoryName'];?> <?php if (isset($scat2)){ echo " , ".$scat2['contentSubCategoryName'];}?> <?php if (isset($scat3)){ echo " , ".$scat3['contentSubCategoryName'];}?>
<br />
<strong>Price: <?php echo $value['price'];?></strong>
<br />
<h4>Product Details</h4>
<p><?php echo $value['body'];?></p>
</div>
</div>
</div>
<?php include_once 'footer.php'; ?>




