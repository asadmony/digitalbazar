<?php
	ob_start();
	$title = "Location of Institute or Company - Directory of Bangladesh";
	include_once 'classes/institute.php';
	include_once 'library/Session.php';
	include_once 'helpers/Format.php';
    Session::init();

	$inst= new institute();
    $fm = new Format();
	if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
		header("Location:institute.php");
	} else {
		$InstituteID = $_GET['ID'];
	}
	$Info = $inst->getInfoByInsId($InstituteID);
	if (isset($Info)){
		$value = $Info->fetch_assoc();
	}

?>

<?php include'includes/header.php'?>

<div class="container page_content">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="timelinepic">
		<?php if($value['CoverPic'] == ""){?>
		<img src="<?php echo web_root; ?>images/InstituteCover.jpeg" alt="Cover photo is not uploaded" />
		<?}else{?>
			<img src="<?php echo web_root; ?>user/<?php echo $value['CoverPic']; } ?>">
		</div>
	</div>
	<div class="row" >
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="profilepic" style="display: none;">
		<?php if($value['logo'] == ""){?>
		<img src="<?php echo web_root; ?>images/InstituteLogo.png" alt="Logo is not uploaded" />
		<?}else{?>
			<img src="<?php echo web_root; ?>user/<?php echo $value['logo']; } ?>">
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2 class="company_name"><?php echo $value['InstituteName'] ?></h2>
		</div>
	</div>




<div class="row">
<?php
    $ln = $fm->cslug($value['InstituteName']);
    $link = $ln.'-'.$value['InstituteID'];
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
		<div class="col-xs-12 clo-sm-12 col-md-8 col-lg-8" id="content_left" style="height: auto;">
		<div class="db-content-area">
			<iframe src="<?php echo $value['iframelink']; ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
		</div>
		<div class="col-xs-12 clo-sm-12 col-md-4 col-lg-4">
		<br>
			<div class="col-xs-12 clo-sm-12 col-md-12 col-lg-12 opening_hour">
				<h2>Opening Hours</h2>
				<hr>
				<hr>
				<table width="90%">

					<tr>
						<td>Saturday</td>
						<td align="right"><?php echo $value['SaturdayOpen'] ?>am-<?php echo $value['SaturdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Sunday</td>
						<td align="right"><?php echo $value['SundayOpen'] ?>am-<?php echo $value['SundayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Monday</td>
						<td align="right"><?php echo $value['MondayOpen'] ?>am-<?php echo $value['MondayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Tuesday</td>
						<td align="right"><?php echo $value['TuesdayOpen'] ?>am-<?php echo $value['TuesdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Wednesday</td>
						<td align="right"><?php echo $value['WednesdayOpen'] ?>am-<?php echo $value['WednesdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Thursday</td>
						<td align="right"><?php echo $value['ThursdayOpen'] ?>am-<?php echo $value['ThursdayClose'] ?>pm</td>
					</tr>
					<tr>
						<td>Friday</td>
						<td align="right"><?php echo $value['FridayOpen'] ?>am-<?php echo $value['FridayClose'] ?>pm</td>
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
				<hr>
				<hr>
			</div>
		</div>
</div>
</div>

<?php include 'includes/footer.php'?>
