<?php
	ob_start();
	$title="Directory of Bangladesh";
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/library/Database.php');
	include_once ($filepath.'/library/Session.php');
	include_once ($filepath.'/helpers/Format.php');
	Session::init();
	$login = Session::get("userlog");
	//Sign OUT
	if (isset($_GET['action']) && $_GET['action'] == "logout"){
		Session::destroy();
	}

	include_once 'helpers/Format.php';
	$fm = new Format();
	$db = new Database();
    
?>
<?php include 'includes/header.php';?>
  <!-- Page Content -->
    <div class="slogan">
    		<div class="container">
	 <!-- Jumbotron Header -->
         <header class="jumbotron slogan_toglle">
            <center><h2><font size="+4">W</font>elcome to the <font size="+4">D</font>irectory<br>
            institute and it's details.
            </h2></center>
            <hr>
           <form action="search.php" method="get">
          	<div class="row">
                	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 padmar">
                		<input type="text" name="what" class="input-lg searchbox" placeholder="    What??"></div>
                		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padmar">
                    		<button class="searchbtn padmar searchbox_btn pull-right" type="submit"><font size="+1">SEARCH</font></button>
                	</div>
          	</div>
           </form>
        </header>

        </div>
		</div>
        <!-- Title -->
                <div class="container">
        <div class="row">
            <div class="col-lg-12 ">
               <center> <h3>Recent Products or Services</h3></center>
                <hr>
            </div>
        </div>
        <!-- /.row -->
	   <!-- Page Features -->
        <div class="row text-center">
		<?php
			$per_page = 20;
			if(isset($_GET["page"]) && $_GET["page"] > 0 ){
				$page = $_GET["page"];
			}else{
				$page = 1;
			}
			$start_form = ($page-1)*$per_page;

			$query = "SELECT * FROM tb_content ORDER BY conID DESC LIMIT $start_form,$per_page";
			$post = $db->select($query);
			if ($post){
				while($result = $post->fetch_assoc()){
					$details = $fm->textShorten($result['body'], 35);
                    $conNm = $fm->textShorten($result['conName'], 25);
                    $ln = $fm->cslug($result['conName']);
                    $link = $ln.'-'.$result['conID'];
		?>
			<a href="product/<?php echo $link; ?>">
            <div class="col-md-3 col-sm-4 col-xs-12 digitalbazar-feature" style="height: 320px;">
                <div class="thumbnail"  style="height: auto;">
                    <img src="<?php echo web_root; ?>user/<?php echo $result['image']; ?>"  class="img-responsive" alt="<?php echo $result['conName']; ?>" style="height: 200px;" />
                    <center><h4><a href="<?php echo web_root; ?>product/<?php echo $link; ?>"><?php echo $conNm; ?></a></h4></center>
					<p><?php echo $details ; ?></p>
                </div>
            </div>
            </a>
            <?php }}else {
			echo "No post found";
		} ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagenumber ">
                    <hr>
			<?php
				$q= "SELECT * FROM tb_content";
				$r = $db->select($q);
				$total_rows= mysqli_num_rows($r);
				$total_pages= ceil($total_rows/$per_page);
				if($total_pages > 1){
			?>

			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 hidden-xs"><a href="page-1" > First Page</a></div>
                 	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6"><a href="page-<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 pagenumber hidden-xs">
                    	<ul>
				<?php if ($page > 3){?>
				<a href="page-<?php echo $page-3; ?>"><li><?php echo $page-3; ?></li></a>
				<?php }
				if ($page > 2){
				?>
				<a href="page-<?php echo $page-2; ?>"><li><?php echo $page-2; ?></li></a>
				<?php }
				if ($page > 1){
				?>
				<a href="page-<?php echo $page-1; ?>"><li><?php echo $page-1; ?></li></a>
				<?php } ?>
                            <a href="page-<?php echo $page; ?>" style="color: #ff9933;"><li ><?php echo $page; ?></li></a>
                            <?php
                            if ($page+1 <= $total_pages){
                            ?>
                            <a href="page-<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
                            <?php }
                            if ($page+2 <= $total_pages){
                            ?>
                            <a href="page-<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
                            <?php }
                            if ($page+3 <= $total_pages){
                            ?>
                            <a href="page-<?php echo $page+3; ?>"><li><?php echo $page+3; ?></li></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6"><?php
                            if ($page != $total_pages){
                            ?>
                    <a href="page-<?php echo $page+1; ?>"> Next Page &gt;&gt;</a>
                    <?php } ?></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 hidden-xs"><a href="page-<?php echo $total_pages ?>"> Last Page</a></div>
			<?php } ?>
			</div>
            </div>

		</div>
        <!-- /.row -->
		</div>

 <?php include 'includes/footer.php';?>