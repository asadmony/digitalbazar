<?php
    ob_start();
    include_once 'classes/institute.php';
    include_once 'library/Database.php';
    include_once 'library/Session.php';
    include_once 'helpers/Format.php';
    $fm = new Format();
    $db = new Database();

        Session::init();

    $inst= new institute();

    if (!isset($_GET['ID']) || $_GET['ID'] == NULL ){
        header("Location:institute.php");
    } else {
        $id = $_GET['ID'];
    }
    $Info = $inst->getInfoByInsId($id);
    if (isset($Info)){
        $value = $Info->fetch_assoc();
    }
    $query = "SELECT * FROM tb_content WHERE InstituteID = '$id' ORDER BY conID DESC ";
    $post = $db->select($query);

    $title = "Products or Services of ".$value['InstituteName']."- Directory of Bangladesh";
?>
<?php include'includes/header.php' ;?>

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
            <div class="row text-center">
            <?php
                $per_page = 12;
                if(isset($_GET["page"])){
                    $page = $_GET["page"];
                }else{
                    $page = 1;
                }
                if (!empty($post)){
                        $total_rows= mysqli_num_rows($post);
                        $total_pages= ceil($total_rows/$per_page);
                        $start_form = ($page-1)*$per_page;
                        $done = 0;
                        for($i = 0; $i <= ($start_form+$per_page-1); $i++){
                            $result = $post->fetch_assoc();
                            if($i >= $start_form && $done != $result['conID'] && isset($result['conID']) ){
                                $done = $result['conID'];
                                $details = $fm->textShorten($result['body'], 30);
                                $conNm = $fm->textShorten($result['conName'], 20);
                                $ln = $fm->cslug($result['conName']);
                            	$plink = $ln.'-'.$result['conID'];
            ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 digitalbazar-feature" style="height: 320px;">
                <div class="thumbnail"  style="height: auto;">
                    <img src="<?php echo web_root; ?>user/<?php echo $result['image']; ?>"  class="img-responsive" style="height: 200px;" alt="<?php echo $result['conName']; ?>">
                    <h5><b><?php echo $conNm ; ?></b></h5>
                    <p><?php echo $details ; ?></p>
                    <span class="price">BTD: <?php echo $result['price']; ?></span>
                    <center><a href="<?php echo web_root; ?>product/<?php echo $plink; ?>"><h6>View details</h6></a></center>
                </div>
            </div>



                <?php } }}else {
            echo "No post found!";
        } ?>
        <br /> <hr />
        <?php
                /*if(isset($post)){
                    $total_rows= mysqli_num_rows($post);
                    $total_pages= ceil($total_rows/$per_page);*/
                    if( $total_pages >> 1 ){
            ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber">
                    <hr>
            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-1" > First Page</a></div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pagenumber hidden-xs">
                        <ul>
                <?php 
                if ($page > 2){
                ?>
                <a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $page-2; ?>"><li><?php echo $page-2; ?></li></a>
                <?php }
                if ($page > 1){
                ?>
                <a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $page-1; ?>"><li><?php echo $page-1; ?></li></a>
                <?php } ?>
                            <a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $page; ?>" style="color: #ff9933;"><li ><?php echo $page; ?></li></a>
                            <?php
                            if ($page+1 <= $total_pages){
                            ?>
                            <a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
                            <?php }
                            if ($page+2 <= $total_pages){
                            ?>
                            <a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><?php
                            if ($page != $total_pages){
                            ?>
                    <a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $page+1; ?>"> Next Page &gt;&gt;</a>
                    <?php } ?></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="<?php echo web_root; ?>products/<?php echo $link ?>_page-<?php echo $total_pages ?>"> Last Page</a></div>
            </div>
            <?php
            } ?>
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
