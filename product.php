<?php
	ob_start();
	include_once 'classes/content.php';
	include_once 'classes/category.php';
	include_once 'classes/institute.php';
	include_once 'classes/comment.php';
	include_once 'library/Database.php';
	include_once 'helpers/Format.php';
	include_once 'library/Session.php';
	Session::init();

	$cnt= new content();
	$fm = new Format();
	$db = new Database();
	$inst = new institute();
	$cmnt = new comment();
	$cat = new category();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:index.php");
	} else {
		$id = $_GET['ID'];
	}
	$getcon = $cnt->getProByID($id);
	if ($getcon){
		$value = $getcon->fetch_assoc();
	}
	if(!empty($value['SubCatID2']) && $value['SubCatID2'] != 0 ){
		$s = $value['SubCatID2'];
		$scat = $cat->getConSubCatByID($s);
		$scat2 =  $scat->fetch_assoc();
	}
	if(!empty($value['SubCatID3']) && $value['SubCatID3'] = 0 ){
		$s = $value['SubCatID3'];
		$sbcat = $cat->getConSubCatByID($s);
		$scat3 =  $sbcat->fetch_assoc();
	}
	$InstituteID = $value['InstituteID'];
	$getIns = $inst->getInfoByInsId($InstituteID);
	if (!empty($getIns)){
		$result = $getIns->fetch_assoc();
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])){
		$commentIns = $cmnt->commentInsert($_POST,$id,$InstituteID);
	}
	$getcomnts = $cmnt->getCommentsByID($id);
	$title=$value['conName'];
?>
<?php include 'includes/header.php'; ?>
<div class="container page_content">
	<div class="row">
		<div class="col-xs-12" id="timelinepic">
		<?php if($result['CoverPic'] == ""){?>
		<img  src="<?php echo web_root; ?>images/InstituteCover.jpeg" alt="Cover photo is not uploaded" />
		<?php }else{?>
		<img style="height: 360px;" src="<?php echo web_root; ?>user/<?php echo $result['CoverPic']; ?>">
		<?php } ?>
		</div>
	</div>
	<div class="row" >
		<?php 
			if($result['logo'] == ""){
				$style = 'display: none;';
			}else{
				$style = 'background-color: white; border-radius: 10px;';
			}
		?>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="profilepic" style="<?php echo $style; ?>">
		<img src="<?php echo web_root; ?>user/<?php echo $result['logo'];?>">
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2 class="company_name"><?php echo $result['InstituteName'] ?></h2>
		</div>
	</div>

<div class="row">
<?php
    $ln = $fm->cslug($result['InstituteName']);
    $link = $ln.'-'.$result['InstituteID'];
?>
<!--nav-->
<div class="scrollmenu">
    <a href="<?php echo web_root; ?>institute/<?php echo $link ?>">Home</a>
	<a href="<?php echo web_root; ?>products/<?php echo $link ?>">Products</a>
	<a href="<?php echo web_root; ?>map/<?php echo $link ?>">Map</a>
	<a href="<?php echo web_root; ?>contacts/<?php echo $link ?>">Contact</a>
	
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



</div>

 <!--nav ends-->


<div class="row">
	<div class="col-xs-12 clo-sm-12 col-md-8 col-lg-8" id="content_left" style="height:auto;">
		<div class="row text-center">

			<img src="<?php echo web_root; ?>user/<?php echo $value['image'];?>" alt="<?php echo $value['conName'];?>" style="max-width: 90%;" />
			<h2><?php echo $value['conName'];?></h2>
			<br />

			<strong>Institute or Company:</strong> <a href="<?php echo web_root; ?>institute/<?php echo $link;?>"><?php echo $result['InstituteName'];?></a>

				<br />
			<strong>Product Category: </strong><?php echo $value['contentSubCategoryName'];?> <?php if (isset($scat2)){ echo " , ".$scat2['contentSubCategoryName'];}?> <?php if (isset($scat3)){ echo " , ".$scat3['contentSubCategoryName'];}?>
			<br />
			<strong>Price: <?php echo $value['price'];?></strong>
			<br />
			<h4>Product Details</h4>
			<p><?php echo $value['body'];?></p>
                </div>
           	<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 review">

			</div>
		</div>
<br>
<?php
	if (isset($commentIns)){
		echo $commentIns;
	}
?>
<form action="" method="post">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<label for="name">Your Name:</label>
			<input type="text" name="name" class="form-control" placeholder="Your Name">
			<label for="enail">Email:</label>
			<input type="text" name="email" class="form-control" placeholder="domain@mail.com">
			<label for="number">Phone Number:</label>
			<input type="text" name="phone" class="form-control" placeholder="+880 00 000 00">
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	<label>Message:</label>
		<textarea name="message"  rows="6"
		class="form-control">
		</textarea>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id="submit">
		<input type="submit" name="comment" value="Submit" class="form-control">
		</div>
		</div>
</form>
<br />
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4 class="page_details">Reviews</h4>
			<?php
				if ($getcomnts){
					while($comments = $getcomnts->fetch_assoc()){

			?>
				<a href="mailto:<?php echo $comments['email']; ?>" target="_top"><?php echo $comments['name']; ?></a> <br />
				<p><?php echo $comments['message']; ?></p>
				<br />
				<?php } }?>
		</div>

	</div>




		<div class="col-xs-12 clo-sm-12 col-md-4 col-lg-4">
		<br>
			<div class="col-xs-12 clo-sm-12 col-md-12 col-lg-12 opening_hour">
				<h2>Opening Hours</h2>
				<hr>
				<hr>
				<table width="70%">

					<tr>
						<td>Saturday</td>
						<td align="right"><?php echo $result['SaturdayOpen'] ?>am-<?php echo $result['SaturdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Sunday</td>
						<td align="right"><?php echo $result['SundayOpen'] ?>am-<?php echo $result['SundayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Monday</td>
						<td align="right"><?php echo $result['MondayOpen'] ?>am-<?php echo $result['MondayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Tuesday</td>
						<td align="right"><?php echo $result['TuesdayOpen'] ?>am-<?php echo $result['TuesdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Wednesday</td>
						<td align="right"><?php echo $result['WednesdayOpen'] ?>am-<?php echo $result['WednesdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Thursday</td>
						<td align="right"><?php echo $result['ThursdayOpen'] ?>am-<?php echo $result['ThursdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Friday</td>
						<td align="right"><?php echo $result['FridayOpen'] ?>am-<?php echo $result['FridayClose'] ?>pm</td>
					</tr>
				</table>
			</div>
			<div class="col-xs-12 clo-sm-12 col-md-12 col-lg-12 related_items">
				<h2>Related Items</h2>
				<hr>
				<?php
					$Insti=$inst->getRandInst();

				if ($Insti){
					$i = 0;
					while ($Institutes = $Insti->fetch_assoc()){
						$i++;
						$ln = $fm->cslug($Institutes['InstituteName']);
                        $link = $ln.'-'.$Institutes['InstituteID'];

				?>
				 <a href="<?php echo web_root; ?>institute/<?php echo $link; ?>">
            
            <div class="thumbnail">
                <img src="<?php echo web_root; ?>user/<?php echo $Institutes['CoverPic']; ?>" class="img-responsive" alt="<?php echo $Institutes['InstituteName']; ?>" />
                <center><h4><a href="<?php echo web_root; ?>institute/<?php echo $link ?>"><?php echo $Institutes['InstituteName']; ?></a></h4></center>
            </div>
            </a>
				<?php }} ?>

			</div>
			<div class="col-xs-12 clo-sm-12 col-md-12 col-lg-12 advertisement">
				<h2>Advertisement</h2>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- digitalbazar -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-8167273874729854"
                     data-ad-slot="2996118415"
                     data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <br>
			</div>
			<br>
			<br>
		</div>
</div>
</div>
</div>
<?php include_once 'includes/footer.php';?>